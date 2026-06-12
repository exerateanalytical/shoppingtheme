#!/usr/bin/env python3
"""
Generate branded category images for the Alluvia Peptides store.

Produces one premium 1080×1080 PNG per category, on-brand:
  * Navy gradient background (brand --navy / --navy-mid / --navy-soft)
  * Faint molecular-node motif echoing the hexagon logo mark
  * The category's own icon (reused from front-page.php) in its accent colour
  * Alluvia hexagon brand mark + wordmark lockup
  * Gold hairline frame and category name in an elegant serif

Output: images/categories/<slug>.png  (+ an SVG source alongside)

Run:  python3 generate_category_images.py
"""

import os
import cairosvg

NAVY = "#0d1b2a"
NAVY_MID = "#162336"
NAVY_SOFT = "#1e3050"
TEAL = "#00c6b3"
GOLD = "#c8a96e"
GOLD_LIGHT = "#e4c98f"
SAND = "#cdd6e0"

OUT_DIR = "/home/user/shoppingtheme/images/categories"
SIZE = 1080

# Each category: (slug, name two-line, tagline, accent colour, icon inner-SVG
# in a 0 0 64 64 viewBox — lifted verbatim from front-page.php).
CATEGORIES = [
    ("medical-peptides", ["Medical", "Peptides"], "THERAPEUTIC · RESTORATIVE", TEAL,
     '<rect x="26" y="8" width="12" height="48" rx="4" fill="ACCENT" fill-opacity="0.12" stroke="ACCENT" stroke-width="2"/><rect x="8" y="26" width="48" height="12" rx="4" fill="ACCENT" fill-opacity="0.12" stroke="ACCENT" stroke-width="2"/><circle cx="32" cy="11.5" r="4" fill="ACCENT"/><circle cx="32" cy="52.5" r="4" fill="ACCENT"/><circle cx="11.5" cy="32" r="4" fill="ACCENT"/><circle cx="52.5" cy="32" r="4" fill="ACCENT"/><circle cx="32" cy="32" r="7" fill="ACCENT" fill-opacity="0.18"/><circle cx="32" cy="32" r="3.5" fill="ACCENT"/>'),
    ("skincare-peptides", ["Skincare", "Peptides"], "COLLAGEN · RENEWAL", GOLD,
     '<path d="M 8 20 C 18 14 26 26 40 20 C 48 16 54 20 56 20" stroke="ACCENT" stroke-width="2" stroke-linecap="round" fill="none"/><path d="M 8 32 C 18 26 26 38 40 32 C 48 28 54 32 56 32" stroke="ACCENT" stroke-width="2" stroke-linecap="round" fill="none" stroke-opacity=".75"/><path d="M 8 44 C 18 38 26 50 40 44 C 48 40 54 44 56 44" stroke="ACCENT" stroke-width="2" stroke-linecap="round" fill="none" stroke-opacity=".5"/><circle cx="30" cy="12" r="4" fill="ACCENT"/><line x1="30" y1="16" x2="30" y2="20" stroke="ACCENT" stroke-width="1.8" stroke-linecap="round"/><circle cx="30" cy="23" r="3" fill="ACCENT" fill-opacity=".7"/><line x1="30" y1="26" x2="30" y2="32" stroke="ACCENT" stroke-width="1.8" stroke-linecap="round"/><circle cx="30" cy="35" r="2.5" fill="ACCENT" fill-opacity=".5"/><line x1="30" y1="37.5" x2="30" y2="43" stroke="ACCENT" stroke-width="1.5" stroke-linecap="round" stroke-dasharray="2.5 2"/><circle cx="30" cy="46" r="2" fill="ACCENT" fill-opacity=".3"/>'),
    ("collagen-peptides", ["Collagen", "Peptides"], "JOINTS · SKIN · TISSUE", "#7fb8d4",
     '<path d="M 28 6 C 28 14 44 14 44 22 C 44 30 28 30 28 38 C 28 46 44 46 44 54 C 44 60 36 62 32 58" stroke="ACCENT" stroke-width="2.5" fill="none" stroke-linecap="round"/><path d="M 36 10 C 36 18 20 18 20 26 C 20 34 36 34 36 42 C 36 50 20 50 20 58" stroke="ACCENT" stroke-width="2" fill="none" stroke-linecap="round" stroke-opacity=".65"/><path d="M 32 8 C 32 16 46 20 44 28 C 42 36 26 36 26 44 C 26 52 40 52 38 58" stroke="ACCENT" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-opacity=".35"/><circle cx="36" cy="22" r="3" fill="ACCENT"/><circle cx="28" cy="38" r="2.5" fill="ACCENT" fill-opacity=".7"/><circle cx="36" cy="46" r="2" fill="ACCENT" fill-opacity=".5"/>'),
    ("sports-recovery", ["Sports &", "Recovery"], "PERFORMANCE · REPAIR", "#e07b54",
     '<polygon points="32,5 54,18 54,43 32,56 10,43 10,18" stroke="ACCENT" stroke-width="2" fill="ACCENT" fill-opacity="0.08"/><path d="M 37 14 L 26 34 L 33 34 L 27 50 L 42 28 L 35 28 Z" fill="ACCENT" stroke="none"/><circle cx="32" cy="5" r="3" fill="ACCENT"/><circle cx="54" cy="18" r="3" fill="ACCENT" fill-opacity=".5"/><circle cx="10" cy="43" r="3" fill="ACCENT" fill-opacity=".5"/>'),
    ("weight-loss-metabolic", ["Weight-Loss", "& Metabolic"], "APPETITE · FAT LOSS", "#9b72cf",
     '<path d="M 32 10 A 22 22 0 1 1 54 32" stroke="ACCENT" stroke-width="2.5" fill="none" stroke-linecap="round"/><path d="M 47 22 L 54 32 L 44 34" stroke="ACCENT" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/><circle cx="32" cy="32" r="8" stroke="ACCENT" stroke-width="1.5" fill="ACCENT" fill-opacity="0.1"/><circle cx="32" cy="26" r="3" fill="ACCENT"/><circle cx="37.2" cy="34.5" r="3" fill="ACCENT" fill-opacity=".7"/><circle cx="26.8" cy="34.5" r="3" fill="ACCENT" fill-opacity=".7"/><line x1="32" y1="29" x2="35.5" y2="32.5" stroke="ACCENT" stroke-width="1.5"/><line x1="32" y1="29" x2="28.5" y2="32.5" stroke="ACCENT" stroke-width="1.5"/><line x1="35" y1="34.5" x2="29" y2="34.5" stroke="ACCENT" stroke-width="1.5"/>'),
    ("hormone-anti-aging", ["Hormone &", "Anti-Aging"], "LONGEVITY · VITALITY", GOLD,
     '<path d="M 14 8 L 50 8 L 34 30 L 50 56 L 14 56 L 30 30 Z" stroke="ACCENT" stroke-width="2" fill="ACCENT" fill-opacity="0.08" stroke-linejoin="round"/><circle cx="32" cy="31" r="3.5" fill="ACCENT"/><path d="M 23 15 Q 32 19 41 15" stroke="ACCENT" stroke-width="1.8" fill="none" stroke-linecap="round"/><path d="M 21 22 Q 32 26 43 22" stroke="ACCENT" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-opacity=".7"/><path d="M 21 40 Q 32 44 43 40" stroke="ACCENT" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-opacity=".7"/><path d="M 23 48 Q 32 52 41 48" stroke="ACCENT" stroke-width="1.8" fill="none" stroke-linecap="round"/>'),
    ("hair-growth-peptides", ["Hair Growth", "Peptides"], "FOLLICLE · DENSITY", "#78c9a2",
     '<ellipse cx="32" cy="54" rx="16" ry="7" stroke="ACCENT" stroke-width="2" fill="ACCENT" fill-opacity="0.12"/><circle cx="32" cy="54" r="3" fill="ACCENT" fill-opacity=".5"/><path d="M 22 54 C 22 46 15 38 19 26 C 21 18 25 14 24 9" stroke="ACCENT" stroke-width="2" fill="none" stroke-linecap="round" stroke-opacity=".5"/><path d="M 32 54 C 32 44 25 36 28 24 C 30 15 33 10 32 7" stroke="ACCENT" stroke-width="2.5" fill="none" stroke-linecap="round"/><path d="M 42 54 C 42 46 49 38 45 26 C 43 18 39 14 40 9" stroke="ACCENT" stroke-width="2" fill="none" stroke-linecap="round" stroke-opacity=".5"/><circle cx="30" cy="34" r="3" fill="ACCENT"/><circle cx="31" cy="20" r="2.5" fill="ACCENT" fill-opacity=".7"/><circle cx="32" cy="10" r="2" fill="ACCENT" fill-opacity=".5"/>'),
    ("lab-supplies-accessories", ["Lab Supplies", "& Accessories"], "RECONSTITUTE · STORE", "#5b7186",
     '<rect x="24" y="16" width="16" height="40" rx="4" fill="ACCENT" fill-opacity="0.12" stroke="ACCENT" stroke-width="2"/><rect x="26" y="9" width="12" height="8" rx="2" fill="ACCENT"/><line x1="24" y1="40" x2="40" y2="40" stroke="ACCENT" stroke-width="2" stroke-opacity="0.6"/><line x1="24" y1="47" x2="40" y2="47" stroke="ACCENT" stroke-width="1.5" stroke-opacity="0.4"/><path d="M 50 14 C 50 14 46 20 46 23.5 A 4 4 0 1 0 54 23.5 C 54 20 50 14 50 14 Z" fill="ACCENT" fill-opacity="0.75"/>'),
    ("research-peptides", ["Research", "Peptides"], "HIGH-PURITY · COA", TEAL,
     '<path d="M 24 8 L 24 25 L 10 48 C 8 53 12 57 17 57 L 47 57 C 52 57 56 53 54 48 L 40 25 L 40 8 Z" stroke="ACCENT" stroke-width="2" fill="ACCENT" fill-opacity="0.08"/><line x1="20" y1="8" x2="44" y2="8" stroke="ACCENT" stroke-width="2.5" stroke-linecap="round"/><circle cx="25" cy="47" r="3.5" fill="ACCENT" fill-opacity=".6"/><line x1="28.5" y1="47" x2="35.5" y2="47" stroke="ACCENT" stroke-width="1.8"/><circle cx="39" cy="47" r="3.5" fill="ACCENT" fill-opacity=".6"/><circle cx="28" cy="38" r="2.5" fill="ACCENT" fill-opacity=".75"/><line x1="30" y1="36.5" x2="34" y2="31" stroke="ACCENT" stroke-width="1.5" stroke-opacity=".5"/><circle cx="36" cy="29" r="3" fill="ACCENT"/><line x1="35" y1="26.5" x2="31" y2="20" stroke="ACCENT" stroke-width="1.5" stroke-opacity=".4"/><circle cx="30" cy="17" r="2" fill="ACCENT" fill-opacity=".5"/>'),
]


def brand_lockup(cx, y, accent):
    """Hexagon mark + ALLUVIA PEPTIDES wordmark, centred on cx at top y."""
    hexs = 22  # hexagon radius
    return f"""
    <g transform="translate({cx - 132}, {y})">
      <g transform="translate(0,-6) scale(1.05)">
        <polygon points="17,2 30,9.5 30,24.5 17,32 4,24.5 4,9.5" stroke="{TEAL}" stroke-width="1.6" fill="none" opacity="0.95"/>
        <circle cx="17" cy="10" r="2.2" fill="{TEAL}"/>
        <circle cx="10.5" cy="21" r="2.2" fill="{TEAL}"/>
        <circle cx="23.5" cy="21" r="2.2" fill="{TEAL}"/>
        <line x1="17" y1="10" x2="10.5" y2="21" stroke="{TEAL}" stroke-width="1.1" opacity="0.5"/>
        <line x1="17" y1="10" x2="23.5" y2="21" stroke="{TEAL}" stroke-width="1.1" opacity="0.5"/>
        <line x1="10.5" y1="21" x2="23.5" y2="21" stroke="{TEAL}" stroke-width="1.1" opacity="0.5"/>
      </g>
      <text x="44" y="14" font-family="DejaVu Serif" font-size="22" font-weight="bold" fill="#ffffff" letter-spacing="2">ALLUVIA</text>
      <text x="45" y="31" font-family="DejaVu Sans" font-size="11" fill="{GOLD}" letter-spacing="6">PEPTIDES</text>
    </g>"""


def molecule_motif(accent):
    """Faint decorative hexagon-node clusters in the corners."""
    def cluster(cx, cy, s, op):
        return f"""<g opacity="{op}" transform="translate({cx},{cy}) scale({s})">
          <polygon points="0,-18 15.6,-9 15.6,9 0,18 -15.6,9 -15.6,-9" fill="none" stroke="{accent}" stroke-width="1.4"/>
          <circle cx="0" cy="-18" r="2.4" fill="{accent}"/><circle cx="15.6" cy="-9" r="2.4" fill="{accent}"/>
          <circle cx="15.6" cy="9" r="2.4" fill="{accent}"/><circle cx="0" cy="18" r="2.4" fill="{accent}"/>
          <circle cx="-15.6" cy="9" r="2.4" fill="{accent}"/><circle cx="-15.6" cy="-9" r="2.4" fill="{accent}"/>
        </g>"""
    return (
        cluster(150, 250, 1.6, 0.10) + cluster(250, 170, 1.0, 0.07) +
        cluster(930, 820, 1.6, 0.10) + cluster(840, 910, 1.0, 0.07) +
        cluster(945, 230, 1.1, 0.06) + cluster(140, 880, 1.1, 0.06)
    )


def _esc(s):
    return s.replace("&", "&amp;").replace("<", "&lt;").replace(">", "&gt;")


def build_svg(name_lines, tagline, accent, icon_inner):
    icon = icon_inner.replace("ACCENT", accent)
    name_lines = [_esc(n) for n in name_lines]
    tagline = _esc(tagline)
    cx = SIZE / 2
    # Category name (one or two lines), elegant serif
    name_y = 720
    if len(name_lines) == 2:
        name_svg = (
            f'<text x="{cx}" y="{name_y}" font-family="DejaVu Serif" font-size="74" '
            f'font-weight="bold" fill="#ffffff" text-anchor="middle">{name_lines[0]}</text>'
            f'<text x="{cx}" y="{name_y + 82}" font-family="DejaVu Serif" font-size="74" '
            f'font-weight="bold" fill="#ffffff" text-anchor="middle">{name_lines[1]}</text>'
        )
        rule_y = name_y + 128
    else:
        name_svg = (
            f'<text x="{cx}" y="{name_y + 40}" font-family="DejaVu Serif" font-size="74" '
            f'font-weight="bold" fill="#ffffff" text-anchor="middle">{name_lines[0]}</text>'
        )
        rule_y = name_y + 86

    return f"""<svg xmlns="http://www.w3.org/2000/svg" width="{SIZE}" height="{SIZE}" viewBox="0 0 {SIZE} {SIZE}">
  <defs>
    <linearGradient id="bg" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0" stop-color="{NAVY}"/>
      <stop offset="0.55" stop-color="{NAVY_MID}"/>
      <stop offset="1" stop-color="{NAVY_SOFT}"/>
    </linearGradient>
    <radialGradient id="glow" cx="0.5" cy="0.40" r="0.5">
      <stop offset="0" stop-color="{accent}" stop-opacity="0.30"/>
      <stop offset="1" stop-color="{accent}" stop-opacity="0"/>
    </radialGradient>
  </defs>

  <rect width="{SIZE}" height="{SIZE}" fill="url(#bg)"/>
  {molecule_motif(accent)}
  <rect x="0" y="0" width="{SIZE}" height="{SIZE}" fill="url(#glow)"/>

  <!-- gold hairline frame -->
  <rect x="40" y="40" width="{SIZE - 80}" height="{SIZE - 80}" fill="none"
        stroke="{GOLD}" stroke-opacity="0.55" stroke-width="2" rx="8"/>

  {brand_lockup(cx, 110, accent)}

  <!-- icon badge -->
  <circle cx="{cx}" cy="430" r="180" fill="{accent}" fill-opacity="0.06"
          stroke="{accent}" stroke-opacity="0.45" stroke-width="2.5"/>
  <circle cx="{cx}" cy="430" r="150" fill="none" stroke="{accent}"
          stroke-opacity="0.18" stroke-width="1.2"/>
  <g transform="translate({cx - 110}, 320) scale(3.44)">{icon}</g>

  {name_svg}
  <line x1="{cx - 70}" y1="{rule_y}" x2="{cx + 70}" y2="{rule_y}"
        stroke="{GOLD}" stroke-width="2.5"/>
  <text x="{cx}" y="{rule_y + 52}" font-family="DejaVu Sans" font-size="22"
        fill="{SAND}" text-anchor="middle" letter-spacing="6">{tagline}</text>
</svg>"""


def main():
    os.makedirs(OUT_DIR, exist_ok=True)
    for slug, name_lines, tagline, accent, icon_inner in CATEGORIES:
        svg = build_svg(name_lines, tagline, accent, icon_inner)
        svg_path = os.path.join(OUT_DIR, f"{slug}.svg")
        png_path = os.path.join(OUT_DIR, f"{slug}.png")
        with open(svg_path, "w", encoding="utf-8") as f:
            f.write(svg)
        cairosvg.svg2png(bytestring=svg.encode("utf-8"),
                         write_to=png_path, output_width=SIZE, output_height=SIZE)
        print(f"  ✓ {slug}.png")
    print(f"Done — {len(CATEGORIES)} category images in {OUT_DIR}")


if __name__ == "__main__":
    main()
