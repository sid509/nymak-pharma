<?php

/**
 * FR/ES data for Product seeding.
 *
 * - 'groups': therapeutic_group dictionary (EN => [fr, es])
 * - 'descriptions': slug => [fr, es] for the 50 products that carry one
 * - 'names': explicit overrides for names that don't fit the
 *   "<Molecule> <Form>" rule translator (devices, kits, specials)
 */
return [
    'groups' => [
        'Anaesthetics' => ['fr' => 'Anesthésiques', 'es' => 'Anestésicos'],
        'Analgesic & Antipyretic' => ['fr' => 'Analgésiques & antipyrétiques', 'es' => 'Analgésicos y antipiréticos'],
        'Analgesics, Cough & Cold' => ['fr' => 'Analgésiques, toux & rhume', 'es' => 'Analgésicos, tos y resfriado'],
        'Anthelmintics' => ['fr' => 'Anthelminthiques', 'es' => 'Antihelmínticos'],
        'Anti-Diabetics' => ['fr' => 'Antidiabétiques', 'es' => 'Antidiabéticos'],
        'Anti-Inflammatories' => ['fr' => 'Anti-inflammatoires', 'es' => 'Antiinflamatorios'],
        'Antiamoebic Infusions' => ['fr' => 'Perfusions anti-amibiennes', 'es' => 'Perfusiones antiamebianas'],
        'Antiasthmatics' => ['fr' => 'Antiasthmatiques', 'es' => 'Antiasmáticos'],
        'Antibacterial Infusions' => ['fr' => 'Perfusions antibactériennes', 'es' => 'Perfusiones antibacterianas'],
        'Antibacterials' => ['fr' => 'Antibactériens', 'es' => 'Antibacterianos'],
        'Antibiotics — Quinolones' => ['fr' => 'Antibiotiques — quinolones', 'es' => 'Antibióticos — quinolonas'],
        'Antibiotics — β-Lactam' => ['fr' => 'Antibiotiques — bêta-lactamines', 'es' => 'Antibióticos — betalactámicos'],
        'Anticoagulants' => ['fr' => 'Anticoagulants', 'es' => 'Anticoagulantes'],
        'Antidiarrhoeals' => ['fr' => 'Antidiarrhéiques', 'es' => 'Antidiarreicos'],
        'Antiemetics' => ['fr' => 'Antiémétiques', 'es' => 'Antieméticos'],
        'Antifungal Infusions' => ['fr' => 'Perfusions antifongiques', 'es' => 'Perfusiones antifúngicas'],
        'Antifungals' => ['fr' => 'Antifongiques', 'es' => 'Antifúngicos'],
        'Antimalarials' => ['fr' => 'Antipaludiques', 'es' => 'Antipalúdicos'],
        'Antiprotozoal Infusions' => ['fr' => 'Perfusions antiprotozoaires', 'es' => 'Perfusiones antiprotozoarias'],
        'Antiretrovirals (ARVs)' => ['fr' => 'Antirétroviraux (ARV)', 'es' => 'Antirretrovirales (ARV)'],
        'Antisera & Immunoglobulins' => ['fr' => 'Antisérums & immunoglobulines', 'es' => 'Antisueros e inmunoglobulinas'],
        'Antispasmodics' => ['fr' => 'Antispasmodiques', 'es' => 'Antiespasmódicos'],
        'Antiulcerants' => ['fr' => 'Antiulcéreux', 'es' => 'Antiulcerosos'],
        'Anxiolytics' => ['fr' => 'Anxiolytiques', 'es' => 'Ansiolíticos'],
        'Cardiovascular' => ['fr' => 'Cardiovasculaires', 'es' => 'Cardiovasculares'],
        'Cephalosporins' => ['fr' => 'Céphalosporines', 'es' => 'Cefalosporinas'],
        'Clavulanate Combinations' => ['fr' => 'Associations au clavulanate', 'es' => 'Combinaciones con clavulanato'],
        'Dry Powder Injections' => ['fr' => 'Poudres sèches pour injection', 'es' => 'Polvos secos para inyección'],
        'Electrolyte & Dextrose IV Infusions' => ['fr' => 'Perfusions IV d’électrolytes & glucose', 'es' => 'Perfusiones IV de electrolitos y glucosa'],
        'Erectile Dysfunction' => ['fr' => 'Dysfonction érectile', 'es' => 'Disfunción eréctil'],
        'Fluid & Electrolyte Replenishers' => ['fr' => 'Réhydratants fluides & électrolytiques', 'es' => 'Rehidratantes de fluidos y electrolitos'],
        'Haemostatic Agents' => ['fr' => 'Agents hémostatiques', 'es' => 'Agentes hemostáticos'],
        'IV Access & Infusion' => ['fr' => 'Accès IV & perfusion', 'es' => 'Acceso IV e infusión'],
        'Immunosuppressants' => ['fr' => 'Immunosuppresseurs', 'es' => 'Inmunosupresores'],
        'Macrolides' => ['fr' => 'Macrolides', 'es' => 'Macrólidos'],
        'Nutrient & Fluid Replenishers' => ['fr' => 'Réhydratants nutritifs & fluides', 'es' => 'Rehidratantes nutritivos y de fluidos'],
        'Nymak Branded Range' => ['fr' => 'Gamme de marque Nymak', 'es' => 'Gama de marca Nymak'],
        'Opioid Analgesics & Dependence Care' => ['fr' => 'Analgésiques opioïdes & traitement de la dépendance', 'es' => 'Analgésicos opioides y tratamiento de la dependencia'],
        'Osmotic Diuretics' => ['fr' => 'Diurétiques osmotiques', 'es' => 'Diuréticos osmóticos'],
        'Ovulation Stimulants' => ['fr' => 'Stimulants de l’ovulation', 'es' => 'Estimulantes de la ovulación'],
        'Oxazolidinones' => ['fr' => 'Oxazolidinones', 'es' => 'Oxazolidinonas'],
        'Patient Care & Urology' => ['fr' => 'Soins du patient & urologie', 'es' => 'Cuidado del paciente y urología'],
        'Penems' => ['fr' => 'Pénems', 'es' => 'Penems'],
        'Peritoneal Dialysis' => ['fr' => 'Dialyse péritonéale', 'es' => 'Diálisis peritoneal'],
        'Rapid Tests' => ['fr' => 'Tests rapides', 'es' => 'Pruebas rápidas'],
        'Supplemental Medication' => ['fr' => 'Médicaments complémentaires', 'es' => 'Medicamentos complementarios'],
        'Surgical & Wound Care' => ['fr' => 'Chirurgie & soins des plaies', 'es' => 'Cirugía y cuidado de heridas'],
        'Syringes & Needles' => ['fr' => 'Seringues & aiguilles', 'es' => 'Jeringas y agujas'],
    ],

    'descriptions' => [
        'snake-venom-antiserum-0' => [
            'fr' => 'Immunoglobulines équines polyvalentes raffinées par enzymes (liquide)',
            'es' => 'Inmunoglobulinas equinas polivalentes refinadas por enzimas (líquido)',
        ],
        'combipack-of-snake-venom-antiserum-with-sterile-water-for-injection-bp-1' => [
            'fr' => 'Immunoglobulines équines polyvalentes raffinées par enzymes, lyophilisées',
            'es' => 'Inmunoglobulinas equinas polivalentes refinadas por enzimas, liofilizadas',
        ],
        'tetanus-antitoxin-bp-1500-iu-2' => [
            'fr' => 'Immunoglobulines équines raffinées par enzymes (liquide)',
            'es' => 'Inmunoglobulinas equinas refinadas por enzimas (líquido)',
        ],
        'tetanus-antitoxin-bp-1500-iu-with-sterilized-water-for-injection-bp-3' => [
            'fr' => 'Immunoglobulines équines raffinées par enzymes, lyophilisées',
            'es' => 'Inmunoglobulinas equinas refinadas por enzimas, liofilizadas',
        ],
        'alumak-20-120-tablets-liberia' => [
            'fr' => 'Comprimés antipaludiques Artéméther 20 mg + Luméfantrine 120 mg. Fabriqués dans des conditions WHO-GMP et fournis dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Comprimidos antipalúdicos Arteméter 20 mg + Lumefantrina 120 mg. Fabricados bajo condiciones WHO-GMP y suministrados como parte de la cartera de marca Nymak Pharma.',
        ],
        'alumak-80-480-tablets-liberia' => [
            'fr' => 'Comprimés antipaludiques Artéméther 80 mg + Luméfantrine 480 mg. Fabriqués dans des conditions WHO-GMP et fournis dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Comprimidos antipalúdicos Arteméter 80 mg + Lumefantrina 480 mg. Fabricados bajo condiciones WHO-GMP y suministrados como parte de la cartera de marca Nymak Pharma.',
        ],
        'alumak-sp-liberia' => [
            'fr' => 'Suspension orale d’artéméther et luméfantrine pour le traitement du paludisme pédiatrique. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Suspensión oral de arteméter y lumefantrina para el tratamiento de la malaria pediátrica. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'alzolemak-tablets-liberia' => [
            'fr' => 'Comprimés anthelminthiques à large spectre d’albendazole. Fabriqués dans des conditions WHO-GMP et fournis dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Comprimidos antihelmínticos de amplio espectro de albendazol. Fabricados bajo condiciones WHO-GMP y suministrados como parte de la cartera de marca Nymak Pharma.',
        ],
        'apetimak-liberia' => [
            'fr' => 'Formulation stimulant l’appétit fournie sous la marque Apetimak. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Formulación estimulante del apetito suministrada bajo la marca Apetimak. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'athermak-injection-liberia' => [
            'fr' => 'Injection antipaludique d’α-β arteether pour le traitement du paludisme grave. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Inyección antipalúdica de α-β arteéter para el tratamiento de la malaria grave. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'cefmak-injection-liberia' => [
            'fr' => 'Injection de ceftriaxone, céphalosporine à large spectre. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Inyección de ceftriaxona, cefalosporina de amplio espectro. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'cipromak-500-tablets-liberia' => [
            'fr' => 'Comprimés antibiotiques de ciprofloxacine 500 mg, fluoroquinolone. Fabriqués dans des conditions WHO-GMP et fournis dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Comprimidos antibióticos de ciprofloxacina 500 mg, fluoroquinolona. Fabricados bajo condiciones WHO-GMP y suministrados como parte de la cartera de marca Nymak Pharma.',
        ],
        'clearmak-suspension-liberia' => [
            'fr' => 'Suspension orale fournie sous la marque Clearmak. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Suspensión oral suministrada bajo la marca Clearmak. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'cloxamak-capsules-liberia' => [
            'fr' => 'Gélules antibiotiques de cloxacilline résistante à la pénicillinase. Fabriquées dans des conditions WHO-GMP et fournies dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Cápsulas antibióticas de cloxacilina resistente a la penicilinasa. Fabricadas bajo condiciones WHO-GMP y suministradas como parte de la cartera de marca Nymak Pharma.',
        ],
        'cold-mak-liberia' => [
            'fr' => 'Formulation de soulagement du rhume et de la grippe fournie sous la marque Cold Mak. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Formulación para el alivio del resfriado y la gripe suministrada bajo la marca Cold Mak. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'cotrimak-suspension-liberia' => [
            'fr' => 'Suspension orale antibactérienne de co-trimoxazole. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Suspensión oral antibacteriana de cotrimoxazol. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'doxymak-capsules-liberia' => [
            'fr' => 'Gélules antibiotiques à large spectre de doxycycline 100 mg. Fabriquées dans des conditions WHO-GMP et fournies dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Cápsulas antibióticas de amplio espectro de doxiciclina 100 mg. Fabricadas bajo condiciones WHO-GMP y suministradas como parte de la cartera de marca Nymak Pharma.',
        ],
        'erythromak-liberia' => [
            'fr' => 'Formulation antibiotique macrolide d’érythromycine. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Formulación antibiótica macrólida de eritromicina. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'gas-relief-suspension-liberia' => [
            'fr' => 'Suspension orale antiacide et antiflatulente. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Suspensión oral antiácida y antiflatulenta. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'ibumak-suspension-liberia' => [
            'fr' => 'Suspension orale d’ibuprofène contre la douleur, la fièvre et l’inflammation. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Suspensión oral de ibuprofeno para el dolor, la fiebre y la inflamación. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'ketomak-tablets-liberia' => [
            'fr' => 'Comprimés antifongiques de kétoconazole 200 mg. Fabriqués dans des conditions WHO-GMP et fournis dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Comprimidos antifúngicos de ketoconazol 200 mg. Fabricados bajo condiciones WHO-GMP y suministrados como parte de la cartera de marca Nymak Pharma.',
        ],
        'metromak-suspension-liberia' => [
            'fr' => 'Suspension orale de métronidazole pour les infections amibiennes et anaérobies. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Suspensión oral de metronidazol para infecciones amebianas y anaerobias. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'metromak-tablets-liberia' => [
            'fr' => 'Comprimés de métronidazole pour les infections amibiennes et anaérobies. Fabriqués dans des conditions WHO-GMP et fournis dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Comprimidos de metronidazol para infecciones amebianas y anaerobias. Fabricados bajo condiciones WHO-GMP y suministrados como parte de la cartera de marca Nymak Pharma.',
        ],
        'mzolemak-suspension-liberia' => [
            'fr' => 'Suspension orale anthelminthique fournie sous la marque Mzolemak. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Suspensión oral antihelmíntica suministrada bajo la marca Mzolemak. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'paramak-suspension-liberia' => [
            'fr' => 'Suspension orale pédiatrique de paracétamol pour la fièvre et la douleur. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Suspensión oral pediátrica de paracetamol para la fiebre y el dolor. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'silmak-tablets-liberia' => [
            'fr' => 'Formulation en comprimés fournie sous la marque Silmak pour le marché libérien. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Formulación en comprimidos suministrada bajo la marca Silmak para el mercado liberiano. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'alumak-dp-sierra-leone' => [
            'fr' => 'Formulation antipaludique dispersible d’artéméther et luméfantrine. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Formulación antipalúdica dispersable de arteméter y lumefantrina. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'alumak-forte-sierra-leone' => [
            'fr' => 'Comprimés antipaludiques forte dose Artéméther 80 mg + Luméfantrine 480 mg. Fabriqués dans des conditions WHO-GMP et fournis dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Comprimidos antipalúdicos de alta concentración Arteméter 80 mg + Lumefantrina 480 mg. Fabricados bajo condiciones WHO-GMP y suministrados como parte de la cartera de marca Nymak Pharma.',
        ],
        'alumak-tablets-sierra-leone' => [
            'fr' => 'Comprimés antipaludiques d’artéméther + luméfantrine. Fabriqués dans des conditions WHO-GMP et fournis dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Comprimidos antipalúdicos de arteméter + lumefantrina. Fabricados bajo condiciones WHO-GMP y suministrados como parte de la cartera de marca Nymak Pharma.',
        ],
        'alzolemak-400-tablets-sierra-leone' => [
            'fr' => 'Comprimés anthelminthiques à large spectre d’albendazole 400 mg. Fabriqués dans des conditions WHO-GMP et fournis dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Comprimidos antihelmínticos de amplio espectro de albendazol 400 mg. Fabricados bajo condiciones WHO-GMP y suministrados como parte de la cartera de marca Nymak Pharma.',
        ],
        'amclomak-capsules-sierra-leone' => [
            'fr' => 'Gélules antibiotiques associant ampicilline et cloxacilline. Fabriquées dans des conditions WHO-GMP et fournies dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Cápsulas antibióticas de combinación de ampicilina y cloxacilina. Fabricadas bajo condiciones WHO-GMP y suministradas como parte de la cartera de marca Nymak Pharma.',
        ],
        'amoximak-125-suspension-sierra-leone' => [
            'fr' => 'Suspension orale pédiatrique d’amoxicilline 125 mg / 5 ml. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Suspensión oral pediátrica de amoxicilina 125 mg / 5 ml. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'amoximak-250-suspension-sierra-leone' => [
            'fr' => 'Suspension orale d’amoxicilline 250 mg / 5 ml. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Suspensión oral de amoxicilina 250 mg / 5 ml. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'amoximak-250-tablets-sierra-leone' => [
            'fr' => 'Comprimés antibiotiques pénicilline d’amoxicilline 250 mg. Fabriqués dans des conditions WHO-GMP et fournis dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Comprimidos antibióticos penicilínicos de amoxicilina 250 mg. Fabricados bajo condiciones WHO-GMP y suministrados como parte de la cartera de marca Nymak Pharma.',
        ],
        'ampimak-250-capsules-sierra-leone' => [
            'fr' => 'Gélules antibiotiques d’ampicilline 250 mg. Fabriquées dans des conditions WHO-GMP et fournies dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Cápsulas antibióticas de ampicilina 250 mg. Fabricadas bajo condiciones WHO-GMP y suministradas como parte de la cartera de marca Nymak Pharma.',
        ],
        'artemak-60-injection-sierra-leone' => [
            'fr' => 'Injection d’artésunate 60 mg pour le traitement du paludisme grave. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Inyección de artesunato 60 mg para el tratamiento de la malaria grave. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'biomak-syrup-sierra-leone' => [
            'fr' => 'Sirop nutritionnel fourni sous la marque Biomak. Fabriqué dans des conditions WHO-GMP et fourni dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Jarabe nutricional suministrado bajo la marca Biomak. Fabricado bajo condiciones WHO-GMP y suministrado como parte de la cartera de marca Nymak Pharma.',
        ],
        'cefisimak-400-tablets-sierra-leone' => [
            'fr' => 'Comprimés de céfixime 400 mg, céphalosporine de troisième génération. Fabriqués dans des conditions WHO-GMP et fournis dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Comprimidos de cefixima 400 mg, cefalosporina de tercera generación. Fabricados bajo condiciones WHO-GMP y suministrados como parte de la cartera de marca Nymak Pharma.',
        ],
        'cefmak-injection-sierra-leone' => [
            'fr' => 'Injection de ceftriaxone, céphalosporine à large spectre. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Inyección de ceftriaxona, cefalosporina de amplio espectro. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'cipromak-500-tablets-sierra-leone' => [
            'fr' => 'Comprimés antibiotiques de ciprofloxacine 500 mg, fluoroquinolone. Fabriqués dans des conditions WHO-GMP et fournis dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Comprimidos antibióticos de ciprofloxacina 500 mg, fluoroquinolona. Fabricados bajo condiciones WHO-GMP y suministrados como parte de la cartera de marca Nymak Pharma.',
        ],
        'clavmak-12-g-injection-sierra-leone' => [
            'fr' => 'Injection d’amoxicilline 1 g + clavulanate de potassium 200 mg. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Inyección de amoxicilina 1 g + clavulanato de potasio 200 mg. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'clavmak-228-suspension-sierra-leone' => [
            'fr' => 'Suspension orale d’amoxicilline et clavulanate de potassium 228,5 mg. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Suspensión oral de amoxicilina y clavulanato de potasio 228,5 mg. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'corcef-injection-sierra-leone' => [
            'fr' => 'Antibiotique céphalosporine injectable fourni sous la marque Corcef. Fabriqué dans des conditions WHO-GMP et fourni dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Antibiótico cefalosporínico inyectable suministrado bajo la marca Corcef. Fabricado bajo condiciones WHO-GMP y suministrado como parte de la cartera de marca Nymak Pharma.',
        ],
        'cypmak-tablets-sierra-leone' => [
            'fr' => 'Comprimés de cyproheptadine fournis sous la marque Cypmak. Fabriqués dans des conditions WHO-GMP et fournis dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Comprimidos de ciproheptadina suministrados bajo la marca Cypmak. Fabricados bajo condiciones WHO-GMP y suministrados como parte de la cartera de marca Nymak Pharma.',
        ],
        'doxymak-capsules-sierra-leone' => [
            'fr' => 'Gélules antibiotiques à large spectre de doxycycline 100 mg. Fabriquées dans des conditions WHO-GMP et fournies dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Cápsulas antibióticas de amplio espectro de doxiciclina 100 mg. Fabricadas bajo condiciones WHO-GMP y suministradas como parte de la cartera de marca Nymak Pharma.',
        ],
        'i-paramak-suspension-sierra-leone' => [
            'fr' => 'Suspension orale associant ibuprofène et paracétamol. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Suspensión oral de combinación de ibuprofeno y paracetamol. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'ibumak-400-tablets-sierra-leone' => [
            'fr' => 'Comprimés d’ibuprofène 400 mg contre la douleur, la fièvre et l’inflammation. Fabriqués dans des conditions WHO-GMP et fournis dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Comprimidos de ibuprofeno 400 mg para el dolor, la fiebre y la inflamación. Fabricados bajo condiciones WHO-GMP y suministrados como parte de la cartera de marca Nymak Pharma.',
        ],
        'omemak-injection-sierra-leone' => [
            'fr' => 'Injection d’oméprazole 40 mg pour les troubles liés à l’acidité. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Inyección de omeprazol 40 mg para los trastornos relacionados con la acidez. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'silmak-100-tablets-sierra-leone' => [
            'fr' => 'Formulation en comprimés fournie sous la marque Silmak pour la Sierra Leone. Fabriquée dans des conditions WHO-GMP et fournie dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Formulación en comprimidos suministrada bajo la marca Silmak para Sierra Leona. Fabricada bajo condiciones WHO-GMP y suministrada como parte de la cartera de marca Nymak Pharma.',
        ],
        'zincomak-syrup-sierra-leone' => [
            'fr' => 'Sirop de zinc en complément pour la nutrition pédiatrique et le soutien en cas de diarrhée. Fabriqué dans des conditions WHO-GMP et fourni dans le cadre du portefeuille de marque Nymak Pharma.',
            'es' => 'Jarabe de zinc como suplemento para la nutrición pediátrica y el apoyo en caso de diarrea. Fabricado bajo condiciones WHO-GMP y suministrado como parte de la cartera de marca Nymak Pharma.',
        ],
    ],

    // Names that don't follow "<Molecule> <Form>" — devices, kits, specials.
    'names' => [
        'Intraperitoneal Dialysis Fluid' => ['fr' => 'Liquide de dialyse intrapéritonéale', 'es' => 'Líquido de diálisis intraperitoneal'],
        'Methadone Oral Concentrate' => ['fr' => 'Concentré oral de méthadone', 'es' => 'Concentrado oral de metadona'],
        'Sterile Quinine Dihydrochloride Concentrate' => ['fr' => 'Concentré stérile de dichlorhydrate de quinine', 'es' => 'Concentrado estéril de diclorhidrato de quinina'],
        'Multiple Micronutrient Sachet' => ['fr' => 'Sachet de multi-micronutriments', 'es' => 'Sobre de mult micronutrientes'],
        'Oral Rehydration Salt (ORS)' => ['fr' => 'Sels de réhydratation orale (SRO)', 'es' => 'Sales de rehidratación oral (SRO)'],
        'Zidovudine + Lamivudine + Nevirapine Combipack' => ['fr' => 'Combipack zidovudine + lamivudine + névirapine', 'es' => 'Combipack de zidovudina + lamivudina + nevirapina'],
        'Insulin Syringe' => ['fr' => 'Seringue à insuline', 'es' => 'Jeringa de insulina'],
        'Single Use Syringe' => ['fr' => 'Seringue à usage unique', 'es' => 'Jeringa de un solo uso'],
        'Single Use Needle' => ['fr' => 'Aiguille à usage unique', 'es' => 'Aguja de un solo uso'],
        'Pen Needles' => ['fr' => 'Aiguilles pour stylo', 'es' => 'Agujas para pluma'],
        'Disposable Spinal Needle' => ['fr' => 'Aiguille rachidienne à usage unique', 'es' => 'Aguja espinal desechable'],
        'A.V. Fistula Needle' => ['fr' => 'Aiguille pour fistule AV', 'es' => 'Aguja para fístula AV'],
        '3-Way Stop Cock' => ['fr' => 'Robinet à 3 voies', 'es' => 'Llave de tres vías'],
        '3-Way Stop Cock with Extension Tube' => ['fr' => 'Robinet à 3 voies avec prolongateur', 'es' => 'Llave de tres vías con tubo de extensión'],
        'Low / High Pressure Extension Tube' => ['fr' => 'Prolongateur basse / haute pression', 'es' => 'Tubo de extensión de baja / alta presión'],
        'Extension Tube with T Connector' => ['fr' => 'Prolongateur avec connecteur en T', 'es' => 'Tubo de extensión con conector en T'],
        'Extension Tube with Needle-Free Y Site' => ['fr' => 'Prolongateur avec site en Y sans aiguille', 'es' => 'Tubo de extensión con sitio en Y sin aguja'],
        'Flow Regulator with Extension Tube' => ['fr' => 'Régulateur de débit avec prolongateur', 'es' => 'Regulador de flujo con tubo de extensión'],
        'Multi-Way Extension Tubes / Connectors' => ['fr' => 'Prolongateurs / connecteurs multi-voies', 'es' => 'Tubos de extensión / conectores multivía'],
        'Safety I.V. Cannula / Catheter' => ['fr' => 'Canule / cathéter IV de sécurité', 'es' => 'Cánula / catéter IV de seguridad'],
        'I.V. Cannula with Wings & Injection Port' => ['fr' => 'Canule IV avec ailettes & port d’injection', 'es' => 'Cánula IV con alas y puerto de inyección'],
        'I.V. Cannula without Wings & Injection Port' => ['fr' => 'Canule IV sans ailettes & port d’injection', 'es' => 'Cánula IV sin alas ni puerto de inyección'],
        'I.V. Cannula with Suturable Wings & Snap Port Cap' => ['fr' => 'Canule IV avec ailettes suturables & capuchon à clip', 'es' => 'Cánula IV con alas suturables y tapa a presión'],
        'Flash Back I.V. Cannula / Catheter' => ['fr' => 'Canule / cathéter IV à chambre de reflux', 'es' => 'Cánula / catéter IV con cámara de retorno'],
        'Infusion Set' => ['fr' => 'Perfuseur', 'es' => 'Equipo de infusión'],
        'Measured Volume Administration Set' => ['fr' => 'Perfuseur à volume mesuré', 'es' => 'Equipo de administración de volumen medido'],
        'Blood Administration Set' => ['fr' => 'Perfuseur pour transfusion sanguine', 'es' => 'Equipo de administración de sangre'],
        'Scalp Vein Set' => ['fr' => 'Perfuseur veineux à ailettes (scalp)', 'es' => 'Palomilla para vena del cuero cabelludo'],
        'Foley Balloon Catheter' => ['fr' => 'Cathéter à ballonnet de Foley', 'es' => 'Catéter con balón de Foley'],
        'Urine Bag' => ['fr' => 'Poche urinaire', 'es' => 'Bolsa de orina'],
        'Oxygen Mask' => ['fr' => 'Masque à oxygène', 'es' => 'Mascarilla de oxígeno'],
        'Surgical Mask' => ['fr' => 'Masque chirurgical', 'es' => 'Mascarilla quirúrgica'],
        'Sutures (Vicryl)' => ['fr' => 'Sutures (Vicryl)', 'es' => 'Suturas (Vicryl)'],
        'Surgical Gloves' => ['fr' => 'Gants chirurgicaux', 'es' => 'Guantes quirúrgicos'],
        'Examination Gloves' => ['fr' => 'Gants d’examen', 'es' => 'Guantes de exploración'],
        'Blood Collection Tube' => ['fr' => 'Tube de prélèvement sanguin', 'es' => 'Tubo de extracción de sangre'],
        'Absorbent Cotton Wool' => ['fr' => 'Coton hydrophile absorbant', 'es' => 'Algodón absorbente'],
        'Absorbent Gauze Roll' => ['fr' => 'Rouleau de gaze absorbante', 'es' => 'Rollo de gasa absorbente'],
        'Absorbent Gauze Swab' => ['fr' => 'Compresse de gaze absorbante', 'es' => 'Hisopo de gasa absorbente'],
        'Adhesive Tape' => ['fr' => 'Sparadrap adhésif', 'es' => 'Cinta adhesiva'],
        'Crepe Bandage' => ['fr' => 'Bande de crêpe', 'es' => 'Venda de crepé'],
        'HIV 1 & 2 Test' => ['fr' => 'Test VIH 1 & 2', 'es' => 'Prueba de VIH 1 y 2'],
        'HIV-Ab / Ag 4th Gen Rapid Test' => ['fr' => 'Test rapide VIH Ag/Ab 4e génération', 'es' => 'Prueba rápida VIH Ag/Ab 4.ª generación'],
        'HBsAg Card Test' => ['fr' => 'Test carte HBsAg', 'es' => 'Prueba en tarjeta HBsAg'],
        'HCV Card Test' => ['fr' => 'Test carte VHC', 'es' => 'Prueba en tarjeta VHC'],
        'Syphilis Card Test' => ['fr' => 'Test carte syphilis', 'es' => 'Prueba en tarjeta de sífilis'],
        'Pregnancy Test' => ['fr' => 'Test de grossesse', 'es' => 'Prueba de embarazo'],
        'LH (Ovulation) Test' => ['fr' => 'Test LH (ovulation)', 'es' => 'Prueba de LH (ovulación)'],
        'Malaria Pf / Pv Antigen Test' => ['fr' => 'Test antigène paludisme Pf / Pv', 'es' => 'Prueba de antígeno malaria Pf / Pv'],
        'Malaria Pf / Pan Antigen Test' => ['fr' => 'Test antigène paludisme Pf / Pan', 'es' => 'Prueba de antígeno malaria Pf / Pan'],
        'Typhoid IgG / IgM Test' => ['fr' => 'Test typhoïde IgG / IgM', 'es' => 'Prueba fiebre tifoidea IgG / IgM'],
        'Chikungunya IgG / IgM Test' => ['fr' => 'Test chikungunya IgG / IgM', 'es' => 'Prueba chikungunya IgG / IgM'],
        'Leptospira IgM & IgG Card' => ['fr' => 'Test carte leptospirose IgM & IgG', 'es' => 'Tarjeta de prueba leptospira IgM e IgG'],
        'H. Pylori Antibody Rapid Test Device' => ['fr' => 'Test rapide anticorps H. pylori', 'es' => 'Prueba rápida de anticuerpos H. pylori'],
        'Toxoplasma IgG / IgM Test' => ['fr' => 'Test toxoplasmose IgG / IgM', 'es' => 'Prueba toxoplasma IgG / IgM'],
        'Troponin I Test' => ['fr' => 'Test troponine I', 'es' => 'Prueba de troponina I'],
        'Scrub Typhus Test' => ['fr' => 'Test typhus des broussailles', 'es' => 'Prueba de tifus de los matorrales'],
        'Leishmania Ab Test' => ['fr' => 'Test anticorps leishmaniose', 'es' => 'Prueba de anticuerpos leishmania'],
        'Urinalysis Strips' => ['fr' => 'Bandelettes d’analyse d’urine', 'es' => 'Tiras de análisis de orina'],
        'Dengue Diagnostic Solution' => ['fr' => 'Solution de diagnostic dengue', 'es' => 'Solución de diagnóstico de dengue'],
        'Urine Strip 10P Kit' => ['fr' => 'Kit bandelettes urinaires 10P', 'es' => 'Kit de tiras de orina 10P'],
        'Snake Venom Antiserum' => ['fr' => 'Antisérum antivenimeux', 'es' => 'Antisuero antiofídico'],
        'Combipack of Snake Venom Antiserum with Sterile Water for Injection BP' => ['fr' => 'Combipack d’antisérum antivenimeux avec eau stérile pour injection BP', 'es' => 'Combipack de antisuero antiofídico con agua estéril para inyección BP'],
        'Tetanus Antitoxin BP 1500 IU' => ['fr' => 'Antitoxine tétanique BP 1500 UI', 'es' => 'Antitoxina tetánica BP 1500 UI'],
        'Tetanus Antitoxin BP 1500 IU with Sterilized Water for Injection BP' => ['fr' => 'Antitoxine tétanique BP 1500 UI avec eau stérilisée pour injection BP', 'es' => 'Antitoxina tetánica BP 1500 UI con agua esterilizada para inyección BP'],
        'Cold Mak' => ['fr' => 'Cold Mak', 'es' => 'Cold Mak'],
        'Apetimak' => ['fr' => 'Apetimak', 'es' => 'Apetimak'],
        'Erythromak' => ['fr' => 'Erythromak', 'es' => 'Erythromak'],
        'Alumak SP' => ['fr' => 'Alumak SP', 'es' => 'Alumak SP'],
        'Alumak DP' => ['fr' => 'Alumak DP', 'es' => 'Alumak DP'],
        'Alumak Forte' => ['fr' => 'Alumak Forte', 'es' => 'Alumak Forte'],
        'Gas Relief Suspension' => ['fr' => 'Suspension anti-gaz', 'es' => 'Suspensión antigases'],
    ],
];
