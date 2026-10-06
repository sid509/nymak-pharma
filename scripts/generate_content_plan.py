#!/usr/bin/env python3
"""
Generate NYMAK_Pharma_Website_Content_Plan.xlsx — the client content-approval
workbook for the Nymak Pharma redesign.

Content sources:
  * Existing site  https://www.nymakpharma.com/  (crawled 2026-09-25; client-approved copy)
  * New site copy  Sources/app/Models/PageContent.php + database/seeders/*

Output: <repo workspace>/NYMAK_Pharma_Website_Content_Plan.xlsx
"""

from pathlib import Path

from openpyxl import Workbook
from openpyxl.styles import Alignment, Border, Font, PatternFill, Side
from openpyxl.utils import get_column_letter

OUT = Path(__file__).resolve().parents[2] / 'NYMAK_Pharma_Website_Content_Plan.xlsx'

OLD = 'https://www.nymakpharma.com'
NEW = '(new site)'

# ---------------------------------------------------------------- styling
# NOTE: always use 8-digit ARGB (FF alpha prefix) — 6-digit values are stored
# with a 00 alpha and render transparent (invisible) in some spreadsheet apps.
HDR_FILL = PatternFill('solid', fgColor='FF000000')    # black header band
HDR_FONT = Font(name='Calibri', size=11, bold=True, color='FFFFFFFF')
BODY = Font(name='Calibri', size=10)
BODY_B = Font(name='Calibri', size=10, bold=True)
WRAP = Alignment(wrap_text=True, vertical='top')
WRAP_C = Alignment(wrap_text=True, vertical='center', horizontal='center')
THIN = Side(style='thin', color='FFC9D2D6')
BORDER = Border(left=THIN, right=THIN, top=THIN, bottom=THIN)

FILL_NEW = PatternFill('solid', fgColor='FFFFF3D6')    # new content — amber
FILL_EXIST = PatternFill('solid', fgColor='FFEAF6F5')  # existing approved — teal tint
FILL_FLAG = PatternFill('solid', fgColor='FFFDE8E8')   # needs client decision — red tint

# header substrings that read better centered (narrow categorical columns)
CENTER_COLS = {'Page ID', 'Page Type', 'Action', 'Existing or New', 'Status', 'Change Type',
               'Approval Required', 'Current Navigation', 'Navigation Location', 'CTA', '#'}


def sheet(ws, headers, rows, widths, freeze='A2'):
    ws.append(headers)
    ws.row_dimensions[1].height = 30
    for c in range(1, len(headers) + 1):
        cell = ws.cell(row=1, column=c)
        cell.fill, cell.font, cell.alignment, cell.border = HDR_FILL, HDR_FONT, WRAP_C, BORDER
    for r in rows:
        ws.append(r)
    for i, w in enumerate(widths, start=1):
        ws.column_dimensions[get_column_letter(i)].width = w
    ws.freeze_panes = freeze
    ws.auto_filter.ref = f'A1:{get_column_letter(len(headers))}{len(rows) + 1}'
    center_idx = {i + 1 for i, h in enumerate(headers) if h in CENTER_COLS}
    for row in ws.iter_rows(min_row=2):
        for cell in row:
            cell.font = BODY
            cell.alignment = WRAP_C if cell.column in center_idx else WRAP
            cell.border = BORDER


wb = Workbook()

# ================================================================ SHEET 0 — READ ME
ws = wb.active
ws.title = '0. Read Me'
readme_rows = [
    ('NYMAK PHARMA — WEBSITE CONTENT PLAN', ''),
    ('', ''),
    ('Purpose', 'This workbook lists every page of the new NYMAK Pharma website, the exact '
                'write-up/content proposed for each section, and where that content comes from. '
                'It is the basis for client content approval before the redesigned site goes live.'),
    ('', ''),
    ('Content source of truth', 'The existing website www.nymakpharma.com — the client has confirmed '
     'its content is up to date and approved. Existing wording is preserved wherever possible.'),
    ('Design source of truth', 'The approved redesigned website (Laravel + React build). Colours, fonts, '
     'layout and navigation are documented in docs/design-system.md and docs/navigation.md and are frozen.'),
    ('', ''),
    ('HOW TO READ THIS FILE', ''),
    ('Sheet 1 — Page Content Plan', 'Section-by-section write-up for every page of the new site. '
     'Column "Existing or New" shows whether the text is carried over from the current site or is new.'),
    ('Sheet 2 — Page Inventory', 'Every page that exists on the current website and what happens to it.'),
    ('Sheet 3 — New Pages', 'Pages that do not exist on the current website. Each has a documented reason.'),
    ('Sheet 4 — Navigation', 'Current menu vs the proposed (final) menu structure.'),
    ('Sheet 5 — Content Change Log', 'Every meaningful content change, with reason and approval flag.'),
    ('', ''),
    ('COLOUR KEY (used throughout)', ''),
    ('Teal row', 'Existing approved content — carried over from the current website.'),
    ('Amber row', 'New content or a new page — CLIENT APPROVAL REQUIRED.'),
    ('Red row', 'A decision is needed — content proposed for removal or a factual correction.'),
    ('', ''),
    ('SITE TOTALS', ''),
    ('Existing public pages audited', '10 live pages + 4 orphaned blog posts + 5 legacy redirect URLs'),
    ('Pages redesigned (same content, new design)', '10 — every existing page is carried over'),
    ('New URLs proposed', '8 standalone pages + 4 articles + 46 branded-product pages + 11 team-member pages = 69'),
    ('Pages proposed for removal', '4 orphaned demo blog posts (CLIENT APPROVAL REQUIRED)'),
    ('URL changes needing 301 redirects', '9 page moves + 5 legacy redirects to re-point (see docs/seo-page-map.md)'),
]
for r in readme_rows:
    ws.append(r)
ws.column_dimensions['A'].width = 42
ws.column_dimensions['B'].width = 110
for row in ws.iter_rows():
    for cell in row:
        cell.font = BODY_B if cell.row in (1, 8, 15, 20) and cell.column == 1 else BODY
        cell.alignment = WRAP
for hr, size in ((1, 16), (8, 12), (15, 12), (20, 12)):
    ws.row_dimensions[hr].height = 24 if hr > 1 else 30
    for c in (1, 2):
        ws.cell(row=hr, column=c).fill = HDR_FILL
        ws.cell(row=hr, column=c).font = Font(name='Calibri', size=size, bold=True, color='FFFFFFFF')
ws['A16'].fill = FILL_EXIST
ws['A17'].fill = FILL_NEW
ws['A18'].fill = FILL_FLAG

# ================================================================ SHEET 1 — PAGE CONTENT PLAN
H1 = ['Page ID', 'Page Type', 'Page Title', 'Current URL', 'Proposed URL', 'Navigation Location',
      'Action', 'Section Name', 'Section Heading', 'Write-up / Content', 'Content Source',
      'Existing or New', 'SEO Title', 'Meta Description', 'CTA', 'Notes']

AWARDS_BODY = ('Each accolade and certification we\u2019ve earned reflects our deep-rooted commitment to quality, '
               'integrity, and global healthcare excellence. These recognitions are not just symbols on paper \u2014 '
               'they stand for the trust of our partners, the safety of our products, and the lives we strive to '
               'improve. With every certificate and every award, we reaffirm our promise to deliver nothing but the best.')
AWARDS_LIST = ('GST Certificate — Government of India · Importer-Exporter Code — Government of India · '
               'ISO 13485:2016 — International Management Certification · Certificate of Good Manufacturing '
               'Practices — Food & Drug Administration · Registration-cum-Membership Certificate — Pharmexcil · '
               'Star Export House Certificate of Recognition — Government of India')
TESTIMONIALS = ('1. "Good Plant, Having modern machinery and storage. Processes are well controlled as per GMP '
                'requirement. Batch, lots are analyzed by QC and fully assured by QA." — Mr. Bija Joel, D R Congo\n'
                '2. "Good and neatly maintained manufacturing plant. Supportive Management, Diversified fields, '
                'wishing all the best in future endeavor." — Mr. Alexis Kenne, Cameroon\n'
                '3. "Manufacturing facility is good. Focused on innovation & up-gradation of existing facilities, '
                'quality conscious." — Dr. Hassan Ould Keboud, Mauritania')

rows1 = []

def P(pid, ptype, title, cur, new, nav, action, sec, head, content, src, ex, seo, meta, cta, notes):
    rows1.append([pid, ptype, title, cur, new, nav, action, sec, head, content, src, ex, seo, meta, cta, notes])

# ---------- HOME ----------
home_seo = 'Pharmaceutical Manufacturer & Exporter in India | Nymak Pharma'
home_meta = ('Nymak Pharma — WHO-GMP certified pharmaceutical manufacturer and Star Export House supplying '
             'IV fluids, finished formulations, medical devices, rapid test kits and vaccines to 24+ countries.')
P('P01', 'Homepage', 'Home', OLD + '/', '/', 'Header: Home · Footer brand column', 'Redesign',
  'Hero banner', '25+ years of Efficacy-Driven lifecare',
  'Badge: "WHO-GMP Certified · Star Export House"\n'
  'Sub-headline: "Your Reliable Partner in Efficacious Lifecare Solutions — trusted in 24 countries and counting. '
  'A WHO-GMP certified pharmaceutical manufacturer and Star Export House supplying IV fluids, finished formulations, '
  'medical devices, rapid diagnostic kits and vaccines."\n'
  'Buttons: "Explore Our Products" → /products · "Contact Us" → /contact',
  'Existing website + one added descriptor sentence', 'Existing + New',
  home_seo, home_meta, 'Explore Our Products / Contact Us',
  'Headline + first sub-line are verbatim from current site. The added second sentence lists the five product '
  'segments for SEO — CLIENT REVIEW REQUIRED. Hero image: client-supplied drone shot of the facility '
  '(Resources/Nymak Office Drone Shot), replacing the old illustrated banner.')
P('P01', 'Homepage', 'Home', OLD + '/', '/', '', '',
  'About preview', 'About Nymak Pharma — "A pharmaceutical manufacturer India has exported through since 1998"',
  '"Founded in 1998 under the leadership of Mr. Ranjit Advani, Nymak Pharma began with Sterilized Water for '
  'Injections BP in plastic ampoules, serving the South Pacific. From those beginnings we grew into Honduras, '
  'then Nigeria in 2000 — a milestone that lifted exports by 25% and opened our expansion across Africa.\n\n'
  'Today we operate from a WHO-GMP certified facility in Mundra, Gujarat, supported by in-house regulatory, '
  'laboratory, QC/QA and design teams — and recognised as a Government of India certified Star Export House."',
  'Existing website (About page) — condensed', 'Existing (restructured)',
  '', '', 'Know More → /about',
  'Condensed from the approved About page (7 paragraphs → 2). No new facts. CLIENT REVIEW: condensed wording.')
P('P01', 'Homepage', 'Home', OLD + '/', '/', '', '',
  'Values strip', 'Quality · Trust · Efficacy',
  'The three value markers "Quality / Trust / Efficacy" from the current homepage are carried into the About page '
  'values cards (Efficacy, Customer-first, Sincerity) rather than duplicated on the homepage.',
  'Existing website', 'Existing (moved to About)', '', '', '',
  'On the current site these appear as three headings under About. On the new site they are expressed once, on '
  'the About page — flags as "Merged".')
P('P01', 'Homepage', 'Home', OLD + '/', '/', '', '',
  'Product portfolio', 'Five product segments, one quality standard',
  '"A pharmaceutical export portfolio built for hospitals, distributors, NGOs and public health programmes."\n'
  'Cards for the five approved categories, each linking to its page:\n'
  '· IV Fluids — sterile IV solutions for rehydration and electrolyte restoration\n'
  '· Finished Formulations — finished dosage forms tested for quality, efficacy and stability\n'
  '· Medical Devices & Disposables — devices engineered for safe, accurate drug delivery\n'
  '· Rapid Diagnostic Kits — diagnostics that prioritise speed and sensitivity\n'
  '· Vaccines & Antisera — immunization and antiserum solutions for public-health missions',
  'Existing website (category names + intros, condensed)', 'Existing (restructured)',
  '', '', 'View category → /products/{category}',
  'Category card copy condensed from each approved category intro. "Vaccines" shown as "Vaccines & Antisera" '
  '(products listed are antisera — see Change Log).')
P('P01', 'Homepage', 'Home', OLD + '/', '/', '', '',
  'Marketed brands', 'The Nymak branded range',
  '"Registered brands supplied across West African markets — each manufactured under WHO-GMP conditions." '
  'Cards for branded products (Alumak, Amoximak, Cefmak, Cipromak, Clavmak, Zincomak and sister brands) with '
  'pack-shot photography.',
  'Client-supplied product photography (Resources/Nymak Product Pictures)', 'New',
  '', '', 'View product → /products/finished-formulations/{product}',
  'NEW CONTENT — CLIENT APPROVAL REQUIRED. Brand names/compositions derived from client-supplied pack shots; '
  'not shown on the current website. Confirm the branded range may be publicly displayed.')
P('P01', 'Homepage', 'Home', OLD + '/', '/', '', '',
  'Quality & compliance band', 'Certified for the markets that demand proof',
  '"Every batch is analysed by our in-house QC laboratory and released through QA review. Our regulatory team '
  'supports dossiers and registrations in destination markets."',
  'Existing website (About page facts + testimonial wording)', 'Existing (restructured)',
  '', '', 'Our certifications → /quality-certifications',
  'Facts sourced from approved About page ("in-house QC/QA, regulatory team"). Presentation is new.')
P('P01', 'Homepage', 'Home', OLD + '/', '/', '', '',
  'Global presence band', 'From Mundra to 24+ country markets',
  '"Operating across West, Central and East Africa, Central America and the South Pacific — with offices in the '
  'UK, Sierra Leone and Liberia, and products like Alumak, Cefmak and Cipromak registered under local partnerships."',
  'Existing website (Global Presence + Contact pages)', 'Existing (restructured)',
  '', '', 'Explore markets → /global-presence',
  'Restates approved facts (24+ countries, offices in UK/Sierra Leone/Liberia). Brand names flagged for approval.')
P('P01', 'Homepage', 'Home', OLD + '/', '/', '', '',
  'Client logo strip', 'Trusted by pharmaceutical partners across markets',
  'Scrolling strip of 12 client/partner logos (Davimed, Prince Pharma, Sam Pharma, Satguru, Syner-Med, Trucare, '
  'Unique Pharma, Westgate, Xanaano, Zawadi, Zee Pharma, Core Africa Liberia).',
  'Client-supplied logos (Resources/Client Logos)', 'New',
  '', '', '',
  'NEW PRESENTATION — CLIENT APPROVAL REQUIRED. Confirm the client consents to displaying partner logos.')
P('P01', 'Homepage', 'Home', OLD + '/', '/', '', '',
  'Testimonials', 'What our clients say', TESTIMONIALS,
  'Existing website — verbatim', 'Existing', '', '', '',
  'All three testimonials carried over word-for-word (light copy-edit only on capitalisation).')
P('P01', 'Homepage', 'Home', OLD + '/', '/', '', '',
  'FAQ preview', 'Questions partners ask us',
  'Preview of 4 FAQs linking to the full FAQ page (e.g. "Who is Nymak Pharma?", "Which countries does Nymak serve?").',
  'New FAQ content', 'New', '', '', 'All FAQs → /faqs',
  'NEW CONTENT — CLIENT APPROVAL REQUIRED (see P14 FAQs).')
P('P01', 'Homepage', 'Home', OLD + '/', '/', '', '',
  'Journal preview', 'From the Nymak journal',
  'Cards for the latest 3 articles linking to /blog.',
  'New blog content', 'New', '', '', 'Read more → /blog/{post}',
  'NEW CONTENT — CLIENT APPROVAL REQUIRED (see P13 Blog).')
P('P01', 'Homepage', 'Home', OLD + '/', '/', '', '',
  'Closing CTA', "Have a requirement? Let's talk.",
  '"Product enquiries, distribution partnerships, tenders and registration support — our exports team responds '
  'to every enquiry."',
  'Rewritten from "Have Questions? Get In Touch!"', 'Rewritten',
  '', '', 'Contact Us → /contact · Download brochure',
  'Minor rewrite for a B2B audience; same purpose as current strip. CLIENT REVIEW REQUIRED.')
P('P01', 'Homepage', 'Home', OLD + '/', '/', '', '',
  'Facility video banner', '—',
  'The current homepage embeds a facility video banner with a Play control. The redesign does not carry a video '
  'section; the footage can be re-added if the client supplies/confirms the file.',
  'Existing website', 'Removed', '', '', '',
  'CLIENT DECISION REQUIRED — reinstate the facility video or confirm removal.')

# ---------- ABOUT ----------
P('P02', 'Company page', 'About Us', OLD + '/about-us/', '/about', 'Header: About Us · Footer: Company', 'Restructure',
  'Hero', '25+ years of efficacy-driven lifecare',
  '"From a single injectable for the South Pacific to a Star Export House supplying 24+ countries — the story of '
  'Nymak Pharma is a story of quality compounding."',
  'Existing website (title verbatim) + new lead', 'Existing + New',
  'About Us — WHO-GMP Pharmaceutical Manufacturer Since 1998 | Nymak Pharma',
  'Founded in 1998, Nymak Pharma is a WHO-GMP certified pharmaceutical manufacturer and Star Export House '
  'serving 24+ countries from Mundra, Gujarat, India.', '',
  'URL changes /about-us/ → /about (301). Lead sentence is new summary copy — CLIENT REVIEW REQUIRED.')
P('P02', 'Company page', 'About Us', OLD + '/about-us/', '/about', '', '',
  'Company overview', 'Company overview',
  'Para 1: "Founded in 1998 under the visionary leadership of Mr. Ranjit Advani, Nymak Pharma embarked on its '
  'journey producing Sterilized Water for Injections BP in 5 ml and 10 ml plastic ampoules. Our beginnings were '
  'humble — our first clients were in the South Pacific, where we established our dedication to quality, service '
  'and efficacy, always remembering that behind every product is a person in need."\n\n'
  'Para 2: "As our expertise flourished, so did our reach — several island markets across the South Pacific, then '
  'Honduras in Central America. Anticipating evolving needs, we diversified into a wide array of pharmaceuticals '
  'and medical devices built for the healthcare challenges faced by the communities we serve."\n\n'
  'Para 3: "Today, with over 25 years of lifecare excellence, Nymak Pharma maintains a presence in more than 24 '
  'countries and exported over 200 containers in FY 2023–24. As a Government of India certified Star Export House, '
  'our infrastructure includes an in-house regulatory team, a quality control laboratory, a committed warehouse and '
  'passionate QC/QA and design teams — all devoted to the highest standards of care and excellence."',
  'Existing website — condensed', 'Existing (restructured)',
  '', '', '',
  'CLIENT REVIEW REQUIRED: current page has 7 paragraphs incl. the 2000 Nigeria/25%-growth paragraph — that fact '
  'moves to the Journey timeline below. "26 years"→"25+", "22 countries"→"24+" standardised to the brochure '
  '(docs/decisions.md). All other facts preserved.')
P('P02', 'Company page', 'About Us', OLD + '/about-us/', '/about', '', '',
  'Capability cards', 'What keeps quality consistent',
  '1. In-house QC laboratory — "Batch lots are analysed by quality control before release."\n'
  '2. QA oversight — "A dedicated quality assurance function reviews and approves every release."\n'
  '3. Regulatory team — "Dossier preparation and product registration support for destination markets."',
  'Existing website (About + testimonials facts)', 'Existing (restructured)', '', '', '',
  'New card presentation of facts already approved on the current site.')
P('P02', 'Company page', 'About Us', OLD + '/about-us/', '/about', '', '',
  'Journey timeline', 'Milestones that shaped Nymak',
  '1998 — Founded in Gujarat: "Mr. Ranjit Advani establishes Nymak Pharma, beginning with Sterilized Water for '
  'Injections BP in 5 ml and 10 ml plastic ampoules for South Pacific markets."\n'
  '2000 — The Nigeria milestone: "Entry into the Nigerian market lifts export sales by 25% and opens wider '
  'expansion across the African continent."\n'
  '2000s — Portfolio diversification: "From water for injections, the range grows into pharmaceuticals, IV fluids, '
  'medical devices and disposables for export markets."\n'
  'Today — 24+ countries, 200+ containers: "A Government of India certified Star Export House operating from a '
  'WHO-GMP facility in Mundra, with offices in the UK, Sierra Leone and Liberia."',
  'Existing website — facts verbatim, restructured as timeline', 'Existing (restructured)', '', '', '',
  'Only documented milestones included (1998, 2000, diversification, today). No invented dates.')
P('P02', 'Company page', 'About Us', OLD + '/about-us/', '/about', '', '',
  'Values cards', 'Values behind the products',
  'Efficacy — "Every product must work as promised."\n'
  'Customer-first — "Behind every product is a person in need."\n'
  'Sincerity — "Transparent dealings, honest documentation, certifications that can be verified."',
  'Existing website (About closing paragraph)', 'Existing (restructured)', '', '', '',
  'The approved closing values ("efficacy, a customer-centric approach, and sincerity") become three cards.')
P('P02', 'Company page', 'About Us', OLD + '/about-us/', '/about', '', '',
  'Leadership preview', 'The team behind the quality',
  'Cards for the four leadership members (Ranjit Advani, Haresh Advani, Dimendra Patel, Murtuza Naqvi) linking to /team.',
  'Existing website (Team page)', 'Existing', '', '', 'Meet the team → /team', '')
P('P02', 'Company page', 'About Us', OLD + '/about-us/', '/about', '', '',
  'Credentials band', 'Verified, not just claimed',
  '"WHO-GMP certified manufacturing, ISO 13485:2016 quality systems, Star Export House recognition and Pharmexcil '
  'membership — credentials that regulators and partners can verify."',
  'Existing website (certificates strip)', 'Existing (restructured)', '', '',
  'See the certificates → /quality-certifications', '')
P('P02', 'Company page', 'About Us', OLD + '/about-us/', '/about', '', '',
  'Testimonials', '—', TESTIMONIALS,
  'Existing website — verbatim', 'Existing (moved to Home)', '', '', '',
  'Current About page ends with "Our Clients say". The same three testimonials appear on the new homepage; '
  'not duplicated here — flag as Moved.')

# ---------- PRODUCTS INDEX ----------
P('P03', 'Product catalogue', 'Products (overview)', '— (no overview page; nav "Products" linked straight to /iv-fluid/)',
  '/products', 'Header: Products · Footer: Products → All Products', 'New Page',
  'Hero', 'A pharmaceutical export portfolio built for real-world need',
  '"Five segments, 300+ line items, one manufacturing standard. Every product below ships under WHO-GMP conditions '
  'with registration support for your market."',
  'New copy over the approved catalogue', 'New',
  'Pharmaceutical Products — IV Fluids, Formulations & More | Nymak Pharma',
  'Explore Nymak Pharma\'s export portfolio: IV fluids, finished formulations, medical devices & disposables, '
  'rapid diagnostic kits and vaccines.', '',
  'NEW PAGE — needed because the old nav linked "Products" directly to IV Fluids; a catalogue overview page '
  'improves navigation and SEO (required page per Requirements §9). Line-item count "300+" = 271 catalogue '
  'rows + 46 branded products in the new database — verify figure with client.')
P('P03', 'Product catalogue', 'Products (overview)', '', '/products', '', '',
  'Category cards', '—', 'Five cards linking to the category pages, each carrying the approved category name, '
  'intro line and product count.', 'Existing website', 'Existing (restructured)', '', '',
  'Open category → /products/{category}', '')
P('P03', 'Product catalogue', 'Products (overview)', '', '/products', '', '',
  'Branded portfolio', 'Registered Nymak brands in market',
  '"Products marketed under Nymak brand names in West African markets — Alumak, Cefmak, Cipromak, Clavmak and more."',
  'Client-supplied pack shots', 'New', '', '', 'View brand product → detail page',
  'NEW CONTENT — CLIENT APPROVAL REQUIRED.')
P('P03', 'Product catalogue', 'Products (overview)', '', '/products', '', '',
  'Enquiry card', 'Need something specific?',
  '"Our regulatory team supports custom presentations, pack sizes and market-specific registrations. Tell us what '
  'your market needs."', 'New copy from approved facts', 'New', '', '',
  'Send an enquiry → /contact', 'CLIENT REVIEW REQUIRED.')

# ---------- CATEGORY PAGES ----------
CAT_SEO = {
    'iv-fluids': ('IV Fluids Manufacturer & Exporter in India | Nymak Pharma',
                  'WHO-GMP certified IV fluids manufacturer in India supplying intravenous infusions — dextrose, '
                  'saline, RL, mannitol & antibiotic infusions — to 24+ countries.'),
    'finished-formulations': ('Finished Formulations Manufacturer India | Nymak Pharma',
                              'Pharmaceutical finished formulations manufacturer & exporter: tablets, capsules, '
                              'syrups, injectables across antimalarial, antibiotic, ARV & chronic therapies.'),
    'medical-devices-and-disposables': ('Medical Devices & Disposables Supplier India | Nymak Pharma',
                                        'Exporter of medical devices & surgical disposables from India: IV cannulas, '
                                        'syringes, infusion sets, catheters, gauze & gloves for hospitals & tenders.'),
    'rapid-diagnostic-kits': ('Rapid Diagnostic Test Kits Manufacturer India | Nymak Pharma',
                              'Rapid diagnostic kits exporter from India: malaria, HIV, HBsAg, HCV, syphilis, '
                              'typhoid & pregnancy test kits for labs, NGOs & health ministries.'),
    'vaccines': ('Vaccines & Antisera Exporter India | Nymak Pharma',
                 'Pharmaceutical vaccines & antisera supplier: snake venom antiserum and tetanus antitoxin exported '
                 'from India to Africa, Asia & Central America.'),
}

P('P04', 'Product category', 'IV Fluids', OLD + '/product/iv-fluids/', '/products/iv-fluids',
  'Header: Products ▸ IV Fluids · Footer: Products ▸ IV Fluids', 'Redesign',
  'Hero / category intro', 'IV Fluids',
  '"Sterile intravenous (IV) solutions formulated for swift rehydration and vital electrolyte restoration, '
  'trusted for consistent performance across a range of clinical applications."',
  'Existing website — condensed', 'Existing (restructured)',
  CAT_SEO['iv-fluids'][0], CAT_SEO['iv-fluids'][1], '',
  'Condensed from approved intro ("...deliver exceptional performance across a range of clinical applications, '
  'ensuring optimal patient care when it matters most"). CLIENT REVIEW REQUIRED. URL: /product/iv-fluids/ → '
  '/products/iv-fluids (301); /iv-fluid/ and /product/iv-fluid/ already 301 to the category today.')
P('P04', 'Product category', 'IV Fluids', '', '', '', '',
  'Category description', '—',
  '"Nymak Pharma manufactures a comprehensive range of large-volume parenteral (LVP) IV fluids including dextrose, '
  'sodium chloride, ringer lactate, mannitol and multiple electrolyte formulations, alongside antibacterial, '
  'antifungal and analgesic intravenous infusions."',
  'New descriptive paragraph (summarises approved table)', 'New', '', '', '',
  'NEW CONTENT — CLIENT APPROVAL REQUIRED. Added for the 300-word SEO minimum; every item named exists in the '
  'approved product table.')
IV_GROUPS = [
    ('Antibacterial Infusions', 'Ciprofloxacin Intravenous Infusion — 200 mg/100 ml — 100 ml · Ofloxacin Intravenous '
     'Infusion — 200 mg/100 ml — 100 ml · Levofloxacin Intravenous Infusion — 500 mg/100 ml — 100 ml · Moxifloxacin '
     'Infusion — 400 mg/100 ml — 100 ml · Pefloxacin Infusion — 400 mg/100 ml — 100 ml'),
    ('Antifungal Infusions', 'Fluconazole Intravenous Infusion — 200 mg/100 ml — 100 ml'),
    ('Antiamoebic Infusions', 'Metronidazole Intravenous Infusion — 500 mg/100 ml — 100 ml · Ornidazole Intravenous '
     'Infusion — 500 mg/100 ml — 100 ml'),
    ('Antiprotozoal Infusions', 'Tinidazole Intravenous Infusion — 800 mg/400 ml — 400 ml'),
    ('Analgesic & Antipyretic', 'Paracetamol Intravenous Infusion — 1000 mg/100 ml — 100 ml'),
    ('Fluid & Electrolyte Replenishers', 'Sodium Chloride Intravenous Infusion 0.9% w/v — 100/500/1000 ml · Sodium '
     'Chloride Intravenous Infusion 0.45% w/v — 500 ml · Ringer Lactate Intravenous Infusion — 500 ml & 1000 ml'),
    ('Nutrient & Fluid Replenishers', 'Dextrose Intravenous Infusion 5% / 10% / 25% w/v — 500 ml & 1000 ml · Sodium '
     'Chloride + Dextrose Intravenous Infusion 0.9% & 5% w/v — 500 ml & 1000 ml · 0.45% & 5% w/v — 500 ml'),
    ("Electrolyte & Dextrose IV Infusions", "Multiple Electrolytes 'P' / 'G' / 'M' / 'E' & Dextrose Intravenous "
     "Infusion — 500 ml"),
    ('Osmotic Diuretics', 'Mannitol Intravenous Infusion 10% w/v — 100 ml & 500 ml · 20% w/v — 100 ml & 500 ml'),
    ('Oxazolidinones', 'Linezolid Intravenous Infusion — 600 mg/300 ml — 300 ml'),
    ('Peritoneal Dialysis', 'Intraperitoneal Dialysis Fluid — 1.7% w/v — 1000 ml'),
]
for g, items in IV_GROUPS:
    P('P04', 'Product category', 'IV Fluids', '', '', '', '', f'Product table — {g}', g,
      items + '\n(columns: Product Name | Strength | Pack Size)',
      'Existing website — verbatim table', 'Existing', '', '', 'Enquire → /contact?product=…',
      'Carried over unchanged. Group headings lightly re-titled (e.g. "Antibacterials" → "Antibacterial Infusions") '
      'for clarity — formatting only.')
P('P04', 'Product category', 'IV Fluids', '', '', '', '',
  'Category CTA', 'Sourcing IV fluids for your market?',
  'Enquiry prompt linking to the contact form with this category pre-selected.',
  'New CTA (site pattern)', 'New', '', '', 'Send an enquiry → /contact', '')

P('P05', 'Product category', 'Finished Formulations', OLD + '/product/finished-formulations/',
  '/products/finished-formulations', 'Header: Products ▸ Finished Formulations · Footer: same', 'Redesign',
  'Hero / category intro', 'Finished Formulations',
  '"Finished dosage forms designed to meet diverse healthcare needs — each formulation rigorously tested for '
  'quality, efficacy and stability."',
  'Existing website — condensed', 'Existing (restructured)',
  CAT_SEO['finished-formulations'][0], CAT_SEO['finished-formulations'][1], '',
  'Condensed from approved intro. CLIENT REVIEW REQUIRED.')
P('P05', 'Product category', 'Finished Formulations', '', '', '', '',
  'Category description', '—',
  '"From antimalarials and antibiotics to antiretrovirals, supplements and cardiovascular care, Nymak Pharma\'s '
  'finished formulations span tablets, capsules, syrups, suspensions and injections manufactured under WHO-GMP '
  'conditions."', 'New descriptive paragraph (summarises approved table)', 'New', '', '', '',
  'NEW CONTENT — CLIENT APPROVAL REQUIRED (300-word SEO minimum).')
P('P05', 'Product category', 'Finished Formulations', '', '', '', '',
  'Nymak branded range', 'Nymak branded range',
  '46 branded products with pack-shot photography and composition notes — the Alumak, Amoximak, Ampimak, Artemak, '
  'Athermak, Biomak, Cefmak, Cefisimak, Cipromak, Clavmak, Clearmak, Cloxamak, Cold Mak, Corcef, Cotrimak, Cypmak, '
  'Doxymak, Erythromak, Gas Relief, Ibumak, I-Paramak, Ketomak, Metromak, Mzolemak, Omemak, Paramak, Silmak and '
  'Zincomak lines marketed in Sierra Leone and Liberia. Each has a detail page: /products/finished-formulations/{brand}.',
  'Client-supplied pack shots (Resources/Nymak Product Pictures)', 'New', '', '',
  'Open brand page → /products/finished-formulations/{product}',
  'NEW CONTENT — CLIENT APPROVAL REQUIRED. Not shown on current site; sourced from client-supplied photos. '
  'Compositions on pack shots must be verified by the client before launch.')
FF_GROUPS = [
    ('Opioid Analgesics & Dependence Care', 'Buprenorphine Sublingual Tabs 0.2–8 mg · Buprenorphine+Naloxone Tabs '
     '0.4+0.1 / 2+0.5 / 8+2 mg · Naltrexone Tabs 50 mg · Methadone HCl Tabs 5/10/20 mg · Methadone Oral Concentrate '
     '5 & 10 mg/ml — 100 ml · Fentanyl Citrate Inj 50 µg/ml — 2 ml · Buprenorphine HCl Inj 0.3 mg/ml — 1/2 ml · '
     'Naloxone HCl Inj 0.4 mg/ml — 1 ml · Nalbuphine HCl Inj 10/20 mg — 1 ml'),
    ('Antimalarials', 'Chloroquine Phosphate Tabs 100/250 mg · Artemether+Lumefantrine Tabs 20+120 / 40+240 / 80+480 · '
     'Quinine Sulphate Tabs 300 mg · Primaquine Phosphate Tabs 7.5/15 mg · Sulfadoxine+Pyrimethamine Tabs 500+25 mg · '
     'Artesunate+Amodiaquine Tabs 200/600 mg · α-β Arteether Inj 150 mg/2 ml · Chloroquine Phosphate Inj 40 mg/ml · '
     'Sterile Quinine Dihydrochloride Conc. 300 mg/ml · Quinine Dihydrochloride Inj 100 mg/ml · Artemether Inj '
     '40 & 80 mg/ml · Chloroquine Phosphate Syrup 80 mg/5 ml — 60 ml'),
    ('Supplemental Medication', 'Zinc Sulphate Disp. Tabs 20 mg · Glucose Tabs 3.4 g · Folic Acid Tabs 5 mg · '
     'Mecobalamin Tabs 500 µg · Mecobalamin Sublingual Tabs 1500 µg · Iron Sucrose Inj 100 mg/5 ml · Menaphthone '
     'Sodium Bisulphate Inj 10 mg/ml · Vitamin B Complex Inj — 3 ml · Methylcobalamin Inj 500/1000 µg · Magnesium '
     'Sulphate Inj 50% w/v · Ferrous Sulphate+Folic Acid Syrup · Multivitamin Mineral Syrup · Sodium Feredetate Oral '
     'Solution (syrup & drops) · Multivitamin Mineral Lysine Drops · Multiple Micronutrient Sachet 1 g'),
    ('Analgesics, Cough & Cold', 'Diclofenac Potassium Tabs 50 mg · Cetirizine Di-HCl Tabs 10 mg · Salbutamol Tabs '
     '2/4 mg · Diclofenac Sodium Inj 25 mg/ml — 3 ml · Salbutamol Syrup 2 mg/5 ml — 100 ml · Loratadine Syrup '
     '1 mg/ml — 100 ml · Dextromethorphan+Phenylephrine+Chlorpheniramine Syrup — 100 ml'),
    ('Antiulcerants', 'Esomeprazole Mg Trihydrate Tabs 40 mg · Famotidine Tabs 20 mg · Rabeprazole Sodium Tabs 20 mg · '
     'Aluminium Hydroxide+Mg Trisilicate Tabs 250+500 mg · Cimetidine Tabs 200/400 mg · EC Rabeprazole+Domperidone SR '
     'Caps 20/30 mg · Omeprazole Caps 20 mg · Domperidone+Omeprazole Caps 10/20 mg · Ranitidine Inj 25 mg/ml — 2 ml'),
    ('Antiemetics', 'Metoclopramide Tabs 10 mg · Metoclopramide HCl Inj 5 mg/ml — 2 ml/10 ml · Chlorpromazine Inj '
     '50 mg/ml — 2 ml · Promethazine HCl Inj 25 mg/ml — 2 ml'),
    ('Cephalosporins', 'Cefuroxime Axetil Tabs 125/250/500 mg · Cefadroxil Disp. Tabs 250 mg · Cefadroxil Tabs '
     '500 mg · Cefixime Disp. Tabs 50/100 mg · Cefixime Tabs 200 mg · Cefpodoxime Proxetil Disp. Tabs 200 mg · '
     'Cephalexin Caps 250/500 mg · Cefazolin Sodium for Inj 500/1000 mg · Cefepime for Inj 1/2 g · Cefoperazone Inj '
     '500 mg · Cefotaxime Sodium for Inj 250/500/1000 mg · Ceftazidime for Inj 500/1000 mg · Ceftriaxone Inj '
     '500/1000 mg · Ceftriaxone+Sulbactam for Inj 1000+500 mg · Cefoperazone+Sulbactam for Inj 500+500 mg / 1+1 g · '
     'Cefuroxime Sodium for Inj 250/750/1000 mg'),
    ('Antibiotics — β-Lactam', 'Amoxycillin Tabs/Caps 250/500 mg · Ampicillin+Cloxacillin Caps 500 mg · Flucloxacillin '
     'Caps 250/500 mg · Amoxycillin Sodium for Inj 500 mg · Amoxycillin+Clavulanate for Inj 500+100 / 1000+200 mg · '
     'Cloxacillin Sodium for Inj 500 mg · Ampicillin for Inj 500 mg/1 g · Piperacillin+Tazobactam for Inj '
     '1.125/2.25/4.5 g · Amoxycillin+Cloxacillin Oral Suspension 125 mg/5 ml — 100 ml'),
    ('Macrolides', 'Azithromycin Tabs 250/500 mg/1 g · Azithromycin Oral Suspension 200 mg/5 ml — 15 ml · '
     'Erythromycin Stearate Tabs 250/500 mg'),
    ('Antibacterials', 'Lincomycin HCl Caps 500 mg · Co-trimoxazole Tabs 480/960 mg · Doxycycline Caps 100 mg · '
     'Tetracycline Caps 250/500 mg · Metronidazole Tabs 200/400 mg'),
    ('Antiretrovirals (ARVs)', 'Zidovudine+Lamivudine+Nevirapine Combipack 300+150+200 mg · Zidovudine Tabs 300 mg · '
     'Lamivudine Tabs 150 mg · Nevirapine Tabs 200 mg — 60 tabs · Acyclovir Tabs 200/400/800 mg · Lopinavir+Ritonavir '
     'Tabs 200/50 mg · Raltegravir Tabs 400 mg · Tenofovir+Lamivudine+Efavirenz Tabs 300+300+600 mg · Lamivudine+'
     'Zidovudine Tabs 150+300 mg · Lamivudine+Nevirapine+Stavudine Tabs 150+200+30 mg · Stavudine+Lamivudine Tabs '
     '30/150 mg · Lamivudine+Tenofovir Tabs 300+300 mg · Darunavir Tabs 600 mg · Nevirapine Disp. Tabs 50 mg · '
     'Lamivudine+Nevirapine+Zidovudine Paediatric Tabs 30/50/60 mg · Lamivudine+Zidovudine Disp. Tabs 30+60 mg · '
     'Ritonavir Tabs 100 mg · Atazanavir Caps 300 mg'),
    ('Anaesthetics', 'Haloperidol Tabs 5 mg · Bupivacaine HCl in Dextrose Inj 5 mg/ml — 4 ml · Haloperidol Inj '
     '5 mg/ml — 1 ml · Lidocaine Inj 2% — 2 ml'),
    ('Penems', 'Meropenem Inj 500 mg/1 g — 30 ml · Imipenem+Cilastatin for Inj 250+250 / 500+500 mg — 20 ml'),
    ('Anti-Diabetics', 'Glibenclamide Tabs 2.5/5 mg · Metformin HCl Tabs 500/850 mg'),
    ('Erectile Dysfunction', 'Sildenafil Citrate Tabs 50/100 mg — 4 tabs · Tadalafil Tabs 20 mg — 4/10 tabs'),
    ('Antibiotics — Quinolones', 'Ciprofloxacin Tabs 250/500 mg · Ciprofloxacin+Tinidazole Tabs 500+600 mg · '
     'Norfloxacin Tabs 400 mg · Ofloxacin Tabs 200/400 mg · Levofloxacin Tabs 250/500 mg'),
    ('Antidiarrhoeals', 'Loperamide HCl Tabs 2 mg · Oral Rehydration Salt (ORS) — 10.5/20.5/21 g'),
    ('Immunosuppressants', 'Sirolimus Tabs 1/2 mg'),
    ('Anticoagulants', 'Heparin Inj 25000 IU/5 ml, 5000 IU/5 ml — 5 ml'),
    ('Ovulation Stimulants', 'Clomiphene Citrate Tabs 50 mg'),
    ('Antispasmodics', 'Hyoscine Butylbromide Tabs 10 mg · Drotaverine HCl Tabs 40/80 mg · Hyoscine Butylbromide Inj '
     '20 mg/ml — 1 ml'),
    ('Antifungals', 'Fluconazole Caps 50/150/200 mg · Ketoconazole Tabs 200 mg'),
    ('Anthelmintics', 'Albendazole Tabs 400 mg — 1/10 tabs · Mebendazole Tabs 100/500 mg · Tinidazole Tabs 500 mg · '
     'Diethylcarbamazine Citrate Tabs 100/200 mg · Mebendazole Oral Susp. 100 mg/5 ml — 30 ml · Pyrantel Pamoate '
     'Oral Susp. 250 mg/5 ml — 15 ml · Albendazole Susp. 200 mg/5 ml — 10 ml'),
    ('Cardiovascular', 'Amlodipine Besilate Tabs 5/10 mg · Rosuvastatin Tabs 10/20 mg · Nifedipine ER Tabs 20 mg · '
     'Atenolol Tabs 50 mg · Frusemide Tabs 10/40 mg · Frusemide Inj 10 mg — 2 ml · Atorvastatin Tabs 10/20 mg · '
     'Atropine Inj 1 mg/ml — 1 ml · Nitroglycerin Inj 5 mg/ml — 5 ml'),
    ('Haemostatic Agents', 'Ethamsylate Tabs 250/500 mg · Ethamsylate Inj 250 mg/2 ml — 2 ml'),
    ('Antiasthmatics', 'Aminophylline Inj 25 mg/ml — 10 ml'),
    ('Anti-Inflammatories', 'Dexamethasone Sodium Phosphate Inj 4 mg/ml — 2 ml'),
    ('Anxiolytics', 'Diazepam Tabs 5/10 mg · Alprazolam Tabs 0.25/0.5 mg'),
    ('Clavulanate Combinations', 'Amoxicillin+Clavulanate Tabs 375/625/1000 mg · Disp. Tabs 228.2 mg · Cefixime+'
     'Clavulanate Tabs 162.5/325 mg · Disp. Tabs 81.25/162.5 mg · Cefpodoxime+Clavulanate Tabs 325 mg · Disp. Tabs '
     '162.51 mg · Cefadroxil+Clavulanate Tabs 625 mg · Cefuroxime Axetil+Clavulanate Tabs 312.5 mg · Amoxycillin+'
     'Clavulanate Oral Suspension 228.5/312.5/457 mg — 100 ml'),
    ('Dry Powder Injections', 'Esomeprazole 40 mg — 5 ml · Rabeprazole 20 mg — 5 ml · Lansoprazole 30 mg — 10 ml · '
     'Omeprazole 40 mg — 10 ml · Pantoprazole 40 mg — 10 ml · Artesunate 30–240 mg — vials · Teicoplanin 200/400 mg · '
     'Vancomycin HCl 500 mg/1 g · Aciclovir 250/500 mg · Clarithromycin 500 mg · Daptomycin 350/500 mg · Voriconazole '
     '200 mg · Anidulafungin 100 mg · Azithromycin 500 mg · Aztreonam 500 mg/1 g/2 g · Methylprednisolone 500/1000 mg'),
]
for g, items in FF_GROUPS:
    P('P05', 'Product category', 'Finished Formulations', '', '', '', '', f'Product table — {g}', g,
      items + '\n(columns: Product Name | Strength | Pack Size)',
      'Existing website — verbatim table', 'Existing', '', '', 'Enquire → /contact?product=…',
      'Carried over unchanged. 186 catalogue rows across 30 groups (the two Chloroquine 100 mg / 250 mg rows are '
      'consolidated into one). Two spelling corrections flagged in Change Log: "Sulbutamol" → Salbutamol; '
      '"Prantoprazole" → Pantoprazole.')
P('P05', 'Product category', 'Finished Formulations', '', '', '', '',
  'Category CTA', 'Sourcing finished formulations for your market?', 'Enquiry prompt with category pre-selected.',
  'New CTA (site pattern)', 'New', '', '', 'Send an enquiry → /contact', '')

P('P06', 'Product category', 'Medical Devices & Disposables', OLD + '/product/medical-devices-and-disposables/',
  '/products/medical-devices-and-disposables', 'Header: Products ▸ Medical Devices & Disposables · Footer: same',
  'Redesign',
  'Hero / category intro', 'Medical Devices & Disposables',
  '"Precision medical devices and disposables engineered for safe, accurate drug delivery — elevating everyday '
  'patient care."',
  'Existing website — condensed', 'Existing (restructured)',
  CAT_SEO['medical-devices-and-disposables'][0], CAT_SEO['medical-devices-and-disposables'][1], '',
  'Condensed from approved intro. CLIENT REVIEW REQUIRED.')
P('P06', 'Product category', 'Medical Devices & Disposables', '', '', '', '',
  'Category description', '—',
  '"Nymak Pharma supplies IV cannulas, syringes, needles, infusion sets, catheters and surgical disposables '
  'including gauze, cotton wool, bandages and examination gloves to hospitals and health programmes worldwide."',
  'New descriptive paragraph (summarises approved table)', 'New', '', '', '',
  'NEW CONTENT — CLIENT APPROVAL REQUIRED.')
MD_GROUPS = [
    ('Syringes & Needles', 'Insulin Syringe · Single Use Syringe · Single Use Needle · Pen Needles · Disposable '
     'Spinal Needle · A.V. Fistula Needle'),
    ('IV Access & Infusion', '3-Way Stop Cock · 3-Way Stop Cock with Extension Tube · Low/High Pressure Extension '
     'Tube · Extension Tube with T Connector · Extension Tube with Needle-Free Y Site · Flow Regulator with '
     'Extension Tube · Multi-Way Extension Tubes/Connectors · Safety I.V. Cannula/Catheter · I.V. Cannula with '
     'Wings & Injection Port · I.V. Cannula without Wings & Injection Port · I.V. Cannula with Suturable Wings & '
     'Snap Port Cap · Flash Back I.V. Cannula/Catheter · Infusion Set · Measured Volume Administration Set · Blood '
     'Administration Set · Scalp Vein Set'),
    ('Patient Care & Urology', 'Foley Balloon Catheter · Urine Bag · Oxygen Mask · Surgical Mask'),
    ('Surgical & Wound Care', 'Sutures (Vicryl) · Surgical Gloves · Examination Gloves · Blood Collection Tube · '
     'Absorbent Cotton Wool 100/250/400/500 gm · Absorbent Gauze Roll · Absorbent Gauze Swab · Adhesive Tape '
     '2.5/5/18 cm · Crepe Bandage'),
]
for g, items in MD_GROUPS:
    P('P06', 'Product category', 'Medical Devices & Disposables', '', '', '', '', f'Product table — {g}', g,
      items, 'Existing website — verbatim items', 'Existing (reordered)', '', '', 'Enquire → /contact?product=…',
      'Same 35 items as the current flat list, now grouped under four sub-headings for readability — formatting '
      'only. One stray row on the old site ("Neonates only", no product) is dropped — flag in Change Log.')
P('P06', 'Product category', 'Medical Devices & Disposables', '', '', '', '',
  'Category CTA', 'Sourcing medical devices & disposables for your market?',
  'Enquiry prompt with category pre-selected.', 'New CTA (site pattern)', 'New', '', '',
  'Send an enquiry → /contact', '')

P('P07', 'Product category', 'Rapid Diagnostic Kits', OLD + '/product/rapid-diagnostic-kits/',
  '/products/rapid-diagnostic-kits', 'Header: Products ▸ Rapid Diagnostic Kits · Footer: same', 'Redesign',
  'Hero / category intro', 'Rapid Diagnostic Kits',
  '"Rapid diagnostic solutions that prioritise speed and sensitivity, empowering healthcare professionals with '
  'timely, reliable results."',
  'Existing website — condensed', 'Existing (restructured)',
  CAT_SEO['rapid-diagnostic-kits'][0], CAT_SEO['rapid-diagnostic-kits'][1], '',
  'Condensed from approved intro. CLIENT REVIEW REQUIRED.')
P('P07', 'Product category', 'Rapid Diagnostic Kits', '', '', '', '',
  'Category description', '—',
  '"A focused portfolio of rapid test kits covering malaria, HIV 1 & 2, hepatitis B & C, syphilis, typhoid, dengue, '
  'chikungunya, leptospira, H. pylori, toxoplasma, troponin I, scrub typhus, leishmania, pregnancy and ovulation, '
  'plus urinalysis strips."',
  'New descriptive paragraph (summarises approved table)', 'New', '', '', '',
  'NEW CONTENT — CLIENT APPROVAL REQUIRED.')
P('P07', 'Product category', 'Rapid Diagnostic Kits', '', '', '', '',
  'Product table — Rapid Tests', 'Rapid Tests',
  'HIV 1 & 2 Test · HIV-Ab/Ag 4th Gen Rapid Test · HBsAg Card Test · HCV Card Test · Syphilis Card Test · '
  'Pregnancy Test · LH (Ovulation) Test · Malaria Pf/Pv Antigen Test · Malaria Pf/Pan Antigen Test · Typhoid '
  'IgG/IgM Test · Chikungunya IgG/IgM Test · Leptospira IgM & IgG Card · H. Pylori Antibody Rapid Test Device · '
  'Toxoplasma IgG/IgM Test · Troponin I Test · Scrub Typhus Test · Leishmania Ab Test · Urinalysis Strips · '
  'Dengue Diagnostic Solution · Urine Strip 10P Kit\n(columns: Product Name | Specimen — Whole Blood/Serum/Plasma, '
  'Serum/Plasma, Urine or Whole Blood per product)',
  'Existing website — verbatim table', 'Existing', '', '', 'Enquire → /contact?product=…',
  '20 products carried over unchanged, specimen column preserved.')
P('P07', 'Product category', 'Rapid Diagnostic Kits', '', '', '', '',
  'Category CTA', 'Sourcing rapid diagnostic kits for your market?', 'Enquiry prompt with category pre-selected.',
  'New CTA (site pattern)', 'New', '', '', 'Send an enquiry → /contact', '')

P('P08', 'Product category', 'Vaccines & Antisera', OLD + '/product/vaccines/', '/products/vaccines',
  'Header: Products ▸ Vaccines & Antisera · Footer: same', 'Redesign',
  'Hero / category intro', 'Vaccines & Antisera',
  '"Immunization and antiserum solutions formulated for stability and safety, supporting public health missions '
  'worldwide."',
  'Existing website — condensed', 'Existing (restructured)',
  CAT_SEO['vaccines'][0], CAT_SEO['vaccines'][1], '',
  'Condensed from approved intro. Display name "Vaccines" → "Vaccines & Antisera" because the listed products are '
  'antisera/immunoglobulins — URL slug unchanged (/products/vaccines). CLIENT REVIEW REQUIRED.')
P('P08', 'Product category', 'Vaccines & Antisera', '', '', '', '',
  'Category description', '—',
  '"Nymak Pharma supplies snake venom antiserum and tetanus antitoxin in liquid and lyophilised presentations, '
  'supporting immunisation and emergency care programmes across its export markets."',
  'New descriptive paragraph (summarises approved table)', 'New', '', '', '',
  'NEW CONTENT — CLIENT APPROVAL REQUIRED.')
P('P08', 'Product category', 'Vaccines & Antisera', '', '', '', '',
  'Product table — Antisera & Immunoglobulins', 'Antisera & Immunoglobulins',
  'Snake Venom Antiserum — Polyvalent Enzyme Refined Equine Immunoglobulins (Liquid) — 10 ml Vial · Combipack of '
  'Snake Venom Antiserum with Sterile Water for Injection BP — Lyophilized — 10 ml Vial + 10 ml Ampoule · Tetanus '
  'Antitoxin BP 1500 IU — Liquid — 1 ml Vial · Tetanus Antitoxin BP 1500 IU with Sterilized Water for Injection BP '
  '— Lyophilized — 1 ml Vial + 1 ml Ampoule\n(columns: Product Name | Description | Pack Size)',
  'Existing website — verbatim table', 'Existing', '', '', 'Enquire → /contact?product=…',
  '4 products carried over unchanged.')
P('P08', 'Product category', 'Vaccines & Antisera', '', '', '', '',
  'Category CTA', 'Sourcing vaccines & antisera for your market?', 'Enquiry prompt with category pre-selected.',
  'New CTA (site pattern)', 'New', '', '', 'Send an enquiry → /contact', '')

# ---------- MANUFACTURING ----------
P('P09', 'Capability page', 'Manufacturing', '— (no dedicated page on current site)', '/manufacturing',
  'Header: Manufacturing · Footer: Company ▸ Manufacturing', 'New Page',
  'Hero', 'A WHO-GMP facility built for export',
  '"Nymak Pharma manufactures at Plot No. 22, Phase 3, Port Biz Industrial Park, Kandla-Mundra Highway, '
  'Mundra (Kutch), Gujarat — minutes from two of India\'s busiest export ports."',
  'New page — facts from approved Contact/About pages', 'New',
  'Pharmaceutical Manufacturing Facility — Mundra, Gujarat | Nymak Pharma',
  'Inside Nymak Pharma\'s WHO-GMP certified manufacturing facility in Mundra, Gujarat — in-house QC lab, '
  'QA systems, regulatory and warehouse teams.', '',
  'NEW PAGE — CLIENT APPROVAL REQUIRED. All copy is assembled from approved facts (address, WHO-GMP, in-house '
  'teams, client inspection feedback) — no new claims, but the page itself is new.')
P('P09', 'Capability page', 'Manufacturing', '', '', '', '',
  'Overview', 'Manufacturing at Mundra',
  'Para 1: facility location within Port Biz Industrial Park on the Kandla–Mundra highway; 200+ containers shipped '
  'FY 2023–24.\nPara 2: WHO-GMP certified facility with ISO 13485:2016 QMS; in-house QC lab, QA, regulatory, design '
  'and logistics functions.\nPara 3: client inspections describe "modern machinery and storage, processes well '
  'controlled to GMP requirement, and a quality-conscious, supportive management" (approved testimonial wording).',
  'Approved facts + testimonial quotes', 'New (assembled from approved content)', '', '', '', '')
P('P09', 'Capability page', 'Manufacturing', '', '', '', '',
  'Capability cards', 'What runs inside the facility',
  'Six cards: In-house QC laboratory · Quality assurance oversight · Regulatory & dossier support · Design & '
  'packaging · Warehousing & logistics · Continuous up-gradation.',
  'Approved About-page facts restructured as cards', 'New (assembled from approved content)', '', '', '', '')
P('P09', 'Capability page', 'Manufacturing', '', '', '', '',
  'Dosage forms & product lines', 'Dosage forms & product lines',
  'Six cards summarising the approved catalogue: IV fluids & infusions (100–1000 ml) · Tablets & capsules · Oral '
  'liquids · Injections (ampoules & vials) · Medical devices · Diagnostics & antisera.',
  'Approved catalogue summarised', 'New (assembled from approved content)', '', '',
  'Discuss your requirement → /contact', '')

# ---------- QUALITY ----------
P('P10', 'Trust page', 'Quality & Certifications', '— (certificates appear as a strip on Home & Team; no dedicated page)',
  '/quality-certifications', 'Header: Quality · Footer: Company ▸ Quality & Certifications', 'New Page',
  'Hero', 'Certified quality, verifiable compliance',
  '"Every accolade reflects our commitment to quality, integrity and the partners who rely on our products — '
  'WHO-GMP, ISO 13485:2016, Star Export House and more."',
  'New page — lead adapted from approved awards strip', 'New',
  'Quality & Certifications — WHO-GMP, ISO 13485 | Nymak Pharma',
  'Nymak Pharma\'s quality credentials: WHO-GMP certified facility, ISO 13485:2016, Star Export House, '
  'Pharmexcil RCMC — with in-house QC/QA oversight.', '',
  'NEW PAGE — CLIENT APPROVAL REQUIRED.')
P('P10', 'Trust page', 'Quality & Certifications', '', '', '', '',
  'Certificates grid', 'Awards & certifications',
  AWARDS_BODY + '\n\nSix credentials with issuing bodies: WHO-GMP (Food & Drugs Control Administration, Gujarat) · '
  'ISO 13485:2016 · Star Export House (DGFT, Govt. of India) · Pharmexcil RCMC · Importer-Exporter Code · GST '
  'Registration. Certificate scans displayed where provided.',
  'Existing website — strip copy verbatim + cert list', 'Existing', '', '', '',
  'Approved strip text preserved; per-certificate description lines are new microcopy — CLIENT REVIEW REQUIRED. '
  'Scans: Resources/Certification Logo, ISO Certificate, Star Export House.')
P('P10', 'Trust page', 'Quality & Certifications', '', '', '', '',
  'Quality system', 'How quality works here',
  'Three paragraphs: raw-material control → documented GMP production → in-house QC analysis → QA release review; '
  'regulatory dossier, compliant labelling and controlled warehousing around production; this is what partners '
  'verify in audits.',
  'Approved facts (About + testimonials) restructured', 'New (assembled from approved content)', '', '', '', '')
P('P10', 'Trust page', 'Quality & Certifications', '', '', '', '',
  'Quality FAQ sidebar', 'Quality questions',
  'Links the quality-related FAQs (certifications held, how quality is assured).',
  'New FAQ content', 'New', '', '', 'See all FAQs → /faqs', 'NEW CONTENT — approval required.')

# ---------- GLOBAL PRESENCE ----------
P('P11', 'Markets page', 'Global Presence', OLD + '/global-presence/', '/global-presence',
  'Header: Global Presence · Footer: Company ▸ Global Presence', 'Redesign + Expand',
  'Hero', 'Healthcare products to 24+ countries — and counting',
  '"Operating in over 24 countries like Somalia, Kenya, D R Congo, Nigeria and Sierra Leone, we bring more than '
  'healthcare products — we bring dedication. Through every step, our commitment is clear: to improve lives by '
  'delivering quality and efficacious products and leaving a positive footprint wherever we go."',
  'Existing website — verbatim', 'Existing',
  'Global Presence — Pharmaceutical Exports to 24+ Countries | Nymak Pharma',
  'Nymak Pharma exports pharmaceuticals, IV fluids and medical supplies to 24+ countries across Africa, '
  'Central America & the South Pacific.', '',
  'Approved paragraph carried over word-for-word. URL unchanged (only trailing slash dropped).')
P('P11', 'Markets page', 'Global Presence', '', '', '', '',
  'Key markets', 'Where we operate directly',
  'Three market cards with factual descriptions:\n· Sierra Leone — authorised office in Freetown supplying the '
  'registered Alumak/Amoximak/Clavmak/Zincomak branded portfolio.\n· Liberia — supplied through Core Africa Liberia '
  'Inc., Paynesville.\n· Nigeria — entered 2000, lifting exports 25% and opening African expansion.',
  'Approved facts (Contact offices + About story + brand photos)', 'Existing (restructured)', '', '', '',
  'Facts all traceable to approved content; the card copy itself is new wording — CLIENT REVIEW REQUIRED.')
P('P11', 'Markets page', 'Global Presence', '', '', '', '',
  'Export footprint', 'Every container tells a story',
  '"More than 200 containers shipped in FY 2023–24." Market selector lists all named markets: Nigeria, Sierra '
  'Leone, Liberia, Ghana, Somalia, Kenya, DR Congo, Cameroon, Mauritania, Honduras, South Pacific Islands.',
  'Approved facts + country names from site copy', 'Existing (restructured)', '', '', '',
  'Country list compiled from approved mentions (hero names Somalia/Kenya/DRC/Nigeria/Sierra Leone; About names '
  'Honduras, South Pacific, Nigeria; offices add Liberia; testimonials add DR Congo, Cameroon, Mauritania; Ghana '
  'added — VERIFY, Ghana is not explicitly named on the current site → CLIENT REVIEW REQUIRED).')
P('P11', 'Markets page', 'Global Presence', '', '', '', '',
  'International offices', 'International offices & partners',
  'Cards for the three overseas offices with addresses/phones/emails:\n· Nymak Pharma — United Kingdom, 39 Moat '
  'Drive, Harrow HA1 4RY — +44 7943 534797 — paresh.wadhwani@nymakpharma.com\n· Core Africa — Sierra Leone, 1st '
  'Floor, 39 Liverpool Street (UP), Off Pademba Road, Freetown — +232 90855049 — sierraleone@coreafrica.net\n'
  '· Core Africa Liberia Inc., Omega, Kakata Highway, Paynesville, Montserrado County — +231 555 188 288 · '
  '+231 777 736 498 — liberia@coreafrica.net',
  'Existing website (Contact page "Group Companies")', 'Existing', '', '', '',
  'Carried from the current Contact page. Changes flagged: Liberia gains a second phone (+231 777 736 498 — verify '
  'source); Sierra Leone address gains "1st Floor … (UP)". Coral Marketing (4th group company) not shown — '
  'see Change Log.')
P('P11', 'Markets page', 'Global Presence', '', '', '', '',
  'Closing CTA', "Don't see your market?",
  '"We open new markets with the right partners. If you distribute pharmaceuticals or manage public health '
  'procurement, let\'s discuss your territory."', 'New CTA copy', 'New', '', '', 'Contact us → /contact',
  'CLIENT REVIEW REQUIRED.')

# ---------- TEAM ----------
P('P12', 'Company page', 'Team', OLD + '/team/', '/team', 'Header: Team · Footer: Quick Links ▸ Team', 'Redesign',
  'Hero', 'The people behind the promise',
  '"Behind every innovation, every product, and every promise we make — stands a team united by expertise and '
  'empathy. We combine clinical precision with heartfelt commitment to deliver quality healthcare solutions that '
  'truly make a difference."',
  'Existing website — verbatim (lead lightly condensed)', 'Existing',
  'Our Team — Leadership & Experts | Nymak Pharma',
  'Meet the leadership and specialists behind Nymak Pharma — exports, regulatory affairs, quality control, '
  'logistics and design.', '',
  '"At Nymak Pharma," → "We" — trivial tightening; otherwise verbatim.')
TEAM = [
    ('Mr. Ranjit Advani', 'Founder & Mentor',
     '"With over 50 years of invaluable experience in the pharmaceutical industry, Ranjit Advani serves as the '
     'visionary leader and mentor at Nymak Pharma. His extensive expertise and adept administration have been '
     'instrumental in shaping the company\'s growth and success."'),
    ('Mr. Haresh Advani', 'Director',
     '"Haresh Advani brings over 20 years of expertise in exports and marketing to Nymak Pharma. His strategic '
     'insights and deep understanding of international markets have played a pivotal role in expanding our global '
     'footprint and driving export growth."'),
    ('Mr. Dimendra Patel', 'Technical Head',
     '"Dimendra Patel leverages 15 years of experience in regulatory affairs and quality assurance within the '
     'pharmaceutical sector. His meticulous approach ensures that all products by Nymak Pharma adhere to stringent '
     'regulatory standards, guaranteeing safety, efficacy, and compliance."'),
    ('Mr. Murtaza Naqvi', 'Business Development Manager',
     '"Murtaza Naqvi is an experienced Business Development Manager with a rich background in marketing and '
     'business expansion, particularly in the African market. With over a decade of living and working in Africa, '
     'he has developed a profound understanding of the region\'s business landscape, consumer behavior, and market '
     'dynamics."'),
    ('Mr. Jobe John', 'International Business Development — FWA',
     '"Jobe John is an experienced Business Development Manager with a rich background in marketing and business '
     'expansion, particularly in French-speaking West African markets. With over a decade of living and working in '
     'Africa, Jobe has developed a profound understanding of the region\'s business landscape, consumer behavior, '
     'and market dynamics."'),
    ('Mr. Narendra Hirani', 'Logistics & Warehouse Head',
     '"Narendra Hirani is a seasoned hand in logistics and warehousing with two decades of experience in logistics '
     'and related fields. His extensive career has equipped him with comprehensive knowledge and expertise in '
     'managing logistics operations, warehouse management, and supply chain optimization."'),
    ('Mr. Vishal Lalwani', 'Planning & Material Control Head',
     '"Vishal Lalwani is an accomplished Planning and Material Control Head with a decade of experience in Central '
     'America and India. His expertise lies in strategic planning, material control, and supply chain management, '
     'making him a valuable asset in optimizing inventory and resource management processes."'),
    ('Mr. Shivaksh Somani', 'Accounts Head',
     '"With a keen eye for detail and a strong command over financial strategy, Shivaksh Somani leads our '
     'accounting operations with precision and integrity. His expertise ensures smooth financial management, '
     'compliance, and transparency across the board, playing a pivotal role in driving fiscal efficiency and '
     'supporting the company\'s growth."'),
    ('Mr. Dolat Pokar', 'Accounts Compliance Head',
     '"Dolat Pokar is a seasoned finance and accounts compliance head with 15 years of extensive experience in '
     'financial management, accounting, and regulatory compliance. His expertise ensures the financial integrity '
     'and compliance adherence of the organization."'),
    ('Mr. Mehul J. Vaghela', 'Sr. Graphic Designer',
     '"Mehul Vaghela leverages 8 years of experience in artwork and product designing within the pharmaceutical '
     'sector. His expertise lies in product packaging development and creating promotional inputs for brand '
     'support."'),
    ('Mr. Chintan Patel', 'Head of Quality Control',
     '"Chintan Patel brings a relentless commitment to excellence in his role as Head of Quality Control. With a '
     'sharp focus on detail and adherence to industry standards, he ensures that every product meets our strict '
     'quality benchmarks. His proactive approach and deep technical knowledge are key to maintaining consistency, '
     'reliability, and customer trust in everything we deliver."'),
]
for i, (name, role, bio) in enumerate(TEAM):
    note = ''
    if 'Murtaza' in name:
        note = 'CLIENT REVIEW REQUIRED — current site spells the name "Murtuza Naqvi"; new draft uses "Murtaza". Confirm spelling.'
    slug = '-'.join(name.replace('Mr. ', '').replace('.', '').lower().split())
    P('P12', 'Company page', 'Team', '', f'/team/{slug}', '', '',
      f'Member — {name}', f'{name} — {role}', bio,
      'Existing website — verbatim bio', 'Existing', f'{name} — {role} | Nymak Pharma',
      bio.strip('"')[:150], 'Profile → /team/{slug}',
      note + ' Each member also gets a detail page /team/{slug} carrying this approved bio (NEW page type — '
      'approval required). Leadership flag splits members into "Guided by experience" (first 4) and '
      '"Every discipline, one standard" (remaining 7) — presentation only.')
P('P12', 'Company page', 'Team', '', '/team', '', '',
  'Certificates + CTA bands', 'Our Awards & Certificates / Get in touch',
  AWARDS_LIST + '\n' + '"Have Questions? Get In Touch!" strip with contact form link.',
  'Existing website', 'Existing (relocated)', '', '', '',
  'Current Team page ends with the awards strip and contact strip. On the new site certificates live on '
  '/quality-certifications and the CTA is the global site footer — not duplicated per page. Flag as Moved.')

# ---------- INSIDE NYMAK ----------
P('P13', 'Story page', 'Inside Nymak', '—', '/inside-nymak', 'Header: Inside Nymak', 'New Page',
  'Hero', 'From a single ampoule to 24+ countries',
  '"Scroll through the story of how a 1998 startup in Mundra became an exporter trusted across four regions."',
  'New page', 'New',
  'Inside Nymak — An Interactive Story | Nymak Pharma',
  'An interactive walk through Nymak Pharma — from a 1998 startup in Mundra to an exporter trusted across '
  '24+ countries.', '',
  'NEW PAGE — CLIENT APPROVAL REQUIRED.')
P('P13', 'Story page', 'Inside Nymak', '', '', '', '',
  'Journey timeline', 'How we got here',
  'Scrollytelling timeline of 14 milestones: 1998 Founded in Gujarat · 2000 The Nigeria milestone · 2002 Beyond '
  'ampoules · 2004 IV fluids & infusions · 2006 Devices & disposables · 2008 Quality in-house · 2010 Rapid '
  'diagnostics · 2012 Regulatory under one roof · 2014 ISO 13485 certified · 2016 The branded range · 2018 UK '
  'office opens · 2020 Through the pandemic · 2022 Star Export House · 2024 24+ countries, 200+ containers.',
  'New content', 'New', '', '', '',
  'CLIENT APPROVAL REQUIRED — only 1998, 2000 and 2024 are documented on the current site. The dated milestones '
  'for 2002–2022 are illustrative and MUST be verified or replaced with documented facts before launch.')
P('P13', 'Story page', 'Inside Nymak', '', '', '', '',
  'Market explorer', 'Tap a market. See what we built there.',
  '"Each country below is a real operating relationship — select one to see the products we supply there today." '
  'Interactive chips for the 11 markets; selecting Sierra Leone or Liberia shows the branded products supplied.',
  'New presentation of approved data', 'New', '', '', '', 'CLIENT REVIEW REQUIRED.')
P('P13', 'Story page', 'Inside Nymak', '', '', '', '',
  'Closing CTA', 'Ready to write the next chapter with us?',
  '"Distributors, ministries and hospital groups — tell us what your market needs and we will scope a supply plan."',
  'New copy', 'New', '', '', 'Contact us → /contact', 'CLIENT REVIEW REQUIRED.')

# ---------- BLOG ----------
P('P14', 'Blog', 'Blog & Resources', '— (no blog in navigation; 4 orphan demo posts exist)',
  '/blog', 'Header: Blog · Footer: Company ▸ Blog & Resources', 'New Page',
  'Hero', 'Insights from inside pharmaceutical exports',
  '"Company news, quality explainers and product knowledge from the Nymak team."', 'New', 'New',
  'Insights & Resources | Nymak Pharma',
  'Company news, quality explainers and product insights from Nymak Pharma — a WHO-GMP certified pharmaceutical '
  'manufacturer and exporter.', '',
  'NEW PAGE — CLIENT APPROVAL REQUIRED. The 4 existing "private clinic" posts are off-topic theme leftovers — '
  'proposed for removal (see Inventory).')
BLOGS = [
    ('From Sterilized Water for Injections to 24 Countries: The Nymak Pharma Journey',
     'nymak-pharma-journey-1998-to-24-countries',
     'Retells the approved company story: founded 1998 by Mr. Ranjit Advani with Sterilized Water for Injections '
     'BP 5 ml/10 ml ampoules for the South Pacific; expansion across the islands, then Honduras; the 2000 Nigeria '
     'entry lifting export sales 25%; today 24+ countries and 200+ containers (FY 2023–24) as a Star Export House '
     'with in-house regulatory, laboratory, QC/QA and design teams.',
     'All facts from approved About content — new article format.'),
    ('What WHO-GMP Certification Means for Our Partners', 'who-gmp-certification-nymak-pharma',
     'Explains what WHO-GMP covers (environment, validation, in-process checks, documentation, traceability, '
     'training), how QC/QA works at the Mundra facility, and lists the credentials: WHO-GMP, ISO 13485:2016, '
     'Star Export House, Pharmexcil RCMC, IEC, GST.',
     'Facts from approved certifications/testimonials — new explanatory article.'),
    ('Inside the IV Fluids Range: Large-Volume Parenterals for Critical Care',
     'iv-fluids-range-large-volume-parenterals',
     'Walks the approved IV fluids table: core replenishers (NaCl 0.9%/0.45%, RL, dextrose 5/10/25%), '
     'multi-electrolyte formulations, mannitol, peritoneal dialysis fluid, and therapeutic infusions '
     '(ciprofloxacin, ofloxacin, levofloxacin, moxifloxacin, pefloxacin, metronidazole, ornidazole, tinidazole, '
     'fluconazole, linezolid, paracetamol).',
     'All products from approved catalogue — new article format.'),
    ('Star Export House: What the Recognition Means', 'star-export-house-recognition',
     'Explains Star Export House status under India\'s Foreign Trade Policy, the 200+ containers FY 2023–24 '
     'performance it recognises, and how it sits alongside WHO-GMP and ISO 13485:2016.',
     'Facts from approved credentials — new explanatory article.'),
]
for title, slug, body, note in BLOGS:
    P('P14', 'Blog', 'Blog & Resources', '', f'/blog/{slug}', '', 'New Page',
      f'Article — {title}', title, body, 'New content derived from approved facts', 'New',
      f'{title[:55]} | Nymak Pharma', body[:150] + '…', 'Back to blog → /blog',
      'NEW CONTENT — CLIENT APPROVAL REQUIRED. ' + note)

# ---------- FAQS ----------
P('P15', 'Support page', 'FAQs', '—', '/faqs', 'Footer: Company ▸ FAQs (not in header)', 'New Page',
  'Hero', 'Frequently asked questions',
  '"Direct answers about who we are, what we manufacture, where we export and how to work with us."', 'New', 'New',
  'Frequently Asked Questions | Nymak Pharma',
  'Answers about Nymak Pharma\'s products, IV fluids, certifications, export markets, quality systems and how to '
  'partner with us.', '', 'NEW PAGE — CLIENT APPROVAL REQUIRED. Answers compiled from approved site facts.')
FAQS = [
    ('General', 'Who is Nymak Pharma?', 'WHO-GMP certified pharmaceutical manufacturer and exporter founded 1998 '
     'by Mr. Ranjit Advani; HQ Mundra (Kutch), Gujarat; supplies IV fluids, finished formulations, medical devices, '
     'rapid diagnostic kits and antisera to 24+ countries.'),
    ('General', 'Is Nymak Pharma a pharmaceutical exporter?', 'Yes — Government of India recognised Star Export '
     'House; 200+ containers exported FY 2023–24 across West/Central/East Africa, Central America and the '
     'South Pacific.'),
    ('General', 'Where is Nymak Pharma located?', 'HO & works at Plot No. 22, Phase 3, Port Biz Industrial Park, '
     'Kandla-Mundra Highway, Bhadreshwar, Mundra (Kutch), Gujarat; branch office in Ahmedabad; international '
     'offices/partners in the UK, Sierra Leone and Liberia.'),
    ('Products', 'What products does Nymak Pharma manufacture?', 'Five segments: IV fluids/infusions; finished '
     'formulations (tablets, capsules, syrups, suspensions, injections); medical devices & disposables; rapid '
     'diagnostic kits; vaccines & antisera incl. snake venom antiserum and tetanus antitoxin.'),
    ('Products', 'What IV fluids does Nymak Pharma offer?', 'Fluid/electrolyte replenishers (NaCl 0.9%/0.45%, '
     'Ringer lactate), dextrose 5/10/25% and combinations, multiple-electrolyte formulations, mannitol, peritoneal '
     'dialysis fluid, and therapeutic infusions (ciprofloxacin, metronidazole, fluconazole, paracetamol, '
     'linezolid) — 100 ml to 1000 ml packs.'),
    ('Products', 'Which rapid diagnostic kits does Nymak supply?', 'Rapid tests for malaria (Pf/Pv, Pf/Pan), '
     'HIV 1&2 and 4th-gen Ag/Ab, HBsAg, HCV, syphilis, typhoid, dengue, chikungunya, leptospira, H. pylori, '
     'toxoplasma, troponin I, scrub typhus, leishmania, pregnancy and ovulation, plus urinalysis strips.'),
    ('Products', 'Can products be supplied under our own brand or in customised packaging?', 'Yes — both Nymak '
     'registered brands (Alumak, Cefmak, Cipromak ranges in West Africa) and market-specific presentations; '
     'branding/labelling/pack finalised per destination registration requirements.'),
    ('Quality', 'What certifications does Nymak Pharma hold?', 'WHO-GMP, ISO 13485:2016, Star Export House, '
     'Pharmexcil RCMC membership, IEC and GST registration.'),
    ('Quality', 'How does Nymak assure product quality?', 'In-house QC laboratory analyses batches; QA reviews and '
     'approves release; in-house regulatory team for dossiers; in-house design team for compliant packaging.'),
    ('Exports', 'Which countries does Nymak Pharma serve?', '24+ countries; named markets include Nigeria, Sierra '
     'Leone, Liberia, Ghana, Somalia, Kenya, DR Congo, Cameroon, Mauritania, Honduras and South Pacific islands, '
     'with offices in the UK, Sierra Leone and Liberia.'),
    ('Exports', 'How can I become a distributor for Nymak Pharma products?', 'Via the contact page, '
     'info@nymakpharma.com, or the Sierra Leone/Liberia offices; the regulatory team supports registration '
     'and dossiers.'),
    ('Exports', 'Does Nymak Pharma supply to tenders and public health programmes?', 'Yes — IV fluids, '
     'antimalarials, antiretrovirals, rapid diagnostic kits and disposables are supplied to hospitals, '
     'distributors and public health programmes; tender enquiries via the contact page.'),
]
for cat, q, a in FAQS:
    P('P15', 'Support page', 'FAQs', '', '/faqs', '', '', f'FAQ ({cat})', q, a,
      'New content from approved facts', 'New', '', '', 'Contact us → /contact',
      'NEW CONTENT — CLIENT APPROVAL REQUIRED.' + (' Ghana included — verify (see Change Log).' if 'Ghana' in a else ''))
P('P15', 'Support page', 'FAQs', '', '/faqs', '', '',
  'Closing CTA', 'Still have a question?',
  '"Our exports and regulatory teams respond to every enquiry — products, pricing, registration, packaging and '
  'logistics."', 'New', 'New', '', '', 'Contact us → /contact', '')

# ---------- CONTACT ----------
P('P16', 'Conversion page', 'Contact Us', OLD + '/contact-us/', '/contact',
  'Header: Contact Us (button) · Footer: Company ▸ Contact Us', 'Redesign',
  'Hero', "Let's talk about your market",
  '"Whether you\'re a distributor, hospital, NGO or health programme — tell us your requirement and our exports '
  'team will respond."',
  'Existing website — condensed', 'Existing (restructured)',
  'Contact Us — Pharmaceutical Export Enquiries | Nymak Pharma',
  'Contact Nymak Pharma for pharmaceutical exports, product enquiries, distribution and partnership — offices in '
  'India, UK, Sierra Leone & Liberia.', '',
  'URL changes /contact-us/ → /contact (301). Lead condensed from approved intro; audience wording '
  '(distributor/hospital/NGO) mirrors the approved "healthcare provider, partner, or distributor" — '
  'CLIENT REVIEW REQUIRED.')
P('P16', 'Conversion page', 'Contact Us', '', '', '', '',
  'Enquiry form', 'Send an enquiry',
  'Fields: Full Name* · Company/Organisation · Business Email* · Phone/WhatsApp · Country · Product of Interest '
  '(dropdown) · Subject · Message* · Privacy consent checkbox.',
  'Existing form + added fields', 'Existing + New', '', '', 'Submit → stored enquiry + email to info@nymakpharma.com',
  'Current form: Full Name*, Email*, Phone*, Subject, Message + "I Agree To The Privacy Policy" checkbox. New '
  'fields added (Company, Country, Product of Interest) — CLIENT REVIEW REQUIRED. The privacy checkbox stays but '
  'now links to a real Privacy Policy page.')
P('P16', 'Conversion page', 'Contact Us', '', '', '', '',
  'Head Office & Works', 'Head Office & Works',
  'HO & Works: Plot No. 22, Phase 3, Port Biz Industrial Park, Kandla-Mundra Highway, Bhadreshwar, Mundra (Kutch), '
  'Gujarat — 370421, INDIA\nBranch: A-802, Money Plant High Street, Near BSNL Office, Jagatpur Road, SG Highway, '
  'Ahmedabad, Gujarat, INDIA\nPhone: +91 98252 25567 · Email: info@nymakpharma.com\nHours: Mon–Sat, 9:30–18:30 IST',
  'Existing website — verbatim addresses', 'Existing + New', '', '', 'tel: / mailto: / WhatsApp links',
  'Addresses verbatim. Postal code 370421 added for NAP consistency — VERIFY. "Mon–Sat, 9:30–18:30 IST" business '
  'hours are NEW information not on the current site — CLIENT REVIEW REQUIRED.')
P('P16', 'Conversion page', 'Contact Us', '', '', '', '',
  'International offices', '—',
  'UK — 39 Moat Drive, Harrow HA1 4RY — +44 7943 534797 — paresh.wadhwani@nymakpharma.com\n'
  'Sierra Leone — 1st Floor, 39 Liverpool Street (UP), Off Pademba Road, Freetown — +232 90855049 — '
  'sierraleone@coreafrica.net\n'
  'Liberia — Omega, Kakata Highway, Paynesville, Montserrado County — +231 555 188 288 / +231 777 736 498 — '
  'liberia@coreafrica.net',
  'Existing website (Group Companies cards)', 'Existing', '', '', '',
  'See P11 notes: Liberia alt phone and SL "1st Floor" wording need verification; Coral Marketing card '
  '(+91 9687250541, info@coralmarketing.net, same Plot 22 address) is not shown — CLIENT DECISION REQUIRED.')
P('P16', 'Conversion page', 'Contact Us', '', '', '', '',
  'Supporting text', 'Have questions? Get in touch!',
  '"Through our commitment of providing quality products at competitive pricing and with support of our valued '
  'clients, we hope to increase our global presence and diversify our product portfolio in years to come."',
  'Existing website — verbatim', 'Existing (moved into hero lead)', '', '', '',
  'Approved sentence preserved as intro copy.')

# ---------- LEGAL ----------
P('P17', 'Legal page', 'Privacy Policy', '— (current site has none: /privacy-policy/ 404s; only a consent '
  'checkbox exists)', '/privacy-policy', 'Footer bottom bar', 'New Page',
  'Body', 'Privacy Policy',
  'Sections: Information we collect (enquiry details + IP for abuse prevention) · How we use it · Email & contact '
  'data · Data retention · Cookies & analytics · Contact (info@nymakpharma.com).',
  'New legal copy', 'New', 'Privacy Policy | Nymak Pharma',
  'How Nymak Pharma collects, uses and protects personal data submitted through this website.', '',
  'NEW PAGE — CLIENT APPROVAL REQUIRED. Legally required because the form already asks users to agree to a '
  'privacy policy that does not exist. Recommend client legal review.')
P('P18', 'Legal page', 'Terms of Use', '—', '/terms', 'Footer bottom bar', 'New Page',
  'Body', 'Terms of Use',
  'Sections: About this website · Product information (B2B only, not medical advice) · Intellectual property · '
  'Accuracy · Liability · Governing law (India; Gujarat jurisdiction).',
  'New legal copy', 'New', 'Terms of Use | Nymak Pharma',
  'Terms governing the use of the Nymak Pharma website and its content.', '',
  'NEW PAGE — CLIENT APPROVAL REQUIRED. Recommend client legal review.')

sheet(ws := wb.create_sheet('1. Page Content Plan'), H1, rows1,
      [8, 15, 22, 30, 26, 26, 13, 24, 34, 70, 26, 18, 42, 48, 24, 52])
# colour rows by Existing/New + flag approvals
ex_col = H1.index('Existing or New') + 1
notes_col = H1.index('Notes') + 1
for r in range(2, len(rows1) + 2):
    val = (ws.cell(row=r, column=ex_col).value or '')
    notes = (ws.cell(row=r, column=notes_col).value or '')
    if 'New' in val:
        fill = FILL_NEW
    elif 'Removed' in val:
        fill = FILL_FLAG
    else:
        fill = FILL_EXIST
    if 'CLIENT' in notes and fill is FILL_EXIST:
        fill = FILL_FLAG
    ws.cell(row=r, column=1).fill = fill
    ws.cell(row=r, column=ex_col).fill = fill

# ================================================================ SHEET 2 — PAGE INVENTORY
H2 = ['Page', 'Current URL', 'Current Navigation', 'Page Type', 'Existing Content', 'Proposed Action',
      'New URL', 'Reason', 'Status']
rows2 = [
    ['Home', OLD + '/', 'Header: Home', 'Homepage',
     'Hero (25+ years tagline), About preview, Quality/Trust/Efficacy markers, 5 product categories, '
     '"Our Clients Say" (3 testimonials), "Our Awards & Certificates" (6 credentials), facility video banner, '
     '"Have Questions? Get In Touch!" form strip.',
     'Redesign', '/', 'Same content, new approved design; sections reordered; video banner pending client decision.',
     'Redesigned'],
    ['About Us', OLD + '/about-us/', 'Header: About Us · Footer: Quick Links', 'Company page',
     '"25+ Years of Efficacy Driven Lifecare" hero, 7-paragraph company overview (founded 1998, South Pacific → '
     'Honduras → Nigeria 2000 +25%, 22 countries / 200+ containers FY 23–24, Star Export House, in-house teams, '
     'efficacy/customer-centric/sincerity values), testimonials.',
     'Restructure', '/about', 'All facts preserved; copy condensed and split into overview/timeline/values/credentials '
     'sections; "22 countries"→"24+" and "26 years"→"25+" standardised to brochure.',
     'Restructured — CLIENT REVIEW'],
    ['Team', OLD + '/team/', 'Header: Team · Footer: Quick Links', 'Team page',
     'Intro paragraph + 11 member cards with names, roles and bios; awards strip; contact strip.',
     'Redesign', '/team', 'Same 11 members and bios; adds member detail pages; certificates strip moves to '
     'Quality page; "Murtuza"→"Murtaza" spelling flagged.', 'Redesigned'],
    ['Global Presence', OLD + '/global-presence/', 'Header: Global Presence · Footer: Quick Links (as "Global Reach")',
     'Markets page', 'Single paragraph (24+ countries; names Somalia, Kenya, D R Congo, Nigeria, Sierra Leone) '
     'and a map image.', 'Redesign + Expand', '/global-presence',
     'Approved paragraph verbatim; adds market cards, footprint list and office cards sourced from approved '
     'content.', 'Redesigned'],
    ['Contact Us', OLD + '/contact-us/', 'Header: Contact Us (button) · Footer: Quick Links', 'Contact page',
     'Intro, CF7 enquiry form (name/email/phone/subject/message + privacy checkbox), "Have questions? Get in '
     'touch!" text, HO & Works + Branch addresses, 4 Group Companies cards (Coral Marketing, Core Africa SL, '
     'Core Africa Liberia, UK).', 'Redesign', '/contact',
     'All contact info preserved; form gains Company/Country/Product fields; Coral Marketing card pending '
     'decision; business hours added — flagged.', 'Redesigned'],
    ['IV Fluids (category)', OLD + '/product/iv-fluids/', 'Header: Products → (linked /iv-fluid/) · Footer: '
     'Product Categories', 'Product category', 'Intro paragraph + product tables: 26 products in 11 therapeutic '
     'groups (name/strength/pack size).', 'Redesign', '/products/iv-fluids',
     'Tables verbatim; intro condensed; adds description paragraph + enquiry CTA.', 'Redesigned'],
    ['Finished Formulations (category)', OLD + '/product/finished-formulations/', 'Footer: Product Categories',
     'Product category', 'Intro paragraph + product tables: 187 rows in 30 groups.', 'Redesign',
     '/products/finished-formulations', 'Tables verbatim (Chloroquine 100/250 mg rows consolidated → 186 rows); '
     'adds branded-range section + description + CTA.', 'Redesigned'],
    ['Medical Devices & Disposables (category)', OLD + '/product/medical-devices-and-disposables/',
     'Footer: Product Categories', 'Product category', 'Intro + flat list of 36 items (one stray "Neonates only" '
     'row).', 'Redesign', '/products/medical-devices-and-disposables',
     'Same items grouped under 4 sub-headings; stray non-product row dropped.', 'Redesigned'],
    ['Rapid Diagnostic Kits (category)', OLD + '/product/rapid-diagnostic-kits/', 'Footer: Product Categories',
     'Product category', 'Intro + table of 20 kits with specimen column.', 'Redesign',
     '/products/rapid-diagnostic-kits', 'Table verbatim; intro condensed; adds description + CTA.', 'Redesigned'],
    ['Vaccines (category)', OLD + '/product/vaccines/', 'Footer: Product Categories', 'Product category',
     'Intro + table of 4 antisera products (name/description/pack).', 'Redesign', '/products/vaccines',
     'Table verbatim; display name → "Vaccines & Antisera" (products are antisera) — slug unchanged.',
     'Redesigned'],
    ['/iv-fluid/ (legacy URL)', OLD + '/iv-fluid/', 'Header "Products" item target', 'Redirect', '301 → '
     '/product/iv-fluids/', 'Replace', '/products/iv-fluids',
     'Already a redirect; must be pointed at the new URL.', 'Redirect required'],
    ['/product/iv-fluid/ (legacy URL)', OLD + '/product/iv-fluid/', 'Sitemap only', 'Redirect', '301 → '
     '/product/iv-fluids/', 'Replace', '/products/iv-fluids', 'Already a redirect.', 'Redirect required'],
    ['/product/finished-formulation/ (legacy URL)', OLD + '/product/finished-formulation/', 'Sitemap only',
     'Redirect', '301 → /product/rapid-diagnostic-kits/ (misconfigured today)', 'Replace',
     '/products/finished-formulations', 'Fix: point to the correct Finished Formulations page.', 'Redirect required'],
    ['/product/finished-formulation-2/ (legacy URL)', OLD + '/product/finished-formulation-2/', 'Sitemap only',
     'Redirect', '301 → /product/rapid-diagnostic-kits/', 'Replace', '/products/rapid-diagnostic-kits',
     'Keep existing behaviour.', 'Redirect required'],
    ['/product/medical-device/ (legacy URL)', OLD + '/product/medical-device/', 'Sitemap only', 'Redirect',
     '301 → /product/medical-devices-and-disposables/', 'Replace', '/products/medical-devices-and-disposables',
     'Already a redirect.', 'Redirect required'],
    ['Post: How Private Clinics Improve Healthcare Access', OLD + '/how-private-clinics-improve-healthcare-access/',
     'None (orphan; in wp-sitemap only)', 'Blog post', 'Generic private-clinic article, dated May 2025.',
     'Remove', '—', 'Off-topic theme/demo content — not Nymak content, not linked anywhere. 410 or 301 → /blog.',
     'Removal — CLIENT APPROVAL REQUIRED'],
    ['Post: How Private Clinics Improve Healthcare Access (2)', OLD + '/how-private-clinics-improve-healthcare-access-2/',
     'None (orphan)', 'Blog post', 'Duplicate of the above.', 'Remove', '—', 'Duplicate + off-topic.',
     'Removal — CLIENT APPROVAL REQUIRED'],
    ['Post: Personalized Medical Care At Private Clinics', OLD + '/personalized-medical-care-at-private-clinics/',
     'None (orphan)', 'Blog post', 'Generic private-clinic article.', 'Remove', '—', 'Off-topic demo content.',
     'Removal — CLIENT APPROVAL REQUIRED'],
    ['Post: Private Clinic Services For Comprehensive Care', OLD + '/private-clinic-services-for-comprehensive-care/',
     'None (orphan)', 'Blog post', 'Generic private-clinic article.', 'Remove', '—', 'Off-topic demo content.',
     'Removal — CLIENT APPROVAL REQUIRED'],
    ['Privacy Policy', OLD + '/privacy-policy/', 'Referenced by the form consent checkbox', 'Legal page',
     'None — URL returns 404; only a consent checkbox exists.', 'New Page', '/privacy-policy',
     'Required because the form already asks for privacy consent.', 'New'],
    ['Terms of Use', '—', '—', 'Legal page', 'None.', 'New Page', '/terms',
     'Standard legal coverage for a B2B catalogue site.', 'New'],
    ['Manufacturing', '—', '—', 'Capability page', 'Facility facts only exist inside the About text and '
     'testimonials.', 'New Page', '/manufacturing',
     'Requirement §9 core page + supports "pharmaceutical manufacturing" keywords; content assembled from '
     'approved facts.', 'New'],
    ['Quality & Certifications', '—', '—', 'Trust page', 'Certificates strip exists on Home/Team; no dedicated '
     'page.', 'New Page', '/quality-certifications',
     'Requirement §9 core page; consolidates the approved certification list.', 'New'],
    ['Products (overview)', '—', 'Header "Products" linked straight to /iv-fluid/', 'Catalogue index', 'None — no '
     'all-products overview exists.', 'New Page', '/products',
     'Needed as the parent of the 5 categories for nav/breadcrumbs/SEO.', 'New'],
    ['Inside Nymak', '—', '—', 'Story page', 'None — interactive story format is new.', 'New Page',
     '/inside-nymak', 'Signature page of the approved design; timeline dates MUST be verified (2002–2022 '
     'milestones are illustrative).', 'New — CLIENT APPROVAL REQUIRED'],
    ['Blog / Resources', '—', '—', 'Blog index', '4 off-topic orphan posts only.', 'New Page', '/blog',
     'Requirement §9 core page for authority/content marketing; seeds with 4 company-derived articles.',
     'New — CLIENT APPROVAL REQUIRED'],
    ['FAQs', '—', '—', 'Support page', 'None.', 'New Page', '/faqs',
     'Requirement §9 + §14 (conversational Q&A for AI search); answers compiled from approved facts.',
     'New — CLIENT APPROVAL REQUIRED'],
    ['Branded product detail pages (46)', '—', '—', 'Product detail', 'None — brand products not on current site; '
     'exist only as client-supplied pack shots.', 'New Page', '/products/finished-formulations/{brand}',
     'Real products with photography; gives each registered brand a citable page.', 'New — CLIENT APPROVAL REQUIRED'],
    ['Team member detail pages (11)', '—', '—', 'Profile page', 'Bios exist on the Team page.', 'New Page',
     '/team/{member}', 'Extends the approved bios into individual citable pages.', 'New — CLIENT APPROVAL REQUIRED'],
]
sheet(wb.create_sheet('2. Page Inventory'), H2, rows2, [34, 40, 34, 15, 60, 14, 30, 55, 24])
ws2 = wb['2. Page Inventory']
st_col = H2.index('Status') + 1
for r in range(2, len(rows2) + 2):
    s = ws2.cell(row=r, column=st_col).value or ''
    fill = FILL_FLAG if 'APPROVAL' in s or 'REVIEW' in s else (FILL_NEW if s == 'New' else FILL_EXIST)
    ws2.cell(row=r, column=st_col).fill = fill

# ================================================================ SHEET 3 — NEW PAGES
H3 = ['Page Title', 'Proposed URL', 'Navigation Location', 'Purpose', 'Why This Page Is Needed', 'Page Write-up',
      'Main Sections', 'CTA', 'SEO Title', 'Meta Description', 'Notes']
rows3 = [
    ['Manufacturing', '/manufacturing', 'Header (4th item) · Footer ▸ Company', 'Show the facility and in-house '
     'capabilities to support "pharmaceutical manufacturer India" searches.',
     'Requirement §9 core page; facility details currently buried in About copy. All content is assembled from '
     'approved facts (address, WHO-GMP, in-house QC/QA/regulatory/design/warehouse, client inspection quotes) — '
     'no new claims.',
     'Hero: "A WHO-GMP facility built for export" — located at Plot No. 22, Phase 3, Port Biz Industrial Park, '
     'Kandla-Mundra Highway, Mundra (Kutch), Gujarat. Overview ×3 paragraphs. Capability cards ×6 (QC lab, QA, '
     'regulatory & dossier, design & packaging, warehousing & logistics, continuous up-gradation). Dosage-form '
     'cards ×6 summarising the approved catalogue.',
     'Hero · Manufacturing at Mundra (×3 paras) · What runs inside the facility (6 cards) · Dosage forms & product '
     'lines (6 cards)', 'Discuss your requirement → /contact',
     'Pharmaceutical Manufacturing Facility — Mundra, Gujarat | Nymak Pharma',
     'Inside Nymak Pharma\'s WHO-GMP certified manufacturing facility in Mundra, Gujarat — in-house QC lab, QA '
     'systems, regulatory and warehouse teams.',
     'CLIENT APPROVAL REQUIRED — new page; verify the assembled copy reads accurately.'],
    ['Quality & Certifications', '/quality-certifications', 'Header (5th item, label "Quality") · Footer ▸ Company',
     'One verifiable home for all credentials (WHO-GMP, ISO 13485, Star Export House, Pharmexcil RCMC, IEC, GST).',
     'Requirement §9 core page; certificates currently only appear as a strip on Home/Team with linked PDFs.',
     'Hero: "Certified quality, verifiable compliance". Credentials grid (approved strip copy verbatim + per-cert '
     'description microcopy). Certificate scans. "How quality works here" ×3 paragraphs (approved facts). '
     'Quality FAQ sidebar.',
     'Hero · Awards & certifications · Certificate scans · How quality works here · Quality questions',
     'See all FAQs → /faqs', 'Quality & Certifications — WHO-GMP, ISO 13485 | Nymak Pharma',
     'Nymak Pharma\'s quality credentials: WHO-GMP certified facility, ISO 13485:2016, Star Export House, '
     'Pharmexcil RCMC — with in-house QC/QA oversight.',
     'CLIENT APPROVAL REQUIRED — new page; cert descriptions are new microcopy; confirm certificate PDFs may be '
     're-published.'],
    ['Products (overview)', '/products', 'Header: Products · Footer ▸ Products → All Products',
     'Catalogue landing page listing the five categories and the branded range.',
     'The old nav jumped straight to IV Fluids; a parent page is required for breadcrumbs, sitemap and SEO '
     '(Requirement §9).',
     'Hero: "A pharmaceutical export portfolio built for real-world need" — "Five segments, 300+ line items, one '
     'manufacturing standard." Category cards ×5 · branded-range band · enquiry card.',
     'Hero · Category cards ×5 · Registered Nymak brands · Need something specific?',
     'Send an enquiry → /contact',
     'Pharmaceutical Products — IV Fluids, Formulations & More | Nymak Pharma',
     'Explore Nymak Pharma\'s export portfolio: IV fluids, finished formulations, medical devices & disposables, '
     'rapid diagnostic kits and vaccines.',
     'CLIENT APPROVAL REQUIRED — new page; verify "300+ line items" claim matches the catalogue the client wants '
     'public.'],
    ['Inside Nymak', '/inside-nymak', 'Header (8th item)', 'Interactive brand story — the signature visual page '
     'of the approved design.',
     'Approved design includes this page; it must not ship with invented history.',
     'Hero: "From a single ampoule to 24+ countries". Scroll-driven timeline (14 milestones). Market explorer '
     '(tap a market → products supplied). Closing CTA.',
     'Hero · Journey timeline · Market explorer · Closing CTA', 'Contact us → /contact',
     'Inside Nymak — An Interactive Story | Nymak Pharma',
     'An interactive walk through Nymak Pharma — from a 1998 startup in Mundra to an exporter trusted across '
     '24+ countries.',
     'CLIENT APPROVAL REQUIRED — the dated milestones for 2002–2022 are illustrative; client must confirm real '
     'dates or approve a reduced timeline of documented milestones only.'],
    ['Blog / Resources', '/blog', 'Header (9th item) · Footer ▸ Company', 'Article index for company news, '
     'quality explainers and product knowledge.',
     'Requirement §9 core page + §14/15 (conversational, citable content for AI search). The 4 existing orphan '
     'posts are off-topic demo content (proposed removal).',
     'Hero: "Insights from inside pharmaceutical exports" + article cards.',
     'Hero · Article cards · pagination', 'Read article → /blog/{slug}',
     'Insights & Resources | Nymak Pharma',
     'Company news, quality explainers and product insights from Nymak Pharma — a WHO-GMP certified pharmaceutical '
     'manufacturer and exporter.',
     'CLIENT APPROVAL REQUIRED — new page.'],
    ['Article — The Nymak Pharma Journey', '/blog/nymak-pharma-journey-1998-to-24-countries', 'Blog ▸ Company',
     'Company history article.', 'Authority content derived entirely from the approved About copy.',
     '1998 founding with Sterilized Water for Injections BP · South Pacific expansion · Honduras · 2000 Nigeria '
     '(+25% exports) · today: 24+ countries, 200+ containers FY 2023–24, Star Export House.',
     'H2s: Expanding beyond the first markets · The Nigeria milestone · Where we stand today',
     'Explore our products → /products', 'Nymak Pharma Journey: 1998 to 24+ Export Countries | Nymak Pharma',
     'The story of Nymak Pharma — from Sterilized Water for Injections in 1998 to a Star Export House supplying '
     'pharmaceuticals across 24+ countries.', 'CLIENT APPROVAL REQUIRED.'],
    ['Article — What WHO-GMP Certification Means', '/blog/who-gmp-certification-nymak-pharma', 'Blog ▸ Quality',
     'Quality explainer.', 'Converts approved certification facts into a citable explainer.',
     'What GMP covers · quality control at the Mundra facility (QC lab + QA review + regulatory + design) · why it '
     'matters to buyers · credentials list.',
     'H2s: What the standard covers · Quality control in practice at Nymak · Why it matters for buyers',
     'See certifications → /quality-certifications',
     'WHO-GMP Certified Pharmaceutical Manufacturer | Nymak Pharma',
     'What WHO-GMP and ISO 13485 certification mean in practice at Nymak Pharma — and why they matter to '
     'importers, distributors and health programmes.', 'CLIENT APPROVAL REQUIRED.'],
    ['Article — Inside the IV Fluids Range', '/blog/iv-fluids-range-large-volume-parenterals', 'Blog ▸ Products',
     'Product-range explainer.', 'Converts the approved IV fluids catalogue into a readable explainer.',
     'Core replenishers · multi-electrolyte & specialist fluids · therapeutic infusions · export readiness.',
     'H2s: The core replenisher range · Multi-electrolyte and specialist fluids · Therapeutic infusions · Built '
     'for export', 'Browse IV fluids → /products/iv-fluids',
     'IV Fluids & Large-Volume Parenterals | Nymak Pharma',
     'Inside Nymak Pharma\'s IV fluids range — saline, dextrose, RL, multi-electrolyte and therapeutic infusions '
     'manufactured under WHO-GMP for 24+ markets.', 'CLIENT APPROVAL REQUIRED.'],
    ['Article — Star Export House: What the Recognition Means', '/blog/star-export-house-recognition',
     'Blog ▸ Company', 'Credential explainer.', 'Converts the approved Star Export House credential into a '
     'citable article.',
     'What the status recognises · what it signals to partners · part of a larger quality story.',
     'H2s: What the status recognises · What it signals to partners · Part of a larger quality story',
     'Our credentials → /quality-certifications',
     'Star Export House Certified Pharma Exporter | Nymak Pharma',
     'Nymak Pharma is a Government of India certified Star Export House — what the recognition means for '
     'importers, distributors and partners.', 'CLIENT APPROVAL REQUIRED.'],
    ['FAQs', '/faqs', 'Footer ▸ Company (deliberately not in the header)', 'Single page answering the 12 partner '
     'questions (General/Products/Quality/Exports).',
     'Requirement §9 core page + §14 Q&A content for AI search; also powers FAQPage schema.',
     'Hero + 12 Q&A grouped under General (3), Products (4), Quality (2), Exports (3) + closing CTA.',
     'Hero · FAQ groups · Still have a question? CTA', 'Contact us → /contact',
     'Frequently Asked Questions | Nymak Pharma',
     'Answers about Nymak Pharma\'s products, IV fluids, certifications, export markets, quality systems and how '
     'to partner with us.',
     'CLIENT APPROVAL REQUIRED — all 12 answers are new copy assembled from approved facts.'],
    ['Privacy Policy', '/privacy-policy', 'Footer bottom bar', 'Legal basis for the existing form-consent '
     'checkbox.', 'The current form already asks users to "Agree To The Privacy Policy" but no such page exists '
     '(404). Required for compliance + trust.',
     '6 sections covering data collection (enquiry form + IP for abuse prevention), use, contact-data handling, '
     'retention, cookies/analytics, contact.',
     'Information we collect · How we use it · Email & contact data · Data retention · Cookies & analytics · '
     'Contact', '—', 'Privacy Policy | Nymak Pharma',
     'How Nymak Pharma collects, uses and protects personal data submitted through this website.',
     'CLIENT APPROVAL REQUIRED — legal review recommended before publish.'],
    ['Terms of Use', '/terms', 'Footer bottom bar', 'B2B catalogue terms (not medical advice, IP, liability, '
     'governing law).', 'Standard protection for a B2B pharma catalogue; no equivalent exists today.',
     '6 sections: About this website · Product information · Intellectual property · Accuracy · Liability · '
     'Governing law (India / Gujarat).',
     'About this website · Product information · Intellectual property · Accuracy · Liability · Governing law',
     '—', 'Terms of Use | Nymak Pharma',
     'Terms governing the use of the Nymak Pharma website and its content.',
     'CLIENT APPROVAL REQUIRED — legal review recommended.'],
    ['Branded product detail pages ×46', '/products/finished-formulations/{brand-slug}', 'Linked from Home '
     'brands band, /products branded range, market explorer and category page.',
     'A citable page per registered brand product (Alumak, Amoximak, Cefmak, Cipromak, Clavmak, Zincomak, etc.).',
     'Real products with client-supplied pack shots for Sierra Leone (24) and Liberia (22). Each page: product '
     'name, composition note, market, pack shot, enquiry CTA, Product schema.',
     'Template per product: title · brand photo · composition/description line · market supplied · spec block · '
     'enquiry CTA.', 'Enquire about this product → /contact?product={id}',
     '{Product Name} — {composition} | Nymak Pharma (pattern)', '{Brand} — {composition} supplied to {market} '
     'by Nymak Pharma, WHO-GMP manufactured. (pattern)',
     'CLIENT APPROVAL REQUIRED — compositions are read from pack shots; client must verify each product\'s public '
     'composition before launch.'],
    ['Team member detail pages ×11', '/team/{member-slug}', 'Linked from Team page cards.',
     'Individual profile page per team member.', 'Extends the approved bios into citable pages (Person schema); '
     'helps "key person" searches.',
     'Template per member: name · role · approved bio · back to team.',
     'Name · role · bio · CTA', 'Contact us → /contact',
     '{Member Name} — {Role} | Nymak Pharma (pattern)', 'Approved bio (≤155 chars) as description (pattern).',
     'CLIENT APPROVAL REQUIRED — new page type; confirm members consent to individual pages.'],
]
sheet(wb.create_sheet('3. New Pages'), H3, rows3, [32, 34, 30, 40, 48, 60, 44, 28, 44, 48, 44])
ws3 = wb['3. New Pages']
for r in range(2, len(rows3) + 2):
    ws3.cell(row=r, column=1).fill = FILL_NEW

# ================================================================ SHEET 4 — NAVIGATION
H4 = ['#', 'EXISTING — Header (nymakpharma.com)', 'EXISTING — Destination', '',
      'PROPOSED — Header (new site)', 'PROPOSED — Destination', 'Change']
rows4 = [
    [1, 'Home', '/', '', 'Home', '/', 'No change'],
    [2, 'About Us', '/about-us/', '', 'About Us', '/about', 'URL shortened (301)'],
    [3, 'Products', '/iv-fluid/ (301 → /product/iv-fluids/)', '',
     'Products  ▾ dropdown', '/products + 5 categories', 'Restructured — becomes overview + dropdown'],
    ['3a', '— (no dropdown)', '', '', '▾ All Products', '/products', 'New'],
    ['3b', '', '', '', '▾ IV Fluids', '/products/iv-fluids', 'URL: /product/iv-fluids/ → /products/iv-fluids (301)'],
    ['3c', '', '', '', '▾ Finished Formulations', '/products/finished-formulations',
     'URL: /product/finished-formulations/ → /products/finished-formulations (301)'],
    ['3d', '', '', '', '▾ Medical Devices & Disposables', '/products/medical-devices-and-disposables',
     'URL change (301)'],
    ['3e', '', '', '', '▾ Rapid Diagnostic Kits', '/products/rapid-diagnostic-kits', 'URL change (301)'],
    ['3f', '', '', '', '▾ Vaccines & Antisera', '/products/vaccines', 'URL change (301); label adds "& Antisera"'],
    [4, 'Team', '/team/', '', 'Manufacturing', '/manufacturing', 'NEW item — approval required'],
    [5, 'Global Presence', '/global-presence/', '', 'Quality', '/quality-certifications',
     'NEW item — approval required'],
    [6, 'Contact Us (button)', '/contact-us/', '', 'Global Presence', '/global-presence', 'No change'],
    ['7', '', '', '', 'Team', '/team', 'No change (URL: /team/ → /team)'],
    ['8', '', '', '', 'Inside Nymak', '/inside-nymak', 'NEW item — approval required'],
    ['9', '', '', '', 'Blog', '/blog', 'NEW item — approval required'],
    ['10', '', '', '', 'Contact Us (button)', '/contact', 'URL: /contact-us/ → /contact (301)'],
]
ws4 = wb.create_sheet('4. Navigation')
ws4.append(['EXISTING vs PROPOSED NAVIGATION — header'])
ws4.row_dimensions[1].height = 24
for c in range(1, len(H4) + 1):
    ws4.cell(row=1, column=c).fill = HDR_FILL
    ws4.cell(row=1, column=c).font = Font(name='Calibri', size=12, bold=True, color='FFFFFFFF')
ws4.append(H4)
for c in range(1, len(H4) + 1):
    cell = ws4.cell(row=2, column=c)
    cell.fill, cell.font, cell.alignment = HDR_FILL, HDR_FONT, WRAP_C
for r in rows4:
    ws4.append(r)
for i, w in enumerate([6, 34, 34, 2, 32, 34, 40], start=1):
    ws4.column_dimensions[get_column_letter(i)].width = w
start = len(rows4) + 4
ws4.cell(row=start, column=1, value='FOOTER NAVIGATION')
for c in range(1, len(H4) + 1):
    ws4.cell(row=start, column=c).fill = HDR_FILL
    ws4.cell(row=start, column=c).font = Font(name='Calibri', size=12, bold=True, color='FFFFFFFF')
ws4.row_dimensions[start].height = 24
ws4.append([])
ws4.append(['EXISTING — Footer', '', '', '', 'PROPOSED — Footer', '', ''])
frow = ws4.max_row
for c in range(1, len(H4) + 1):
    ws4.cell(row=frow, column=c).fill = HDR_FILL
    ws4.cell(row=frow, column=c).font = HDR_FONT
    ws4.cell(row=frow, column=c).alignment = WRAP_C
foot_rows = [
    ['Quick Links: About Us · Products · Global Reach · Team · Contact Us', '', '', '',
     'Company: About Us · Manufacturing · Quality & Certifications · Global Presence · Blog & Resources · FAQs · '
     'Contact Us', '', 'Adds Manufacturing, Quality, Blog, FAQs; "Global Reach" renamed to real page name'],
    ['Product Categories: IV Fluids · Finished Formulations · Medical Devices & Disposables · Rapid Diagnostic '
     'Kits · Vaccines', '', '', '',
     'Products: All Products + same 5 categories', '', 'Same categories + "All Products" link'],
    ['Get Connected: phone +91 98252 25567 · info@nymakpharma.com · Mundra address', '', '', '',
     'Get in Touch: same NAP (name/address/phone) + social icons', '', 'Same contact facts; socials added'],
    ['© 2026 Nymakpharma · Powered by Vox360 · WhatsApp float', '', '', '',
     '© year Nymak Pharma Private Limited · Privacy Policy · Terms of Use · Brochure · Sitemap · WhatsApp float',
     '', 'Adds legal/brochure/sitemap links; drops "Powered by" credit'],
]
base = ws4.max_row + 1
for r in foot_rows:
    ws4.append(r)
for rr in range(base - 1, ws4.max_row + 1):
    for cc in range(1, 8):
        ws4.cell(row=rr, column=cc).alignment = WRAP
        if rr == base - 1:
            ws4.cell(row=rr, column=cc).font = BODY_B
for row in ws4.iter_rows(min_row=3):
    for cell in row:
        cell.alignment = WRAP
        if cell.font == Font():
            cell.font = BODY
ws4.freeze_panes = 'A3'

# ================================================================ SHEET 5 — CONTENT CHANGE LOG
H5 = ['Page', 'Section', 'Existing Content (nymakpharma.com)', 'Proposed Content (new site)', 'Change Type',
      'Reason', 'Approval Required']
rows5 = [
    ['Home', 'Hero sub-headline',
     '"Your Reliable Partner in Efficacious Lifecare Solutions— Trusted in 24 Countries and Counting"',
     'Same sentence + new second sentence listing the five product segments '
     '(for SEO/AI readability).', 'New Content (addition)', 'Keyword coverage + entity clarity', 'Yes'],
    ['Home', 'About preview',
     'Single paragraph from the About page (founded 1998, Sterilized Water for Injections BP, South Pacific, '
     '"behind every product is a person in need").',
     'Two short paragraphs covering 1998 → Nigeria 2000 → today (WHO-GMP facility, Star Export House).',
     'Rewritten', 'Condensed for homepage scanning; all facts preserved', 'Yes'],
    ['Home', 'Values markers', '"Quality / Trust / Efficacy" three-part heading.',
     'Expressed on the About page values cards (Efficacy, Customer-first, Sincerity).', 'Merged',
     'Avoid duplicating the values on two pages', 'Yes'],
    ['Home', 'Facility video banner', 'Video banner with Play control.',
     'Not carried into the design.', 'Removed', 'Design has no video section; reinstate if client supplies file',
     'Yes — decision'],
    ['Home', 'Product categories', '5 category icon cards (same names).',
     '5 cards with condensed intro lines + links.', 'Formatting Only', 'Same content, card redesign', 'No'],
    ['Home', 'Marketed brands', 'None on current site.', 'Branded-range band with pack shots (Alumak, Cefmak…).',
     'New Content', 'Showcases real registered brands (client-supplied photos)', 'Yes'],
    ['Home', 'Client logos', 'None on current site.', 'Marquee of 12 partner logos.', 'New Content',
     'Trust signal; assets supplied by client', 'Yes'],
    ['Home', 'Awards & certificates strip', AWARDS_BODY + ' + 6 certificate cards with PDF links.',
     'Same six credentials shown on /quality-certifications + a Home "Certified for the markets that demand '
     'proof" band.', 'Reordered', 'Certificates consolidated on the dedicated Quality page', 'Yes'],
    ['Home', 'Testimonials', TESTIMONIALS, 'Same three testimonials verbatim.', 'No Change', '—', 'No'],
    ['Home', 'FAQ preview', 'None.', '4-question preview → /faqs.', 'New Content', 'AIO/GEO Q&A requirement', 'Yes'],
    ['Home', 'Journal preview', 'None.', 'Latest articles preview → /blog.', 'New Content', 'Requirement §9', 'Yes'],
    ['Home', 'Closing CTA', '"Have Questions? Get In Touch!" + enquiry form.',
     '"Have a requirement? Let\'s talk." + CTA buttons (form lives on /contact).', 'Rewritten',
     'B2B wording; form consolidated on Contact', 'Yes'],
    ['About', 'Company overview', '7 paragraphs incl. explicit 2000/Nigeria +25% growth, "over 26 years", '
     '"more than 22 countries".',
     '3 paragraphs + timeline; "over 25 years", "more than 24 countries" (brochure figures).', 'Rewritten',
     'Split into scannable sections; figures standardised to brochure (decisions documented)', 'Yes'],
    ['About', 'Testimonials', 'Same 3 testimonials at page foot.', 'Shown on Home only.', 'Merged',
     'Avoid duplicating identical quotes on two pages', 'Yes'],
    ['Products (all)', 'Navigation target', '"Products" header item linked to /iv-fluid/ (IV Fluids only).',
     '"Products" → /products overview + dropdown of 5 categories.', 'Restructured',
     'Old link hid 4 of 5 categories from the main nav', 'Yes'],
    ['Category pages', 'Intro paragraphs', 'Category-specific approved intro paragraphs (long-form).',
     'Condensed one-sentence intros + new factual description paragraph.', 'Rewritten',
     'Shorter hero copy; description added for 300-word SEO minimum', 'Yes'],
    ['Category pages', 'Product tables', 'Grouped product tables (name/strength/pack).',
     'Identical product rows; group headings lightly re-titled; tables become searchable spec tables.', 'No Change',
     '—', 'No'],
    ['Finished Formulations', 'Chloroquine Phosphate rows', 'Two rows: 250 mg and 100 mg (separate).',
     'One row "100 mg / 250 mg".', 'Merged', 'Same product, two strengths — consolidated like other products', 'Yes'],
    ['Finished Formulations', 'Salbutamol syrup', '"Sulbutamol Syrup — 2 mg / 5 ml".',
     '"Salbutamol Syrup — 2 mg / 5 ml".', 'Minor Edit', 'Obvious typo in approved content (Salbutamol is the INN)',
     'Yes — factual correction'],
    ['Finished Formulations', 'Pantoprazole inj', '"Prantoprazole for Injection — 40 mg".',
     '"Pantoprazole for Injection — 40 mg".', 'Minor Edit', 'Obvious typo (Pantoprazole is the INN)',
     'Yes — factual correction'],
    ['Medical Devices', 'Cannula description', '"I.V. Cannula without wings and without injection port".',
     '"I.V. Cannula without Wings & Injection Port".', 'Minor Edit', 'Matches the approved wording\'s intent '
     '(without both features)', 'Yes — verify meaning preserved'],
    ['Medical Devices', 'Stray row', '"Neonates only" — a row with no product/strength.',
     'Dropped from the table.', 'Removed', 'Not a product; appears to be an annotation error', 'Yes'],
    ['Medical Devices', 'Flat list', 'One flat table of 36 rows.', 'Same 35 items under 4 sub-headings.',
     'Reordered', 'Readability only — no items added or removed (except stray row above)', 'Yes'],
    ['Vaccines', 'Category name', '"Vaccines".', '"Vaccines & Antisera" (URL slug unchanged).', 'Minor Edit',
     'Listed products are antisera/immunoglobulins — more accurate label', 'Yes'],
    ['Team', 'Member name', '"Murtuza Naqvi".', '"Murtaza Naqvi".', 'Minor Edit',
     'Spelling normalised — must confirm correct spelling with client', 'Yes — factual correction'],
    ['Team', 'Member cards', 'Name, role, bio on a single page.', 'Same + each bio also gets a detail page '
     '/team/{slug}.', 'New Content (pages)', 'Citable profile pages; same approved bio text', 'Yes'],
    ['Team', 'Awards + CTA strips', 'Certificates grid + "Get In Touch" at page foot.',
     'Certificates live on /quality-certifications; global CTA/footer used.', 'Merged', 'Single home for '
     'certificates', 'Yes'],
    ['Global Presence', 'Intro', 'Approved paragraph (24+ countries…).', 'Verbatim paragraph as hero lead.',
     'No Change', '—', 'No'],
    ['Global Presence', 'Markets list', 'Paragraph names 5 countries; offices listed on Contact.',
     'Cards for Sierra Leone/Liberia/Nigeria + chips for 11 named markets (incl. Ghana).', 'New Content',
     'Structured from approved mentions; Ghana added — needs client confirmation', 'Yes'],
    ['Global Presence', 'Offices', 'Group Companies cards on Contact page.', 'Office cards on Global Presence.',
     'Reordered', 'Offices belong on the markets page; also remain on Contact', 'Yes'],
    ['Contact', 'Form fields', 'Full Name*, Email*, Phone*, Subject, Message + privacy checkbox.',
     'Adds Company, Country, Product-of-Interest dropdown.', 'Minor Edit', 'Lead qualification for the exports '
     'team', 'Yes'],
    ['Contact', 'Group company — Coral Marketing', 'Coral Marketing card: Plot No. 22…, +91 9687250541, '
     'info@coralmarketing.net.', 'Not shown (it is a group company, not a Nymak office).', 'Removed',
     'Kept Nymak offices only; reinstate if client wants group companies listed', 'Yes — decision'],
    ['Contact', 'Sierra Leone address', '"39, Liverpool Street, Off Pademba Road, Freetown".',
     '"1st Floor, 39 Liverpool Street (UP), Off Pademba Road, Freetown".', 'Minor Edit',
     'Fuller address used in client assets — verify', 'Yes — verify'],
    ['Contact', 'Liberia phone', '+231 555188288 only.', '+231 555 188 288 · +231 777 736 498.', 'Minor Edit',
     'Second number from client materials — verify before launch', 'Yes — verify'],
    ['Contact', 'Business hours', 'None on current site.', '"Mon–Sat, 9:30–18:30 IST".', 'New Content',
     'Sets response expectations', 'Yes — verify hours'],
    ['Contact', 'Postal code', 'Address shown without PIN code.', 'Adds "370421" (Mundra, Kutch).', 'Minor Edit',
     'NAP/schema completeness', 'Yes — verify PIN'],
    ['Blog', 'Orphan posts', '4 "private clinic" articles (orphaned, off-topic, May 2025).', 'Removed (410) or '
     'redirected to /blog.', 'Removed', 'Not Nymak content — likely theme demo leftovers', 'Yes — decision'],
    ['Legal', 'Privacy Policy', 'Checkbox text only; /privacy-policy/ is 404.', 'Full privacy page.', 'New Content',
     'The checkbox already promises a policy', 'Yes — legal review'],
    ['Legal', 'Terms of Use', 'None.', 'Full terms page.', 'New Content', 'Standard B2B protection', 'Yes — legal review'],
    ['Inside Nymak', 'Timeline', 'None on current site.', '14 dated milestones 1998–2024.', 'New Content',
     'Signature design page — dates 2002–2022 need client verification', 'Yes — verify dates'],
    ['All pages', 'SEO titles', '"{Page} – Nymak Pharma Pvt. Ltd." pattern; home title only 22 chars.',
     'Unique keyword-forward titles, e.g. "Pharmaceutical Manufacturer & Exporter in India | Nymak Pharma".',
     'Rewritten', 'Requirement §5 (unique descriptive titles)', 'Yes'],
    ['All pages', 'Meta descriptions', 'None on any page.', 'Unique 120–160-char descriptions per page.',
     'New Content', 'Requirement §6', 'Yes'],
    ['All pages', 'URLs', '/about-us/, /contact-us/, /product/{category}/', '/about, /contact, /products/{category}',
     'Reordered', 'Shorter keyword URLs (Requirement §7); 301 redirects mapped in seo-page-map.md', 'Yes'],
    ['Footer', 'Links', 'Quick Links + Product Categories + contact.', 'Adds Manufacturing, Quality, Blog, FAQs, '
     'Privacy, Terms, Brochure, Sitemap.', 'New Content', 'Surface the new pages; standard utilities', 'Yes'],
]
sheet(wb.create_sheet('5. Content Change Log'), H5, rows5, [18, 26, 48, 48, 16, 44, 16])
ws5 = wb['5. Content Change Log']
ap_col = H5.index('Approval Required') + 1
for r in range(2, len(rows5) + 2):
    if str(ws5.cell(row=r, column=ap_col).value).startswith('Yes'):
        ws5.cell(row=r, column=ap_col).fill = FILL_FLAG

wb.save(OUT)
print(f'Wrote {OUT}')
print(f'  Sheet1 rows: {len(rows1)} | Sheet2 rows: {len(rows2)} | Sheet3 rows: {len(rows3)} '
      f'| Sheet5 rows: {len(rows5)}')
