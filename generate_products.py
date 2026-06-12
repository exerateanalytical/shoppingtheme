import csv
import random
import re

random.seed(42)

# Category definitions
CATEGORIES = {
    "Medical Peptides": {
        "code": "MED",
        "price_range": (58, 185),
        "products": [
            "BPC-157 5mg", "TB-500 5mg", "Selank 5mg", "Semax 5mg", "LL-37 2mg",
            "Thymosin Alpha-1 5mg", "KPV 10mg", "VIP (Vasoactive Intestinal Peptide) 2mg",
            "SS-31 2mg", "DSIP 5mg", "Dihexa 5mg", "Pinealon 10mg", "Cortagen 10mg",
            "Timalin 10mg", "Bronchogen 10mg", "Cardalgin 10mg", "Vilon 10mg",
            "Prostamax 10mg", "Ventfort 10mg", "Chelohart 10mg", "Glandokort 10mg",
            "Crystagen 10mg", "Bonothyrk 10mg", "Ovagen 10mg", "Libidon 10mg",
            "Gotratix 10mg", "Cerluten 10mg", "Testoluten 10mg", "Pielotax 10mg",
            "Sigumir 10mg", "Chonluten 10mg", "Bonomarlot 10mg", "Suprefort 10mg",
            "Svetinorm 10mg", "Pancragen 10mg", "Endoluten 10mg", "Humanin 2mg",
            "MOTS-c 5mg", "Thymulin 5mg", "TB-4 Fragment (17-23) 2mg", "PT-141 10mg",
            "Kisspeptin-10 2mg", "GLP-1 (7-36) 2mg", "Larazotide Acetate 5mg",
            "PE-22-28 5mg", "Spadin 5mg", "NAP (NAPVSIPQ) 10mg", "ACTH (1-24) 2mg",
            "LL-37 Truncated 2mg", "Angiotensin (1-7) 2mg"
        ]
    },
    "Skincare Peptides": {
        "code": "SKN",
        "price_range": (42, 125),
        "products": [
            "GHK-Cu 50mg", "Matrixyl 3000 50mg", "Argireline (Acetyl Hexapeptide-3) 50mg",
            "SNAP-8 50mg", "Leuphasyl 50mg", "Syn-Coll (Palmitoyl Tripeptide-5) 50mg",
            "Palmitoyl Pentapeptide-4 (Matrixyl) 50mg", "Rigin (Palmitoyl Tetrapeptide-7) 50mg",
            "Decorinyl (Tripeptide-10 Citrulline) 50mg", "Laminyl 50mg", "Syn-Ake 10mg",
            "Chronoline 50mg", "Progeline 50mg", "Dermican (Acetyl Tetrapeptide-9) 50mg",
            "Pepha-Tight 50mg", "Eyeseryl (Acetyl Tetrapeptide-5) 50mg",
            "BONT-L Peptide 10mg", "Inyline (Acetyl Hexapeptide-30) 10mg",
            "Uplevity (Acetyl Hexapeptide-49) 10mg", "Trifluoroacetyl-Tripeptide-2 10mg",
            "Deepaline PVB 50mg", "Pal-GHK 50mg", "Pal-GQPR 50mg", "Pal-KTTKS 50mg",
            "Pal-GHK-Cu 50mg", "SYN-HYCAN 50mg", "Matrigenics 14G 10mg",
            "Rejuline (Tripeptide-29) 50mg", "Aldenine 50mg", "Kollaren (Tripeptide-1 Cu) 50mg",
            "Restylane-like Peptide 10mg", "IP2000 (Vanistryl) 10mg", "Haloxyl 50mg",
            "Eyeliss 50mg", "Serilesine (Hexapeptide-10) 10mg", "Myoxinol 10mg",
            "PrimalHyal Ultrafiller 10mg", "Volufiline 10mg", "Relistase 10mg",
            "Melanostatin 5 (Nonapeptide-1) 10mg", "Idealift (Tripeptide-3) 10mg",
            "Facets (Acetyl Tetrapeptide-2) 10mg", "Thymulen-4 10mg", "Meliprene 10mg",
            "Stemokin 10mg", "Collaxyl (Hexapeptide-9) 10mg", "SYN-TC (Tetrapeptide-30) 10mg",
            "Sesaflash 10mg", "Peptide Complex PCF-5 10mg", "Leuphasyl Advanced 50mg"
        ]
    },
    "Collagen Peptides": {
        "code": "COL",
        "price_range": (38, 95),
        "products": [
            "Marine Collagen Peptides Type I 100g", "Bovine Collagen Peptides Type I & III 100g",
            "Chicken Sternum Type II Collagen 60g", "Hydrolysed Marine Collagen 500mg caps×60",
            "Verisol Bioactive Collagen Peptides 10g", "FORTIGEL Collagen Peptides 10g",
            "TENDOFORTE Collagen Peptides 10g", "BODYBALANCE Collagen Peptides 15g",
            "Collagen Peptide Pro-Hyp 50mg", "Collagen Peptide Hyp-Gly 50mg",
            "Low Molecular Weight Marine Collagen (1000 Da) 100g",
            "Collagen Tripeptide (CTP) 30g", "Fish Collagen Peptide FC-20 50g",
            "Bioactive Collagen Peptide-17 50g", "Peptan B 2000 HD 100g",
            "Peptan F 2000 HD 100g", "Peptan IIM 100g", "Naticol LM 50g",
            "Naticol HP 50g", "Collageneer 50g", "Collagen Oligopeptides (MW<500 Da) 30g",
            "Collagen Dipeptide Pro-Hyp 500mg", "Collagen + Hyaluronic Acid Complex 30g",
            "Collagen + Vitamin C + Zinc 30g", "Collagen + Biotin Complex 30g",
            "Eggshell Membrane Collagen (NEM) 500mg", "Chicken Collagen Type II UC-II 40mg caps×60",
            "Plant-Based Collagen Booster Peptides 30g", "Sea Cucumber Collagen Peptides 30g",
            "Shark Cartilage Collagen Peptides 30g", "Deer Velvet Collagen Peptides 30g",
            "Cod Skin Collagen Peptides 50g", "Tilapia Scale Collagen Peptides 50g",
            "Jellyfish Collagen Peptides 30g", "Starfish Collagen Peptides 30g",
            "Salmon Collagen Peptides 50g", "Tuna Collagen Peptides 50g",
            "Swordfish Collagen Peptides 30g", "Freshwater Fish Collagen Peptides 50g",
            "Bovine Hide Collagen Peptides 100g", "Bovine Bone Collagen Peptides 100g",
            "Porcine Skin Collagen Peptides 100g",
            "Multi-Source Collagen Complex (I+II+III+V+X) 30g",
            "Collagen Ceramide Complex 20g", "Collagen + CoQ10 Complex 20g",
            "Collagen + Resveratrol Complex 20g", "Collagen + Astaxanthin Complex 20g",
            "Collagen Hydrolysate (15000 Da) 100g", "Recombinant Human Collagen Type I 1mg",
            "Recombinant Human Collagen Type III 1mg"
        ]
    },
    "Sports & Recovery": {
        "code": "SPT",
        "price_range": (55, 175),
        "products": [
            "BPC-157 5mg", "TB-500 5mg", "IGF-1 LR3 1mg", "MGF (PEG-MGF) 2mg",
            "CJC-1295 DAC 2mg", "Ipamorelin 5mg", "GHRP-2 5mg", "GHRP-6 5mg",
            "Hexarelin 2mg", "Sermorelin 5mg", "Follistatin 344 1mg", "Follistatin 315 1mg",
            "Myostatin Inhibitor Peptide 2mg", "ACE-031 1mg", "AICAR 50mg",
            "SR9009 10mg (research)", "GW501516 (Cardarine) 10mg (research)",
            "RAD-140 10mg (research)", "LGD-4033 10mg (research)",
            "Ostarine (MK-2866) 10mg (research)", "Andarine (S4) 10mg (research)",
            "YK-11 5mg (research)", "S-23 10mg (research)", "GDF-8 Propeptide 1mg",
            "Epithalon 10mg", "Delta Sleep-Inducing Peptide (DSIP) 5mg",
            "Thymosin Beta-4 Fragment 2mg", "ACE-083 1mg", "BPC-157 + TB-500 Blend 5mg",
            "Semax 5mg", "Selank 5mg", "CJC-1295 No DAC 5mg", "Tesamorelin 2mg",
            "MT-II 10mg", "PT-141 10mg", "LL-37 2mg", "SS-31 2mg", "MOTS-c 5mg",
            "Humanin 2mg", "Thymalin 10mg", "Oxytocin 2mg", "AOD-9604 5mg",
            "Fragment 176-191 5mg", "GHK-Cu 50mg", "Pentadecapeptide BPC-157 Arginate Salt 5mg",
            "TB-500 + BPC-157 Reconstitution Kit", "Ipamorelin + CJC-1295 Blend 5mg",
            "GHRP-2 + CJC-1295 Blend 5mg", "KPV 10mg", "Larazotide Acetate 5mg"
        ]
    },
    "Weight-Loss & Metabolic": {
        "code": "WLM",
        "price_range": (65, 295),
        "products": [
            "Semaglutide 5mg", "Tirzepatide 5mg", "AOD-9604 5mg", "Fragment 176-191 5mg",
            "CJC-1295 No DAC 5mg", "Ipamorelin 5mg", "Tesamorelin 2mg", "MOTS-c 5mg",
            "5-Amino-1MQ 200mg", "HM-3 (VEGF-derived) 5mg", "LEAP2 5mg",
            "Oxyntomodulin 5mg", "Liraglutide 5mg", "Dulaglutide 5mg",
            "GLP-2 (Teduglutide) 2mg", "GIP (1-42) 2mg", "GIP/GLP-1 Dual Agonist 5mg",
            "Exendin-4 2mg", "Exendin-3 2mg", "PYY (3-36) 2mg", "Ghrelin (Human) 2mg",
            "Des-Acyl Ghrelin 2mg", "Obestatin 2mg", "Nesfatin-1 2mg",
            "Leptin Fragment (116-130) 2mg", "Adiponectin (Active Fragment) 2mg",
            "Apelin-13 2mg", "Apelin-36 2mg", "CCK-8 (Cholecystokinin) 2mg",
            "GLP-1 (7-36) Amide 2mg", "GLP-1 (7-37) 2mg", "CagriSema 5mg",
            "Cagrilintide 5mg", "Amylin (Human) 2mg", "Pramlintide 5mg", "Xenin-25 2mg",
            "Spexin 5mg", "Adropin 5mg", "Irisin 5mg",
            "Meteorin-like Protein Fragment 2mg", "β-Klotho Peptide Agonist 2mg",
            "FGF-21 Fragment 5mg", "GDF-15 Fragment 2mg", "RFRP-3 2mg",
            "Neurotensin (8-13) 2mg", "CCK-4 5mg", "Secretin 2mg", "Glucagon (Human) 2mg",
            "Glucose-dependent Insulinotropic Polypeptide 2mg",
            "AOD-9604 + Ipamorelin Blend 5mg"
        ]
    },
    "Hormone & Anti-Aging": {
        "code": "HAA",
        "price_range": (58, 195),
        "products": [
            "Epithalon 10mg", "Thymalin 10mg", "CJC-1295 DAC 2mg", "Ipamorelin 5mg",
            "Sermorelin 5mg", "GHRH (1-29) 2mg", "Humanin 2mg", "MOTS-c 5mg",
            "Thymosin Alpha-1 5mg", "Endoluten 10mg", "Testoluten 10mg", "Cortagen 10mg",
            "Cerluten 10mg", "Vilon 10mg", "Crystagen 10mg", "Pancragen 10mg",
            "Chelohart 10mg", "Svetinorm 10mg", "Suprefort 10mg", "Prostamax 10mg",
            "Pielotax 10mg", "Sigumir 10mg", "Glandokort 10mg", "Pinealon 10mg",
            "Bonomarlot 10mg", "Ovagen 10mg", "Libidon 10mg", "Bronchogen 10mg",
            "Chonluten 10mg", "Ventfort 10mg", "FOXO4-DRI 2mg", "SS-31 2mg",
            "NAD+ Precursor Peptide 50mg", "GHK-Cu 50mg", "CJC-1295 No DAC 5mg",
            "GHRP-2 5mg", "GHRP-6 5mg", "Hexarelin 2mg", "Kisspeptin-10 2mg",
            "Oxytocin 2mg", "GnRH (Gonadorelin) 2mg", "LH-RH Agonist Peptide 2mg",
            "α-MSH 2mg", "MC4-R Agonist 2mg", "PT-141 10mg", "Tesamorelin 2mg",
            "Selank 5mg", "DSIP 5mg", "SS-31 Mitochondrial 2mg", "PE-22-28 5mg"
        ]
    },
    "Hair Growth Peptides": {
        "code": "HGR",
        "price_range": (52, 145),
        "products": [
            "PTD-DBM 5mg", "GHK-Cu 50mg", "KGF (Keratinocyte Growth Factor Fragment) 2mg",
            "Thymosin Beta-4 5mg", "PTD-PCNA (PCNA peptide) 5mg",
            "Biotinoyl Tripeptide-1 50mg", "Acetyl Tetrapeptide-3 50mg",
            "Follistatin 315 1mg", "IGF-1 LR3 1mg", "VEGF Fragment Peptide 2mg",
            "AnaGain 10mg", "Capigen 10mg", "Redensyl 10mg", "Procapil 10mg",
            "Baicapil 10mg", "QR-678 (Growth Factor Blend) 5mg",
            "Emu Oil Peptide Complex 10mg", "FGF-7 Fragment 2mg",
            "FGF-5 Inhibitor Peptide 5mg", "Wnt3a Activator Peptide 2mg",
            "β-Catenin Activator Peptide 2mg", "Sonic Hedgehog Peptide (SHH Fragment) 2mg",
            "Noggin Inhibitor Peptide 2mg", "BMP-4 Antagonist Peptide 2mg",
            "VEGF-A Fragment 2mg", "HGF Fragment Peptide 2mg",
            "SCF (Stem Cell Factor) Fragment 2mg", "EGF (Epidermal Growth Factor) 50mcg",
            "bFGF Fragment Peptide 2mg", "Netrin-1 Fragment 2mg", "CXCL12 Fragment 2mg",
            "DKK-1 Inhibitor Peptide 5mg", "Frizzled Receptor Agonist Peptide 5mg",
            "Angiopoietin-1 Fragment 2mg", "PDGF-BB Fragment 2mg", "TGF-β3 Fragment 2mg",
            "IL-6 Modulator Peptide 2mg", "TNF-α Inhibitor Peptide 5mg",
            "Niacinamide Adenine Peptide Complex 5mg", "Copper Tripeptide GHK-Cu Liposomal 50mg",
            "Capixyl 10mg", "Nanopeptide-1 10mg", "Quasomes Hair Peptide Complex 10mg",
            "Pisum Sativum Peptide 10mg", "Soy Isoflavone Peptide Complex 10mg",
            "Argan Stem Cell Peptide 10mg", "Swiss Apple Stem Cell Peptide 10mg",
            "Edelweiss Callus Culture Extract Peptide 10mg",
            "Myristoyl Pentapeptide-17 50mg", "Oligopeptide-54 50mg"
        ]
    },
    "Research Peptides": {
        "code": "RSC",
        "price_range": (48, 165),
        "products": [
            "Selank 5mg", "Semax 5mg", "Epithalon 10mg", "Dihexa 5mg", "SS-31 2mg",
            "FOXO4-DRI 2mg", "Humanin 2mg", "MOTS-c 5mg", "NAP (NAPVSIPQ) 10mg",
            "AL-11 2mg", "Cerebrolysin Fragment 5mg", "LL-37 2mg", "ARA-290 (CPAG) 5mg",
            "Davunetide (NAP) 10mg", "Cortistatin-14 2mg", "Cortistatin-29 2mg",
            "VIP (Vasoactive Intestinal Peptide) 2mg", "PACAP-27 2mg", "PACAP-38 2mg",
            "GLP-1 Analogue Fragment 2mg", "Exendin Fragment 2mg", "ACTH (4-9) 2mg",
            "ACTH (4-10) 2mg", "ACTH (7-38) 2mg", "MSH Release Inhibiting Factor 2mg",
            "Thyrotropin-Releasing Hormone (TRH) 50mg",
            "CRH (Corticotropin-Releasing Hormone) 2mg", "Urocortin 2mg",
            "Stresscopin 2mg", "Nociceptin (Orphanin FQ) 2mg", "Dynorphin A 2mg",
            "Enkephalin (Leu) 10mg", "Enkephalin (Met) 10mg", "Substance P 5mg",
            "Neurotensin 5mg", "Angiotensin II 5mg", "Angiotensin III 5mg",
            "Bradykinin 5mg", "Kallidin 5mg", "Oxytocin 2mg", "Vasopressin (AVP) 2mg",
            "dDAVP (Desmopressin) 2mg", "Melanocyte-Inhibiting Factor (MIF-1) 5mg",
            "Melanostatin (PLG) 5mg", "Somatostatin-14 2mg", "Somatostatin-28 2mg",
            "Octreotide 5mg", "Lanreotide 5mg", "Pasireotide 2mg",
            "GIP (3-30) Antagonist 2mg"
        ]
    }
}

# Template opening sentences (varied)
SHORT_DESC_OPENERS = [
    "{name} is a high-purity {cat} compound offering {benefit}.",
    "Discover {name}, a premium {cat} peptide designed for {benefit}.",
    "{name} provides researchers with a potent {cat} agent supporting {benefit}.",
    "A leading {cat} compound, {name} is valued for its role in {benefit}.",
    "{name} stands out among {cat} products for its proven role in {benefit}.",
    "Sourced to rigorous standards, {name} is a trusted {cat} peptide for {benefit}.",
    "For those seeking quality {cat} solutions, {name} delivers outstanding {benefit}.",
    "{name} is a research-grade {cat} peptide renowned for {benefit}.",
    "High-purity {name} is a benchmark {cat} compound in the field of {benefit}.",
    "Used by researchers worldwide, {name} is an advanced {cat} peptide for {benefit}.",
]

BENEFITS_BY_CAT = {
    "Medical Peptides": [
        "tissue repair and regeneration", "immune modulation and healing",
        "neuroprotection and CNS support", "anti-inflammatory activity",
        "cellular recovery and protection"
    ],
    "Skincare Peptides": [
        "collagen stimulation and anti-aging", "wrinkle reduction and skin firmness",
        "skin barrier enhancement", "dermal matrix remodelling",
        "youthful skin tone and elasticity"
    ],
    "Collagen Peptides": [
        "joint health and connective tissue support", "skin elasticity and hydration",
        "bone density and structural integrity", "gut lining support",
        "muscle and tendon recovery"
    ],
    "Sports & Recovery": [
        "muscle repair and athletic performance", "growth hormone release and recovery",
        "injury healing and endurance", "lean muscle development",
        "tissue regeneration post-exercise"
    ],
    "Weight-Loss & Metabolic": [
        "metabolic rate optimisation and fat loss", "appetite regulation and glucose control",
        "GLP-1 pathway activation", "energy balance and body composition",
        "insulin sensitivity and lipid metabolism"
    ],
    "Hormone & Anti-Aging": [
        "hormonal balance and longevity", "GH axis stimulation and cellular renewal",
        "telomere protection and anti-aging", "endocrine support and vitality",
        "age-related decline mitigation"
    ],
    "Hair Growth Peptides": [
        "hair follicle stimulation and growth", "scalp circulation and follicle health",
        "anagen phase prolongation", "DHT inhibition and hair density",
        "keratinocyte proliferation support"
    ],
    "Research Peptides": [
        "in-vitro and in-vivo research applications", "neuropeptide signalling studies",
        "receptor binding investigations", "biochemical pathway research",
        "advanced peptide science exploration"
    ]
}

MECHANISMS = {
    "Medical Peptides": [
        "modulates inflammatory cytokine cascades and accelerates tissue repair via upregulation of growth factors",
        "binds to specific receptors in the CNS and peripheral tissues to promote healing and reduce oxidative stress",
        "activates endogenous repair pathways by interacting with actin-binding proteins and angiogenic factors",
        "regulates immune cell activity and promotes resolution of inflammation through receptor-mediated signalling",
        "supports mitochondrial function and cellular bioenergetics through targeted peptide-receptor interactions"
    ],
    "Skincare Peptides": [
        "stimulates fibroblast activity to increase collagen type I and III synthesis in the dermal matrix",
        "inhibits acetylcholine release at the neuromuscular junction to reduce expression line depth",
        "activates TGF-β signalling pathways to enhance extracellular matrix remodelling",
        "chelates copper ions to support enzymatic antioxidant defences and collagen cross-linking",
        "promotes glycosaminoglycan synthesis, improving dermal hydration and structural integrity"
    ],
    "Collagen Peptides": [
        "supplies bioactive Pro-Hyp and Hyp-Gly dipeptides that stimulate fibroblast collagen synthesis",
        "provides hydrolysed collagen fragments absorbed intact to act as signalling molecules in connective tissue",
        "delivers specific molecular weight collagen chains that accumulate in target tissues to support structural repair",
        "activates chondrocyte and tenocyte pathways to support cartilage, tendon and bone remodelling",
        "enhances dermal collagen density through targeted peptide signalling in skin fibroblasts"
    ],
    "Sports & Recovery": [
        "promotes anabolic signalling via the GH/IGF-1 axis, supporting muscle protein synthesis and repair",
        "accelerates tissue regeneration by modulating growth factor release and inflammatory resolution",
        "binds to actin-associated proteins to stabilise cellular architecture during recovery",
        "stimulates ghrelin receptors to enhance GH pulsatility and lean body mass accrual",
        "activates AMPK pathways to improve mitochondrial biogenesis and exercise capacity"
    ],
    "Weight-Loss & Metabolic": [
        "activates GLP-1 receptors in the hypothalamus and pancreas to regulate appetite and insulin secretion",
        "modulates adipocyte lipolysis and fatty acid oxidation through targeted receptor engagement",
        "stimulates AMPK-mediated metabolic pathways to enhance glucose uptake and energy expenditure",
        "inhibits lipogenesis while promoting fat mobilisation via central and peripheral receptor activation",
        "regulates gut-brain axis signalling to suppress appetite and improve glycaemic control"
    ],
    "Hormone & Anti-Aging": [
        "stimulates pituitary GH release via GHRH receptor activation to restore youthful GH/IGF-1 profiles",
        "modulates telomerase activity and gene expression associated with cellular senescence",
        "activates epigenetic repair pathways and supports mitochondrial membrane integrity",
        "regulates hypothalamic-pituitary axis function to optimise endocrine homeostasis",
        "binds pineal and thymic receptors to modulate circadian rhythm and immune senescence"
    ],
    "Hair Growth Peptides": [
        "activates Wnt/β-catenin signalling in dermal papilla cells to prolong the anagen growth phase",
        "stimulates keratinocyte and fibroblast growth factor receptors to enhance follicular proliferation",
        "inhibits 5α-reductase activity and DHT binding at the follicle receptor level",
        "promotes VEGF-mediated neovascularisation of the hair follicle bulb",
        "modulates BMP and Noggin pathways to re-activate dormant follicle stem cells"
    ],
    "Research Peptides": [
        "interacts with specific receptor subtypes to modulate intracellular signalling cascades in research models",
        "serves as a highly selective ligand for receptor binding studies and pathway elucidation",
        "enables investigation of neuropeptide-mediated signal transduction in cellular assay systems",
        "facilitates characterisation of peptide-receptor kinetics in biochemical research settings",
        "supports mechanistic studies of endogenous peptide function in controlled research environments"
    ]
}

RESEARCH_FIELDS = {
    "Medical Peptides": [
        "regenerative medicine and wound healing research",
        "neuroimmunology and CNS repair studies",
        "inflammatory disease and tissue engineering research",
        "peptide therapeutics and translational medicine"
    ],
    "Skincare Peptides": [
        "cosmetic dermatology and anti-aging peptide research",
        "skin biology and extracellular matrix studies",
        "cosmeceutical formulation and efficacy research",
        "dermal fibroblast and collagen biology research"
    ],
    "Collagen Peptides": [
        "connective tissue biology and orthopaedic research",
        "nutricosmetic and skin health science",
        "sports nutrition and musculoskeletal repair research",
        "biomaterial and tissue engineering science"
    ],
    "Sports & Recovery": [
        "exercise physiology and muscle biology research",
        "sports medicine and recovery science",
        "anabolic signalling and body composition research",
        "athletic performance and endurance physiology"
    ],
    "Weight-Loss & Metabolic": [
        "metabolic disease and obesity research",
        "endocrinology and gut hormone biology",
        "type 2 diabetes and insulin resistance research",
        "appetite regulation and energy homeostasis science"
    ],
    "Hormone & Anti-Aging": [
        "longevity science and geroscience research",
        "endocrinology and hormonal health studies",
        "cellular senescence and epigenetic aging research",
        "age-related disease prevention and vitality science"
    ],
    "Hair Growth Peptides": [
        "trichology and hair follicle biology research",
        "androgenetic alopecia and scalp health science",
        "hair regeneration and follicle stem cell research",
        "dermatology and hair growth peptide studies"
    ],
    "Research Peptides": [
        "neuropeptide pharmacology and receptor biology",
        "peptide biochemistry and signal transduction research",
        "endogenous peptide function and physiology studies",
        "advanced peptide research and drug discovery"
    ]
}

DOSING_NOTES = {
    "Medical Peptides": [
        "In research settings, typical protocols involve reconstitution in bacteriostatic water at concentrations of 500–1000 mcg/mL.",
        "Research models commonly employ doses ranging from 200–500 mcg per administration depending on the study design.",
        "Standard research protocols reconstitute lyophilised peptide in sterile bacteriostatic water prior to use.",
        "Investigational dosing in preclinical models typically ranges from 100–500 mcg, adjusted for body weight."
    ],
    "Skincare Peptides": [
        "In cosmetic research, this peptide is typically incorporated into formulations at 2–10% concentration by weight.",
        "Research applications commonly employ solution concentrations of 1–5 mg/mL in aqueous buffer systems.",
        "Formulators typically test this peptide at active concentrations between 0.001% and 0.01% in finished products.",
        "Topical research protocols utilise concentrations of 5–50 mg per formulation batch for efficacy assessment."
    ],
    "Collagen Peptides": [
        "Research and nutritional studies commonly use daily supplementation doses of 5–15 g of hydrolysed collagen.",
        "Investigational protocols for connective tissue support typically employ 10 g daily dissolved in water or beverage.",
        "Bioavailability studies suggest optimal absorption at 5–10 g per serving taken with vitamin C co-factors.",
        "Clinical nutritional research commonly administers 2.5–15 g daily depending on the health outcome under study."
    ],
    "Sports & Recovery": [
        "Typical research reconstitution yields a 1 mg/mL solution in bacteriostatic water for experimental use.",
        "In preclinical recovery models, doses of 200–500 mcg per session are commonly employed.",
        "Research protocols for muscle biology typically administer peptide solutions of 1–2 mg/mL concentration.",
        "Standard investigational use involves reconstitution to 500 mcg/mL and storage at 4°C until use."
    ],
    "Weight-Loss & Metabolic": [
        "Metabolic research models commonly employ subcutaneous administration at doses of 100–500 mcg per session.",
        "GLP-1 pathway research typically utilises peptide concentrations of 0.1–1 nmol/kg in animal models.",
        "Investigational metabolic protocols reconstitute peptide to 1 mg/mL in sterile saline for experimental delivery.",
        "Research dosing for obesity models typically ranges from 50–500 mcg per administration session."
    ],
    "Hormone & Anti-Aging": [
        "Anti-aging research protocols typically reconstitute lyophilised peptide to 1 mg/mL in bacteriostatic water.",
        "Longevity studies commonly employ doses of 100–500 mcg in preclinical models for assessment of biomarkers.",
        "Hormonal axis research typically administers peptide at 200 mcg per session to examine GH/IGF-1 dynamics.",
        "Investigational anti-aging protocols use peptide concentrations of 0.5–2 mg/mL for cellular assay systems."
    ],
    "Hair Growth Peptides": [
        "Hair biology research typically applies peptide solutions at 1–10 mg/mL to follicle culture systems.",
        "In scalp research models, topical application of 50–500 mcg per cm² is commonly employed.",
        "Trichology research protocols reconstitute growth peptides in saline at 1 mg/mL for follicle stimulation assays.",
        "Investigational hair growth protocols utilise peptide concentrations of 5–50 mcg/mL in cell culture media."
    ],
    "Research Peptides": [
        "Standard reconstitution for research use involves dissolving lyophilised peptide in sterile water to 1 mg/mL.",
        "In vitro assay systems commonly employ peptide concentrations of 1–100 nM for receptor binding studies.",
        "Research protocols typically prepare stock solutions at 1 mg/mL and dilute to working concentrations as required.",
        "Investigational biochemical assays commonly use 10–1000 nM peptide concentrations to assess receptor kinetics."
    ]
}

KEY_BENEFITS = {
    "Medical Peptides": [
        ["Potent anti-inflammatory and tissue repair activity",
         "Supports CNS neuroprotection and cognitive function",
         "Promotes angiogenesis and wound healing",
         "Modulates immune response and cytokine balance",
         "High purity ≥98% for reliable research outcomes"],
        ["Accelerates musculoskeletal and gut tissue regeneration",
         "Reduces oxidative stress and supports mitochondrial health",
         "Enhances collagen deposition at injury sites",
         "Supports immune homeostasis and resolution of inflammation",
         "Lyophilised for maximum stability during storage and transport"]
    ],
    "Skincare Peptides": [
        ["Stimulates collagen I and III synthesis in fibroblasts",
         "Visibly reduces fine lines and expression wrinkles",
         "Improves skin firmness, elasticity and hydration",
         "Enhances dermal matrix integrity and barrier function",
         "High purity ≥98% ensures consistent cosmetic efficacy"],
        ["Supports extracellular matrix remodelling",
         "Reduces periorbital puffiness and dark circles",
         "Promotes glycosaminoglycan and hyaluronic acid production",
         "Suitable for advanced cosmeceutical formulation research",
         "Stable lyophilised format with extended shelf life"]
    ],
    "Collagen Peptides": [
        ["Supports skin elasticity, hydration and dermal density",
         "Promotes joint cartilage health and mobility",
         "Enhances tendon and ligament structural integrity",
         "Bioavailable low-molecular-weight peptide fragments",
         "High purity source material with ≥98% peptide content"],
        ["Stimulates endogenous collagen synthesis in fibroblasts",
         "Supports bone mineral density and skeletal strength",
         "Provides essential amino acids: glycine, proline, hydroxyproline",
         "Suitable for nutricosmetic and sports nutrition research",
         "Clean-label format, unflavoured and highly soluble"]
    ],
    "Sports & Recovery": [
        ["Accelerates muscle repair and reduces recovery time",
         "Stimulates GH/IGF-1 axis for anabolic support",
         "Promotes tendon, ligament and connective tissue healing",
         "Supports lean body composition and athletic endurance",
         "High purity ≥98% for accurate preclinical research"],
        ["Enhances mitochondrial biogenesis and cellular energy",
         "Modulates inflammation to support post-exercise recovery",
         "Promotes growth factor release in muscle and connective tissue",
         "Supports nitrogen retention and protein synthesis research",
         "Lyophilised and stable for reliable experimental results"]
    ],
    "Weight-Loss & Metabolic": [
        ["Activates GLP-1 and related metabolic receptor pathways",
         "Supports appetite suppression and satiety signalling",
         "Promotes fat mobilisation and adipocyte lipolysis",
         "Improves insulin sensitivity and glycaemic control",
         "High purity ≥98% for rigorous metabolic research"],
        ["Modulates gut-brain axis to regulate energy intake",
         "Supports lipid oxidation and metabolic rate enhancement",
         "Targets visceral adipose tissue in preclinical models",
         "Provides mechanistic insight into obesity pharmacology",
         "Lyophilised format ensures stability and accurate dosing"]
    ],
    "Hormone & Anti-Aging": [
        ["Stimulates physiological GH release via pituitary axis",
         "Supports telomere maintenance and cellular longevity",
         "Modulates age-associated hormonal decline",
         "Promotes mitochondrial health and bioenergetics",
         "High purity ≥98% for reliable anti-aging research"],
        ["Enhances immune function and thymic activity",
         "Supports endocrine homeostasis and hormonal balance",
         "Promotes epigenetic repair and DNA damage response",
         "Activates longevity-associated FOXO and SIRT pathways",
         "Lyophilised and stable for long-term research programs"]
    ],
    "Hair Growth Peptides": [
        ["Activates Wnt/β-catenin to prolong anagen growth phase",
         "Stimulates keratinocyte and dermal papilla proliferation",
         "Promotes VEGF-driven follicle neovascularisation",
         "Reduces DHT-mediated follicle miniaturisation in models",
         "High purity ≥98% for accurate trichology research"],
        ["Re-activates dormant follicle stem cell populations",
         "Supports FGF-7 mediated keratinocyte growth signalling",
         "Modulates inflammatory pathways implicated in hair loss",
         "Enhances scalp microcirculation in preclinical assays",
         "Lyophilised format suitable for topical and systemic studies"]
    ],
    "Research Peptides": [
        ["Highly selective ligand for receptor binding studies",
         "Enables investigation of signal transduction pathways",
         "Suitable for in-vitro and in-vivo research models",
         "Stable lyophilised format minimises experimental variability",
         "High purity ≥98% for reproducible research outcomes"],
        ["Facilitates neuropeptide pharmacology investigations",
         "Supports biochemical assay development and validation",
         "Compatible with standard HPLC and mass spec analysis",
         "Ideal for peptide-receptor kinetics and binding assays",
         "For research use only — not for human consumption"]
    ]
}

CTA_SENTENCES = [
    "Buy {name} online in Australia from Alluvia — trusted by Australian researchers and biohackers for quality and purity.",
    "Order {name} online Australia with confidence from Alluvia, the trusted supplier for Australian researchers and peptide enthusiasts.",
    "Australian researchers and biohackers trust Alluvia for premium {name} — order online today with fast, discreet delivery.",
    "Purchase {name} from Alluvia, Australia's leading supplier of research-grade peptides — trusted by Australian researchers nationwide.",
    "Alluvia provides Australian researchers with premium-grade {name} — buy online Australia for fast domestic dispatch.",
    "Shop {name} online at Alluvia — trusted by Australian researchers and biohackers seeking the highest purity peptides.",
]


def get_short_description(name, category, idx):
    opener_idx = idx % len(SHORT_DESC_OPENERS)
    benefit_idx = idx % len(BENEFITS_BY_CAT[category])
    opener = SHORT_DESC_OPENERS[opener_idx].format(
        name=name,
        cat=category.lower(),
        benefit=BENEFITS_BY_CAT[category][benefit_idx]
    )

    australia_phrases = [
        f"Available to buy online Australia, {name} meets strict quality standards with ≥98% purity.",
        f"Buy {name} online Australia from a trusted supplier committed to research excellence.",
        f"Available online across Australia, this peptide is supplied at ≥98% purity for reliable results.",
        f"Trusted by Australian researchers and biohackers, {name} is available online with fast local dispatch.",
        f"Australian researchers can buy {name} online with confidence, backed by ≥98% purity certification.",
    ]
    aus_idx = idx % len(australia_phrases)
    return f"{opener} {australia_phrases[aus_idx]}"


def get_html_description(name, category, idx):
    mech_idx = idx % len(MECHANISMS[category])
    field_idx = idx % len(RESEARCH_FIELDS[category])
    dose_idx = idx % len(DOSING_NOTES[category])
    benefit_set_idx = idx % len(KEY_BENEFITS[category])
    cta_idx = idx % len(CTA_SENTENCES)

    mechanism = MECHANISMS[category][mech_idx]
    field = RESEARCH_FIELDS[category][field_idx]
    dosing = DOSING_NOTES[category][dose_idx]
    benefits = KEY_BENEFITS[category][benefit_set_idx]
    cta = CTA_SENTENCES[cta_idx].format(name=name)

    h3_keywords = [
        f"{name} | {category} | Research Grade Australia",
        f"Buy {name} Online Australia | {category}",
        f"{name} – High Purity {category} Peptide",
        f"{name} for {category} Research | Australia",
        f"Premium {name} | {category} Australia",
    ]
    h3 = h3_keywords[idx % len(h3_keywords)]

    research_note = ""
    if category == "Research Peptides":
        research_note = "<p><strong>For research use only. Not for human consumption.</strong></p>\n"

    benefits_html = "\n".join([f"    <li>{b}</li>" for b in benefits])

    html = f"""<h3>{h3}</h3>
{research_note}<p><strong>{name}</strong> {mechanism}. This compound is widely utilised in {field}, with growing interest from preclinical and translational research communities worldwide.</p>

<p>{dosing} Researchers are advised to follow institutional guidelines and conduct thorough literature review prior to experimental use.</p>

<ul>
{benefits_html}
</ul>

<p><strong>Purity:</strong> ≥98% (HPLC verified) | <strong>Format:</strong> Lyophilised powder | <strong>Storage:</strong> Store at −20°C, protect from light and moisture. Stable for 24 months when properly stored.</p>

<p>{cta}</p>"""
    return html


# Build all products
all_products = []

for category, cat_data in CATEGORIES.items():
    code = cat_data["code"]
    price_min, price_max = cat_data["price_range"]
    products = cat_data["products"]

    for i, product_name in enumerate(products):
        idx = i  # Use within-category index for template variation
        sku_num = str(i + 1).zfill(3)
        sku = f"AV-{code}-{sku_num}"

        price = round(random.uniform(price_min, price_max), 2)

        short_desc = get_short_description(product_name, category, idx)
        full_desc = get_html_description(product_name, category, idx)

        tags = f"{product_name}, {category}"

        all_products.append({
            "Type": "simple",
            "SKU": sku,
            "Name": product_name,
            "Published": 1,
            "Is featured?": 0,
            "Visibility in catalog": "visible",
            "Short description": short_desc,
            "Description": full_desc,
            "Tax status": "taxable",
            "Tax class": "",
            "In stock?": 1,
            "Stock": 100,
            "Backorders allowed?": 0,
            "Sold individually?": 0,
            "Regular price": price,
            "Sale price": "",
            "Categories": category,
            "Tags": tags,
            "Weight (g)": 5,
            "Attribute 1 name": "Purity",
            "Attribute 1 value(s)": ">98%",
            "Attribute 1 visible": 1,
            "Attribute 1 global": 1,
        })

# Define headers in exact required order
HEADERS = [
    "Type", "SKU", "Name", "Published", "Is featured?", "Visibility in catalog",
    "Short description", "Description", "Tax status", "Tax class", "In stock?",
    "Stock", "Backorders allowed?", "Sold individually?", "Regular price",
    "Sale price", "Categories", "Tags", "Weight (g)", "Attribute 1 name",
    "Attribute 1 value(s)", "Attribute 1 visible", "Attribute 1 global"
]

output_path = '/home/user/shoppingtheme/alluvia-products.csv'

with open(output_path, 'w', newline='', encoding='utf-8') as f:
    writer = csv.DictWriter(f, fieldnames=HEADERS)
    writer.writeheader()
    for product in all_products:
        writer.writerow(product)

print(f"CSV generated: {output_path}")
print(f"Total products written: {len(all_products)}")
