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

## Notes

- All page designs are self-contained in their PHP template files
- CSS variables (`--teal`, `--navy`, `--gold`, etc.) are defined per template
- Lucide icons load from CDN (requires internet connection)
- The logo SVG mark is inline SVG — no image files needed
