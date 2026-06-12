#!/usr/bin/env python3
"""
Alluvia Peptides — WooCommerce product catalogue generator.

Builds alluvia-products.csv: 50 genuine best-selling peptides per category
across 8 categories (400 products total).

Design goals (per brief):
  * Curated *top-selling* lineup per category — not obscure filler.
  * Realistic Australian market pricing (AUD), scaled by compound + dose.
  * Authentic, benefit-led consumer-wellness copy — NOT generic templates.
    Every description is built from per-peptide facts (what it is, how it
    works, its specific benefits, who it's for), so no two read alike.
  * SEO + GEO (Generative Engine Optimisation) + geo-targeting (Australia):
    unique meta-style H2/H3 structure, scannable benefit lists, and an
    FAQ block that answer-engines (Google AI, ChatGPT, Perplexity) can lift.

Each product record:
    {name, dose, price, sale, summary, what_it_is, how_it_works,
     benefits[4], audience}

Run:  python3 generate_products.py
"""

import csv
import html
from collections import Counter

from catalogue_data import CATEGORIES  # curated dataset lives in its own module

BRAND = "Alluvia"
COUNTRY = "Australia"


def esc(text: str) -> str:
    """Escape a value for safe inclusion in HTML."""
    return html.escape(str(text), quote=False)


# ---------------------------------------------------------------------------
# Research-use copy.  Every product is presented strictly as a research-grade
# reference compound — NOT a consumer product. Benefit data is reframed as
# "areas of research interest" and a prominent Research-Use-Only disclaimer is
# included. This is the industry-standard, lower-risk framing for peptides.
# ---------------------------------------------------------------------------

def _noun(p: dict) -> str:
    return {
        "peptide": "research-grade peptide",
        "compound": "research-grade compound",
        "supply": "laboratory supply",
    }.get(p.get("kind", "peptide"), "research-grade peptide")


def build_short_description(p: dict) -> str:
    """Excerpt on shop/category cards. Research-grade, compliant, keyword-rich."""
    if p.get("kind") == "supply":
        return (
            f"{p['name']} {p['dose']} is a sterile laboratory supply for {p['summary']}. "
            f"Supplied by {BRAND} for laboratory research use only. Not for human consumption."
        )
    return (
        f"{p['name']} {p['dose']} is a {_noun(p)} supplied at ≥99% purity for "
        f"laboratory research use only. {BRAND} provides a Certificate of Analysis "
        f"with every batch. Not for human consumption."
    )


def build_meta_title(p: dict) -> str:
    """SEO <title> — keep close to ~60 chars where possible."""
    label = "Lab Supply" if p.get("kind") == "supply" else (
        "Research Compound" if p.get("kind") == "compound" else "Research Peptide")
    base = f"{p['name']} {p['dose']} | {label} | {BRAND}"
    if len(base) <= 60:
        return base
    return f"{p['name']} {p['dose']} | {label}"


def build_meta_description(p: dict) -> str:
    """SEO meta description — ~150 chars, research-grade, purity + COA + AU."""
    if p.get("kind") == "supply":
        desc = (
            f"{p['name']} {p['dose']} — sterile laboratory supply for peptide "
            f"reconstitution and handling from {BRAND} {COUNTRY}. Research use only."
        )
    else:
        kind_word = "compound" if p.get("kind") == "compound" else "peptide"
        desc = (
            f"{p['name']} {p['dose']} research {kind_word} — ≥99% purity with a COA "
            f"from {BRAND} {COUNTRY}. For laboratory research use only; not for human use."
        )
    return desc[:157].rsplit(" ", 1)[0] if len(desc) > 158 else desc


def build_faqs(p: dict) -> list:
    """Research-oriented Q&As — structured for GEO / AI answers."""
    name = p["name"]
    if p.get("kind") == "supply":
        return [
            (f"What is {name} used for?",
             f"{name} is {p['what_it_is']}. It {p['how_it_works']}."),
            (f"Is {name} for human use?",
             f"No. {name} is a laboratory supply for research handling only and is "
             f"not for human or animal use."),
            (f"How should {name} be stored?",
             f"Store {name} at room temperature away from direct light, and handle "
             f"using appropriate laboratory practices."),
            (f"Does {name} ship within Australia?",
             f"Yes. {BRAND} dispatches {name} {p['dose']} Australia-wide for "
             f"laboratory and research customers."),
        ]
    # storage differs slightly for non-lyophilised compounds
    if p.get("kind") == "compound":
        storage = (f"Store {name} in a cool, dry place away from light and moisture, "
                   f"and handle using appropriate laboratory safety practices.")
    else:
        storage = (f"Store lyophilised {name} frozen and away from light. After "
                   f"reconstitution with bacteriostatic water, keep refrigerated at "
                   f"2–8°C and handle using appropriate laboratory safety practices.")
    return [
        (f"What is {name}?",
         f"{name} is {p['what_it_is']}. In the laboratory it is studied in research "
         f"relating to {p['summary']}. In research models, {name} {p['how_it_works']}."),
        (f"Is {name} for human use?",
         f"No. {name} is supplied strictly as a research chemical for in-vitro and "
         f"laboratory study. It is not a medicine, supplement, cosmetic or food, and "
         f"is not for human or animal consumption."),
        (f"How should {name} be stored and handled?", storage),
        (f"Does {name} ship within Australia?",
         f"Yes. {BRAND} dispatches {name} {p['dose']} Australia-wide, with a "
         f"Certificate of Analysis confirming ≥99% purity for every batch."),
    ]


def build_full_description(p: dict, category: str) -> str:
    """Research-grade, SEO/GEO-optimised HTML body — unique per item."""
    name = p["name"]
    bullets = "".join(f"    <li>{esc(b)}</li>\n" for b in p["benefits"])

    faq_blocks = ""
    for q, a in build_faqs(p):
        faq_blocks += f"  <h4>{esc(q)}</h4>\n  <p>{esc(a)}</p>\n"

    if p.get("kind") == "supply":
        return f"""<h2>{esc(name)} {esc(p['dose'])} — Laboratory Supply</h2>
<p><strong>{esc(name)}</strong> is {esc(p['what_it_is'])}. It is supplied by
{esc(BRAND)} for laboratory and research handling — used for {esc(p['summary'])}.</p>

<h3>Why Researchers Choose {esc(name)}</h3>
<ul>
{bullets}</ul>

<h3>Laboratory-Grade Quality from {esc(BRAND)} ({COUNTRY})</h3>
<ul>
    <li>Sterile, sealed and ready for the research bench</li>
    <li>Australian-based dispatch with fast, tracked shipping</li>
    <li>Consistent, reliable consumables for reproducible work</li>
    <li>Responsive local support and secure checkout</li>
</ul>

<h3>Important — Research Use Only</h3>
<p><strong>{esc(name)} is a laboratory supply for research use only.</strong> It
is intended for use by qualified researchers handling research materials and is
<strong>not for human or animal consumption</strong>. By purchasing, you confirm
you are a qualified researcher or institution and accept full responsibility for
safe, lawful handling and disposal.</p>

<h3>Frequently Asked Questions</h3>
{faq_blocks}"""

    subtitle = ("Research-Grade Compound (≥99% Purity)" if p.get("kind") == "compound"
                else "Research-Grade Peptide (≥99% Purity)")
    return f"""<h2>{esc(name)} {esc(p['dose'])} — {subtitle}</h2>
<p><strong>{esc(name)}</strong> is {esc(p['what_it_is'])}. It is supplied by
{esc(BRAND)} as a high-purity reference {esc(_noun(p).split()[-1])} for laboratory
and research applications, and is studied in research relating to {esc(p['summary'])}.</p>

<h3>Mechanism of Action in Research</h3>
<p>In published and preclinical research, {esc(name)} {esc(p['how_it_works'])}.
{esc(BRAND)} supplies every batch at ≥99% purity, verified by independent HPLC
and mass-spectrometry testing so researchers know exactly what they are working
with.</p>

<h3>Areas of Research Interest</h3>
<p>{esc(name)} has been investigated by researchers in connection with:</p>
<ul>
{bullets}</ul>

<h3>Research-Grade Quality from {esc(BRAND)} ({COUNTRY})</h3>
<ul>
    <li>≥99% purity — independently lab-tested with a downloadable Certificate of Analysis</li>
    <li>Australian-based dispatch with fast, tracked shipping</li>
    <li>Cold-chain handling and stable storage for full potency on arrival</li>
    <li>Responsive local support and secure checkout</li>
</ul>

<h3>Important — Research Use Only</h3>
<p><strong>{esc(name)} is sold for laboratory and research use only.</strong> It
is intended exclusively for in-vitro experimentation and scientific study by
qualified researchers. It is <strong>not for human or animal consumption</strong>
and is not a drug, food, cosmetic or dietary supplement. By purchasing, you
confirm you are a qualified researcher or institution and accept full
responsibility for safe, lawful handling and disposal.</p>

<h3>Frequently Asked Questions</h3>
{faq_blocks}"""


HEADERS = [
    "Type", "SKU", "Name", "Published", "Is featured?", "Visibility in catalog",
    "Short description", "Description", "Tax status", "Tax class", "In stock?",
    "Stock", "Backorders allowed?", "Sold individually?", "Regular price",
    "Sale price", "Categories", "Tags", "Weight (g)", "Attribute 1 name",
    "Attribute 1 value(s)", "Attribute 1 visible", "Attribute 1 global",
    "Meta: _yoast_wpseo_title", "Meta: _yoast_wpseo_metadesc",
    "Meta: _yoast_wpseo_focuskw",
]


def main():
    # First pass: build one row per (category, product). The same peptide can
    # appear in several categories — we collapse those into a single product
    # assigned to multiple categories (avoids duplicate-content / clone SKUs
    # while every category page still lists 50 products).
    by_name = {}          # full_name -> row (first occurrence wins for copy)
    order = []            # preserve first-seen order
    for category, cat in CATEGORIES.items():
        code = cat["code"]
        for i, p in enumerate(cat["products"], start=1):
            full_name = f"{p['name']} {p['dose']}"
            if full_name in by_name:
                # Duplicate peptide — just add this category to the canonical row.
                row = by_name[full_name]
                if category not in row["_cats"]:
                    row["_cats"].append(category)
                continue
            row = {
                "Type": "simple",
                "SKU": f"AV-{code}-{str(i).zfill(3)}",
                "Name": full_name,
                "Published": 1,
                "Is featured?": 1 if i <= 6 else 0,
                "Visibility in catalog": "visible",
                "Short description": build_short_description(p),
                "Description": build_full_description(p, category),
                "Tax status": "taxable",
                "Tax class": "",
                "In stock?": 1,
                "Stock": 100,
                "Backorders allowed?": 0,
                "Sold individually?": 0,
                "Regular price": p["price"],
                "Sale price": p.get("sale", ""),
                "Weight (g)": 25,
                "Attribute 1 name": "Purity",
                "Attribute 1 value(s)": "≥99%",
                "Attribute 1 visible": 1,
                "Attribute 1 global": 1,
                "Meta: _yoast_wpseo_title": build_meta_title(p),
                "Meta: _yoast_wpseo_metadesc": build_meta_description(p),
                "Meta: _yoast_wpseo_focuskw": p["name"],
                "_cats": [category],
                "_pname": p["name"],
            }
            by_name[full_name] = row
            order.append(full_name)

    # Finalise: turn the category list into the WooCommerce Categories + Tags.
    rows = []
    for name in order:
        row = by_name[name]
        cats = row.pop("_cats")
        pname = row.pop("_pname")
        row["Categories"] = ", ".join(cats)
        row["Tags"] = f"{pname}, peptides Australia, buy {pname}, " + ", ".join(cats)
        rows.append(row)

    out = "/home/user/shoppingtheme/alluvia-products.csv"
    with open(out, "w", newline="", encoding="utf-8") as f:
        w = csv.DictWriter(f, fieldnames=HEADERS)
        w.writeheader()
        w.writerows(rows)

    # Report: distinct products + members per category (counting multi-cat).
    per_cat = Counter()
    for r in rows:
        for c in r["Categories"].split(", "):
            per_cat[c] += 1
    print(f"CSV generated: {out}")
    print(f"Distinct products: {len(rows)}")
    for c, n in sorted(per_cat.items()):
        print(f"  {n:3d}  {c}")


if __name__ == "__main__":
    main()
