# Alluvia Peptides — WordPress Setup Guide

## Theme Installation

1. Upload the `shoppingtheme` folder to `/wp-content/themes/`
2. Install and activate the **Omega** parent theme first
3. Activate the **Alluvia Peptides** child theme
4. Install and activate **WooCommerce**

> **Pages auto-create on activation.** When the theme is activated it runs
> `alluvia_create_pages_on_activation()` (in `functions.php`), which creates all
> the pages below, assigns their templates, and sets the static front page + blog
> page under Settings → Reading. The manual table below is a reference / fallback
> if you ever need to recreate a page by hand. To re-run it, visit any admin URL
> with `?alluvia_reset_pages=1` appended (admins only).

---

## Required WordPress Pages (auto-created — reference only)

If creating manually: go to **Pages → Add New** and create each page below.
Set the **Template** (right sidebar → Page Attributes → Template) as shown.

| Page Title              | Slug                  | Template                          |
|-------------------------|-----------------------|-----------------------------------|
| Home / Landing          | *(set as front page)* | *(front-page.php auto-loads)*     |
| About                   | `about`               | Alluvia – About                   |
| Contact                 | `contact`             | Alluvia – Contact                 |
| FAQ                     | `faq`                 | Alluvia – FAQ                     |
| Blog                    | `blog`                | *(set as Posts page)*             |
| COA Library             | `coa-library`         | Alluvia – COA Library             |
| Shipping Policy         | `shipping-policy`     | Alluvia – Shipping Policy         |
| Terms & Conditions      | `terms-conditions`    | Alluvia – Terms & Conditions      |
| Privacy Policy          | `privacy-policy`      | Alluvia – Privacy Policy          |
| Disclaimer              | `disclaimer`          | Alluvia – Disclaimer              |

## WordPress Reading Settings

Go to **Settings → Reading**:
- "Your homepage displays" → **A static page**
- Homepage: select the **Home / Landing** page
- Posts page: select the **Blog** page

## WooCommerce Setup

WooCommerce creates its own pages automatically (Shop, Cart, Checkout, My Account).
The `woocommerce.php` wrapper applies the Alluvia nav and footer to all WooCommerce
pages automatically, so the store is **fully functional on WooCommerce's own
templates** out of the box.

### Bespoke commerce templates (pending staging integration)

The theme also ships high-fidelity bespoke designs for the shop, product, cart,
checkout and account pages (`page-shop.php`, `page-product.php`, `page-cart.php`,
`page-checkout.php`, `page-account.php`). These are **design references** — they
are not yet wired to WooCommerce's live cart/checkout, so do **not** assign them
to live pages yet. The plan is to convert them into real WooCommerce template
overrides (`archive-product.php`, `single-product.php`, and `cart` / `checkout` /
`myaccount` overrides) driven by WooCommerce's authoritative cart and checkout
flow. A custom AJAX cart engine (`alluvia_ajax_add_to_cart()` /
`alluvia_ajax_update_cart()` in `functions.php`) is already in place to back the
bespoke add-to-cart buttons and qty steppers. **This integration must be
smoke-tested on a staging WordPress + WooCommerce install before go-live.**

---

## URL Structure

Make sure **Settings → Permalinks** is set to **Post name** (`/%postname%/`) for clean URLs.

---

## Contact Form

The contact form submits via AJAX to `functions.php → alluvia_handle_contact()`.
Email goes to the WordPress admin email address. No plugin required.

To connect a Mailchimp list, replace the `alluvia_handle_subscribe()` function body in `functions.php`.

---

## Product Catalogue Import

The store ships with a ready-to-import catalogue in `alluvia-products.csv`:
**50 best-sellers in each of the 8 peptide categories**, plus emerging
compounds and a **Lab Supplies & Accessories** category (bacteriostatic water,
sterile vials, reconstitution kits).

To import:

1. Install and activate **WooCommerce** (see above).
2. Go to **Products → All Products → Import** (top of the screen).
3. Choose `alluvia-products.csv` and click **Continue**.
4. Leave column mapping on **auto** — the headers match WooCommerce exactly.
5. Click **Run the importer**.

This creates **321 distinct products** across 9 categories with SEO/GEO-optimised
descriptions, AUD prices, ≥99% purity attribute and stock. Each of the 8 peptide
categories lists 50+ products — peptides that belong in more than one category (e.g. BPC-157,
GHK-Cu) are assigned to **multiple categories as a single product** rather than
cloned, which avoids duplicate-content SEO penalties. Categories are created
automatically from the `Categories` column.

### SEO meta & structured data

- The CSV includes `Meta: _yoast_wpseo_title`, `_yoast_wpseo_metadesc` and
  `_yoast_wpseo_focuskw` columns. If **Yoast SEO** is installed, these populate
  each product's SEO title, meta description and focus keyword on import.
- The theme automatically outputs **Product** and **FAQPage** JSON-LD structured
  data on every single-product page (see `alluvia_product_schema()` in
  `functions.php`), so prices, availability and the product FAQ are eligible for
  Google rich results and AI answer engines — no plugin required.

### Branded product images (auto-generated vials)

Every product has a unique branded **vial** image in `images/products/<SKU>.jpg`
plus a matching **carton** (`images/cartons/<SKU>.jpg`) and **group** shot
(`images/groups/<SKU>.jpg`) — all 1080×1080. One universal design is auto-filled
per product — the label reads each product's name (auto-sized + wrapped), dose,
≥99% purity, category (accent colour) plus a COA seal, lot and storage line. On
admin loads after the products are imported, the theme **auto-assigns the vial as
the product's featured image and the carton + group shots as its gallery images**,
matched by SKU (`alluvia_assign_product_images()` in `functions.php`, batched to
avoid timeouts). Regenerate with:

```
python3 generate_product_images.py          # all products
python3 generate_product_images.py sample   # quick test renders to /tmp
```

### Certificate of Analysis (COA)

Each product has a branded COA in `images/coa/<SKU>.pdf` (printable) and
`images/coa/<SKU>.jpg` (web preview), generated by `generate_coa.py`. The
document carries the product identity (sequence, formula, MW, CAS), the same
catalogue number and **lot** as the vial label, a specifications/results table,
RP-HPLC + ESI-MS plots, a conforms conclusion with the Research-Use-Only
statement, a QC signature and a verifiable document code.

- The single product page shows a **Download Certificate of Analysis (PDF)**
  button plus a **Certificate of Analysis** tab (preview image + download),
  matched by SKU (`alluvia_product_coa_button()` / `alluvia_coa_product_tab()`).
- The **COA Library** page (`page-coa.php`) lists every product that has a COA
  with a download link and live search / category filtering.

Regenerate with:

```
python3 generate_coa.py                       # all products -> images/coa/<SKU>.jpg + .pdf
python3 generate_coa.py sample                # a few sample COAs to /tmp/coa
python3 generate_coa.py --data lab.json      # populate with REAL lab results
```

**Loading real lab data.** Pass `--data <file.json|file.csv>` to override the
template placeholders with actual results per batch. Key each entry by product
SKU (or lot); any omitted field falls back to the template value. Supported
fields: `lot`, `purity`, `single_imp`, `water`, `acetate`, `peptide_content`,
`mfg`, `retest`, `formula`, `mw`, `cas`, `tested_by` (credited on the
chromatogram). See `coa-lab-data.example.json` for the format.

> **Important — analytical values:** the generated figures (HPLC purity, MS,
> Karl Fischer, etc.) are realistic but **deterministic placeholders**. A COA
> must reflect the actual certificate issued by the testing laboratory — feed
> real per-batch lab results before publishing COAs to customers. Lot numbers
> are deterministic (`make_lot()` in `generate_product_images.py`), so re-running
> the vial and COA generators keeps the printed lot and the COA in agreement.

### Branded category images

Nine on-brand category images live in `images/categories/` (1080×1080 PNG, with
matching editable SVG sources). On the first admin page load after the categories exist,
the theme **automatically assigns each image as its WooCommerce category
thumbnail** (`alluvia_assign_category_images()` in `functions.php`) — no manual
upload needed. To regenerate them, run:

```
python3 generate_category_images.py
```

To regenerate or edit the catalogue, update `catalogue_data.py` (the curated
per-peptide dataset) and run:

```
python3 generate_products.py
```

This rewrites `alluvia-products.csv`. Each product's copy is built from real
per-peptide facts (what it is, how it works, areas of research interest) so
every description is unique — no generic templated write-ups.

### Compliance — Research Use Only

All product copy uses **research-use-only framing**: every description presents
the compound as a research-grade reference material, reframes properties as
"areas of research interest", and includes a prominent **Research Use Only —
Not for Human Consumption** disclaimer. In addition, the theme shows a
research-use notice on every single-product page and a site-wide disclaimer in
the footer (`alluvia_product_ruo_notice()` / `alluvia_footer_disclaimer()` in
`functions.php`), and each vial label carries the same notice. This is the
industry-standard, lower-risk framing for peptide retail. It is not legal
advice — have a suitably qualified advisor review before going live.

---

## Notes

- All page designs are self-contained in their PHP template files
- CSS variables (`--teal`, `--navy`, `--gold`, etc.) are defined per template
- Lucide icons load from CDN (requires internet connection)
- The logo SVG mark is inline SVG — no image files needed
