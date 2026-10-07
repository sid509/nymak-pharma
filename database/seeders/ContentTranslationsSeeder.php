<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Market;
use App\Models\PageContent;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

/**
 * Seeds baseline FR/ES translations for all public content:
 *
 *   - PageContent slots (materialises schema-default rows where absent)
 *   - Categories, markets, posts, FAQs, team members, testimonials
 *   - Products: authored descriptions + therapeutic-group dictionary +
 *     a rule translator for "<Molecule> <Form>" pharma names
 *
 * Authored translations live in database/seeders/i18n/*.php so they can be
 * reviewed/edited like content, and admins can refine any value from the
 * panel afterwards. Re-running is idempotent: values are overwritten, not
 * duplicated. English fallbacks always apply for anything left blank.
 */
class ContentTranslationsSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedPages();
        $this->seedModels();
        $this->seedProducts();
    }

    // ── Page content ────────────────────────────────────────────────

    private function seedPages(): void
    {
        $translations = require database_path('seeders/i18n/pages.php');
        $schema = collect((new \ReflectionClassConstant(PageContent::class, 'SCHEMA'))->getValue())
            ->mapWithKeys(fn ($fields, $page) => [$page => collect($fields)->keyBy(0)]);

        foreach ($translations as $slot => $locales) {
            // Page keys can contain dots (products.index, team.index) — find
            // the schema page that prefixes this slot.
            $page = $schema->keys()->first(fn ($p) => str_starts_with($slot, $p.'.'));
            $key = $page ? substr($slot, strlen($page) + 1) : null;
            $field = $key ? $schema->get($page)?->get($key) : null;
            if (! $field) {
                $this->command?->warn("Unknown page slot skipped: {$slot}");
                continue;
            }

            // Materialise the row with its English default if it isn't in the
            // DB yet, so translations have somewhere to live.
            $row = PageContent::firstOrCreate(
                ['page' => $page, 'key' => $key],
                ['value' => is_string($field[3]) ? $field[3] : json_encode($field[3])]
            );

            foreach (['fr', 'es'] as $locale) {
                if (! isset($locales[$locale])) continue;
                $v = $locales[$locale];
                // JSON slots: write the encoded array straight into i18n —
                // Html::sanitize inside setTranslations would entity-encode
                // the quotes and break json_decode in PageContent::for().
                if ($field[2] === 'json') {
                    $i18n = $row->i18n ?? [];
                    $i18n[$locale] = array_merge($i18n[$locale] ?? [], [
                        'value' => json_encode($v, JSON_UNESCAPED_UNICODE),
                    ]);
                    $row->i18n = $i18n;
                } else {
                    $row->setTranslations($locale, ['value' => is_array($v) ? json_encode($v, JSON_UNESCAPED_UNICODE) : $v]);
                }
            }
            $row->save();
        }
    }

    // ── Model records ───────────────────────────────────────────────

    private function seedModels(): void
    {
        $map = require database_path('seeders/i18n/models.php');
        $classes = [
            'ProductCategory' => [ProductCategory::class, 'slug'],
            'Market' => [Market::class, 'slug'],
            'Post' => [Post::class, 'slug'],
            'Faq' => [Faq::class, 'id'],
            'TeamMember' => [TeamMember::class, 'slug'],
            'Testimonial' => [Testimonial::class, 'id'],
        ];

        foreach ($map as $model => $records) {
            [$class, $idField] = $classes[$model];
            foreach ($records as $id => $fields) {
                $row = $class::where($idField, $id)->first();
                if (! $row) {
                    $this->command?->warn("{$model} not found: {$id}");
                    continue;
                }
                foreach (['fr', 'es'] as $locale) {
                    $row->setTranslations($locale, collect($fields)
                        ->mapWithKeys(fn ($v, $f) => [$f => $v[$locale] ?? null])
                        ->filter()->all());
                }
                $row->save();
            }
        }
    }

    // ── Products ────────────────────────────────────────────────────

    private function seedProducts(): void
    {
        $data = require database_path('seeders/i18n/products.php');
        [$groups, $descriptions, $names] = [$data['groups'], $data['descriptions'], $data['names']];

        foreach (Product::all() as $p) {
            foreach (['fr', 'es'] as $locale) {
                $fields = [
                    'name' => $names[$p->name][$locale] ?? static::pharmaName($p->name, $locale),
                    'therapeutic_group' => $groups[$p->therapeutic_group][$locale] ?? null,
                ];
                if (isset($descriptions[$p->slug])) {
                    $fields['description'] = $descriptions[$p->slug][$locale];
                }
                $p->setTranslations($locale, array_filter($fields));
            }
            $p->save();
        }
    }

    // ── Pharma name rule translator ─────────────────────────────────
    // "<Molecule(s)> <Form>" → local convention. Molecule stems are
    // substituted per INN spelling; anything unmapped stays in English INN
    // (internationally understood). Salt names flip to "<salt> de <molecule>".

    private static function pharmaName(string $en, string $locale): string
    {
        // Explicit multi-word compounds first.
        foreach (static::compounds($locale) as $needle => $out) {
            if (stripos($en, $needle) !== false) {
                return $out;
            }
        }

        foreach (static::forms($locale) as $suffix => $tpl) {
            if (preg_match('/\b'.preg_quote($suffix, '/').'$/i', $en)) {
                $mol = trim(substr($en, 0, strlen($en) - strlen($suffix)));
                return sprintf($tpl, static::molecule($mol, $locale));
            }
        }

        return static::molecule($en, $locale); // no form suffix — translate stems only
    }

    private static function forms(string $locale): array
    {
        return $locale === 'fr' ? [
            'Sublingual Tablets' => 'Comprimés sublinguaux de %s',
            'Dispersible Tablets' => 'Comprimés dispersibles de %s',
            'Extended-Release Tablets' => 'Comprimés à libération prolongée de %s',
            'Paediatric Tablets' => 'Comprimés pédiatriques de %s',
            'SR Capsules' => 'Gélules à libération prolongée de %s',
            'Intravenous Infusion' => 'Perfusion intraveineuse de %s',
            'Infusion' => 'Perfusion de %s',
            'for Oral Suspension' => '%s pour suspension orale',
            'Oral Suspension' => 'Suspension orale de %s',
            'Oral Solution' => 'Solution orale de %s',
            'for Injection' => '%s pour injection',
            'Injection' => 'Injection de %s',
            'Tablets' => 'Comprimés de %s',
            'Capsules' => 'Gélules de %s',
            'Suspension' => 'Suspension de %s',
            'Syrup' => 'Sirop de %s',
            'Drops' => 'Gouttes de %s',
            'Sachet' => 'Sachet de %s',
        ] : [
            'Sublingual Tablets' => 'Comprimidos sublinguales de %s',
            'Dispersible Tablets' => 'Comprimidos dispersables de %s',
            'Extended-Release Tablets' => 'Comprimidos de liberación prolongada de %s',
            'Paediatric Tablets' => 'Comprimidos pediátricos de %s',
            'SR Capsules' => 'Cápsulas de liberación prolongada de %s',
            'Intravenous Infusion' => 'Perfusión intravenosa de %s',
            'Infusion' => 'Perfusión de %s',
            'for Oral Suspension' => '%s para suspensión oral',
            'Oral Suspension' => 'Suspensión oral de %s',
            'Oral Solution' => 'Solución oral de %s',
            'for Injection' => '%s para inyección',
            'Injection' => 'Inyección de %s',
            'Tablets' => 'Comprimidos de %s',
            'Capsules' => 'Cápsulas de %s',
            'Suspension' => 'Suspensión de %s',
            'Syrup' => 'Jarabe de %s',
            'Drops' => 'Gotas de %s',
            'Sachet' => 'Sobre de %s',
        ];
    }

    private static function compounds(string $locale): array
    {
        // Whole-phrase replacements — order matters (longest first).
        return $locale === 'fr' ? [
            "Multiple Electrolytes 'P' & Dextrose Intravenous Infusion" => 'Perfusion intraveineuse de multi-électrolytes « P » et glucose',
            "Multiple Electrolytes 'G' & Dextrose Intravenous Infusion" => 'Perfusion intraveineuse de multi-électrolytes « G » et glucose',
            "Multiple Electrolytes 'M' & Dextrose Intravenous Infusion" => 'Perfusion intraveineuse de multi-électrolytes « M » et glucose',
            "Multiple Electrolytes 'E' & Dextrose Intravenous Infusion" => 'Perfusion intraveineuse de multi-électrolytes « E » et glucose',
            'Sodium Chloride and Dextrose Intravenous Infusion' => 'Perfusion intraveineuse de chlorure de sodium et glucose',
            'Ferrous Sulphate + Folic Acid Syrup' => 'Sirop de sulfate ferreux + acide folique',
            'Dextromethorphan, Phenylephrine & Chlorpheniramine Syrup' => 'Sirop de dextrométhorphane, phényléphrine et chlorphéniramine',
            'Aluminium Hydroxide + Magnesium Trisilicate Tablets' => "Comprimés d'hydroxyde d'aluminium + trisilicate de magnésium",
            'Enteric Coated Rabeprazole and Domperidone SR Capsules' => 'Gélules LP de rabéprazole gastrorésistant et dompéridone',
            'Bupivacaine Hydrochloride in Dextrose Injection' => "Injection de chlorhydrate de bupivacaïne dans le glucose",
            'Vitamin B Complex Injection' => 'Injection de complexe vitamine B',
            'Multivitamin Mineral Syrup' => 'Sirop multivitamines-minéraux',
            'Multivitamin Mineral Lysine Drops' => 'Gouttes de multivitamines-minéraux-lysine',
            'α-β Arteether Injection' => "Injection d'α-β arteether",
            'Cetirizine Di-hydrochloride Tablets' => 'Comprimés de dichlorhydrate de cétirizine',
        ] : [
            "Multiple Electrolytes 'P' & Dextrose Intravenous Infusion" => 'Perfusión intravenosa de multielectrolitos « P » y glucosa',
            "Multiple Electrolytes 'G' & Dextrose Intravenous Infusion" => 'Perfusión intravenosa de multielectrolitos « G » y glucosa',
            "Multiple Electrolytes 'M' & Dextrose Intravenous Infusion" => 'Perfusión intravenosa de multielectrolitos « M » y glucosa',
            "Multiple Electrolytes 'E' & Dextrose Intravenous Infusion" => 'Perfusión intravenosa de multielectrolitos « E » y glucosa',
            'Sodium Chloride and Dextrose Intravenous Infusion' => 'Perfusión intravenosa de cloruro de sodio y glucosa',
            'Ferrous Sulphate + Folic Acid Syrup' => 'Jarabe de sulfato ferroso + ácido fólico',
            'Dextromethorphan, Phenylephrine & Chlorpheniramine Syrup' => 'Jarabe de dextrometorfano, fenilefrina y clorfeniramina',
            'Aluminium Hydroxide + Magnesium Trisilicate Tablets' => 'Comprimidos de hidróxido de aluminio + trisilicato de magnesio',
            'Enteric Coated Rabeprazole and Domperidone SR Capsules' => 'Cápsulas LP de rabeprazol con cubierta entérica y domperidona',
            'Bupivacaine Hydrochloride in Dextrose Injection' => 'Inyección de clorhidrato de bupivacaína en glucosa',
            'Vitamin B Complex Injection' => 'Inyección de complejo de vitamina B',
            'Multivitamin Mineral Syrup' => 'Jarabe de multivitaminas-minerales',
            'Multivitamin Mineral Lysine Drops' => 'Gotas de multivitaminas-minerales-lisina',
            'α-β Arteether Injection' => 'Inyección de α-β arteéter',
            'Cetirizine Di-hydrochloride Tablets' => 'Comprimidos de diclorhidrato de cetirizina',
        ];
    }

    private static function molecule(string $en, string $locale): string
    {
        // Salt flips: "Quinine Sulphate" → "Sulfate de quinine".
        foreach (static::salts($locale) as $salt => $tpl) {
            if (preg_match('/\b'.preg_quote($salt, '/').'$/i', $en)) {
                $mol = trim(substr($en, 0, strlen($en) - strlen($salt)));
                if ($mol !== '' && ! preg_match('/\d/', $mol)) {
                    return sprintf($tpl, static::stems($mol, $locale));
                }
            }
        }

        return static::stems($en, $locale);
    }

    private static function salts(string $locale): array
    {
        return $locale === 'fr' ? [
            'Dihydrochloride' => 'Dichlorhydrate de %s',
            'Hydrochloride' => 'Chlorhydrate de %s',
            'Phosphate' => 'Phosphate de %s',
            'Sulphate' => 'Sulfate de %s',
            'Citrate' => 'Citrate de %s',
            'Stearate' => 'Stéarate de %s',
            'Potassium' => 'Potassium de %s',
            'Sodium' => '%s sodique',
            'Magnesium' => 'Magnésium %s',
        ] : [
            'Dihydrochloride' => 'Diclorhidrato de %s',
            'Hydrochloride' => 'Clorhidrato de %s',
            'Phosphate' => 'Fosfato de %s',
            'Sulphate' => 'Sulfato de %s',
            'Citrate' => 'Citrato de %s',
            'Stearate' => 'Estearato de %s',
            'Potassium' => 'Potasio de %s',
            'Sodium' => '%s sódico',
            'Magnesium' => 'Magnesio %s',
        ];
    }

    private static function stems(string $en, string $locale): string
    {
        static $dicts = [];
        $dicts[$locale] ??= require __DIR__."/i18n/stems.{$locale}.php";

        $out = ' '.$en.' ';
        foreach ($dicts[$locale] as $enStem => $local) {
            $out = preg_replace('/\b'.preg_quote($enStem, '/').'\b/u', $local, $out);
        }
        // Word joiners
        $out = str_ireplace(' and ', $locale === 'fr' ? ' et ' : ' y ', $out);

        return trim($out);
    }
}
