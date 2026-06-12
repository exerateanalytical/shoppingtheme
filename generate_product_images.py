#!/usr/bin/env python3
"""
Branded universal vial — auto-filled per-product image generator.

Designs ONE branded Alluvia peptide vial (glass body, crimp cap, lyophilised
cake, label) and stamps each product's own details onto the label by reading
the catalogue:

    * product name   -> label headline (auto-sized + wrapped)
    * dose           -> the highlighted property
    * purity (≥99%)  -> property line
    * category       -> accent colour (cap button + label rule + dose)

Output: images/products/<SKU>.png  (1080×1080), one per distinct product.
The SKU/dedupe logic mirrors generate_products.py so filenames line up with
the CSV rows.

Usage:
    python3 generate_product_images.py sample   # render a few test vials to /tmp
    python3 generate_product_images.py          # render all 294 products
"""

import io
import os
import sys
import cairosvg
from PIL import Image

from catalogue_data import CATEGORIES

# Brand palette
NAVY = "#0d1b2a"
TEAL = "#00c6b3"
GOLD = "#c8a96e"
INK = "#22303c"
SUB = "#6b7a86"

# Category -> accent colour (matches the category images)
ACCENTS = {
    "Medical Peptides": TEAL,
    "Skincare Peptides": GOLD,
    "Collagen Peptides": "#5fa8cc",
    "Sports & Recovery": "#e07b54",
    "Weight-Loss & Metabolic": "#9b72cf",
    "Hormone & Anti-Aging": GOLD,
    "Hair Growth Peptides": "#5bb98c",
    "Research Peptides": TEAL,
}

SIZE = 1080
OUT_DIR = "/home/user/shoppingtheme/images/products"


def esc(s):
    return (str(s).replace("&", "&amp;").replace("<", "&lt;").replace(">", "&gt;"))


def wrap(text, fs, max_w, max_lines=3):
    """Greedy word-wrap using an approximate serif glyph width."""
    cw = fs * 0.54
    max_chars = max(6, int(max_w / cw))
    words = text.split()
    lines, cur = [], ""
    for w in words:
        trial = (cur + " " + w).strip()
        if len(trial) <= max_chars:
            cur = trial
        else:
            if cur:
                lines.append(cur)
            cur = w
        if len(lines) == max_lines:
            break
    if cur and len(lines) < max_lines:
        lines.append(cur)
    return lines


def fit_name(name, max_w, max_lines=3, band_h=120):
    """Largest font size at which the name fits the label band (width + height)."""
    n_words = len(name.split())
    for fs in (42, 38, 34, 31, 28, 25, 22, 20):
        lines = wrap(name, fs, max_w, max_lines)
        fits_words = len(" ".join(lines).split()) == n_words
        fits_height = fs * 1.12 * len(lines) <= band_h
        if fits_words and len(lines) <= max_lines and fits_height:
            return fs, lines
    return 20, wrap(name, 20, max_w, max_lines)


def build_vial_svg(name, dose, purity, accent, category="", lot="ALV·000000"):
    cx = SIZE / 2
    label_x0, label_x1 = 403, 677          # taller pharma-style label
    label_y0, label_h = 392, 404
    inner_w = (label_x1 - label_x0) - 50

    name_fs, name_lines = fit_name(esc(name), inner_w, 3, band_h=100)
    line_h = name_fs * 1.12
    block_h = line_h * len(name_lines)
    name_top = 548 - block_h / 2 + name_fs * 0.8   # band centred at y=548, dose at 648
    name_svg = ""
    for i, ln in enumerate(name_lines):
        y = name_top + i * line_h
        name_svg += (f'<text x="{cx}" y="{y:.0f}" font-family="DejaVu Serif" '
                     f'font-size="{name_fs}" font-weight="bold" fill="{INK}" '
                     f'text-anchor="middle">{ln}</text>')

    # adaptive dose size for long dose strings ("500mcg x 60")
    dlen = len(dose)
    dose_fs = 40 if dlen <= 5 else (32 if dlen <= 9 else 25)

    # category line (uppercase, letterspaced, shrink for long names)
    cat = esc(category.upper())
    cat_fs, cat_ls = (12, 2.5) if len(cat) <= 16 else (10.5, 1.5)

    return f"""<svg xmlns="http://www.w3.org/2000/svg" width="{SIZE}" height="{SIZE}" viewBox="0 0 {SIZE} {SIZE}">
  <defs>
    <linearGradient id="bg" x1="0" y1="0" x2="0" y2="1">
      <stop offset="0" stop-color="#ffffff"/><stop offset="0.62" stop-color="#fbfcfd"/>
      <stop offset="1" stop-color="#eef2f5"/>
    </linearGradient>
    <radialGradient id="shadow" cx="0.5" cy="0.5" r="0.5">
      <stop offset="0" stop-color="#0d1b2a" stop-opacity="0.18"/>
      <stop offset="1" stop-color="#0d1b2a" stop-opacity="0"/>
    </radialGradient>
    <linearGradient id="glass" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0" stop-color="#ffffff" stop-opacity="0.9"/>
      <stop offset="0.18" stop-color="#dfe8ee" stop-opacity="0.7"/>
      <stop offset="0.5"  stop-color="#eef4f7" stop-opacity="0.55"/>
      <stop offset="0.85" stop-color="#cdd9e1" stop-opacity="0.7"/>
      <stop offset="1"    stop-color="#e9f0f4" stop-opacity="0.82"/>
    </linearGradient>
    <linearGradient id="metal" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0" stop-color="#cfd6db"/><stop offset="0.2" stop-color="#f2f4f6"/>
      <stop offset="0.5" stop-color="#aab2b8"/><stop offset="0.78" stop-color="#eef0f2"/>
      <stop offset="1" stop-color="#b7bfc5"/>
    </linearGradient>
    <linearGradient id="cap" x1="0" y1="0" x2="0" y2="1">
      <stop offset="0" stop-color="{accent}" stop-opacity="0.95"/>
      <stop offset="1" stop-color="{accent}" stop-opacity="0.65"/>
    </linearGradient>
  </defs>

  <rect width="{SIZE}" height="{SIZE}" fill="url(#bg)"/>
  <ellipse cx="{cx}" cy="906" rx="178" ry="28" fill="url(#shadow)"/>

  <!-- glass body -->
  <path d="M 392 372 Q 392 352 412 348 L 480 338 Q 480 318 484 314 L 596 314 Q 600 318 600 338 L 668 348 Q 688 352 688 372 L 688 856 Q 688 884 660 884 L 420 884 Q 392 884 392 856 Z"
        fill="url(#glass)" stroke="#b3c1cb" stroke-width="2.5"/>
  <!-- lyophilised cake -->
  <path d="M 414 872 L 666 872 L 666 818 Q 600 806 540 814 Q 480 822 414 812 Z"
        fill="#fbfaf6" stroke="#e7e2d4" stroke-width="1.5"/>
  <!-- glass highlights -->
  <rect x="410" y="372" width="20" height="470" rx="10" fill="#ffffff" opacity="0.6"/>
  <rect x="650" y="380" width="9"  height="450" rx="5"  fill="#ffffff" opacity="0.32"/>

  <!-- neck + crimp cap + flip-off button -->
  <rect x="474" y="286" width="132" height="40" fill="url(#glass)" stroke="#b3c1cb" stroke-width="2"/>
  <rect x="446" y="214" width="188" height="78" rx="9" fill="url(#metal)" stroke="#9aa3a9" stroke-width="1.5"/>
  <g stroke="#9aa3a9" stroke-width="1" opacity="0.5">
    <line x1="452" y1="230" x2="628" y2="230"/><line x1="452" y1="244" x2="628" y2="244"/>
    <line x1="452" y1="258" x2="628" y2="258"/><line x1="452" y1="272" x2="628" y2="272"/>
  </g>
  <rect x="470" y="176" width="140" height="48" rx="10" fill="url(#cap)" stroke="{accent}" stroke-width="1.5"/>
  <ellipse cx="540" cy="186" rx="56" ry="8" fill="#ffffff" opacity="0.25"/>

  <!-- ===== LABEL ===== -->
  <rect x="{label_x0}" y="{label_y0}" width="{label_x1 - label_x0}" height="{label_h}" rx="14"
        fill="#ffffff" stroke="#e4e9ed" stroke-width="1.5"/>
  <rect x="{label_x0}" y="{label_y0}" width="6" height="{label_h}" rx="3" fill="{accent}"/>

  <!-- brand lockup (top-left) -->
  <g transform="translate(432, 414)">
    <g transform="scale(0.72)">
      <polygon points="17,2 30,9.5 30,24.5 17,32 4,24.5 4,9.5" stroke="{TEAL}" stroke-width="1.6" fill="none"/>
      <circle cx="17" cy="10" r="2.2" fill="{TEAL}"/><circle cx="10.5" cy="21" r="2.2" fill="{TEAL}"/>
      <circle cx="23.5" cy="21" r="2.2" fill="{TEAL}"/>
      <line x1="17" y1="10" x2="10.5" y2="21" stroke="{TEAL}" stroke-width="1.1" opacity="0.5"/>
      <line x1="17" y1="10" x2="23.5" y2="21" stroke="{TEAL}" stroke-width="1.1" opacity="0.5"/>
      <line x1="10.5" y1="21" x2="23.5" y2="21" stroke="{TEAL}" stroke-width="1.1" opacity="0.5"/>
    </g>
    <text x="32" y="11" font-family="DejaVu Serif" font-size="15" font-weight="bold" fill="{NAVY}" letter-spacing="1.3">ALLUVIA</text>
    <text x="33" y="22" font-family="DejaVu Sans" font-size="7" fill="{GOLD}" letter-spacing="3.5">PEPTIDES</text>
  </g>

  <!-- COA seal badge (top-right) -->
  <g transform="translate(636, 432)">
    <circle r="27" fill="none" stroke="{accent}" stroke-width="2"/>
    <circle r="22" fill="{accent}" fill-opacity="0.07" stroke="{accent}" stroke-width="0.8" stroke-opacity="0.5"/>
    <path d="M -9 1 L -3 8 L 10 -7" fill="none" stroke="{accent}" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
    <text x="0" y="17" font-family="DejaVu Sans" font-size="6.5" font-weight="bold" fill="{accent}" text-anchor="middle" letter-spacing="1">COA</text>
  </g>

  <!-- category + rule -->
  <text x="{cx}" y="472" font-family="DejaVu Sans" font-size="{cat_fs}" fill="{accent}" font-weight="bold" text-anchor="middle" letter-spacing="{cat_ls}">{cat}</text>
  <line x1="{cx - 40}" y1="486" x2="{cx + 40}" y2="486" stroke="{GOLD}" stroke-width="1.5"/>

  {name_svg}

  <!-- dose hero -->
  <text x="{cx}" y="648" font-family="DejaVu Sans" font-size="{dose_fs}" font-weight="bold" fill="{accent}" text-anchor="middle">{esc(dose)}</text>
  <text x="{cx}" y="674" font-family="DejaVu Sans" font-size="14" fill="{INK}" text-anchor="middle" letter-spacing="2">{esc(purity)} PURITY · LYOPHILISED</text>

  <line x1="430" y1="696" x2="650" y2="696" stroke="#e9edf0" stroke-width="1.2"/>
  <!-- lot / net row -->
  <text x="436" y="718" font-family="DejaVu Sans" font-size="11" fill="{SUB}" letter-spacing="0.5">LOT {esc(lot)}</text>
  <text x="644" y="718" font-family="DejaVu Sans" font-size="11" fill="{SUB}" text-anchor="end" letter-spacing="0.5">NET 1 VIAL</text>
  <text x="{cx}" y="735" font-family="DejaVu Sans" font-size="11" font-weight="bold" fill="{accent}" text-anchor="middle" letter-spacing="2">RESEARCH USE ONLY</text>
  <text x="{cx}" y="751" font-family="DejaVu Sans" font-size="9" fill="{SUB}" text-anchor="middle" letter-spacing="1.5">NOT FOR HUMAN CONSUMPTION</text>
  <text x="{cx}" y="768" font-family="DejaVu Sans" font-size="9" fill="{SUB}" text-anchor="middle" letter-spacing="1">STORE -20°C · ALLUVIAPEPTIDES.COM.AU</text>
</svg>"""


def make_lot(sku):
    """Deterministic, authentic-looking lot code from the SKU."""
    h = abs(hash(sku)) % 1000000
    return f"ALV·{h:06d}"


def distinct_products():
    """Mirror generate_products.py dedupe: first category wins, gives SKU+accent."""
    seen = {}
    order = []
    for category, cat in CATEGORIES.items():
        code = cat["code"]
        for i, p in enumerate(cat["products"], start=1):
            key = f"{p['name']} {p['dose']}"
            if key in seen:
                continue
            sku = f"AV-{code}-{str(i).zfill(3)}"
            seen[key] = {
                "sku": sku,
                "name": p["name"], "dose": p["dose"],
                "category": category,
                "accent": ACCENTS.get(category, TEAL),
                "lot": make_lot(sku),
            }
            order.append(key)
    return [seen[k] for k in order]


def svg_to_jpg(svg, path, quality=88):
    png = cairosvg.svg2png(bytestring=svg.encode("utf-8"),
                           output_width=SIZE, output_height=SIZE)
    im = Image.open(io.BytesIO(png)).convert("RGB")
    im.save(path, "JPEG", quality=quality, optimize=True)


def render(prod, path):
    svg = build_vial_svg(prod["name"], prod["dose"], "≥99%", prod["accent"],
                         category=prod["category"], lot=prod["lot"])
    svg_to_jpg(svg, path)


def main():
    products = distinct_products()
    if len(sys.argv) > 1 and sys.argv[1] == "sample":
        picks = [
            ("BPC-157", "5mg", "Sports & Recovery"),
            ("GHK-Cu (Copper Peptide)", "50mg", "Skincare Peptides"),
            ("Semaglutide", "5mg", "Weight-Loss & Metabolic"),
            ("Ipamorelin / CJC-1295 Blend", "10mg", "Sports & Recovery"),
            ("Hydrolysed Marine Collagen Peptides", "300g", "Collagen Peptides"),
            ("Wolverine Blend (BPC-157 + TB-500 + GHK-Cu)", "16mg", "Sports & Recovery"),
        ]
        os.makedirs("/tmp/vials", exist_ok=True)
        out = []
        for name, dose, cat in picks:
            svg = build_vial_svg(name, dose, "≥99%", ACCENTS[cat],
                                 category=cat, lot=make_lot(name))
            slug = name.split()[0].lower().strip("(")
            p = f"/tmp/vials/{slug}.png"
            cairosvg.svg2png(bytestring=svg.encode("utf-8"), write_to=p,
                             output_width=SIZE, output_height=SIZE)
            out.append(p)
            print("  ✓", p)
        return out

    os.makedirs(OUT_DIR, exist_ok=True)
    for prod in products:
        render(prod, os.path.join(OUT_DIR, prod["sku"] + ".jpg"))
    print(f"Rendered {len(products)} product vials into {OUT_DIR}")


if __name__ == "__main__":
    main()
