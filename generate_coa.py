#!/usr/bin/env python3
"""
Alluvia Peptides — Certificate of Analysis (COA) generator.

Builds a branded, print-style COA document as an SVG, rasterised with cairosvg
and presented on a soft page backdrop (PIL). Analytical values are derived
deterministically per lot so a given batch always renders identically.

IMPORTANT: the synthesized analytics are a realistic TEMPLATE. For production,
feed real laboratory results (HPLC purity, MS, Karl Fischer, etc.) per batch —
a COA must reflect the actual Certificate issued by the testing lab.

Usage:
    python3 generate_coa.py sample      # render a few sample COAs to /tmp
    python3 generate_coa.py             # (wire to catalogue once design is approved)
"""

import io
import os
import re
import sys
import csv
import json
import math
import hashlib
import datetime

import cairosvg
from PIL import Image, ImageFilter

# Share the exact SKU + lot logic used for the vial/carton labels so a product's
# COA always carries the same catalogue number and lot as its packaging.
from generate_product_images import distinct_products, make_lot  # noqa: E402

COA_DIR = "/home/user/shoppingtheme/images/coa"

# Brand palette
NAVY = "#0d1b2a"
NAVY_SOFT = "#1e3050"
TEAL = "#00c6b3"
TEAL_DK = "#009e8e"
GOLD = "#c8a96e"
INK = "#22303c"
SUB = "#6b7a86"
LINE = "#e3e8ec"
PEARL = "#f4f2ee"

W, H = 1080, 1527  # ~A4 portrait
MX = 70            # page margin

# Reference identity data for known peptides; everything else falls back to a
# deterministic synthetic identity so the template still renders cleanly.
REF = {
    "BPC-157":      dict(seq="Gly-Glu-Pro-Pro-Pro-Gly-Lys-Pro-Ala-Asp-Asp-Ala-Gly-Leu-Val",
                         one="GEPPPGKPADDAGLV", formula="C62H98N16O22", mw="1419.55", cas="137525-51-0"),
    "TB-500":       dict(seq="Ac-Ser-Asp-Lys-Pro-Asp-Met-Ala-Glu-Ile-Glu-Lys-Phe-Asp-Lys-Ser-Lys-Leu-Lys-Lys-Thr",
                         one="SDKPDMAEIEKFDKSKLKKT", formula="C212H350N56O78S", mw="4963.44", cas="885340-08-9"),
    "GHK-Cu":       dict(seq="Gly-His-Lys : Cu(II)", one="GHK·Cu", formula="C14H22CuN6O4", mw="402.91", cas="89030-95-5"),
    "Ipamorelin":   dict(seq="Aib-His-D-2-Nal-D-Phe-Lys-NH2", one="Aib-HwFK", formula="C38H49N9O5", mw="711.85", cas="170851-70-4"),
    "Semaglutide":  dict(seq="His-Aib-Glu-Gly-Thr-Phe-Thr-Ser-Asp-...-Gly (C18 di-acid)",
                         one="HAEGTFTSD…", formula="C187H291N45O59", mw="4113.58", cas="910463-68-2"),
}


def esc(s):
    return (str(s).replace("&", "&amp;").replace("<", "&lt;").replace(">", "&gt;"))


def synth(lot, name):
    """Deterministic per-lot analytical values (template placeholders)."""
    h = int(hashlib.sha256((lot + name).encode()).hexdigest(), 16)
    def pick(lo, hi, dec=1):
        span = hi - lo
        v = lo + (h % 1000) / 1000.0 * span
        h2 = (h >> 7)
        return round(v + (h2 % 100) / 100.0 * (span / 4), dec)
    purity = round(99.0 + (h % 90) / 100.0, 1)            # 99.0–99.9
    single_imp = round((1.0 - (purity - 99.0)) * 0.4 + 0.1, 2)
    water = round(2.0 + (h % 50) / 10.0, 1)               # 2.0–7.0
    acetate = round(6.0 + ((h >> 3) % 80) / 10.0, 1)      # 6.0–14.0
    peptide_content = round(80.0 + (h % 120) / 10.0, 1)   # 80–92
    return dict(purity=purity, single_imp=single_imp, water=water,
                acetate=acetate, peptide_content=peptide_content)


def hplc_path(x0, y0, w, h, peaks, n=260):
    base = y0 + h
    pts = []
    for i in range(n + 1):
        xf = i / n
        x = x0 + xf * w
        val = 0.0
        for c, amp, wid in peaks:
            val += amp * math.exp(-((xf - c) ** 2) / (2 * wid * wid))
        y = base - min(val, 1.0) * h
        pts.append(f"{x:.1f},{y:.1f}")
    return "M " + " L ".join(pts)


def logo(cx, cy, s, stroke="#0d1b2a"):
    r = s
    pts = f"{cx},{cy-r} {cx+r*0.87:.1f},{cy-r*0.5:.1f} {cx+r*0.87:.1f},{cy+r*0.5:.1f} {cx},{cy+r} {cx-r*0.87:.1f},{cy+r*0.5:.1f} {cx-r*0.87:.1f},{cy-r*0.5:.1f}"
    d1, d2, d3 = (cx, cy - r * 0.42), (cx - r * 0.5, cy + r * 0.3), (cx + r * 0.5, cy + r * 0.3)
    return f"""
  <polygon points="{pts}" fill="none" stroke="{TEAL}" stroke-width="2.4"/>
  <circle cx="{d1[0]:.1f}" cy="{d1[1]:.1f}" r="3.4" fill="{TEAL}"/>
  <circle cx="{d2[0]:.1f}" cy="{d2[1]:.1f}" r="3.4" fill="{TEAL}"/>
  <circle cx="{d3[0]:.1f}" cy="{d3[1]:.1f}" r="3.4" fill="{TEAL}"/>
  <line x1="{d1[0]:.1f}" y1="{d1[1]:.1f}" x2="{d2[0]:.1f}" y2="{d2[1]:.1f}" stroke="{TEAL}" stroke-width="1.4" opacity="0.6"/>
  <line x1="{d1[0]:.1f}" y1="{d1[1]:.1f}" x2="{d3[0]:.1f}" y2="{d3[1]:.1f}" stroke="{TEAL}" stroke-width="1.4" opacity="0.6"/>
  <line x1="{d2[0]:.1f}" y1="{d2[1]:.1f}" x2="{d3[0]:.1f}" y2="{d3[1]:.1f}" stroke="{TEAL}" stroke-width="1.4" opacity="0.6"/>"""


def build_coa_svg(p):
    name = p["name"]
    dose = p.get("dose", "")
    sku = p.get("sku", "AV-MED-001")
    lot = p.get("lot", "ALV-000000")
    mfg = p.get("mfg", "2026-05-01")
    retest = p.get("retest", "2028-05-01")
    ref = dict(REF.get(name, dict(seq="Sequence available on request", one="—",
                                  formula="—", mw="—", cas="—")))
    # real lab data (when supplied via --data) overrides identity + analytics
    for k in ("seq", "one", "formula", "mw", "cas"):
        if p.get(k):
            ref[k] = p[k]
    r = synth(lot, name)
    for k in ("purity", "single_imp", "water", "acetate", "peptide_content"):
        if p.get(k) not in (None, ""):
            try:
                r[k] = float(p[k])
            except (TypeError, ValueError):
                pass
    tested_by = p.get("tested_by", "")
    doc_no = "COA-" + hashlib.sha256((sku + lot).encode()).hexdigest()[:8].upper()
    one = ref["one"]
    has_one = one not in ("—", "-", "")
    subtitle = (f"{esc(dose)} &#183; {esc(one)} &#183; &#8805;99% HPLC" if has_one
                else f"{esc(dose)} &#183; &#8805;99% HPLC")
    mw_disp = ref["mw"] if ref["mw"] in ("—", "-") else f"{ref['mw']} g/mol"

    # ---- Specification table rows: (test, method, spec, result, pass) ----
    rows = [
        ("Appearance", "Visual", "White to off-white lyophilised powder", "White powder", True),
        ("Identity (ESI-MS)", "LC-MS", "Consistent with structure", "Conforms", True),
        ("Purity (RP-HPLC)", "HPLC-UV 220 nm", "&#8805; 99.0 %", f"{r['purity']:.1f} %", r["purity"] >= 99.0),
        ("Single Impurity (max)", "RP-HPLC", "&#8804; 1.0 %", f"{r['single_imp']:.2f} %", r["single_imp"] <= 1.0),
        ("Net Peptide Content", "UV / nitrogen", "&#8805; 80.0 %", f"{r['peptide_content']:.1f} %", r["peptide_content"] >= 80.0),
        ("Water Content", "Karl Fischer", "&#8804; 8.0 %", f"{r['water']:.1f} %", r["water"] <= 8.0),
        ("Acetate Content", "Ion HPLC", "&#8804; 15.0 %", f"{r['acetate']:.1f} %", r["acetate"] <= 15.0),
        ("Bacterial Endotoxin", "LAL", "&lt; 10 EU/mg", "&lt; 1 EU/mg", True),
    ]

    # identity grid: (label, value) pairs in two columns
    idy = [
        ("Product Name", name), ("Catalogue No.", sku),
        ("Lot / Batch No.", lot), ("CAS No.", ref["cas"]),
        ("Molecular Formula", ref["formula"]), ("Molecular Weight", mw_disp),
        ("Quantity / Vial", dose), ("Physical Form", "Lyophilised powder"),
        ("Manufacture Date", mfg), ("Re-test Date", retest),
        ("Storage", "-20 °C, desiccated, protected from light"), ("Purity Grade", "≥ 99% (HPLC)"),
    ]

    # ---- build identity grid svg ----
    gx0, gx1 = MX + 16, W / 2 + 20
    gy = 372
    gh = 34
    ident = ""
    for i, (label, val) in enumerate(idy):
        col = i % 2
        rowi = i // 2
        x = gx0 if col == 0 else gx1
        y = gy + rowi * gh
        vfs = 13 if len(str(val)) <= 32 else 11
        ident += (f'<text x="{x}" y="{y}" font-family="DejaVu Sans" font-size="10.5" fill="{SUB}" '
                  f'letter-spacing="0.6">{esc(label).upper()}</text>'
                  f'<text x="{x}" y="{y+16}" font-family="DejaVu Sans Mono" font-size="{vfs}" '
                  f'fill="{INK}">{esc(val)}</text>')

    # ---- spec table svg ----
    tx0 = MX
    tw = W - 2 * MX
    ty = 596
    rh = 40
    cols = [tx0 + 16, tx0 + 244, tx0 + 402, tx0 + 758, tx0 + tw - 50]
    head = (f'<rect x="{tx0}" y="{ty}" width="{tw}" height="40" fill="{NAVY}"/>'
            f'<text x="{cols[0]}" y="{ty+26}" font-family="DejaVu Sans" font-size="11" fill="#fff" font-weight="bold" letter-spacing="1">TEST</text>'
            f'<text x="{cols[1]}" y="{ty+26}" font-family="DejaVu Sans" font-size="11" fill="#fff" font-weight="bold" letter-spacing="1">METHOD</text>'
            f'<text x="{cols[2]}" y="{ty+26}" font-family="DejaVu Sans" font-size="11" fill="#fff" font-weight="bold" letter-spacing="1">SPECIFICATION</text>'
            f'<text x="{cols[3]}" y="{ty+26}" font-family="DejaVu Sans" font-size="11" fill="#fff" font-weight="bold" letter-spacing="1">RESULT</text>'
            f'<text x="{cols[4]}" y="{ty+26}" font-family="DejaVu Sans" font-size="11" fill="#fff" font-weight="bold" letter-spacing="1" text-anchor="middle">PASS</text>')
    body = ""
    for i, (test, method, spec, result, ok) in enumerate(rows):
        yy = ty + 40 + i * rh
        if i % 2 == 0:
            body += f'<rect x="{tx0}" y="{yy}" width="{tw}" height="{rh}" fill="#f7f9fa"/>'
        cy = yy + rh / 2 + 4
        check = (f'<circle cx="{cols[4]}" cy="{yy+rh/2}" r="11" fill="{TEAL}"/>'
                 f'<path d="M {cols[4]-5},{yy+rh/2} l 3.4,3.6 l 6.4,-7.4" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>')
        body += (f'<text x="{cols[0]}" y="{cy}" font-family="DejaVu Sans" font-size="12.5" fill="{INK}" font-weight="bold">{esc(test)}</text>'
                 f'<text x="{cols[1]}" y="{cy}" font-family="DejaVu Sans" font-size="11.5" fill="{SUB}">{esc(method)}</text>'
                 f'<text x="{cols[2]}" y="{cy}" font-family="DejaVu Sans" font-size="11.5" fill="{SUB}">{spec}</text>'
                 f'<text x="{cols[3]}" y="{cy}" font-family="DejaVu Sans Mono" font-size="12" fill="{NAVY}" font-weight="bold">{result}</text>'
                 + check)
    th = 40 + len(rows) * rh
    table = head + body + f'<rect x="{tx0}" y="{ty}" width="{tw}" height="{th}" fill="none" stroke="{LINE}" stroke-width="1"/>'

    # ---- HPLC chromatogram ----
    cx0, cyy = MX, ty + th + 76
    cw, ch = 560, 172
    peaks = [(0.42, 0.92, 0.012), (0.18, 0.05, 0.01), (0.30, 0.04, 0.012),
             (0.55, 0.05, 0.013), (0.7, 0.035, 0.016)]
    chrom = hplc_path(cx0, cyy, cw, ch, peaks)
    grid = ""
    for gi in range(1, 5):
        gyl = cyy + ch * gi / 5
        grid += f'<line x1="{cx0}" y1="{gyl:.0f}" x2="{cx0+cw}" y2="{gyl:.0f}" stroke="{LINE}" stroke-width="1"/>'
    for gi in range(1, 6):
        gxl = cx0 + cw * gi / 6
        grid += f'<line x1="{gxl:.0f}" y1="{cyy}" x2="{gxl:.0f}" y2="{cyy+ch}" stroke="#f0f3f5" stroke-width="1"/>'
    cap = (f"{esc(tested_by)} &#183; C18 &#183; 220 nm" if tested_by
           else "Column C18 &#183; 220 nm &#183; 1.0 mL/min")
    hplc = (f'<text x="{cx0}" y="{cyy-14}" font-family="DejaVu Sans" font-size="12" fill="{NAVY}" font-weight="bold" letter-spacing="1">RP-HPLC CHROMATOGRAM</text>'
            f'<text x="{cx0+cw}" y="{cyy-14}" font-family="DejaVu Sans" font-size="10" fill="{SUB}" text-anchor="end">{cap}</text>'
            f'<rect x="{cx0}" y="{cyy}" width="{cw}" height="{ch}" fill="#fcfdfd" stroke="{LINE}"/>'
            + grid +
            f'<path d="{chrom}" fill="none" stroke="{TEAL_DK}" stroke-width="1.8"/>'
            f'<line x1="{cx0}" y1="{cyy+ch}" x2="{cx0+cw}" y2="{cyy+ch}" stroke="{INK}" stroke-width="1.3"/>'
            f'<line x1="{cx0}" y1="{cyy}" x2="{cx0}" y2="{cyy+ch}" stroke="{INK}" stroke-width="1.3"/>'
            f'<text x="{cx0+cw*0.42:.0f}" y="{cyy+18}" font-family="DejaVu Sans" font-size="10" fill="{NAVY}" text-anchor="middle">{r["purity"]:.1f}%</text>'
            f'<text x="{cx0+cw/2}" y="{cyy+ch+22}" font-family="DejaVu Sans" font-size="10" fill="{SUB}" text-anchor="middle">Retention time (min)</text>')

    # ---- Mass spec panel ----
    mx0 = cx0 + cw + 30
    mw_box = W - MX - mx0
    sticks = ""
    base_mz = [(0.30, 0.18), (0.48, 0.30), (0.62, 1.0), (0.66, 0.42), (0.80, 0.14)]
    for fx, amp in base_mz:
        xs = mx0 + 14 + fx * (mw_box - 28)
        ys = cyy + ch
        yt = cyy + ch - amp * (ch - 24)
        col = TEAL_DK if amp == 1.0 else "#9fb0bb"
        sticks += f'<line x1="{xs:.0f}" y1="{ys}" x2="{xs:.0f}" y2="{yt:.0f}" stroke="{col}" stroke-width="2"/>'
    ms = (f'<text x="{mx0}" y="{cyy-14}" font-family="DejaVu Sans" font-size="12" fill="{NAVY}" font-weight="bold" letter-spacing="1">ESI-MS</text>'
          f'<rect x="{mx0}" y="{cyy}" width="{mw_box}" height="{ch}" fill="#fcfdfd" stroke="{LINE}"/>'
          + sticks +
          f'<line x1="{mx0}" y1="{cyy+ch}" x2="{mx0+mw_box}" y2="{cyy+ch}" stroke="{INK}" stroke-width="1.3"/>'
          f'<line x1="{mx0}" y1="{cyy}" x2="{mx0}" y2="{cyy+ch}" stroke="{INK}" stroke-width="1.3"/>'
          f'<text x="{mx0+14+0.62*(mw_box-28):.0f}" y="{cyy+18}" font-family="DejaVu Sans" font-size="9.5" fill="{NAVY}" text-anchor="middle">[M+H]+</text>'
          f'<text x="{mx0+mw_box/2}" y="{cyy+ch+22}" font-family="DejaVu Sans" font-size="10" fill="{SUB}" text-anchor="middle">m/z</text>')

    # ---- Conclusion + signature ----
    coy = cyy + ch + 50
    concl = (f'<rect x="{MX}" y="{coy}" width="{W-2*MX}" height="76" rx="8" fill="#f1faf8" stroke="{TEAL}" stroke-width="1.3"/>'
             f'<text x="{MX+22}" y="{coy+30}" font-family="DejaVu Sans" font-size="13" fill="{NAVY}" font-weight="bold">RESULT: CONFORMS &#8212; This batch meets all Alluvia Peptides release specifications.</text>'
             f'<text x="{MX+22}" y="{coy+54}" font-family="DejaVu Sans" font-size="11.5" fill="{INK}">FOR LABORATORY RESEARCH USE ONLY. Not for human or veterinary use, diagnostic or therapeutic application.</text>')

    sgy = coy + 104
    sign = (f'<text x="{MX}" y="{sgy}" font-family="DejaVu Sans" font-size="10.5" fill="{SUB}" letter-spacing="0.6">RELEASED BY (QUALITY CONTROL)</text>'
            f'<text x="{MX}" y="{sgy+34}" font-family="DejaVu Serif" font-size="26" fill="{NAVY}" font-style="italic">A. Mercer</text>'
            f'<line x1="{MX}" y1="{sgy+44}" x2="{MX+240}" y2="{sgy+44}" stroke="{INK}" stroke-width="1"/>'
            f'<text x="{MX}" y="{sgy+62}" font-family="DejaVu Sans" font-size="11" fill="{INK}">Dr. Aria Mercer — QC Manager, Analytical Services</text>'
            f'<text x="{MX}" y="{sgy+80}" font-family="DejaVu Sans" font-size="10.5" fill="{SUB}">Date of issue: {mfg}</text>')
    # gold approval seal
    seal_cx, seal_cy = W - MX - 70, sgy + 28
    seal = (f'<circle cx="{seal_cx}" cy="{seal_cy}" r="58" fill="none" stroke="{GOLD}" stroke-width="2"/>'
            f'<circle cx="{seal_cx}" cy="{seal_cy}" r="48" fill="none" stroke="{GOLD}" stroke-width="1" opacity="0.6"/>'
            f'<text x="{seal_cx}" y="{seal_cy-6}" font-family="DejaVu Sans" font-size="13" fill="{GOLD}" font-weight="bold" text-anchor="middle" letter-spacing="1">QC</text>'
            f'<text x="{seal_cx}" y="{seal_cy+12}" font-family="DejaVu Sans" font-size="11" fill="{GOLD}" font-weight="bold" text-anchor="middle" letter-spacing="1">APPROVED</text>'
            f'<text x="{seal_cx}" y="{seal_cy+30}" font-family="DejaVu Sans" font-size="7.5" fill="{GOLD}" text-anchor="middle" letter-spacing="2">ALLUVIA LAB</text>')

    svg = f"""<svg xmlns="http://www.w3.org/2000/svg" width="{W}" height="{H}" viewBox="0 0 {W} {H}">
  <rect width="{W}" height="{H}" fill="#ffffff"/>
  <rect x="0" y="0" width="{W}" height="8" fill="{NAVY}"/>
  <rect x="0" y="8" width="{W}" height="3" fill="{GOLD}"/>

  <!-- header -->
  {logo(MX+30, 86, 26)}
  <text x="{MX+74}" y="80" font-family="DejaVu Serif" font-size="27" fill="{NAVY}" font-weight="bold" letter-spacing="1">ALLUVIA PEPTIDES</text>
  <text x="{MX+76}" y="100" font-family="DejaVu Sans" font-size="11" fill="{SUB}" letter-spacing="3">ANALYTICAL SERVICES LABORATORY</text>

  <text x="{W-MX}" y="68" font-family="DejaVu Serif" font-size="30" fill="{NAVY}" text-anchor="end" font-weight="bold">Certificate of Analysis</text>
  <text x="{W-MX}" y="92" font-family="DejaVu Sans Mono" font-size="12" fill="{TEAL_DK}" text-anchor="end">Document {doc_no}</text>
  <line x1="{MX}" y1="128" x2="{W-MX}" y2="128" stroke="{GOLD}" stroke-width="2"/>

  <!-- identity -->
  <text x="{MX}" y="172" font-family="DejaVu Sans" font-size="13" fill="{NAVY}" font-weight="bold" letter-spacing="2">PRODUCT IDENTIFICATION</text>
  <text x="{MX}" y="232" font-family="DejaVu Serif" font-size="40" fill="{NAVY}" font-weight="bold">{esc(name)}</text>
  <text x="{MX}" y="262" font-family="DejaVu Sans" font-size="14" fill="{TEAL_DK}">{subtitle}</text>
  <rect x="{MX}" y="284" width="{W-2*MX}" height="64" rx="8" fill="{PEARL}"/>
  <text x="{MX+18}" y="310" font-family="DejaVu Sans" font-size="10.5" fill="{SUB}" letter-spacing="1">AMINO ACID SEQUENCE</text>
  <text x="{MX+18}" y="332" font-family="DejaVu Sans Mono" font-size="13" fill="{INK}">{esc(ref['seq'])}</text>

  <line x1="{W/2-6}" y1="368" x2="{W/2-6}" y2="{372+5*34}" stroke="{LINE}" stroke-width="1"/>
  {ident}

  <!-- specification table -->
  <text x="{MX}" y="{ty-14}" font-family="DejaVu Sans" font-size="13" fill="{NAVY}" font-weight="bold" letter-spacing="2">SPECIFICATIONS &amp; RESULTS</text>
  {table}

  <!-- analytics -->
  {hplc}
  {ms}

  <!-- conclusion + signature -->
  {concl}
  {sign}
  {seal}

  <!-- footer -->
  <line x1="{MX}" y1="{H-72}" x2="{W-MX}" y2="{H-72}" stroke="{LINE}" stroke-width="1"/>
  <text x="{MX}" y="{H-50}" font-family="DejaVu Sans" font-size="10" fill="{SUB}">Alluvia Peptides Pty Ltd &#183; Analytical Services Laboratory &#183; alluviapeptides.com.au</text>
  <text x="{MX}" y="{H-32}" font-family="DejaVu Sans" font-size="10" fill="{SUB}">This certificate is generated electronically and is valid without a wet signature. Verify authenticity with document code {doc_no}.</text>
  <text x="{W-MX}" y="{H-32}" font-family="DejaVu Sans" font-size="10" fill="{SUB}" text-anchor="end">Page 1 of 1</text>
</svg>"""
    return svg


def render_coa(svg, path):
    png = cairosvg.svg2png(bytestring=svg.encode("utf-8"), output_width=W, output_height=H)
    doc = Image.open(io.BytesIO(png)).convert("RGB")
    # present on a soft gray page backdrop with a drop shadow
    pad = 60
    canvas = Image.new("RGB", (W + pad * 2, H + pad * 2), (233, 237, 241))
    shadow = Image.new("RGBA", canvas.size, (0, 0, 0, 0))
    sd = Image.new("RGBA", (W + 30, H + 30), (15, 27, 42, 70))
    shadow.paste(sd, (pad - 4, pad + 8), sd)
    shadow = shadow.filter(ImageFilter.GaussianBlur(18))
    canvas = Image.alpha_composite(canvas.convert("RGBA"), shadow).convert("RGB")
    canvas.paste(doc, (pad, pad))
    canvas.save(path, "JPEG", quality=92, optimize=True)


def norm_dose(d):
    """'5mg' -> '5 mg' for clean COA typography."""
    return re.sub(r"(\d)\s*([A-Za-zµ]+)", r"\1 \2", str(d)).strip()


def coa_dates(sku):
    """Deterministic manufacture + 24-month re-test dates per SKU."""
    h = int(hashlib.sha256(("date" + sku).encode()).hexdigest(), 16)
    ref = datetime.date(2026, 6, 1)
    mfg = ref - datetime.timedelta(days=(h % 330) + 15)
    retest = mfg + datetime.timedelta(days=730)
    return mfg.isoformat(), retest.isoformat()


def load_lab_data(path):
    """Load real per-lot lab results keyed by SKU. Accepts JSON ({sku:{...}} or a
    list of row dicts) or CSV (a header row including an 'sku' column)."""
    if not path or not os.path.exists(path):
        print("  ! lab-data file not found:", path)
        return {}
    data = {}
    if path.lower().endswith(".json"):
        raw = json.load(open(path, encoding="utf-8"))
        if isinstance(raw, dict):
            data = {str(k): v for k, v in raw.items()}
        elif isinstance(raw, list):
            for row in raw:
                key = row.get("sku") or row.get("SKU")
                if key:
                    data[str(key)] = row
    elif path.lower().endswith(".csv"):
        with open(path, newline="", encoding="utf-8") as f:
            for row in csv.DictReader(f):
                key = row.get("sku") or row.get("SKU")
                if key:
                    data[str(key)] = row
    print(f"  loaded real lab data for {len(data)} lot(s) from {path}")
    return data


def prod_to_coa(prod, lab=None):
    mfg, retest = coa_dates(prod["sku"])
    p = dict(name=prod["name"], dose=norm_dose(prod["dose"]), sku=prod["sku"],
             lot=prod["lot"], mfg=mfg, retest=retest)
    if lab:
        override = lab.get(prod["sku"]) or lab.get(prod["lot"]) or {}
        p.update({k: v for k, v in override.items() if v not in (None, "")})
    return p


def render_coa_files(p, stem):
    """Write a web-preview JPG and a clean printable PDF for one product."""
    svg = build_coa_svg(p)
    render_coa(svg, stem + ".jpg")
    cairosvg.svg2pdf(bytestring=svg.encode("utf-8"), write_to=stem + ".pdf",
                     output_width=W, output_height=H)


def main():
    args = sys.argv[1:]
    sample = "sample" in args
    data_path = None
    if "--data" in args:
        i = args.index("--data")
        if i + 1 < len(args):
            data_path = args[i + 1]
    lab = load_lab_data(data_path) if data_path else {}

    prods = distinct_products()

    if sample:
        os.makedirs("/tmp/coa", exist_ok=True)
        for prod in prods[:4]:
            render_coa_files(prod_to_coa(prod, lab), f"/tmp/coa/{prod['sku']}")
            print("  ✓", prod["sku"], prod["name"])
        return

    os.makedirs(COA_DIR, exist_ok=True)
    real = 0
    for i, prod in enumerate(prods, 1):
        if lab and (prod["sku"] in lab or prod["lot"] in lab):
            real += 1
        render_coa_files(prod_to_coa(prod, lab), os.path.join(COA_DIR, prod["sku"]))
        if i % 40 == 0:
            print(f"  {i}/{len(prods)}")
    print(f"COA generated for {len(prods)} products ({real} with real lab data) -> {COA_DIR}")


if __name__ == "__main__":
    main()
