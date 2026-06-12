# Alluvia Peptides — WordPress Setup Guide

## Theme Installation

1. Upload the `shoppingtheme` folder to `/wp-content/themes/`
2. Install and activate the **Omega** parent theme first
3. Activate the **Shopping** child theme
4. Install and activate **WooCommerce**

---

## Required WordPress Pages to Create

Go to **Pages → Add New** and create each page below.
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
The `woocommerce.php` wrapper applies the Alluvia nav and footer to all WooCommerce pages automatically.

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

The store ships with a ready-to-import catalogue of **400 peptide products —
50 best-sellers in each of the 8 categories** — in `alluvia-products.csv`.

To import:

1. Install and activate **WooCommerce** (see above).
2. Go to **Products → All Products → Import** (top of the screen).
3. Choose `alluvia-products.csv` and click **Continue**.
4. Leave column mapping on **auto** — the headers match WooCommerce exactly.
5. Click **Run the importer**.

This creates all 400 products with their categories, SEO/GEO-optimised
descriptions, AUD prices, ≥99% purity attribute and stock. Categories are
created automatically from the `Categories` column.

To regenerate or edit the catalogue, update `catalogue_data.py` (the curated
per-peptide dataset) and run:

```
python3 generate_products.py
```

This rewrites `alluvia-products.csv`. Each product's copy is built from real
per-peptide facts (what it is, how it works, its specific benefits) so every
description is unique and benefit-led — no generic templated write-ups.

---

## Notes

- All page designs are self-contained in their PHP template files
- CSS variables (`--teal`, `--navy`, `--gold`, etc.) are defined per template
- Lucide icons load from CDN (requires internet connection)
- The logo SVG mark is inline SVG — no image files needed
