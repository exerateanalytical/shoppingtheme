<?php
/**
 * Template Name: Alluvia – Contact
 *
 * @package Shopping
 */
add_action( 'wp_head', function() {
?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap');

    :root {
      --navy: #0d1b2a;
      --navy-mid: #162336;
      --navy-soft: #1e3050;
      --teal: #00c6b3;
      --teal-dark: #009e8e;
      --gold: #c8a96e;
      --coral: #e8758a;
      --purple: #9b72cf;
      --orange: #e07b54;
      --mint: #78c9a2;
      --sky: #7fb8d4;
      --pearl: #f4f2ee;
      --pearl-dark: #e8e4dc;
      --white: #ffffff;
      --text-dark: #0d1b2a;
      --text-mid: #4a5568;
      --text-light: #8899aa;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Inter', sans-serif;
      background: var(--pearl);
      color: var(--text-dark);
      line-height: 1.6;
    }

    /* ===== NAVIGATION ===== */
    nav {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 1000;
      padding: 0 40px;
      height: 72px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      transition: background 0.3s, box-shadow 0.3s;
    }

    nav.scrolled {
      background: rgba(13, 27, 42, 0.88);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      box-shadow: 0 1px 0 rgba(0, 198, 179, 0.15);
    }

    .nav-logo{display:flex;flex-direction:row;align-items:center;gap:11px;text-decoration:none}
.logo-mark{width:34px;height:34px;flex-shrink:0}
.logo-text{display:flex;flex-direction:column;line-height:1}
.nav-logo-word{font-family:'Cormorant Garamond',Georgia,serif;font-size:30px;font-weight:600;color:#fff;letter-spacing:.05em}
.nav-logo-sub{font-family:'Space Grotesk',system-ui,sans-serif;font-size:9px;font-weight:600;letter-spacing:.38em;color:#00c6b3;text-transform:uppercase;margin-top:3px}

    

    .nav-links {
      display: flex;
      align-items: center;
      gap: 32px;
      list-style: none;
    }

    .nav-links a {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 14px;
      font-weight: 500;
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      transition: color 0.2s;
    }

    .nav-links a:hover { color: var(--teal); }

    .nav-right {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .nav-icon-btn {
      background: none;
      border: none;
      cursor: pointer;
      color: rgba(255, 255, 255, 0.8);
      display: flex;
      align-items: center;
      justify-content: center;
      width: 38px;
      height: 38px;
      border-radius: 50%;
      transition: background 0.2s, color 0.2s;
      position: relative;
      text-decoration: none;
    }

    .nav-icon-btn:hover { background: rgba(255, 255, 255, 0.1); color: var(--white); }

    .cart-badge {
      position: absolute;
      top: -2px; right: -2px;
      background: var(--teal);
      color: var(--navy);
      font-family: 'Space Grotesk', sans-serif;
      font-size: 9px;
      font-weight: 700;
      width: 16px;
      height: 16px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .btn-shop-now {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 13px;
      font-weight: 600;
      background: var(--teal);
      color: var(--navy);
      border: none;
      border-radius: 50px;
      padding: 10px 24px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      transition: background 0.2s, transform 0.15s;
    }

    .btn-shop-now:hover { background: var(--teal-dark); transform: translateY(-1px); }

    .hamburger {
      display: none;
      background: none;
      border: none;
      cursor: pointer;
      color: var(--white);
      width: 40px;
      height: 40px;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
    }

    .hamburger:hover { background: rgba(255,255,255,0.1); }

    /* Mobile overlay */
    .mobile-nav-overlay {
      display: none;
      position: fixed;
      inset: 0;
      z-index: 2000;
      background: var(--navy);
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 28px;
    }

    .mobile-nav-overlay.open { display: flex; }

    .mobile-nav-close {
      position: absolute;
      top: 20px; right: 20px;
      background: none;
      border: none;
      color: var(--white);
      cursor: pointer;
      width: 44px;
      height: 44px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
    }

    .mobile-nav-close:hover { background: rgba(255,255,255,0.1); }

    .mobile-nav-overlay a {
      font-family: 'Cormorant Garamond', serif;
      font-size: 36px;
      font-weight: 400;
      color: var(--white);
      text-decoration: none;
      transition: color 0.2s;
    }

    .mobile-nav-overlay a:hover { color: var(--teal); }

    /* ===== HERO ===== */
    .page-hero {
      background: linear-gradient(135deg, var(--navy) 0%, var(--navy-soft) 55%, #1c2e48 100%);
      padding: 148px 40px 88px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .page-hero::before {
      content: '';
      position: absolute;
      top: -120px; right: -120px;
      width: 480px; height: 480px;
      background: radial-gradient(circle, rgba(0, 198, 179, 0.07) 0%, transparent 70%);
      border-radius: 50%;
      pointer-events: none;
    }

    .page-hero::after {
      content: '';
      position: absolute;
      bottom: -80px; left: -80px;
      width: 320px; height: 320px;
      background: radial-gradient(circle, rgba(155, 114, 207, 0.06) 0%, transparent 70%);
      border-radius: 50%;
      pointer-events: none;
    }

    .breadcrumb {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 13px;
      color: rgba(255, 255, 255, 0.45);
      margin-bottom: 22px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
    }

    .breadcrumb a {
      color: rgba(255, 255, 255, 0.45);
      text-decoration: none;
      transition: color 0.2s;
    }

    .breadcrumb a:hover { color: var(--teal); }

    .page-hero h1 {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(44px, 6vw, 76px);
      font-weight: 300;
      color: var(--white);
      line-height: 1.1;
      margin-bottom: 22px;
      position: relative;
    }

    .page-hero h1 em {
      font-style: italic;
      color: var(--teal);
    }

    .page-hero p {
      font-family: 'Inter', sans-serif;
      font-size: 17px;
      color: rgba(255, 255, 255, 0.6);
      max-width: 560px;
      margin: 0 auto;
      line-height: 1.75;
      position: relative;
    }

    /* ===== INFO CARDS ===== */
    .info-cards-section {
      background: var(--white);
      padding: 72px 40px;
    }

    .info-cards-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .info-card {
      background: var(--pearl);
      border-radius: 16px;
      padding: 32px 24px;
      text-align: center;
      border: 1px solid var(--pearl-dark);
      transition: transform 0.25s, box-shadow 0.25s;
    }

    .info-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 16px 40px rgba(13, 27, 42, 0.09);
    }

    .info-card-icon {
      width: 56px;
      height: 56px;
      background: rgba(0, 198, 179, 0.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      color: var(--teal);
    }

    .info-card h3 {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 16px;
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 8px;
    }

    .info-card .info-value {
      font-family: 'Inter', sans-serif;
      font-size: 15px;
      color: var(--text-dark);
      font-weight: 500;
      margin-bottom: 5px;
    }

    .info-card .info-note {
      font-family: 'Inter', sans-serif;
      font-size: 13px;
      color: var(--text-light);
    }

    /* ===== CONTACT SECTION ===== */
    .contact-section {
      background: var(--pearl);
      padding: 80px 40px;
    }

    .contact-layout {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 380px;
      gap: 48px;
      align-items: start;
    }

    /* Form Card */
    .contact-form-card {
      background: var(--white);
      border-radius: 20px;
      padding: 48px;
      box-shadow: 0 4px 28px rgba(13, 27, 42, 0.06);
    }

    .contact-form-card h2 {
      font-family: 'Cormorant Garamond', serif;
      font-size: 38px;
      font-weight: 500;
      color: var(--text-dark);
      margin-bottom: 34px;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 7px;
      margin-bottom: 20px;
    }

    .form-group label {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 13px;
      font-weight: 500;
      color: var(--text-dark);
      letter-spacing: 0.2px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      color: var(--text-dark);
      background: var(--pearl);
      border: 1.5px solid var(--pearl-dark);
      border-radius: 10px;
      padding: 13px 16px;
      transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
      outline: none;
      width: 100%;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      border-color: var(--teal);
      box-shadow: 0 0 0 3px rgba(0, 198, 179, 0.12);
      background: var(--white);
    }

    .form-group textarea { resize: vertical; min-height: 148px; }
    .form-group select { appearance: none; cursor: pointer; }

    .checkbox-group {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      margin-bottom: 28px;
    }

    .checkbox-group input[type="checkbox"] {
      width: 18px;
      height: 18px;
      min-width: 18px;
      accent-color: var(--teal);
      margin-top: 2px;
      cursor: pointer;
    }

    .checkbox-group label {
      font-family: 'Inter', sans-serif;
      font-size: 13px;
      color: var(--text-mid);
      line-height: 1.6;
      cursor: pointer;
    }

    .checkbox-group label a { color: var(--teal); text-decoration: none; }
    .checkbox-group label a:hover { text-decoration: underline; }

    .btn-submit {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 15px;
      font-weight: 600;
      background: var(--teal);
      color: var(--navy);
      border: none;
      border-radius: 50px;
      padding: 14px 36px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      transition: background 0.2s, transform 0.15s;
    }

    .btn-submit:hover { background: var(--teal-dark); transform: translateY(-1px); }

    /* Success state */
    .form-success {
      display: none;
      text-align: center;
      padding: 48px 24px;
    }

    .form-success.visible { display: block; }

    .success-icon-wrap {
      width: 76px;
      height: 76px;
      background: rgba(0, 198, 179, 0.12);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 24px;
      color: var(--teal);
      animation: popIn 0.45s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes popIn {
      0% { transform: scale(0.4); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }

    .form-success h3 {
      font-family: 'Cormorant Garamond', serif;
      font-size: 36px;
      font-weight: 500;
      color: var(--text-dark);
      margin-bottom: 12px;
    }

    .form-success p {
      font-family: 'Inter', sans-serif;
      font-size: 15px;
      color: var(--text-mid);
      max-width: 380px;
      margin: 0 auto;
      line-height: 1.7;
    }

    /* Sidebar */
    .contact-sidebar {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .sidebar-card {
      background: var(--white);
      border-radius: 16px;
      padding: 28px;
      box-shadow: 0 4px 24px rgba(13, 27, 42, 0.06);
    }

    .sidebar-card h3 {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-light);
      letter-spacing: 1.5px;
      text-transform: uppercase;
      margin-bottom: 18px;
    }

    .response-list {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .response-list li {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-family: 'Inter', sans-serif;
      font-size: 13px;
    }

    .response-list .channel { color: var(--text-mid); }

    .response-list .time {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 11px;
      font-weight: 600;
      color: var(--teal-dark);
      background: rgba(0, 198, 179, 0.08);
      padding: 3px 10px;
      border-radius: 50px;
    }

    .hours-list {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 0;
    }

    .hours-list li {
      display: flex;
      justify-content: space-between;
      font-family: 'Inter', sans-serif;
      font-size: 13px;
      color: var(--text-mid);
      padding: 8px 0;
      border-bottom: 1px solid var(--pearl-dark);
    }

    .hours-list li:last-child { border-bottom: none; }
    .hours-list .day { font-weight: 500; color: var(--text-dark); }

    .open-badge {
      display: none;
      align-items: center;
      gap: 7px;
      font-family: 'Space Grotesk', sans-serif;
      font-size: 11px;
      font-weight: 600;
      color: #16a34a;
      background: rgba(22, 163, 74, 0.1);
      padding: 5px 12px;
      border-radius: 50px;
      margin-top: 14px;
      width: fit-content;
    }

    .open-dot {
      width: 7px;
      height: 7px;
      background: #22c55e;
      border-radius: 50%;
      animation: pulseDot 2s infinite;
    }

    @keyframes pulseDot {
      0%, 100% { opacity: 1; transform: scale(1); }
      50% { opacity: 0.5; transform: scale(0.85); }
    }

    .sidebar-card.teal-bg {
      background: linear-gradient(135deg, var(--teal) 0%, var(--teal-dark) 100%);
    }

    .sidebar-card.teal-bg h3 { color: rgba(13, 27, 42, 0.7); }

    .sidebar-card.teal-bg p {
      font-family: 'Inter', sans-serif;
      font-size: 13px;
      color: rgba(13, 27, 42, 0.78);
      margin-bottom: 18px;
      line-height: 1.65;
    }

    .btn-ghost-white {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 13px;
      font-weight: 600;
      background: transparent;
      color: var(--navy);
      border: 2px solid rgba(13, 27, 42, 0.4);
      border-radius: 50px;
      padding: 9px 22px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      transition: background 0.2s, color 0.2s, border-color 0.2s;
    }

    .btn-ghost-white:hover {
      background: var(--navy);
      color: var(--white);
      border-color: var(--navy);
    }

    .tracking-text {
      font-family: 'Inter', sans-serif;
      font-size: 13px;
      color: var(--text-mid);
      margin-bottom: 14px;
      line-height: 1.6;
    }

    .tracking-link {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 14px;
      font-weight: 600;
      color: var(--teal-dark);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: gap 0.2s;
    }

    .tracking-link:hover { gap: 10px; }

    /* ===== FAQ ===== */
    .faq-section {
      background: var(--white);
      padding: 80px 40px;
    }

    .section-heading {
      text-align: center;
      margin-bottom: 52px;
    }

    .section-heading h2 {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(34px, 4vw, 52px);
      font-weight: 400;
      color: var(--text-dark);
      margin-bottom: 12px;
    }

    .section-heading p {
      font-family: 'Inter', sans-serif;
      font-size: 16px;
      color: var(--text-mid);
    }

    .faq-list {
      max-width: 820px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .faq-item {
      background: var(--pearl);
      border: 1.5px solid var(--pearl-dark);
      border-radius: 14px;
      overflow: hidden;
      transition: border-color 0.2s;
    }

    .faq-item.open { border-color: rgba(0, 198, 179, 0.3); }

    .faq-question {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 22px 24px;
      cursor: pointer;
      gap: 16px;
      user-select: none;
    }

    .faq-question h4 {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 15px;
      font-weight: 500;
      color: var(--text-dark);
      flex: 1;
    }

    .faq-icon {
      width: 30px;
      height: 30px;
      min-width: 30px;
      background: var(--white);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--teal);
      border: 1.5px solid var(--pearl-dark);
      transition: background 0.2s, border-color 0.2s, color 0.2s;
    }

    .faq-item.open .faq-icon {
      background: var(--teal);
      border-color: var(--teal);
      color: var(--white);
    }

    .faq-answer {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.38s ease;
    }

    .faq-answer-inner {
      padding: 0 24px 22px;
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      color: var(--text-mid);
      line-height: 1.75;
    }

    .faq-answer-inner a { color: var(--teal-dark); text-decoration: none; }
    .faq-answer-inner a:hover { text-decoration: underline; }

    /* ===== MAP ===== */
    .map-section {
      background: var(--white);
      padding: 0 40px 80px;
    }

    .map-placeholder {
      max-width: 1200px;
      margin: 0 auto;
      height: 300px;
      background: linear-gradient(135deg, var(--navy) 0%, var(--navy-soft) 100%);
      border-radius: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 14px;
      position: relative;
      overflow: hidden;
    }

    .map-placeholder::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse at 50% 50%, rgba(0, 198, 179, 0.11) 0%, transparent 65%);
      pointer-events: none;
    }

    .map-icon-wrap {
      width: 64px;
      height: 64px;
      background: rgba(0, 198, 179, 0.14);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--teal);
      position: relative;
      z-index: 1;
    }

    .map-placeholder h3 {
      font-family: 'Cormorant Garamond', serif;
      font-size: 30px;
      font-weight: 400;
      color: var(--white);
      position: relative;
      z-index: 1;
    }

    .map-placeholder p {
      font-family: 'Inter', sans-serif;
      font-size: 13px;
      color: rgba(255, 255, 255, 0.45);
      position: relative;
      z-index: 1;
    }

    /* ===== NEWSLETTER ===== */
    .newsletter-strip {
      background: var(--navy-mid);
      padding: 52px 40px;
    }

    .newsletter-inner {
      max-width: 580px;
      margin: 0 auto;
      text-align: center;
    }

    .newsletter-inner h3 {
      font-family: 'Cormorant Garamond', serif;
      font-size: 34px;
      font-weight: 400;
      color: var(--white);
      margin-bottom: 8px;
    }

    .newsletter-inner p {
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      color: rgba(255, 255, 255, 0.5);
      margin-bottom: 24px;
    }

    .newsletter-form {
      display: flex;
      gap: 12px;
    }

    .newsletter-form input {
      flex: 1;
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      background: rgba(255, 255, 255, 0.07);
      border: 1.5px solid rgba(255, 255, 255, 0.14);
      color: var(--white);
      border-radius: 50px;
      padding: 13px 20px;
      outline: none;
      transition: border-color 0.2s, background 0.2s;
    }

    .newsletter-form input::placeholder { color: rgba(255, 255, 255, 0.3); }
    .newsletter-form input:focus { border-color: var(--teal); background: rgba(255,255,255,0.1); }

    .btn-subscribe {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 14px;
      font-weight: 600;
      background: var(--teal);
      color: var(--navy);
      border: none;
      border-radius: 50px;
      padding: 13px 28px;
      cursor: pointer;
      white-space: nowrap;
      transition: background 0.2s;
    }

    .btn-subscribe:hover { background: var(--teal-dark); }

    /* ===== FOOTER ===== */
    footer {
      background: #060e17;
      padding: 72px 40px 0;
    }

    .footer-grid {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1fr;
      gap: 48px;
      padding-bottom: 56px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    }

    .footer-logo {
      font-family: 'Cormorant Garamond', serif;
      font-size: 24px;
      font-weight: 600;
      color: var(--white);
      text-decoration: none;
      display: flex;
      align-items: baseline;
      gap: 6px;
      margin-bottom: 14px;
    }

    .footer-logo span {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 9px;
      font-weight: 500;
      color: var(--teal);
      letter-spacing: 2px;
      text-transform: uppercase;
    }

    .footer-desc {
      font-family: 'Inter', sans-serif;
      font-size: 13px;
      color: rgba(255, 255, 255, 0.4);
      line-height: 1.75;
      margin-bottom: 24px;
    }

    .social-row {
      display: flex;
      gap: 10px;
    }

    .social-btn {
      width: 36px;
      height: 36px;
      background: rgba(255, 255, 255, 0.06);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: rgba(255, 255, 255, 0.45);
      text-decoration: none;
      transition: background 0.2s, color 0.2s;
    }

    .social-btn:hover { background: var(--teal); color: var(--navy); }

    .footer-col h4 {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 11px;
      font-weight: 600;
      color: rgba(255, 255, 255, 0.3);
      letter-spacing: 1.8px;
      text-transform: uppercase;
      margin-bottom: 20px;
    }

    .footer-links {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .footer-links a {
      font-family: 'Inter', sans-serif;
      font-size: 13px;
      color: rgba(255, 255, 255, 0.45);
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: color 0.2s, gap 0.2s;
    }

    .footer-links a:hover { color: var(--teal); gap: 9px; }
    .footer-links i { width: 14px; height: 14px; }

    .footer-bottom {
      max-width: 1200px;
      margin: 0 auto;
      padding: 24px 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 12px;
    }

    .footer-bottom p {
      font-family: 'Inter', sans-serif;
      font-size: 12px;
      color: rgba(255, 255, 255, 0.25);
    }

    .footer-bottom-links {
      display: flex;
      gap: 20px;
    }

    .footer-bottom-links a {
      font-family: 'Inter', sans-serif;
      font-size: 12px;
      color: rgba(255, 255, 255, 0.25);
      text-decoration: none;
      transition: color 0.2s;
    }

    .footer-bottom-links a:hover { color: var(--teal); }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1100px) {
      .info-cards-grid { grid-template-columns: repeat(2, 1fr); }
      .contact-layout { grid-template-columns: 1fr; }
      .contact-sidebar { display: grid; grid-template-columns: repeat(2, 1fr); }
      .footer-grid { grid-template-columns: 1fr 1fr; gap: 36px; }
    }

    @media (max-width: 900px) {
      .nav-links { display: none; }
      .hamburger { display: flex; }
      .btn-shop-now { display: none; }
      .contact-form-card { padding: 32px 24px; }
    }

    @media (max-width: 640px) {
  .page-hero h1,.hero-title{font-size:clamp(36px,9vw,52px)!important}
  .section-title{font-size:clamp(28px,7vw,42px)!important}
  .featured-title,.post-title{font-size:clamp(24px,6vw,36px)!important}
  .product-title{font-size:clamp(28px,7vw,38px)!important}
  .section-desc,.post-lead,.featured-body{font-size:16px}
  body,p,.article p{font-size:15px;line-height:1.75}
  .still-help h2,.newsletter h2,.cta-title{font-size:clamp(24px,6vw,36px)!important}

      nav { padding: 0 20px; }
      .page-hero { padding: 120px 20px 60px; }
      .info-cards-section { padding: 52px 20px; }
      .info-cards-grid { grid-template-columns: 1fr; }
      .contact-section { padding: 52px 20px; }
      .contact-sidebar { grid-template-columns: 1fr; }
      .faq-section { padding: 52px 20px; }
      .map-section { padding: 0 20px 52px; }
      .newsletter-strip { padding: 44px 20px; }
      .newsletter-form { flex-direction: column; }
      .footer-grid { grid-template-columns: 1fr; gap: 28px; }
      footer { padding: 48px 20px 0; }
      .footer-bottom { flex-direction: column; align-items: flex-start; }
      .form-row { grid-template-columns: 1fr; }
      .contact-form-card { padding: 28px 20px; }
    }

    @media (max-width: 400px) {
      .page-hero h1 { font-size: 38px; }
      .contact-form-card { padding: 20px 16px; }
    }
</style>
<?php
}, 20 );
get_header( 'alluvia' );
?>
<!-- ===== NAVIGATION ===== -->
  <nav id="mainNav">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo"><svg class="logo-mark" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><polygon points="17,2 30,9.5 30,24.5 17,32 4,24.5 4,9.5" stroke="#00c6b3" stroke-width="1.6" fill="none" opacity="0.9"/><circle cx="17" cy="10" r="2.2" fill="#00c6b3"/><circle cx="10.5" cy="21" r="2.2" fill="#00c6b3"/><circle cx="23.5" cy="21" r="2.2" fill="#00c6b3"/><line x1="17" y1="10" x2="10.5" y2="21" stroke="#00c6b3" stroke-width="1.1" opacity="0.5"/><line x1="17" y1="10" x2="23.5" y2="21" stroke="#00c6b3" stroke-width="1.1" opacity="0.5"/><line x1="10.5" y1="21" x2="23.5" y2="21" stroke="#00c6b3" stroke-width="1.1" opacity="0.5"/></svg><div class="logo-text"><span class="nav-logo-word">Alluvia</span><span class="nav-logo-sub">Peptides</span></div></a>
    <ul class="nav-links">
      <li><a href="<?php echo esc_url(alluvia_shop_url()); ?>">Products</a></li>
      <li><a href="<?php echo esc_url(home_url('/about/#science')); ?>">Science</a></li>
      <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About</a></li>
      <li><a href="#reviews">Reviews</a></li>
      <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li>
    </ul>
    <div class="nav-right">
      <button class="nav-icon-btn" aria-label="Cart">
        <i data-lucide="shopping-cart"></i>
        <span class="cart-badge">3</span>
      </button>
      <a href="<?php echo esc_url(alluvia_account_url()); ?>" class="nav-icon-btn" aria-label="Account">
        <i data-lucide="user"></i>
      </a>
      <a href="<?php echo esc_url(alluvia_shop_url()); ?>" class="btn-shop-now">Shop Now</a>
      <button class="hamburger" id="hamburgerBtn" aria-label="Open menu">
        <i data-lucide="menu"></i>
      </button>
    </div>
  </nav>

  <!-- Mobile Nav Overlay -->
  <div class="mobile-nav-overlay" id="mobileNav" role="dialog" aria-modal="true" aria-label="Navigation menu">
    <button class="mobile-nav-close" id="mobileNavClose" aria-label="Close menu">
      <i data-lucide="x"></i>
    </button>
    <a href="<?php echo esc_url(alluvia_shop_url()); ?>">Products</a>
    <a href="<?php echo esc_url(home_url('/about/#science')); ?>">Science</a>
    <a href="<?php echo esc_url(home_url('/about/')); ?>">About</a>
    <a href="#reviews">Reviews</a>
    <a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a>
    <a href="<?php echo esc_url(alluvia_shop_url()); ?>" class="btn-shop-now" style="margin-top: 16px;">Shop Now</a>
  </div>

  <!-- ===== PAGE HERO ===== -->
  <section class="page-hero">
    <div class="breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
      <i data-lucide="chevron-right"></i>
      <span>Contact</span>
    </div>
    <h1>Get in <em>Touch</em></h1>
    <p>Our team of peptide specialists is here to help with orders, research questions, and consultations.</p>
  </section>

  <!-- ===== INFO CARDS ===== -->
  <section class="info-cards-section">
    <div class="info-cards-grid">
      <div class="info-card">
        <div class="info-card-icon"><i data-lucide="mail"></i></div>
        <h3>Email Us</h3>
        <div class="info-value">hello@alluviapeptides.com</div>
        <div class="info-note">Response within 4 hours</div>
      </div>
      <div class="info-card">
        <div class="info-card-icon"><i data-lucide="phone"></i></div>
        <h3>Call Us</h3>
        <div class="info-value">+1 (800) 555-0192</div>
        <div class="info-note">Mon–Fri 9am–6pm EST</div>
      </div>
      <div class="info-card">
        <div class="info-card-icon"><i data-lucide="message-circle"></i></div>
        <h3>Live Chat</h3>
        <div class="info-value">Available on site</div>
        <div class="info-note">Mon–Fri 9am–8pm EST</div>
      </div>
      <div class="info-card">
        <div class="info-card-icon"><i data-lucide="map-pin"></i></div>
        <h3>Location</h3>
        <div class="info-value">Miami, Florida, USA</div>
        <div class="info-note">By appointment only</div>
      </div>
    </div>
  </section>

  <!-- ===== CONTACT FORM + SIDEBAR ===== -->
  <section class="contact-section">
    <div class="contact-layout">

      <!-- Left: Contact Form -->
      <div class="contact-form-card">
        <h2>Send Us a Message</h2>

        <div id="contactFormWrap">
          <form id="contactForm" novalidate>
            <div class="form-row">
              <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" placeholder="Jane" autocomplete="given-name" />
              </div>
              <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" placeholder="Doe" autocomplete="family-name" />
              </div>
            </div>

            <div class="form-group">
              <label for="emailAddr">Email Address</label>
              <input type="email" id="emailAddr" name="email" placeholder="jane@example.com" autocomplete="email" />
            </div>

            <div class="form-group">
              <label for="subject">Subject</label>
              <select id="subject" name="subject">
                <option value="">Select a subject...</option>
                <option value="general">General Enquiry</option>
                <option value="order">Order Support</option>
                <option value="research">Research Consultation</option>
                <option value="product">Product Information</option>
                <option value="wholesale">Wholesale / B2B</option>
                <option value="press">Press / Media</option>
              </select>
            </div>

            <div class="form-group">
              <label for="message">Message</label>
              <textarea id="message" name="message" rows="6" placeholder="Tell us how we can help..."></textarea>
            </div>

            <div class="checkbox-group">
              <input type="checkbox" id="consent" name="consent" />
              <label for="consent">I consent to Alluvia Peptides storing my data in accordance with the <a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>">Privacy Policy</a></label>
            </div>

            <button type="submit" class="btn-submit">
              <i data-lucide="send"></i>
              Send Message
            </button>
          </form>
        </div>

        <!-- Success State -->
        <div class="form-success" id="formSuccess">
          <div class="success-icon-wrap">
            <i data-lucide="check-circle" style="width: 32px; height: 32px;"></i>
          </div>
          <h3>Message Sent!</h3>
          <p>Thank you for reaching out. One of our peptide specialists will get back to you within 4 business hours.</p>
        </div>
      </div>

      <!-- Right: Sidebar -->
      <div class="contact-sidebar">

        <div class="sidebar-card">
          <h3>Response Times</h3>
          <ul class="response-list">
            <li><span class="channel">Email</span><span class="time">Within 4 hours</span></li>
            <li><span class="channel">Live Chat</span><span class="time">Instant</span></li>
            <li><span class="channel">Phone</span><span class="time">Immediate</span></li>
            <li><span class="channel">Wholesale Enquiries</span><span class="time">Within 24h</span></li>
          </ul>
        </div>

        <div class="sidebar-card">
          <h3>Business Hours</h3>
          <ul class="hours-list">
            <li><span class="day">Monday</span><span>9:00am – 6:00pm EST</span></li>
            <li><span class="day">Tuesday</span><span>9:00am – 6:00pm EST</span></li>
            <li><span class="day">Wednesday</span><span>9:00am – 6:00pm EST</span></li>
            <li><span class="day">Thursday</span><span>9:00am – 6:00pm EST</span></li>
            <li><span class="day">Friday</span><span>9:00am – 6:00pm EST</span></li>
            <li><span class="day">Saturday</span><span>Closed</span></li>
            <li><span class="day">Sunday</span><span>Closed</span></li>
          </ul>
          <div class="open-badge" id="openNowBadge">
            <span class="open-dot"></span>
            Open Now
          </div>
        </div>

        <div class="sidebar-card teal-bg">
          <h3>Book a Consultation</h3>
          <p>Not sure which peptide protocol is right for your research? Book a free 15-minute consultation with one of our specialists.</p>
          <a href="#" class="btn-ghost-white">Book Now</a>
        </div>

        <div class="sidebar-card">
          <h3>Order Tracking</h3>
          <p class="tracking-text">Already placed an order? Track your shipment in real time using your order number and email address.</p>
          <a href="#" class="tracking-link">
            Track Your Order
            <i data-lucide="arrow-right"></i>
          </a>
        </div>

      </div>
    </div>
  </section>

  <!-- ===== FAQ ACCORDION ===== -->
  <section class="faq-section">
    <div class="section-heading">
      <h2>Frequently Asked Questions</h2>
      <p>Can't find your answer? Reach out to our team directly.</p>
    </div>

    <div class="faq-list" id="faqList">

      <div class="faq-item">
        <div class="faq-question" role="button" tabindex="0" aria-expanded="false">
          <h4>Can I use Alluvia peptides for personal use?</h4>
          <div class="faq-icon"><i data-lucide="plus"></i></div>
        </div>
        <div class="faq-answer" role="region">
          <div class="faq-answer-inner">
            All Alluvia peptides are sold strictly for research and laboratory purposes only and are not intended for human consumption, self-administration, or therapeutic use. Before considering any peptide protocol, we strongly recommend consulting a licensed physician or qualified healthcare professional. Alluvia Peptides assumes no liability for any misuse of products sold through our platform.
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-question" role="button" tabindex="0" aria-expanded="false">
          <h4>How quickly will my order be dispatched?</h4>
          <div class="faq-icon"><i data-lucide="plus"></i></div>
        </div>
        <div class="faq-answer" role="region">
          <div class="faq-answer-inner">
            All orders are processed within 24 hours of payment confirmation. Orders placed before 2:00pm EST on business days (Monday through Friday) qualify for same-day dispatch. You will receive a tracking number by email as soon as your package is handed to our courier. Cold-chain packaging is used on all orders to ensure peptide integrity throughout transit.
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-question" role="button" tabindex="0" aria-expanded="false">
          <h4>Do you ship internationally?</h4>
          <div class="faq-icon"><i data-lucide="plus"></i></div>
        </div>
        <div class="faq-answer" role="region">
          <div class="faq-answer-inner">
            Yes. We ship to most countries worldwide via express courier. All international orders are dispatched with full cold-chain packaging including dry ice or phase-change gel packs where required. Delivery times and import regulations vary by country. Please review our <a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>">Shipping Info page</a> for a full list of supported destinations and any country-specific import restrictions before placing your order.
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-question" role="button" tabindex="0" aria-expanded="false">
          <h4>What is a Certificate of Analysis (COA)?</h4>
          <div class="faq-icon"><i data-lucide="plus"></i></div>
        </div>
        <div class="faq-answer" role="region">
          <div class="faq-answer-inner">
            A Certificate of Analysis (COA) is a document issued by an independent, third-party laboratory that confirms the identity, purity, potency, and microbiological safety of a specific batch of peptide. Every batch manufactured for Alluvia Peptides is tested by an ISO-certified analytical lab, and the corresponding COA is available for download directly on each product page. We believe full batch transparency is a non-negotiable standard in research-grade peptide supply.
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-question" role="button" tabindex="0" aria-expanded="false">
          <h4>Can I return a product if I am not satisfied?</h4>
          <div class="faq-icon"><i data-lucide="plus"></i></div>
        </div>
        <div class="faq-answer" role="region">
          <div class="faq-answer-inner">
            We offer a 30-day return policy for all unopened products in original, undamaged packaging. If you receive a damaged, defective, or incorrect item, please contact us within 72 hours of delivery and we will arrange a replacement or full refund at no charge. Due to the nature of our research-grade inventory, opened or used products cannot be accepted for return. Please review our full Returns Policy for complete terms and conditions.
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-question" role="button" tabindex="0" aria-expanded="false">
          <h4>Do you offer wholesale pricing?</h4>
          <div class="faq-icon"><i data-lucide="plus"></i></div>
        </div>
        <div class="faq-answer" role="region">
          <div class="faq-answer-inner">
            Yes. Alluvia Peptides offers competitive wholesale and B2B pricing for qualified research institutions, compounding pharmacies, clinical facilities, and registered distributors. Volume-tiered discounts are available across our full catalogue. To enquire about wholesale pricing, preferred supplier agreements, or custom formulation requests, please email our dedicated team at wholesale@alluviapeptides.com or select "Wholesale / B2B" from the contact form above.
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ===== MAP PLACEHOLDER ===== -->
  <section class="map-section">
    <div class="map-placeholder">
      <div class="map-icon-wrap">
        <i data-lucide="map-pin" style="width: 28px; height: 28px;"></i>
      </div>
      <h3>Miami, Florida</h3>
      <p>Exact address provided upon appointment booking</p>
    </div>
  </section>

  <!-- ===== NEWSLETTER STRIP ===== -->
  <section class="newsletter-strip">
    <div class="newsletter-inner">
      <h3>Stay Informed</h3>
      <p>Research updates, new product launches, and exclusive offers delivered to your inbox.</p>
      <div class="newsletter-form">
        <input type="email" placeholder="Enter your email address" aria-label="Email address" />
        <button class="btn-subscribe" type="button">Subscribe</button>
      </div>
    </div>
  </section>

  <!-- ===== FOOTER ===== -->
  <footer>
    <div class="footer-grid">
      <div>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo footer-logo-link"><?php echo alluvia_logo_svg(); ?></a>
        <p class="footer-desc">Pharmaceutical-grade peptides backed by peer-reviewed science.</p>
        <div class="social-row">
          <a href="#" class="social-btn" aria-label="Instagram"><i data-lucide="instagram"></i></a>
          <a href="#" class="social-btn" aria-label="Twitter"><i data-lucide="twitter"></i></a>
          <a href="#" class="social-btn" aria-label="Facebook"><i data-lucide="facebook"></i></a>
          <a href="#" class="social-btn" aria-label="YouTube"><i data-lucide="youtube"></i></a>
        </div>
      </div>

      <div class="footer-col">
        <h4>Products</h4>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url(alluvia_shop_url()); ?>"><i data-lucide="chevron-right"></i>BPC-157</a></li>
          <li><a href="<?php echo esc_url(alluvia_shop_url()); ?>"><i data-lucide="chevron-right"></i>GHK-Cu Peptide</a></li>
          <li><a href="<?php echo esc_url(alluvia_shop_url()); ?>"><i data-lucide="chevron-right"></i>Ipamorelin</a></li>
          <li><a href="<?php echo esc_url(alluvia_shop_url()); ?>"><i data-lucide="chevron-right"></i>AOD-9604</a></li>
          <li><a href="<?php echo esc_url(alluvia_shop_url()); ?>"><i data-lucide="chevron-right"></i>Semaglutide</a></li>
          <li><a href="<?php echo esc_url(alluvia_shop_url()); ?>"><i data-lucide="chevron-right"></i>View All Products</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Company</h4>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><i data-lucide="chevron-right"></i>About Us</a></li>
          <li><a href="<?php echo esc_url(home_url('/about/#science')); ?>"><i data-lucide="chevron-right"></i>Science</a></li>
          <li><a href="#"><i data-lucide="chevron-right"></i>Research</a></li>
          <li><a href="#"><i data-lucide="chevron-right"></i>Careers</a></li>
          <li><a href="#"><i data-lucide="chevron-right"></i>Press</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Support</h4>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><i data-lucide="chevron-right"></i>Contact Us</a></li>
          <li><a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>"><i data-lucide="chevron-right"></i>Shipping Info</a></li>
          <li><a href="#"><i data-lucide="chevron-right"></i>Returns Policy</a></li>
          <li><a href="#"><i data-lucide="chevron-right"></i>FAQ</a></li>
          <li><a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>"><i data-lucide="chevron-right"></i>Terms</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; 2025 Alluvia Peptides. All rights reserved.</p>
      <div class="footer-bottom-links">
        <a href="#">Privacy Policy</a>
        <a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>">Terms of Service</a>
        <a href="#">Disclaimer</a>
      </div>
    </div>
  </footer>

  <script>
    // ---- Nav scroll effect ----
    var mainNav = document.getElementById('mainNav');
    window.addEventListener('scroll', function () {
      mainNav.classList.toggle('scrolled', window.scrollY > 20);
    });

    // ---- Mobile hamburger ----
    var hamburgerBtn = document.getElementById('hamburgerBtn');
    var mobileNav = document.getElementById('mobileNav');
    var mobileNavClose = document.getElementById('mobileNavClose');

    hamburgerBtn.addEventListener('click', function () {
      mobileNav.classList.add('open');
      document.body.style.overflow = 'hidden';
    });

    mobileNavClose.addEventListener('click', function () {
      mobileNav.classList.remove('open');
      document.body.style.overflow = '';
    });

    // Close mobile nav on link click
    mobileNav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        mobileNav.classList.remove('open');
        document.body.style.overflow = '';
      });
    });

    // ---- Contact form submit ----
    var contactForm = document.getElementById('contactForm');
    var contactFormWrap = document.getElementById('contactFormWrap');
    var formSuccess = document.getElementById('formSuccess');

    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var btn = contactForm.querySelector('.btn-submit');
      var fn = (document.getElementById('firstName').value || '').trim();
      var ln = (document.getElementById('lastName').value || '').trim();
      var email = (document.getElementById('emailAddr').value || '').trim();
      var subjSel = document.getElementById('subject');
      var subject = (subjSel && subjSel.options[subjSel.selectedIndex]) ? subjSel.options[subjSel.selectedIndex].text : '';
      var message = (document.getElementById('message').value || '').trim();
      if (!fn || !email || !message) { alert('Please enter your name, email and message.'); return; }
      var cfg = window.alluviaAjax || {};
      var orig = btn.innerHTML;
      btn.disabled = true; btn.textContent = 'Sending…';
      fetch(cfg.ajax_url || '/wp-admin/admin-ajax.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
          action: 'alluvia_contact',
          nonce: cfg.contact_nonce || '',
          name: (fn + ' ' + ln).trim(),
          email: email,
          subject: subject || 'Contact Form Submission',
          message: message
        })
      }).then(function (r) { return r.json(); }).then(function (res) {
        if (res && res.success) {
          contactFormWrap.style.display = 'none';
          formSuccess.classList.add('visible');
          lucide.createIcons();
        } else {
          btn.disabled = false; btn.innerHTML = orig; lucide.createIcons();
          alert((res && res.data && res.data.message) || 'Could not send. Please email us directly.');
        }
      }).catch(function () {
        btn.disabled = false; btn.innerHTML = orig; lucide.createIcons();
        alert('Network error. Please email us directly.');
      });
    });

    // ---- FAQ Accordion ----
    var faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(function (item) {
      var question = item.querySelector('.faq-question');
      var answer = item.querySelector('.faq-answer');
      var iconEl = item.querySelector('.faq-icon i');

      function openItem() {
        item.classList.add('open');
        answer.style.maxHeight = answer.scrollHeight + 'px';
        iconEl.setAttribute('data-lucide', 'x');
        question.setAttribute('aria-expanded', 'true');
        lucide.createIcons();
      }

      function closeItem() {
        item.classList.remove('open');
        answer.style.maxHeight = '0';
        iconEl.setAttribute('data-lucide', 'plus');
        question.setAttribute('aria-expanded', 'false');
        lucide.createIcons();
      }

      question.addEventListener('click', function () {
        var isOpen = item.classList.contains('open');
        // Close all first
        faqItems.forEach(function (otherItem) {
          var otherAnswer = otherItem.querySelector('.faq-answer');
          var otherIcon = otherItem.querySelector('.faq-icon i');
          var otherQ = otherItem.querySelector('.faq-question');
          otherItem.classList.remove('open');
          otherAnswer.style.maxHeight = '0';
          otherIcon.setAttribute('data-lucide', 'plus');
          otherQ.setAttribute('aria-expanded', 'false');
        });
        lucide.createIcons();
        if (!isOpen) { openItem(); }
      });

      question.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          question.click();
        }
      });
    });

    // ---- Business hours live "Open Now" badge ----
    (function () {
      var now = new Date();
      var day = now.getDay();      // 0 = Sunday, 6 = Saturday
      var hour = now.getHours();   // 0–23
      var isWeekday = day >= 1 && day <= 5;
      var isOpen = hour >= 9 && hour < 18;
      if (isWeekday && isOpen) {
        var badge = document.getElementById('openNowBadge');
        if (badge) { badge.style.display = 'inline-flex'; }
      }
    })();

    lucide.createIcons();
  </script>
<?php get_footer( 'alluvia' ); ?>
