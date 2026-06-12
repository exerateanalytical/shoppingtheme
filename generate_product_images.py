#!/usr/bin/env python3
"""
Branded product imagery — photoreal vial + carton, auto-filled per product.

Pipeline:
  1. Build the subject (vial OR carton) as a transparent SVG with 3D cylindrical
     / box shading and specular highlights.
  2. Rasterise with cairosvg (transparent).
  3. Photographic compositing pass in PIL: studio backdrop, soft grounded
     shadow, faded floor reflection, vignette and fine film grain — so it reads
     like a studio product shot.

Each product gets TWO images:
  images/products/<SKU>.jpg  -> the vial   (featured image)
  images/cartons/<SKU>.jpg   -> the carton (gallery image)

The label/carton auto-fill from the catalogue: name (auto-sized + wrapped),
dose, ≥99% purity, category accent, COA seal, lot, RESEARCH USE ONLY.

Usage:
    python3 generate_product_images.py sample   # a few test renders to /tmp
    python3 generate_product_images.py          # all products (vial + carton)
"""

import io
import os
import sys
import cairosvg
import numpy as np
from PIL import Image, ImageDraw, ImageFilter

from catalogue_data import CATEGORIES

# Brand palette
NAVY = "#0d1b2a"
TEAL = "#00c6b3"
GOLD = "#c8a96e"
INK = "#22303c"
SUB = "#6b7a86"

ACCENTS = {
    "Medical Peptides": TEAL,
    "Skincare Peptides": GOLD,
    "Collagen Peptides": "#5fa8cc",
    "Sports & Recovery": "#e07b54",
    "Weight-Loss & Metabolic": "#9b72cf",
    "Hormone & Anti-Aging": GOLD,
    "Hair Growth Peptides": "#5bb98c",
    "Research Peptides": TEAL,
    "Lab Supplies & Accessories": "#5b7186",
}

SIZE = 1080
PROD_DIR = "/home/user/shoppingtheme/images/products"
CART_DIR = "/home/user/shoppingtheme/images/cartons"
GROUP_DIR = "/home/user/shoppingtheme/images/groups"


# ---------------------------------------------------------------------------
# Text helpers
# ---------------------------------------------------------------------------
def esc(s):
    return str(s).replace("&", "&amp;").replace("<", "&lt;").replace(">", "&gt;")


def hex_rgb(h):
    h = h.lstrip("#")
    return tuple(int(h[i:i + 2], 16) for i in (0, 2, 4))


def wrap(text, fs, max_w, max_lines=3):
    cw = fs * 0.54
    max_chars = max(6, int(max_w / cw))
    words, lines, cur = text.split(), [], ""
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


def fit_name(name, max_w, max_lines=3, band_h=100, sizes=(42, 38, 34, 31, 28, 25, 22, 20)):
    n_words = len(name.split())
    for fs in sizes:
        lines = wrap(name, fs, max_w, max_lines)
        if (len(" ".join(lines).split()) == n_words and len(lines) <= max_lines
                and fs * 1.12 * len(lines) <= band_h):
            return fs, lines
    return sizes[-1], wrap(name, sizes[-1], max_w, max_lines)


def fit_line(text, max_w, max_fs, ls=0.0, min_fs=7, cwf=0.52):
    """Shrink a single line's font size until it fits max_w (keeps text un-cramped)."""
    n = max(len(text), 1)
    fs = max_fs
    while fs > min_fs and (n * fs * cwf + (n - 1) * ls) > max_w:
        fs -= 1
    return fs


def kind_props(kind, purity):
    """Property line + interior fill path per product kind."""
    if kind == "supply":
        return ("STERILE · LABORATORY GRADE",
                '<path d="M 414 872 L 666 872 L 666 700 Q 600 690 540 698 Q 480 706 '
                '414 696 Z" fill="#deeef6" fill-opacity="0.85" stroke="#bfe0ec" stroke-width="1.5"/>')
    word = "RESEARCH GRADE" if kind == "compound" else "LYOPHILISED"
    cake = ('<path d="M 414 872 L 666 872 L 666 818 Q 600 806 540 814 Q 480 822 '
            '414 812 Z" fill="#fbfaf6" stroke="#e7e2d4" stroke-width="1.5"/>')
    return (f"{purity} PURITY · {word}", cake)


# ---------------------------------------------------------------------------
# Shared label markup (used on the vial and the carton front)
# ---------------------------------------------------------------------------
def brand_lockup(x, y, scale=0.72, sub=True):
    s = (f'<g transform="translate({x}, {y})">'
         f'<g transform="scale({scale})">'
         f'<polygon points="17,2 30,9.5 30,24.5 17,32 4,24.5 4,9.5" stroke="{TEAL}" stroke-width="1.6" fill="none"/>'
         f'<circle cx="17" cy="10" r="2.2" fill="{TEAL}"/><circle cx="10.5" cy="21" r="2.2" fill="{TEAL}"/>'
         f'<circle cx="23.5" cy="21" r="2.2" fill="{TEAL}"/>'
         f'<line x1="17" y1="10" x2="10.5" y2="21" stroke="{TEAL}" stroke-width="1.1" opacity="0.5"/>'
         f'<line x1="17" y1="10" x2="23.5" y2="21" stroke="{TEAL}" stroke-width="1.1" opacity="0.5"/>'
         f'<line x1="10.5" y1="21" x2="23.5" y2="21" stroke="{TEAL}" stroke-width="1.1" opacity="0.5"/></g>'
         f'<text x="{32*scale/0.72}" y="11" font-family="DejaVu Serif" font-size="15" font-weight="bold" fill="{NAVY}" letter-spacing="1.3">ALLUVIA</text>')
    if sub:
        s += f'<text x="{33*scale/0.72}" y="22" font-family="DejaVu Sans" font-size="7" fill="{GOLD}" letter-spacing="3.5">PEPTIDES</text>'
    return s + "</g>"


def coa_seal(x, y, accent, r=27):
    return (f'<g transform="translate({x}, {y})">'
            f'<circle r="{r}" fill="none" stroke="{accent}" stroke-width="2"/>'
            f'<circle r="{r-5}" fill="{accent}" fill-opacity="0.07" stroke="{accent}" stroke-width="0.8" stroke-opacity="0.5"/>'
            f'<path d="M -9 1 L -3 8 L 10 -7" fill="none" stroke="{accent}" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>'
            f'<text x="0" y="17" font-family="DejaVu Sans" font-size="6.5" font-weight="bold" fill="{accent}" text-anchor="middle" letter-spacing="1">COA</text></g>')


# ---------------------------------------------------------------------------
# VIAL (3D cylindrical glass, transparent subject)
# ---------------------------------------------------------------------------
BODY = ("M 392 372 Q 392 352 412 348 L 480 338 Q 480 318 484 314 L 596 314 "
        "Q 600 318 600 338 L 668 348 Q 688 352 688 372 L 688 856 Q 688 884 660 884 "
        "L 420 884 Q 392 884 392 856 Z")


def build_vial_svg(name, dose, purity, accent, category="", lot="ALV·000000", kind="peptide"):
    cx = SIZE / 2
    prop_line, fill_path = kind_props(kind, purity)
    lx0, lx1, ly0, lh = 403, 677, 392, 404
    inner_w = (lx1 - lx0) - 50

    name_fs, name_lines = fit_name(esc(name), inner_w, 3, band_h=100)
    line_h = name_fs * 1.12
    name_top = 548 - (line_h * len(name_lines)) / 2 + name_fs * 0.8
    name_svg = "".join(
        f'<text x="{cx}" y="{name_top + i*line_h:.0f}" font-family="DejaVu Serif" '
        f'font-size="{name_fs}" font-weight="bold" fill="{INK}" text-anchor="middle">{ln}</text>'
        for i, ln in enumerate(name_lines))

    label_w = (lx1 - lx0) - 36                  # usable label width
    dose_fs = fit_line(esc(dose), label_w, 40)
    prop_line = esc(prop_line)
    prop_fs = fit_line(prop_line, label_w, 14, ls=2)
    cat = esc(category.upper())
    cat_ls = 2.5 if len(cat) <= 16 else 1.5
    cat_fs = fit_line(cat, label_w, 12, ls=cat_ls)
    store_line = "STORE -20°C · ALLUVIAPEPTIDES.COM.AU"
    store_fs = fit_line(store_line, label_w, 9, ls=1)
    nfh_fs = fit_line("NOT FOR HUMAN CONSUMPTION", label_w, 9, ls=1.5)

    return f"""<svg xmlns="http://www.w3.org/2000/svg" width="{SIZE}" height="{SIZE}" viewBox="0 0 {SIZE} {SIZE}">
  <defs>
    <clipPath id="bodyclip"><path d="{BODY}"/></clipPath>
    <linearGradient id="glass" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0" stop-color="#eef4f7" stop-opacity="0.95"/>
      <stop offset="0.5" stop-color="#f7fbfc" stop-opacity="0.78"/>
      <stop offset="1" stop-color="#dde7ed" stop-opacity="0.95"/>
    </linearGradient>
    <linearGradient id="cyl" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0"    stop-color="#5e7480" stop-opacity="0.55"/>
      <stop offset="0.10" stop-color="#9fb0bb" stop-opacity="0.18"/>
      <stop offset="0.30" stop-color="#ffffff" stop-opacity="0.75"/>
      <stop offset="0.46" stop-color="#ffffff" stop-opacity="0.0"/>
      <stop offset="0.66" stop-color="#8ea0ab" stop-opacity="0.18"/>
      <stop offset="0.86" stop-color="#566a76" stop-opacity="0.45"/>
      <stop offset="1"    stop-color="#3f525d" stop-opacity="0.6"/>
    </linearGradient>
    <linearGradient id="metal" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0" stop-color="#9aa3a9"/><stop offset="0.16" stop-color="#eef1f3"/>
      <stop offset="0.34" stop-color="#b6bdc2"/><stop offset="0.52" stop-color="#f6f8f9"/>
      <stop offset="0.7" stop-color="#aab2b8"/><stop offset="0.86" stop-color="#e6e9eb"/>
      <stop offset="1" stop-color="#878f95"/>
    </linearGradient>
    <linearGradient id="capg" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0" stop-color="{accent}" stop-opacity="0.6"/>
      <stop offset="0.3" stop-color="{accent}" stop-opacity="1"/>
      <stop offset="0.55" stop-color="#ffffff" stop-opacity="0.45"/>
      <stop offset="0.75" stop-color="{accent}" stop-opacity="0.9"/>
      <stop offset="1" stop-color="{accent}" stop-opacity="0.55"/>
    </linearGradient>
    <clipPath id="labelclip"><rect x="{lx0}" y="{ly0}" width="{lx1-lx0}" height="{lh}" rx="14"/></clipPath>
    <linearGradient id="curve" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0"    stop-color="#26343d" stop-opacity="0.22"/>
      <stop offset="0.07" stop-color="#26343d" stop-opacity="0.07"/>
      <stop offset="0.22" stop-color="#26343d" stop-opacity="0"/>
      <stop offset="0.50" stop-color="#ffffff" stop-opacity="0.20"/>
      <stop offset="0.78" stop-color="#26343d" stop-opacity="0"/>
      <stop offset="0.93" stop-color="#26343d" stop-opacity="0.07"/>
      <stop offset="1"    stop-color="#26343d" stop-opacity="0.22"/>
    </linearGradient>
  </defs>

  <!-- glass body + curvature shading -->
  <path d="{BODY}" fill="url(#glass)" stroke="#aebcc6" stroke-width="2.5"/>
  {fill_path}
  <g clip-path="url(#bodyclip)">
    <!-- lyophilised powder cake settled in the base -->
    <path d="M404,858 Q436,834 478,844 Q510,830 540,836 Q576,830 604,844 Q648,836 676,860 L676,892 L404,892 Z" fill="#e9e6dc"/>
    <path d="M404,858 Q436,834 478,844 Q510,830 540,836 Q576,830 604,844 Q648,836 676,860" fill="none" stroke="#ffffff" stroke-opacity="0.55" stroke-width="2"/>
    <path d="M404,858 Q436,834 478,844 Q510,830 540,836 Q576,830 604,844 Q648,836 676,860" fill="none" stroke="#c9c4b4" stroke-opacity="0.5" stroke-width="1" transform="translate(0,3)"/>
    <rect x="392" y="314" width="296" height="572" fill="url(#cyl)"/>
    <rect x="446" y="320" width="20" height="560" fill="#ffffff" opacity="0.55"/>
    <rect x="455" y="320" width="7" height="560" fill="#ffffff" opacity="0.7"/>
    <ellipse cx="540" cy="884" rx="150" ry="20" fill="#3f525d" opacity="0.28"/>
  </g>
  <!-- rounded base ellipse hint -->
  <ellipse cx="540" cy="876" rx="148" ry="15" fill="none" stroke="#ffffff" stroke-opacity="0.35" stroke-width="2"/>

  <!-- neck + crimp cap + flip button (3D) -->
  <rect x="474" y="286" width="132" height="42" fill="url(#glass)" stroke="#aebcc6" stroke-width="2"/>
  <ellipse cx="540" cy="292" rx="66" ry="9" fill="#dfe8ee"/>
  <rect x="446" y="214" width="188" height="80" rx="9" fill="url(#metal)" stroke="#878f95" stroke-width="1.5"/>
  <g stroke="#7f878d" stroke-width="1" opacity="0.45">
    <line x1="452" y1="232" x2="628" y2="232"/><line x1="452" y1="248" x2="628" y2="248"/>
    <line x1="452" y1="264" x2="628" y2="264"/><line x1="452" y1="280" x2="628" y2="280"/>
  </g>
  <rect x="470" y="174" width="140" height="50" rx="11" fill="url(#capg)" stroke="{accent}" stroke-width="1.5"/>
  <ellipse cx="540" cy="180" rx="60" ry="9" fill="#ffffff" opacity="0.4"/>

  <!-- ===== LABEL ===== -->
  <rect x="{lx0}" y="{ly0}" width="{lx1-lx0}" height="{lh}" rx="14" fill="#ffffff" stroke="#e4e9ed" stroke-width="1.5"/>
  <rect x="{lx0}" y="{ly0}" width="6" height="{lh}" rx="3" fill="{accent}"/>
  <rect x="{lx0}" y="{ly0}" width="{lx1-lx0}" height="{lh}" fill="url(#curve)" clip-path="url(#labelclip)"/>
  {brand_lockup(432, 414)}
  {coa_seal(636, 432, accent)}
  <text x="{cx}" y="472" font-family="DejaVu Sans" font-size="{cat_fs}" fill="{accent}" font-weight="bold" text-anchor="middle" letter-spacing="{cat_ls}">{cat}</text>
  <line x1="{cx-40}" y1="486" x2="{cx+40}" y2="486" stroke="{GOLD}" stroke-width="1.5"/>
  {name_svg}
  <text x="{cx}" y="648" font-family="DejaVu Sans" font-size="{dose_fs}" font-weight="bold" fill="{accent}" text-anchor="middle">{esc(dose)}</text>
  <text x="{cx}" y="674" font-family="DejaVu Sans" font-size="{prop_fs}" fill="{INK}" text-anchor="middle" letter-spacing="2">{prop_line}</text>
  <line x1="430" y1="696" x2="650" y2="696" stroke="#e9edf0" stroke-width="1.2"/>
  <text x="436" y="718" font-family="DejaVu Sans" font-size="11" fill="{SUB}" letter-spacing="0.5">LOT {esc(lot)}</text>
  <text x="644" y="718" font-family="DejaVu Sans" font-size="11" fill="{SUB}" text-anchor="end" letter-spacing="0.5">NET 1 VIAL</text>
  <text x="{cx}" y="735" font-family="DejaVu Sans" font-size="11" font-weight="bold" fill="{accent}" text-anchor="middle" letter-spacing="2">RESEARCH USE ONLY</text>
  <text x="{cx}" y="751" font-family="DejaVu Sans" font-size="{nfh_fs}" fill="{SUB}" text-anchor="middle" letter-spacing="1.5">NOT FOR HUMAN CONSUMPTION</text>
  <text x="{cx}" y="768" font-family="DejaVu Sans" font-size="{store_fs}" fill="{SUB}" text-anchor="middle" letter-spacing="1">{store_line}</text>
</svg>"""


# ---------------------------------------------------------------------------
# CARTON (3D box, transparent subject)
# ---------------------------------------------------------------------------
def build_carton_svg(name, dose, purity, accent, category="", lot="ALV·000000", kind="peptide"):
    prop_line, _ = kind_props(kind, purity)
    # front face rectangle
    fx0, fx1, fy0, fy1 = 322, 690, 322, 854
    fcx = (fx0 + fx1) / 2
    dx, dy = 128, -74           # depth vector (to upper-right)
    # faces
    top = f"{fx0},{fy0} {fx0+dx},{fy0+dy} {fx1+dx},{fy0+dy} {fx1},{fy0}"
    side = f"{fx1},{fy0} {fx1+dx},{fy0+dy} {fx1+dx},{fy1+dy} {fx1},{fy1}"

    inner_w = (fx1 - fx0) - 56
    name_fs, name_lines = fit_name(esc(name), inner_w, 3, band_h=96,
                                   sizes=(44, 39, 34, 30, 27, 24, 21))
    line_h = name_fs * 1.14
    name_top = 546 - (line_h * len(name_lines)) / 2 + name_fs * 0.8   # band above the dose (674)
    name_svg = "".join(
        f'<text x="{fcx}" y="{name_top + i*line_h:.0f}" font-family="DejaVu Serif" '
        f'font-size="{name_fs}" font-weight="bold" fill="{INK}" text-anchor="middle">{ln}</text>'
        for i, ln in enumerate(name_lines))
    cat = esc(category.upper())
    front_w = (fx1 - fx0) - 44                   # usable front-face width
    dose_fs = fit_line(esc(dose), front_w, 46)
    prop_line = esc(prop_line)
    prop_fs = fit_line(prop_line, front_w, 15, ls=2)
    cat_ls = 2.5 if len(cat) <= 16 else 1.5
    cat_fs = fit_line(cat, front_w, 13, ls=cat_ls)
    ruo_line = "RESEARCH USE ONLY · NOT FOR HUMAN USE"
    ruo_fs = fit_line(ruo_line, front_w, 12, ls=2)
    made_line = "ALLUVIAPEPTIDES.COM.AU · MADE IN AUSTRALIA"
    made_fs = fit_line(made_line, front_w, 10, ls=1.5)

    # slim accent stripe running down the side face, parallel to its depth edges
    slope = dy / dx
    def sp(k, y):
        return f"{fx1 + k:.0f},{y + slope * k:.1f}"
    stripe = f"{sp(7, fy0 + 12)} {sp(30, fy0 + 12)} {sp(30, fy1 - 6)} {sp(7, fy1 - 6)}"

    return f"""<svg xmlns="http://www.w3.org/2000/svg" width="{SIZE}" height="{SIZE}" viewBox="0 0 {SIZE} {SIZE}">
  <defs>
    <linearGradient id="front" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0" stop-color="#eef1f4"/><stop offset="0.4" stop-color="#ffffff"/>
      <stop offset="1" stop-color="#e7ecf0"/>
    </linearGradient>
    <linearGradient id="side" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0" stop-color="#c4ccd3"/><stop offset="1" stop-color="#aab4bc"/>
    </linearGradient>
    <linearGradient id="topf" x1="0" y1="0" x2="0" y2="1">
      <stop offset="0" stop-color="#f4f6f8"/><stop offset="1" stop-color="#dde3e8"/>
    </linearGradient>
    <linearGradient id="cband" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0" stop-color="{accent}"/><stop offset="1" stop-color="{accent}" stop-opacity="0.78"/>
    </linearGradient>
  </defs>

  <!-- box faces (top + side give the 3D form) -->
  <polygon points="{top}" fill="url(#topf)" stroke="#c2cad1" stroke-width="1.5"/>
  <polygon points="{side}" fill="url(#side)" stroke="#9aa6ae" stroke-width="1.5"/>
  <polygon points="{fx0},{fy0} {fx1},{fy0} {fx1},{fy1} {fx0},{fy1}" fill="url(#front)" stroke="#cfd6dc" stroke-width="1.5"/>

  <!-- side detail: slim accent stripe + vertical wordmark -->
  <polygon points="{stripe}" fill="{accent}" opacity="0.92"/>
  <text x="{fx1+74}" y="{fy0+360}" font-family="DejaVu Serif" font-size="19" font-weight="bold" fill="#5a6670" text-anchor="middle" letter-spacing="3" transform="rotate(-30 {fx1+74} {fy0+360})">ALLUVIA PEPTIDES</text>

  <!-- top detail: hexagon hint -->
  <g transform="translate({fx0+dx/2+150},{fy0+dy+30})" opacity="0.6">
    <polygon points="0,-10 8.6,-5 8.6,5 0,10 -8.6,5 -8.6,-5" fill="none" stroke="{TEAL}" stroke-width="1.4"/>
  </g>

  <!-- ===== FRONT FACE CONTENT ===== -->
  <rect x="{fx0}" y="{fy0}" width="{fx1-fx0}" height="16" fill="url(#cband)"/>
  {brand_lockup(fx0+24, fy0+54, scale=0.85)}
  {coa_seal(fx1-44, fy0+74, accent, r=29)}
  <text x="{fcx}" y="{fy0+150}" font-family="DejaVu Sans" font-size="{cat_fs}" fill="{accent}" font-weight="bold" text-anchor="middle" letter-spacing="{cat_ls}">{cat}</text>
  <line x1="{fcx-46}" y1="{fy0+166}" x2="{fcx+46}" y2="{fy0+166}" stroke="{GOLD}" stroke-width="1.5"/>
  {name_svg}
  <text x="{fcx}" y="674" font-family="DejaVu Sans" font-size="{dose_fs}" font-weight="bold" fill="{accent}" text-anchor="middle">{esc(dose)}</text>
  <text x="{fcx}" y="702" font-family="DejaVu Sans" font-size="{prop_fs}" fill="{INK}" text-anchor="middle" letter-spacing="2">{prop_line}</text>
  <line x1="{fx0+30}" y1="752" x2="{fx1-30}" y2="752" stroke="#e6eaee" stroke-width="1.2"/>
  <text x="{fx0+30}" y="776" font-family="DejaVu Sans" font-size="12" fill="{SUB}" letter-spacing="0.5">LOT {esc(lot)}</text>
  <text x="{fx1-30}" y="776" font-family="DejaVu Sans" font-size="12" fill="{SUB}" text-anchor="end" letter-spacing="0.5">NET 1 VIAL</text>
  <text x="{fcx}" y="802" font-family="DejaVu Sans" font-size="{ruo_fs}" font-weight="bold" fill="{accent}" text-anchor="middle" letter-spacing="2">{ruo_line}</text>
  <text x="{fcx}" y="824" font-family="DejaVu Sans" font-size="{made_fs}" fill="{SUB}" text-anchor="middle" letter-spacing="1.5">{made_line}</text>
</svg>"""


# ---------------------------------------------------------------------------
# Photographic compositing (PIL)
# ---------------------------------------------------------------------------
def _ensure(a):
    return np.clip(a, 0, 255).astype("uint8")


def studio_composite(subj, accent):
    """Dark studio look: light pool, glossy floor reflection, deep soft shadow,
    specular bloom, shallow depth-of-field and fine grain — a 'snapped' feel."""
    W = H = SIZE
    ar = np.array(hex_rgb(accent), dtype="float32")
    Y = np.arange(H)[:, None].astype("float32")
    X = np.arange(W)[None, :].astype("float32")

    # --- bright white studio backdrop with a soft light pool + subtle floor ---
    t = Y / H
    top = np.array([253, 254, 255]); bot = np.array([229, 234, 239])
    grad = top[None, :] * (1 - t) + bot[None, :] * t
    bg = np.empty((H, W, 3), "float32")
    bg[:] = grad[:, None, :]
    pool = np.clip(1 - np.sqrt((X - 500) ** 2 + ((Y - 400) * 1.2) ** 2) / 560, 0, 1) ** 2
    bg += pool[:, :, None] * (np.array([255, 255, 255]) - bg) * 0.5     # brighten behind product (upper-left key)
    base = Image.fromarray(_ensure(bg), "RGB").convert("RGBA")

    bbox = subj.getbbox()
    b = bbox[3]
    alpha = np.asarray(subj.split()[3], dtype="float32") / 255.0        # subject mask

    # --- soft floor reflection ---
    refl = subj.transpose(Image.FLIP_TOP_BOTTOM)
    layer = Image.new("RGBA", (W, H), (0, 0, 0, 0))
    layer.paste(refl, (0, 2 * b - H), refl)
    la = np.array(layer).astype("float32")
    reflen = 220.0
    fade = np.clip((reflen - (Y - b)) / reflen, 0, 1) * 0.22
    fade[Y < b] = 0
    la[:, :, 3] *= fade
    refl_layer = Image.fromarray(_ensure(la), "RGBA").filter(ImageFilter.GaussianBlur(3.0))
    base = Image.alpha_composite(base, refl_layer)

    # --- deep, soft grounded shadow ---
    sh = Image.new("L", (W, H), 0)
    ImageDraw.Draw(sh).ellipse([540 - 178, b - 32, 540 + 178, b + 44], fill=135)
    sh = sh.filter(ImageFilter.GaussianBlur(38))
    shadow = Image.new("RGBA", (W, H), (20, 28, 38, 255))
    shadow.putalpha(sh)
    base = Image.alpha_composite(base, shadow)

    # --- subject ---
    base = Image.alpha_composite(base, subj)
    rgb = np.array(base.convert("RGB")).astype("float32")

    # --- specular bloom on the subject's brightest highlights ONLY (not the bg) ---
    lum = rgb @ np.array([0.299, 0.587, 0.114])
    bright = (np.clip((lum - 246) / 9, 0, 1) * alpha)[:, :, None] * rgb
    bloom = np.array(Image.fromarray(_ensure(bright)).filter(ImageFilter.GaussianBlur(9))).astype("float32")
    rgb = np.clip(rgb + bloom * 0.16, 0, 255)

    # --- shallow depth of field (sharp centre, soft extreme top/bottom) ---
    blurred = np.array(Image.fromarray(_ensure(rgb)).filter(ImageFilter.GaussianBlur(2.8))).astype("float32")
    dof = np.clip((np.abs(Y - 560) - 320) / 300, 0, 1) * 0.45
    rgb = rgb * (1 - dof[:, :, None]) + blurred * dof[:, :, None]

    # --- directional key light: gentle falloff toward the lower-right ---
    dirf = 1 - np.clip(((X + Y) - 1000) / 2400, 0, 1) * 0.12
    rgb *= dirf[:, :, None]

    # --- gentle vignette + fine film grain ---
    vig = 1 - (np.sqrt((X - 540) ** 2 + (Y - 545) ** 2) / 820) ** 2 * 0.16
    rgb *= np.clip(vig, 0.7, 1)[:, :, None]
    rgb += np.random.randn(H, W, 1).astype("float32") * 2.3
    return Image.fromarray(_ensure(rgb), "RGB")


def _raster(svg):
    png = cairosvg.svg2png(bytestring=svg.encode("utf-8"),
                           output_width=SIZE, output_height=SIZE)
    return Image.open(io.BytesIO(png)).convert("RGBA")


def compose_group(vial_svg, carton_svg, accent):
    """Carton + vial together in one studio scene (third gallery image)."""
    cart = _raster(carton_svg)
    vial = _raster(vial_svg)
    c = cart.crop(cart.getbbox()); v = vial.crop(vial.getbbox())
    cs, vs = 0.92, 0.72
    c = c.resize((int(c.width * cs), int(c.height * cs)), Image.LANCZOS)
    v = v.resize((int(v.width * vs), int(v.height * vs)), Image.LANCZOS)
    canvas = Image.new("RGBA", (SIZE, SIZE), (0, 0, 0, 0))
    base_y = 902
    canvas.alpha_composite(c, (300 - c.width // 2, base_y - 14 - c.height))   # carton, back-left
    canvas.alpha_composite(v, (688 - v.width // 2, base_y - v.height))        # vial, front-right
    return studio_composite(canvas, accent)


def render_svg_composited(svg, path, accent, quality=90):
    png = cairosvg.svg2png(bytestring=svg.encode("utf-8"),
                           output_width=SIZE, output_height=SIZE)
    subj = Image.open(io.BytesIO(png)).convert("RGBA")
    studio_composite(subj, accent).save(path, "JPEG", quality=quality, optimize=True)


# ---------------------------------------------------------------------------
# Catalogue iteration
# ---------------------------------------------------------------------------
def make_lot(sku):
    # Deterministic, reproducible lot derived from the SKU (hashlib, not the
    # process-randomised hash()), so vial labels and COAs always agree.
    import hashlib
    n = int(hashlib.sha256(sku.encode()).hexdigest(), 16) % 1000000
    return f"ALV·{n:06d}"


def distinct_products():
    seen, order = {}, []
    for category, cat in CATEGORIES.items():
        code = cat["code"]
        for i, p in enumerate(cat["products"], start=1):
            key = f"{p['name']} {p['dose']}"
            if key in seen:
                continue
            sku = f"AV-{code}-{str(i).zfill(3)}"
            seen[key] = {
                "sku": sku, "name": p["name"], "dose": p["dose"],
                "category": category, "accent": ACCENTS.get(category, TEAL),
                "lot": make_lot(sku), "kind": p.get("kind", "peptide"),
            }
            order.append(key)
    return [seen[k] for k in order]


def render_pair(prod):
    vial = build_vial_svg(prod["name"], prod["dose"], "≥99%", prod["accent"],
                          category=prod["category"], lot=prod["lot"], kind=prod["kind"])
    cart = build_carton_svg(prod["name"], prod["dose"], "≥99%", prod["accent"],
                            category=prod["category"], lot=prod["lot"], kind=prod["kind"])
    render_svg_composited(vial, os.path.join(PROD_DIR, prod["sku"] + ".jpg"), prod["accent"])
    render_svg_composited(cart, os.path.join(CART_DIR, prod["sku"] + ".jpg"), prod["accent"])
    compose_group(vial, cart, prod["accent"]).save(
        os.path.join(GROUP_DIR, prod["sku"] + ".jpg"), "JPEG", quality=90, optimize=True)


def main():
    if len(sys.argv) > 1 and sys.argv[1] == "sample":
        picks = [
            ("BPC-157", "5mg", "Sports & Recovery", "peptide"),
            ("GHK-Cu (Copper Peptide)", "50mg", "Skincare Peptides", "peptide"),
            ("Semaglutide", "5mg", "Weight-Loss & Metabolic", "peptide"),
            ("Bacteriostatic Water (0.9% Benzyl Alcohol)", "10ml", "Lab Supplies & Accessories", "supply"),
            ("Wolverine Blend (BPC-157 + TB-500 + GHK-Cu)", "16mg", "Sports & Recovery", "peptide"),
        ]
        os.makedirs("/tmp/shots", exist_ok=True)
        for name, dose, cat, kind in picks:
            accent = ACCENTS[cat]
            slug = name.split()[0].lower().strip("(")
            v = build_vial_svg(name, dose, "≥99%", accent, category=cat, lot=make_lot(name), kind=kind)
            c = build_carton_svg(name, dose, "≥99%", accent, category=cat, lot=make_lot(name), kind=kind)
            render_svg_composited(v, f"/tmp/shots/{slug}_vial.jpg", accent)
            render_svg_composited(c, f"/tmp/shots/{slug}_carton.jpg", accent)
            compose_group(v, c, accent).save(f"/tmp/shots/{slug}_group.jpg", "JPEG", quality=90)
            print("  ✓", slug)
        return

    os.makedirs(PROD_DIR, exist_ok=True)
    os.makedirs(CART_DIR, exist_ok=True)
    os.makedirs(GROUP_DIR, exist_ok=True)
    products = distinct_products()
    for n, prod in enumerate(products, 1):
        render_pair(prod)
        if n % 50 == 0:
            print(f"  …{n}/{len(products)}")
    print(f"Rendered {len(products)} vials + cartons.")


if __name__ == "__main__":
    main()
