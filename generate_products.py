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


def build_short_description(p: dict) -> str:
    """Excerpt on shop/category cards. Benefit-led, keyword-rich, AU-targeted."""
    return (
        f"{p['name']} {p['dose']} for {p['summary']}. "
        f"Buy {p['name']} online in {COUNTRY} from {BRAND} — third-party "
        f"tested for ≥99% purity with a Certificate of Analysis and fast, "
        f"discreet nationwide shipping."
    )


def build_meta_title(p: dict) -> str:
    """SEO <title> — keep close to ~60 chars where possible."""
    base = f"Buy {p['name']} {p['dose']} Online Australia | {BRAND}"
    if len(base) <= 60:
        return base
    return f"{p['name']} {p['dose']} Australia | {BRAND}"


def build_meta_description(p: dict) -> str:
    """SEO meta description — ~150 chars, benefit-led, AU + purity hooks."""
    desc = (
        f"Buy {p['name']} {p['dose']} in Australia for {p['summary']}. "
        f"≥99% purity, Certificate of Analysis, fast discreet shipping from {BRAND}."
    )
    return desc[:157].rsplit(" ", 1)[0] if len(desc) > 158 else desc


def build_faqs(p: dict) -> list:
    """Two to three peptide-specific Q&As — structured for GEO / AI answers."""
    name = p["name"]
    return [
        (
            f"What is {name} used for?",
            f"{name} is best known for {p['summary']}. {p['how_it_works'].capitalize()}.",
        ),
        (
            f"How do I store {name}?",
            f"Store lyophilised {name} in the freezer away from light. Once "
            f"reconstituted with bacteriostatic water, keep it refrigerated at "
            f"2–8°C and use within 3–4 weeks for best results.",
        ),
        (
            f"Is {name} available in Australia?",
            f"Yes. {BRAND} ships {name} {p['dose']} Australia-wide from local "
            f"stock — Sydney, Melbourne, Brisbane, Perth and Adelaide — with "
            f"every batch backed by a Certificate of Analysis.",
        ),
    ]


def build_full_description(p: dict, category: str) -> str:
    """Authentic, SEO/GEO-optimised HTML body — unique per peptide."""
    name = p["name"]
    benefits = "".join(f"    <li>{esc(b)}</li>\n" for b in p["benefits"])

    faq_blocks = ""
    for q, a in build_faqs(p):
        faq_blocks += f"  <h4>{esc(q)}</h4>\n  <p>{esc(a)}</p>\n"

    return f"""<h2>{esc(name)} {esc(p['dose'])} — {esc(p['summary'][:1].upper() + p['summary'][1:])}</h2>
<p><strong>{esc(name)}</strong> is {esc(p['what_it_is'])}. It has become one of
the most in-demand compounds in the {esc(category.lower())} category among
{esc(p['audience'])} across {COUNTRY}, valued for {esc(p['summary'])}.</p>

<h3>How {esc(name)} Works</h3>
<p>{esc(name)} {esc(p['how_it_works'])}. {esc(BRAND)} supplies every vial at
≥99% purity, verified by independent HPLC and mass-spectrometry testing so you
know exactly what you are getting.</p>

<h3>Key Benefits of {esc(name)}</h3>
<ul>
{benefits}</ul>

<h3>Why Buy {esc(name)} from {esc(BRAND)} in {COUNTRY}?</h3>
<ul>
    <li>≥99% purity — independently lab-tested with a downloadable Certificate of Analysis</li>
    <li>Australian-based dispatch with fast, discreet, tracked shipping</li>
    <li>Cold-chain handling and lyophilised stability for full potency on arrival</li>
    <li>Responsive local support and secure checkout</li>
</ul>

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
