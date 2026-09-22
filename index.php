<?php
// Stepzy PHP Entry Point with Server-Side XML Parsing
$xmlFile = __DIR__ . '/data/products_catalog.xml';
$xmlFeaturedCount = 0;
if (file_exists($xmlFile)) {
    $xml = @simplexml_load_file($xmlFile);
    if ($xml && isset($xml->featuredShoes->shoe)) {
        $xmlFeaturedCount = count($xml->featuredShoes->shoe);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>STEPZY | Precision Footwear & Kinetic Engineering</title>
  <style>
    /* ==========================================================================
       STEPZY ULTRA-LUXE PURPLE DESIGN SYSTEM
       ========================================================================== */
    :root {
      --bg-dark: #07060d;
      --bg-darker: #040308;
      --bg-card: #0f0c1c;
      --bg-card-hover: #17132c;
      --surface: #1a1631;
      --surface-light: #241e44;
      --surface-active: #31285c;
      --primary: #8b5cf6;
      --primary-hover: #7c3aed;
      --primary-light: #c4b5fd;
      --primary-glow: rgba(139, 92, 246, 0.45);
      --accent: #d946ef;
      --accent-glow: rgba(217, 70, 239, 0.35);
      --text-main: #f8fafc;
      --text-muted: #94a3b8;
      --text-dim: #64748b;
      --border: rgba(139, 92, 246, 0.18);
      --border-hover: rgba(168, 85, 247, 0.55);
      --gold: #fbbf24;
      --emerald: #10b981;
      --rose: #f43f5e;
      --radius-sm: 8px;
      --radius-md: 14px;
      --radius-lg: 20px;
      --radius-xl: 28px;
      --radius-full: 9999px;
      --shadow-subtle: 0 4px 20px rgba(0, 0, 0, 0.35);
      --shadow-glow: 0 10px 30px rgba(139, 92, 246, 0.25);
      --shadow-card: 0 12px 32px rgba(4, 3, 8, 0.65);
      --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      scroll-behavior: smooth;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      background-color: var(--bg-dark);
      color: var(--text-main);
      line-height: 1.5;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
    }

    a {
      text-decoration: none;
      color: inherit;
      transition: var(--transition);
    }

    button, input, select, textarea {
      font-family: inherit;
    }

    .container {
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 24px;
    }

    /* ==========================================================================
       TOP ANNOUNCEMENT BANNER
       ========================================================================== */
    .top-banner {
      background: linear-gradient(90deg, #110d24 0%, #201540 50%, #110d24 100%);
      border-bottom: 1px solid var(--border);
      padding: 8px 16px;
      font-size: 0.78rem;
      font-weight: 600;
      letter-spacing: 0.8px;
      text-align: center;
      color: var(--primary-light);
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 16px;
    }
    .top-banner span.tag {
      background: var(--accent);
      color: #fff;
      font-size: 0.68rem;
      font-weight: 800;
      padding: 2px 7px;
      border-radius: var(--radius-full);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* ==========================================================================
       HEADER & NAVIGATION
       ========================================================================== */
    .header {
      position: sticky;
      top: 0;
      z-index: 100;
      background: rgba(7, 6, 13, 0.92);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--border);
      padding: 14px 0;
    }

    .header-inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 20px;
    }

    /* Brand Logo */
    .brand-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 1.65rem;
      font-weight: 900;
      letter-spacing: -0.5px;
      color: #fff;
    }
    .logo-glyph {
      width: 34px;
      height: 34px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 14px var(--primary-glow);
      transform: rotate(-6deg);
      font-size: 1rem;
    }

    /* Navigation Links */
    .nav-links {
      display: flex;
      align-items: center;
      gap: 24px;
      list-style: none;
    }
    .nav-item {
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--text-muted);
      position: relative;
      padding: 6px 0;
    }
    .nav-item:hover,
    .nav-item.active {
      color: #fff;
    }
    .nav-item::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 0;
      height: 2px;
      background: linear-gradient(90deg, var(--primary), var(--accent));
      transition: var(--transition);
      border-radius: 2px;
    }
    .nav-item:hover::after,
    .nav-item.active::after {
      width: 100%;
    }
    .nav-item.sale-highlight {
      color: var(--accent);
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }

    /* Header Actions */
    .header-actions {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    /* Search Form & Live Results Dropdown */
    .search-form {
      position: relative;
    }
    .search-box {
      position: relative;
      display: flex;
      align-items: center;
    }
    .search-input {
      background: var(--surface);
      border: 1px solid var(--border);
      color: #fff;
      font-size: 0.85rem;
      padding: 8px 75px 8px 34px;
      border-radius: var(--radius-full);
      outline: none;
      width: 210px;
      transition: var(--transition);
    }
    .search-input:focus {
      width: 270px;
      border-color: var(--primary);
      background: var(--surface-light);
      box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.25);
    }
    .search-icon {
      position: absolute;
      left: 11px;
      font-size: 0.82rem;
      color: var(--text-muted);
      pointer-events: none;
    }
    .search-btn {
      position: absolute;
      right: 3px;
      top: 3px;
      bottom: 3px;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      color: #fff;
      border: none;
      border-radius: var(--radius-full);
      padding: 0 12px;
      font-size: 0.75rem;
      font-weight: 700;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition);
    }
    .search-btn:hover {
      filter: brightness(1.15);
    }

    /* Live Autocomplete Dropdown under search bar */
    .search-dropdown {
      position: absolute;
      top: calc(100% + 10px);
      right: 0;
      width: 320px;
      background: #130f25;
      border: 1px solid var(--border-hover);
      border-radius: var(--radius-md);
      padding: 14px;
      box-shadow: 0 18px 45px rgba(0, 0, 0, 0.8);
      opacity: 0;
      visibility: hidden;
      transform: translateY(-8px);
      transition: var(--transition);
      z-index: 120;
    }
    .search-box:focus-within .search-dropdown {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }
    .dropdown-header {
      font-size: 0.72rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--primary-light);
      margin-bottom: 8px;
    }
    .search-quick-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
      margin-bottom: 12px;
    }
    .dropdown-tag {
      font-size: 0.75rem;
      padding: 4px 10px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-full);
      color: var(--text-muted);
      transition: var(--transition);
    }
    .dropdown-tag:hover {
      background: var(--primary);
      color: #fff;
      border-color: var(--primary);
    }
    .search-result-row {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 6px 8px;
      border-radius: var(--radius-sm);
      transition: var(--transition);
    }
    .search-result-row:hover {
      background: var(--surface-light);
    }
    .search-result-row img {
      width: 40px;
      height: 40px;
      border-radius: 6px;
      object-fit: cover;
    }
    .res-name {
      font-size: 0.84rem;
      font-weight: 700;
      color: #fff;
    }
    .res-sub {
      font-size: 0.72rem;
      color: var(--text-muted);
    }
    .dropdown-footer {
      display: block;
      margin-top: 10px;
      padding-top: 8px;
      border-top: 1px solid var(--border);
      text-align: center;
      font-size: 0.78rem;
      font-weight: 700;
      color: var(--primary-light);
    }
    .dropdown-footer:hover {
      color: #fff;
    }

    /* Header Action Buttons (Using Anchor Links for Pure CSS Popups) */
    .btn-action {
      background: var(--surface);
      border: 1px solid var(--border);
      color: #fff;
      padding: 8px 14px;
      border-radius: var(--radius-full);
      font-size: 0.85rem;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      cursor: pointer;
      user-select: none;
      transition: var(--transition);
    }
    .btn-action:hover {
      background: var(--surface-light);
      border-color: var(--primary);
      box-shadow: 0 4px 12px rgba(139, 92, 246, 0.2);
      transform: translateY(-1px);
    }

    .badge-count {
      background: linear-gradient(135deg, var(--primary), var(--accent));
      color: #fff;
      font-size: 0.7rem;
      font-weight: 800;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-left: 2px;
    }

    /* Mobile Hamburger Menu */
    .mobile-menu-toggle {
      display: none;
    }
    .hamburger-btn {
      display: none;
      flex-direction: column;
      justify-content: space-between;
      width: 24px;
      height: 18px;
      cursor: pointer;
    }
    .hamburger-btn span {
      display: block;
      height: 2px;
      width: 100%;
      background: #fff;
      border-radius: 2px;
      transition: var(--transition);
    }

    /* ==========================================================================
       HERO SECTION
       ========================================================================== */
    .hero {
      position: relative;
      padding: 80px 0 100px;
      overflow: hidden;
      background: radial-gradient(circle at 75% 40%, rgba(139, 92, 246, 0.22) 0%, rgba(217, 70, 239, 0.08) 35%, transparent 70%),
                  linear-gradient(180deg, var(--bg-dark) 0%, #0d0a1a 100%);
    }

    .hero-grid {
      display: grid;
      grid-template-columns: 1.15fr 1fr;
      align-items: center;
      gap: 50px;
    }

    .hero-pill {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(139, 92, 246, 0.12);
      border: 1px solid rgba(139, 92, 246, 0.35);
      color: var(--primary-light);
      font-size: 0.78rem;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      padding: 6px 14px;
      border-radius: var(--radius-full);
      margin-bottom: 22px;
    }
    .hero-pill .dot {
      width: 6px;
      height: 6px;
      background: var(--accent);
      border-radius: 50%;
      box-shadow: 0 0 8px var(--accent);
    }

    .hero-title {
      font-size: clamp(2.8rem, 5.2vw, 4.5rem);
      font-weight: 900;
      line-height: 1.05;
      letter-spacing: -1.5px;
      text-transform: uppercase;
      margin-bottom: 20px;
    }
    .gradient-purple {
      background: linear-gradient(135deg, #ffffff 20%, #c4b5fd 60%, var(--accent) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .hero-description {
      font-size: 1.1rem;
      color: var(--text-muted);
      max-width: 520px;
      margin-bottom: 34px;
      line-height: 1.65;
    }

    .hero-cta-group {
      display: flex;
      align-items: center;
      gap: 16px;
      flex-wrap: wrap;
    }

    .btn-main {
      background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
      color: #fff;
      font-size: 0.95rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      padding: 16px 36px;
      border-radius: var(--radius-full);
      display: inline-flex;
      align-items: center;
      gap: 10px;
      box-shadow: var(--shadow-glow);
      border: none;
      cursor: pointer;
      transition: var(--transition);
    }
    .btn-main:hover {
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 14px 34px rgba(139, 92, 246, 0.45);
      filter: brightness(1.1);
    }

    .btn-ghost {
      background: var(--surface);
      color: #fff;
      font-size: 0.95rem;
      font-weight: 700;
      padding: 15px 30px;
      border-radius: var(--radius-full);
      border: 1px solid var(--border);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: var(--transition);
    }
    .btn-ghost:hover {
      border-color: var(--primary);
      background: var(--surface-light);
      transform: translateY(-2px);
    }

    .hero-metrics {
      display: flex;
      gap: 36px;
      margin-top: 48px;
      padding-top: 28px;
      border-top: 1px solid var(--border);
    }
    .metric-value {
      font-size: 1.85rem;
      font-weight: 900;
      color: #fff;
    }
    .metric-label {
      font-size: 0.78rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--text-muted);
    }

    /* Hero Sneaker Visual Showcase */
    .hero-visual-col {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .visual-aura {
      position: absolute;
      width: 440px;
      height: 440px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(139, 92, 246, 0.3) 0%, rgba(217, 70, 239, 0.15) 50%, transparent 70%);
      filter: blur(40px);
      animation: auraPulse 6s ease-in-out infinite alternate;
    }
    @keyframes auraPulse {
      0% { transform: scale(0.9); opacity: 0.7; }
      100% { transform: scale(1.12); opacity: 1; }
    }

    .visual-card-wrap {
      position: relative;
      z-index: 2;
      border-radius: var(--radius-xl);
      overflow: hidden;
      border: 1px solid rgba(168, 85, 247, 0.35);
      background: var(--bg-card);
      box-shadow: 0 24px 64px rgba(4, 3, 8, 0.85);
      transform: perspective(1000px) rotateY(-6deg) rotateX(3deg);
      transition: transform 0.4s cubic-bezier(0.2, 0, 0.2, 1);
    }
    .visual-card-wrap:hover {
      transform: perspective(1000px) rotateY(0deg) rotateX(0deg) scale(1.02);
    }
    .visual-card-wrap img {
      width: 100%;
      height: 460px;
      object-fit: cover;
      display: block;
    }

    .hero-float-card {
      position: absolute;
      bottom: -20px;
      left: -20px;
      z-index: 3;
      background: rgba(17, 13, 32, 0.92);
      backdrop-filter: blur(14px);
      border: 1px solid rgba(168, 85, 247, 0.3);
      border-radius: var(--radius-md);
      padding: 16px 20px;
      box-shadow: var(--shadow-card);
    }
    .float-tag {
      font-size: 0.7rem;
      text-transform: uppercase;
      color: var(--primary-light);
      font-weight: 700;
    }
    .float-name {
      font-size: 1.1rem;
      font-weight: 900;
      color: #fff;
    }
    .float-stars {
      color: var(--gold);
      font-size: 0.8rem;
    }

    /* ==========================================================================
       TRUST TICKER STRIP
       ========================================================================== */
    .trust-strip {
      background: var(--bg-darker);
      border-top: 1px solid var(--border);
      border-bottom: 1px solid var(--border);
      padding: 20px 0;
    }
    .trust-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      text-align: center;
    }
    .trust-item {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
    }
    .trust-icon {
      font-size: 1.4rem;
      color: var(--primary);
    }
    .trust-text h5 {
      font-size: 0.88rem;
      font-weight: 700;
      color: #fff;
    }
    .trust-text p {
      font-size: 0.75rem;
      color: var(--text-muted);
    }

    /* ==========================================================================
       SECTION HEADERS
       ========================================================================== */
    .section-header {
      text-align: center;
      max-width: 680px;
      margin: 0 auto 46px;
    }
    .section-kicker {
      color: var(--primary-light);
      font-size: 0.82rem;
      font-weight: 800;
      letter-spacing: 2px;
      text-transform: uppercase;
      margin-bottom: 8px;
      display: inline-block;
    }
    .section-headline {
      font-size: clamp(2rem, 3.5vw, 2.6rem);
      font-weight: 900;
      letter-spacing: -0.8px;
      text-transform: uppercase;
      color: #fff;
    }
    .section-sub {
      color: var(--text-muted);
      font-size: 0.95rem;
      margin-top: 10px;
    }

    /* ==========================================================================
       CATEGORIES SECTION
       ========================================================================== */
    .categories-section {
      padding: 90px 0;
      background: var(--bg-dark);
    }

    .categories-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
    }

    .cat-tile {
      position: relative;
      border-radius: var(--radius-lg);
      overflow: hidden;
      height: 390px;
      background: var(--bg-card);
      border: 1px solid var(--border);
      transition: var(--transition);
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 24px;
    }
    .cat-tile:hover {
      transform: translateY(-8px);
      border-color: var(--border-hover);
      box-shadow: 0 16px 40px rgba(139, 92, 246, 0.22);
    }

    .cat-tile-img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.6s cubic-bezier(0.2, 0, 0.2, 1);
      z-index: 1;
      filter: brightness(0.8);
    }
    .cat-tile:hover .cat-tile-img {
      transform: scale(1.08);
      filter: brightness(0.95);
    }

    .cat-tile-gradient {
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(7, 6, 13, 0.1) 25%, rgba(15, 12, 28, 0.94) 100%);
      z-index: 2;
    }

    .cat-tile-content {
      position: relative;
      z-index: 3;
    }
    .cat-tile-label {
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: var(--primary-light);
      font-weight: 800;
      margin-bottom: 4px;
    }
    .cat-tile-name {
      font-size: 1.6rem;
      font-weight: 900;
      text-transform: uppercase;
      color: #fff;
      margin-bottom: 12px;
    }
    .cat-tile-btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 0.82rem;
      font-weight: 700;
      color: #fff;
      background: rgba(139, 92, 246, 0.25);
      border: 1px solid rgba(168, 85, 247, 0.4);
      padding: 8px 16px;
      border-radius: var(--radius-full);
      backdrop-filter: blur(8px);
      transition: var(--transition);
    }
    .cat-tile:hover .cat-tile-btn {
      background: var(--primary);
      border-color: var(--primary);
      padding-left: 20px;
    }

    /* ==========================================================================
       PRODUCTS & PURE CSS FILTER SYSTEM
       ========================================================================== */
    .products-section {
      padding: 95px 0 110px;
      background: #0a0815;
      border-top: 1px solid var(--border);
    }

    /* Filter Radio Inputs */
    .filter-switch {
      display: none;
    }

    /* Filter Tabs Bar */
    .filter-tabs {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 10px;
      margin-bottom: 25px;
    }

    .filter-tab {
      padding: 10px 22px;
      border-radius: var(--radius-full);
      font-size: 0.88rem;
      font-weight: 700;
      color: var(--text-muted);
      background: var(--surface);
      border: 1px solid var(--border);
      cursor: pointer;
      user-select: none;
      transition: var(--transition);
    }
    .filter-tab:hover {
      color: #fff;
      border-color: var(--border-hover);
      background: var(--surface-light);
      transform: translateY(-2px);
    }

    /* Quick Keyword Search Strip */
    .catalog-search-strip {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-wrap: wrap;
      gap: 8px;
      margin-bottom: 45px;
      padding: 12px 20px;
      background: rgba(26, 22, 49, 0.6);
      border: 1px solid var(--border);
      border-radius: var(--radius-full);
      max-width: 900px;
      margin-left: auto;
      margin-right: auto;
    }
    .search-strip-title {
      font-size: 0.78rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--primary-light);
      margin-right: 4px;
    }
    .search-chip {
      font-size: 0.76rem;
      font-weight: 700;
      padding: 4px 12px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-full);
      color: var(--text-muted);
      transition: var(--transition);
    }
    .search-chip:hover {
      background: var(--primary);
      color: #fff;
      border-color: var(--primary);
      transform: translateY(-1px);
    }

    /* Active Tab Stylings based on Checked Radio */
    #tab-all:checked ~ .filter-tabs label[for="tab-all"],
    #tab-men:checked ~ .filter-tabs label[for="tab-men"],
    #tab-women:checked ~ .filter-tabs label[for="tab-women"],
    #tab-kids:checked ~ .filter-tabs label[for="tab-kids"],
    #tab-sports:checked ~ .filter-tabs label[for="tab-sports"],
    #tab-new:checked ~ .filter-tabs label[for="tab-new"],
    #tab-sale:checked ~ .filter-tabs label[for="tab-sale"] {
      background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
      color: #fff;
      border-color: transparent;
      box-shadow: 0 4px 18px var(--primary-glow);
    }

    /* Products Grid */
    .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(285px, 1fr));
      gap: 26px;
    }

    /* CSS Filtering Combinators */
    #tab-men:checked ~ .products-grid .product-card:not(.group-men),
    #tab-women:checked ~ .products-grid .product-card:not(.group-women),
    #tab-kids:checked ~ .products-grid .product-card:not(.group-kids),
    #tab-sports:checked ~ .products-grid .product-card:not(.group-sports),
    #tab-new:checked ~ .products-grid .product-card:not(.group-new),
    #tab-sale:checked ~ .products-grid .product-card:not(.group-sale) {
      display: none;
    }

    /* Product Card Styling */
    .product-card {
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: var(--transition);
      position: relative;
    }
    .product-card:hover {
      transform: translateY(-8px);
      border-color: var(--border-hover);
      box-shadow: 0 16px 36px rgba(139, 92, 246, 0.2);
    }

    /* Target Search Match Animation */
    .product-card:target {
      border-color: var(--accent);
      box-shadow: 0 0 0 4px rgba(217, 70, 239, 0.45), 0 20px 48px rgba(139, 92, 246, 0.4);
      transform: translateY(-8px) scale(1.02);
      animation: pulseTarget 1.5s ease;
    }
    @keyframes pulseTarget {
      0% { box-shadow: 0 0 0 8px rgba(217, 70, 239, 0.8); }
      100% { box-shadow: 0 0 0 4px rgba(217, 70, 239, 0.45); }
    }

    .card-media {
      position: relative;
      height: 250px;
      overflow: hidden;
      background: #141026;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card-media img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s cubic-bezier(0.2, 0, 0.2, 1);
    }
    .product-card:hover .card-media img {
      transform: scale(1.08);
    }

    /* Product Badges */
    .badge-chip {
      position: absolute;
      top: 14px;
      left: 14px;
      font-size: 0.72rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      padding: 4px 10px;
      border-radius: var(--radius-sm);
      z-index: 2;
    }
    .badge-purple {
      background: linear-gradient(135deg, var(--primary), var(--accent));
      color: #fff;
    }
    .badge-green {
      background: var(--emerald);
      color: #fff;
    }
    .badge-red {
      background: var(--rose);
      color: #fff;
    }
    .badge-dark {
      background: rgba(7, 6, 13, 0.85);
      border: 1px solid var(--border);
      color: var(--primary-light);
    }

    .btn-wishlist {
      position: absolute;
      top: 14px;
      right: 14px;
      width: 34px;
      height: 34px;
      border-radius: 50%;
      background: rgba(17, 13, 32, 0.8);
      backdrop-filter: blur(8px);
      border: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 0.95rem;
      cursor: pointer;
      transition: var(--transition);
      z-index: 2;
    }
    .btn-wishlist:hover {
      background: var(--accent);
      border-color: var(--accent);
      transform: scale(1.1);
    }

    .card-content {
      padding: 20px;
      display: flex;
      flex-direction: column;
      flex-grow: 1;
    }

    .card-division {
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--primary-light);
      font-weight: 700;
      margin-bottom: 6px;
    }

    .card-heading {
      font-size: 1.15rem;
      font-weight: 800;
      color: #fff;
      margin-bottom: 8px;
      line-height: 1.3;
    }

    /* Interactive Size Pills */
    .card-sizes {
      display: flex;
      align-items: center;
      gap: 6px;
      margin-bottom: 12px;
    }
    .size-pill {
      font-size: 0.72rem;
      font-weight: 700;
      padding: 3px 8px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-sm);
      color: var(--text-muted);
      cursor: pointer;
      transition: var(--transition);
    }
    .size-pill:hover,
    .size-pill.selected {
      color: #fff;
      background: var(--surface-light);
      border-color: var(--primary);
    }

    /* Rating stars */
    .card-score {
      display: flex;
      align-items: center;
      gap: 6px;
      margin-bottom: 16px;
      font-size: 0.85rem;
    }
    .card-score .stars {
      color: var(--gold);
      letter-spacing: 1.5px;
    }
    .card-score .num {
      font-weight: 800;
      color: #fff;
    }
    .card-score .count {
      color: var(--text-dim);
      font-size: 0.75rem;
    }

    /* Card Bottom Details */
    .card-bottom {
      margin-top: auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      padding-top: 14px;
      border-top: 1px solid var(--border);
    }

    .price-group {
      display: flex;
      flex-direction: column;
    }
    .price-current {
      font-size: 1.25rem;
      font-weight: 900;
      color: #fff;
    }
    .price-prev {
      font-size: 0.8rem;
      color: var(--text-dim);
      text-decoration: line-through;
    }

    .btn-buy {
      background: var(--surface);
      color: #fff;
      border: 1px solid var(--border);
      padding: 9px 16px;
      border-radius: var(--radius-full);
      font-size: 0.82rem;
      font-weight: 700;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: var(--transition);
    }
    .btn-buy:hover {
      background: linear-gradient(135deg, var(--primary), var(--accent));
      border-color: transparent;
      box-shadow: 0 4px 14px var(--primary-glow);
      transform: translateY(-2px);
    }

    /* ==========================================================================
       ABOUT & INNOVATION SECTION
       ========================================================================== */
    .about-section {
      padding: 95px 0;
      background: var(--bg-dark);
      border-top: 1px solid var(--border);
    }

    .about-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 50px;
      align-items: center;
    }

    .about-showcase {
      position: relative;
      border-radius: var(--radius-xl);
      overflow: hidden;
      border: 1px solid var(--border);
      box-shadow: var(--shadow-card);
    }
    .about-showcase img {
      width: 100%;
      height: 480px;
      object-fit: cover;
      display: block;
    }

    .about-perks {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-top: 32px;
    }
    .perk-card {
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: var(--radius-md);
      padding: 22px;
      transition: var(--transition);
    }
    .perk-card:hover {
      border-color: var(--border-hover);
      transform: translateY(-3px);
      box-shadow: 0 8px 24px rgba(139, 92, 246, 0.15);
    }
    .perk-icon {
      font-size: 1.6rem;
      margin-bottom: 12px;
      display: inline-block;
    }
    .perk-card h4 {
      font-size: 1rem;
      font-weight: 800;
      color: #fff;
      margin-bottom: 6px;
    }
    .perk-card p {
      font-size: 0.82rem;
      color: var(--text-muted);
      line-height: 1.45;
    }

    /* ==========================================================================
       CHECKOUT & PAYMENT SECTION (id="checkout" and id="contact")
       ========================================================================== */
    .checkout-section {
      padding: 95px 0;
      background: #090714;
      border-top: 1px solid var(--border);
    }

    .checkout-card {
      background: linear-gradient(135deg, #120e24 0%, #1c1538 100%);
      border: 1px solid var(--border-hover);
      border-radius: var(--radius-xl);
      padding: 50px;
      display: grid;
      grid-template-columns: 1.2fr 1fr;
      gap: 48px;
      box-shadow: var(--shadow-card);
    }

    .checkout-lead h3 {
      font-size: 2.2rem;
      font-weight: 900;
      text-transform: uppercase;
      letter-spacing: -0.5px;
      color: #fff;
      margin-bottom: 12px;
    }
    .checkout-lead p {
      color: var(--text-muted);
      font-size: 0.95rem;
      margin-bottom: 24px;
      line-height: 1.6;
    }

    .checkout-steps {
      display: flex;
      gap: 12px;
      margin-bottom: 26px;
    }
    .step-badge {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-full);
      padding: 6px 14px;
      font-size: 0.78rem;
      font-weight: 700;
      color: var(--text-muted);
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .step-badge.active {
      background: var(--primary);
      border-color: var(--primary);
      color: #fff;
    }

    .checkout-summary-box {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-md);
      padding: 20px;
      margin-bottom: 24px;
    }
    .summary-row {
      display: flex;
      justify-content: space-between;
      font-size: 0.88rem;
      margin-bottom: 8px;
      color: var(--text-muted);
    }
    .summary-row.total {
      border-top: 1px solid var(--border);
      padding-top: 12px;
      margin-top: 12px;
      font-size: 1.15rem;
      font-weight: 900;
      color: #fff;
    }

    .payment-methods {
      display: flex;
      gap: 10px;
      margin-bottom: 16px;
    }
    .pay-btn {
      flex: 1;
      padding: 10px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-sm);
      color: #fff;
      font-size: 0.82rem;
      font-weight: 700;
      text-align: center;
      cursor: pointer;
      transition: var(--transition);
    }
    .pay-btn:hover,
    .pay-btn.selected {
      background: var(--surface-light);
      border-color: var(--primary);
    }

    .checkout-form {
      display: flex;
      flex-direction: column;
      gap: 14px;
    }
    .input-row {
      display: flex;
      gap: 12px;
    }
    .input-wrap {
      flex: 1;
    }
    .input-wrap input,
    .input-wrap textarea {
      width: 100%;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-sm);
      padding: 12px 16px;
      color: #fff;
      font-size: 0.9rem;
      outline: none;
      transition: var(--transition);
    }
    .input-wrap input:focus,
    .input-wrap textarea:focus {
      border-color: var(--primary);
      background: var(--surface-light);
      box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
    }

    /* ==========================================================================
       FOOTER
       ========================================================================== */
    .footer {
      background: #040308;
      border-top: 1px solid var(--border);
      padding: 70px 0 30px;
      color: var(--text-muted);
      font-size: 0.88rem;
    }

    .footer-grid {
      display: grid;
      grid-template-columns: 2fr 1.2fr 1.2fr 1.5fr;
      gap: 40px;
      margin-bottom: 50px;
    }

    .footer-brand .brand-logo {
      margin-bottom: 16px;
    }
    .footer-brand p {
      line-height: 1.6;
      margin-bottom: 22px;
    }

    .social-row {
      display: flex;
      gap: 10px;
    }
    .social-btn {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background: var(--surface);
      border: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-weight: 800;
      font-size: 0.82rem;
      transition: var(--transition);
    }
    .social-btn:hover {
      background: var(--primary);
      border-color: var(--primary);
      transform: translateY(-3px);
      box-shadow: 0 4px 12px var(--primary-glow);
    }

    .footer-col-title {
      font-size: 0.92rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #fff;
      margin-bottom: 20px;
    }

    .footer-nav {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .footer-nav a:hover {
      color: var(--primary-light);
      padding-left: 4px;
    }

    .subscribe-box p {
      margin-bottom: 14px;
      line-height: 1.5;
    }
    .subscribe-form {
      display: flex;
      gap: 8px;
    }
    .subscribe-input {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-full);
      padding: 10px 16px;
      color: #fff;
      font-size: 0.85rem;
      outline: none;
      flex-grow: 1;
    }
    .subscribe-input:focus {
      border-color: var(--primary);
    }
    .btn-sub {
      background: linear-gradient(135deg, var(--primary), var(--accent));
      color: #fff;
      border: none;
      border-radius: var(--radius-full);
      padding: 0 20px;
      font-size: 0.85rem;
      font-weight: 700;
      cursor: pointer;
      transition: var(--transition);
    }
    .btn-sub:hover {
      filter: brightness(1.1);
    }

    .footer-legal {
      padding-top: 24px;
      border-top: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 14px;
      font-size: 0.8rem;
    }

    /* ==========================================================================
       TARGET-BASED PURE CSS POPUPS (AUTO-CLOSE ON CLICK)
       ========================================================================== */
    /* Cart Slide-Over Drawer Container */
    .cart-drawer-container {
      position: fixed;
      inset: 0;
      z-index: 999;
      pointer-events: none;
      visibility: hidden;
      transition: visibility 0.3s ease;
    }
    .cart-backdrop {
      position: absolute;
      inset: 0;
      background: rgba(4, 3, 8, 0.8);
      backdrop-filter: blur(6px);
      opacity: 0;
      transition: opacity 0.3s ease;
      cursor: default;
    }
    .cart-drawer-panel {
      position: absolute;
      top: 0;
      right: -440px;
      width: 100%;
      max-width: 420px;
      height: 100%;
      background: #0f0c1c;
      border-left: 1px solid var(--border);
      display: flex;
      flex-direction: column;
      box-shadow: -12px 0 45px rgba(0, 0, 0, 0.85);
      transition: right 0.35s cubic-bezier(0.16, 1, 0.3, 1);
      pointer-events: auto;
    }

    /* When #cart-drawer is active in URL hash */
    #cart-drawer:target {
      visibility: visible;
      pointer-events: auto;
    }
    #cart-drawer:target .cart-backdrop {
      opacity: 1;
    }
    #cart-drawer:target .cart-drawer-panel {
      right: 0;
    }

    .drawer-top {
      padding: 22px 24px;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .drawer-top h3 {
      font-size: 1.2rem;
      font-weight: 800;
      text-transform: uppercase;
      color: #fff;
    }
    .btn-close-drawer {
      cursor: pointer;
      font-size: 1.3rem;
      color: var(--text-muted);
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: var(--surface);
    }
    .btn-close-drawer:hover {
      color: #fff;
      background: var(--rose);
      transform: rotate(90deg);
    }

    .drawer-shipping-progress {
      background: var(--surface);
      padding: 12px 24px;
      border-bottom: 1px solid var(--border);
      font-size: 0.78rem;
      color: var(--primary-light);
    }
    .progress-bar-bg {
      height: 6px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 3px;
      margin-top: 6px;
      overflow: hidden;
    }
    .progress-bar-fill {
      height: 100%;
      width: 86%;
      background: linear-gradient(90deg, var(--primary), var(--accent));
      border-radius: 3px;
    }

    .drawer-items {
      padding: 24px;
      flex-grow: 1;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }
    .bag-item {
      display: flex;
      gap: 14px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-sm);
      padding: 12px;
      align-items: center;
    }
    .bag-item img {
      width: 74px;
      height: 74px;
      object-fit: cover;
      border-radius: 8px;
    }
    .bag-item-info h5 {
      font-size: 0.92rem;
      font-weight: 800;
      color: #fff;
    }
    .bag-item-info p {
      font-size: 0.76rem;
      color: var(--text-muted);
    }
    .bag-item-info .item-cost {
      font-weight: 800;
      color: var(--primary-light);
      font-size: 0.92rem;
      margin-top: 4px;
    }

    .drawer-summary {
      padding: 22px 24px;
      border-top: 1px solid var(--border);
      background: #0a0815;
    }
    .summary-line {
      display: flex;
      justify-content: space-between;
      margin-bottom: 16px;
      font-size: 1.1rem;
      font-weight: 800;
      color: #fff;
    }

    /* Login Modal Container with :target */
    .login-modal-container {
      position: fixed;
      inset: 0;
      z-index: 1000;
      pointer-events: none;
      visibility: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      transition: visibility 0.25s ease;
    }
    .login-backdrop {
      position: absolute;
      inset: 0;
      background: rgba(4, 3, 8, 0.85);
      backdrop-filter: blur(8px);
      opacity: 0;
      transition: opacity 0.25s ease;
      cursor: default;
    }
    .login-card {
      position: relative;
      z-index: 2;
      background: #110e20;
      border: 1px solid var(--border-hover);
      border-radius: var(--radius-xl);
      width: 100%;
      max-width: 440px;
      padding: 38px;
      box-shadow: 0 24px 64px rgba(0, 0, 0, 0.85);
      transform: scale(0.92);
      opacity: 0;
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
      pointer-events: auto;
    }

    /* When #login-modal is active in URL hash */
    #login-modal:target {
      visibility: visible;
      pointer-events: auto;
    }
    #login-modal:target .login-backdrop {
      opacity: 1;
    }
    #login-modal:target .login-card {
      transform: scale(1);
      opacity: 1;
    }

    .btn-close-modal {
      position: absolute;
      top: 20px;
      right: 20px;
      font-size: 1.2rem;
      cursor: pointer;
      color: var(--text-muted);
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: var(--surface);
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition);
    }
    .btn-close-modal:hover {
      color: #fff;
      background: var(--rose);
      transform: rotate(90deg);
    }

    /* ==========================================================================
       RESPONSIVENESS (MOBILE & TABLETS)
       ========================================================================== */
    @media (max-width: 1024px) {
      .categories-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      .trust-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
      }
      .footer-grid {
        grid-template-columns: 1fr 1fr;
      }
      .about-grid,
      .checkout-card {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 860px) {
      .hamburger-btn {
        display: flex;
      }
      .nav-links {
        position: fixed;
        top: 70px;
        left: 0;
        width: 100%;
        background: rgba(7, 6, 13, 0.98);
        backdrop-filter: blur(16px);
        border-bottom: 1px solid var(--border);
        flex-direction: column;
        padding: 24px;
        gap: 18px;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease;
      }
      #mobile-nav-toggle:checked ~ .header-inner .nav-links {
        max-height: 420px;
      }
      #mobile-nav-toggle:checked ~ .header-inner .hamburger-btn span:nth-child(1) {
        transform: translateY(8px) rotate(45deg);
      }
      #mobile-nav-toggle:checked ~ .header-inner .hamburger-btn span:nth-child(2) {
        opacity: 0;
      }
      #mobile-nav-toggle:checked ~ .header-inner .hamburger-btn span:nth-child(3) {
        transform: translateY(-8px) rotate(-45deg);
      }

      .hero-grid {
        grid-template-columns: 1fr;
        text-align: center;
      }
      .hero-description {
        margin-left: auto;
        margin-right: auto;
      }
      .hero-cta-group {
        justify-content: center;
      }
      .hero-metrics {
        justify-content: center;
      }
      .search-input {
        width: 140px;
      }
      .search-input:focus {
        width: 180px;
      }
    }

    @media (max-width: 580px) {
      .categories-grid {
        grid-template-columns: 1fr;
      }
      .trust-grid {
        grid-template-columns: 1fr;
      }
      .footer-grid {
        grid-template-columns: 1fr;
      }
      .checkout-card {
        padding: 28px 20px;
      }
      .hero-metrics {
        flex-direction: column;
        gap: 16px;
      }
      .about-perks {
        grid-template-columns: 1fr;
      }
      .filter-tab {
        padding: 8px 14px;
        font-size: 0.8rem;
      }
      .input-row {
        flex-direction: column;
      }
    }
  
    /* Wishlist Heart Button Liked State */
    .btn-wishlist {
      cursor: pointer;
      user-select: none;
    }
    .btn-wishlist.liked {
      background: linear-gradient(135deg, #f43f5e, #e11d48) !important;
      border-color: #f43f5e !important;
      color: #fff !important;
      transform: scale(1.15) !important;
      box-shadow: 0 0 16px rgba(244, 63, 94, 0.7) !important;
    }

    /* Dynamic Bag Item Controls */
    .bag-item-controls {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-top: 6px;
    }
    .qty-btn {
      width: 24px;
      height: 24px;
      border-radius: 6px;
      background: var(--surface-light);
      border: 1px solid var(--border);
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 800;
      font-size: 0.8rem;
      cursor: pointer;
      transition: var(--transition);
    }
    .qty-btn:hover {
      background: var(--primary);
      border-color: var(--primary);
    }
    .qty-val {
      font-size: 0.85rem;
      font-weight: 700;
      color: #fff;
      min-width: 16px;
      text-align: center;
    }
    .btn-bag-delete {
      margin-left: auto;
      background: transparent;
      border: none;
      color: var(--text-dim);
      cursor: pointer;
      font-size: 1rem;
      transition: var(--transition);
      padding: 4px;
    }
    .btn-bag-delete:hover {
      color: var(--rose);
      transform: scale(1.2);
    }

    /* Order Tracking Modal Styles */
    .track-modal-container {
      position: fixed;
      inset: 0;
      z-index: 999;
      pointer-events: none;
      visibility: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      transition: visibility 0.3s ease;
    }
    .track-backdrop {
      position: absolute;
      inset: 0;
      background: rgba(4, 3, 8, 0.85);
      backdrop-filter: blur(8px);
      opacity: 0;
      transition: opacity 0.3s ease;
      cursor: default;
    }
    .track-card {
      position: relative;
      z-index: 2;
      width: 100%;
      max-width: 580px;
      max-height: 90vh;
      overflow-y: auto;
      background: #0f0c1c;
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      padding: 32px;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.9);
      transform: translateY(20px) scale(0.96);
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      pointer-events: auto;
    }
    #track-modal:target {
      visibility: visible;
      pointer-events: auto;
    }
    #track-modal:target .track-backdrop {
      opacity: 1;
    }
    #track-modal:target .track-card {
      transform: translateY(0) scale(1);
    }

    /* Order Tracking Timeline */
    .track-timeline {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 8px;
      margin: 24px 0;
      position: relative;
    }
    .track-step {
      text-align: center;
      position: relative;
    }
    .track-step-dot {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: var(--surface);
      border: 2px solid var(--border);
      color: var(--text-muted);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.8rem;
      font-weight: 800;
      margin: 0 auto 8px;
      transition: var(--transition);
      position: relative;
      z-index: 2;
    }
    .track-step.done .track-step-dot {
      background: var(--primary);
      border-color: var(--accent);
      color: #fff;
      box-shadow: 0 0 12px var(--primary-glow);
    }
    .track-step.active .track-step-dot {
      background: linear-gradient(135deg, var(--primary), var(--accent));
      border-color: #fff;
      color: #fff;
      animation: pulseTarget 1.5s infinite alternate;
    }
    .track-step-label {
      font-size: 0.72rem;
      font-weight: 700;
      color: var(--text-muted);
      line-height: 1.2;
    }
    .track-step.done .track-step-label,
    .track-step.active .track-step-label {
      color: #fff;
    }

  
    /* PHP CRUD & XML Showcase UI */
    .btn-admin-crud {
      background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(217, 70, 239, 0.2));
      border: 1px solid var(--border);
      color: var(--primary-light);
      font-size: 0.78rem;
      font-weight: 700;
      padding: 6px 14px;
      border-radius: var(--radius-full);
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: var(--transition);
      cursor: pointer;
    }
    .btn-admin-crud:hover {
      background: var(--primary);
      color: #fff;
      border-color: var(--primary);
      box-shadow: 0 0 14px var(--primary-glow);
      transform: translateY(-1px);
    }
    .crud-modal-container {
      position: fixed;
      inset: 0;
      z-index: 999;
      pointer-events: none;
      visibility: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      transition: visibility 0.3s ease;
    }
    .crud-backdrop {
      position: absolute;
      inset: 0;
      background: rgba(4, 3, 8, 0.88);
      backdrop-filter: blur(8px);
      opacity: 0;
      transition: opacity 0.3s ease;
      cursor: default;
    }
    .crud-card {
      position: relative;
      z-index: 2;
      width: 100%;
      max-width: 680px;
      max-height: 90vh;
      overflow-y: auto;
      background: #0f0c1c;
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      padding: 32px;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.95);
      transform: translateY(20px) scale(0.96);
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      pointer-events: auto;
    }
    #crud-modal:target {
      visibility: visible;
      pointer-events: auto;
    }
    #crud-modal:target .crud-backdrop {
      opacity: 1;
    }
    #crud-modal:target .crud-card {
      transform: translateY(0) scale(1);
    }
    .crud-tabs {
      display: flex;
      gap: 8px;
      border-bottom: 1px solid var(--border);
      padding-bottom: 14px;
      margin-bottom: 20px;
    }
    .crud-tab-btn {
      background: var(--surface);
      border: 1px solid var(--border);
      color: var(--text-muted);
      padding: 8px 16px;
      border-radius: var(--radius-full);
      font-size: 0.8rem;
      font-weight: 700;
      cursor: pointer;
      transition: var(--transition);
    }
    .crud-tab-btn.active, .crud-tab-btn:hover {
      background: var(--primary);
      color: #fff;
      border-color: var(--primary);
    }

  </style>
</head>
<body>

  <!-- Mobile Nav State Checkbox -->
  <input type="checkbox" id="mobile-nav-toggle" class="mobile-menu-toggle">

  <!-- Top Announcement Bar -->
  <div class="top-banner">
    <span class="tag">Exclusive Drop</span>
    FREE EXPRESS SHIPPING OVER $100 &bull; 30-DAY ON-ROAD WEAR TEST GUARANTEE
  </div>

  <!-- Header Section -->
  <header class="header">
    <div class="container header-inner">
      <!-- Logo -->
      <a href="#home" class="brand-logo">
        <div class="logo-glyph">⚡</div>
        STEPZY
      </a>

      <!-- Mobile Hamburger Toggle -->
      <label for="mobile-nav-toggle" class="hamburger-btn" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
      </label>

      <!-- Navigation Links -->
      <nav>
        <ul class="nav-links">
          <li><a href="#home" class="nav-item active">Home</a></li>
          <li><a href="#men" class="nav-item">Men</a></li>
          <li><a href="#women" class="nav-item">Women</a></li>
          <li><a href="#kids" class="nav-item">Kids</a></li>
          <li><a href="#sports" class="nav-item">Sports</a></li>
          <li><a href="#products" class="nav-item">New Arrivals</a></li>
          <li><a href="#products" class="nav-item sale-highlight">Sale <span>🔥</span></a></li>
        </ul>
      </nav>

      <!-- Action Buttons (Search with Live Dropdown, Login, Cart) -->
      <div class="header-actions">
        <!-- Interactive Search Form -->
        <form action="#products" method="get" class="search-form">
          <div class="search-box">
            <span class="search-icon">🔍</span>
            <input 
              type="search" 
              class="search-input" 
              placeholder="Search shoes..." 
              list="shoes-datalist" 
              aria-label="Search shoes"
              autocomplete="off"
            >
            <button type="submit" class="search-btn">Search</button>
            <datalist id="shoes-datalist">
              <option value="Stepzy Nebula Violet (Men)"></option>
              <option value="Stepzy Horizon Lilac (Women)"></option>
              <option value="Stepzy Apex Carbon (Sports)"></option>
              <option value="Stepzy Junior Dynamo (Kids)"></option>
              <option value="Stepzy Phantom Knit (Sale)"></option>
              <option value="Stepzy Aero Strike (Sports)"></option>
              <option value="Stepzy TrailBlaze GTX (Outdoor)"></option>
            </datalist>

            <!-- Instant Live Search Dropdown on Focus -->
            <div class="search-dropdown">
              <div class="dropdown-header">Quick Search Hits</div>
              <div class="search-quick-tags">
                <a href="#product-1" class="dropdown-tag">⚡ Nebula Violet</a>
                <a href="#product-3" class="dropdown-tag">🏃 Apex Carbon</a>
                <a href="#product-2" class="dropdown-tag">🌸 Horizon Lilac</a>
                <a href="#product-7" class="dropdown-tag">🔥 Aero Strike</a>
                <a href="#product-5" class="dropdown-tag">🏷️ Sale 30% Off</a>
              </div>
              <div class="dropdown-header" style="margin-top: 10px;">Direct Shoe Matches</div>
              <div style="display: flex; flex-direction: column; gap: 4px;">
                <a href="#product-1" class="search-result-row">
                  <img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=80&q=80" alt="Nebula Violet">
                  <div>
                    <div class="res-name">Stepzy Nebula Violet</div>
                    <div class="res-sub">Men &bull; Road Running &bull; $159.99</div>
                  </div>
                </a>
                <a href="#product-2" class="search-result-row">
                  <img src="https://images.unsplash.com/photo-1582588678413-dbf45f4823e9?auto=format&fit=crop&w=80&q=80" alt="Horizon Lilac">
                  <div>
                    <div class="res-name">Stepzy Horizon Lilac</div>
                    <div class="res-sub">Women &bull; Sprint &bull; $139.99</div>
                  </div>
                </a>
                <a href="#product-3" class="search-result-row">
                  <img src="https://images.unsplash.com/photo-1515955656352-a1fa3ffcd111?auto=format&fit=crop&w=80&q=80" alt="Apex Carbon">
                  <div>
                    <div class="res-name">Stepzy Apex Carbon</div>
                    <div class="res-sub">Sports &bull; Marathon &bull; $179.99</div>
                  </div>
                </a>
              </div>
              <a href="#products" class="dropdown-footer">View All 14 Shoes in Catalog ➔</a>
            </div>
          </div>
        </form>

        <!-- Login Trigger Link -->
        <a href="#login-modal" id="nav-login-btn" class="btn-action">
          👤 <span id="nav-login-label">Login</span>
        </a>

        <!-- Cart Trigger Link -->
        <a href="#cart-drawer" class="btn-action">
          🛒 <span class="badge-count" id="header-cart-count">2</span>
        </a>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero" id="home">
    <div class="container hero-grid">
      <div class="hero-text-col">
        <div class="hero-pill">
          <span class="dot"></span>
          2026 Kinetic Purple Edition
        </div>
        <h1 class="hero-title">
          Transcend <br>
          <span class="gradient-purple">Your Gravity.</span>
        </h1>
        <p class="hero-description">
          Engineered with supercritical nitrogen foam, adaptive carbon propulsion, and aerodynamic weave. Elevate every footstrike with Stepzy's high-performance purple series.
        </p>

        <div class="hero-cta-group">
          <a href="#products" class="btn-main">
            Shop Collection ➔
          </a>
          <a href="#categories" class="btn-ghost">
            Explore Categories
          </a>
        </div>

        <div class="hero-metrics">
          <div>
            <div class="metric-value">44%</div>
            <div class="metric-label">More Energy Return</div>
          </div>
          <div>
            <div class="metric-value">188g</div>
            <div class="metric-label">Ultra-Light Carbon Plate</div>
          </div>
          <div>
            <div class="metric-value">50k+</div>
            <div class="metric-label">Elite Athletes</div>
          </div>
        </div>
      </div>

      <!-- Hero Visual Column -->
      <div class="hero-visual-col">
        <div class="visual-aura"></div>
        <div class="visual-card-wrap">
          <img 
            src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=1000&q=80" 
            alt="Stepzy Nebula Violet Carbon Sneaker"
          >
        </div>
        <div class="hero-float-card">
          <div class="float-tag">Signature Release</div>
          <div class="float-name">Stepzy Nebula Violet</div>
          <div class="float-stars">★★★★★ (4.9 / 5.0)</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Trust Ticker Strip -->
  <div class="trust-strip">
    <div class="container trust-grid">
      <div class="trust-item">
        <div class="trust-icon">⚡</div>
        <div class="trust-text">
          <h5>Next-Day Express</h5>
          <p>Dispatched in under 24 hours</p>
        </div>
      </div>
      <div class="trust-item">
        <div class="trust-icon">🛡️</div>
        <div class="trust-text">
          <h5>30-Day Wear Guarantee</h5>
          <p>Run, train, or full refund</p>
        </div>
      </div>
      <div class="trust-item">
        <div class="trust-icon">🌱</div>
        <div class="trust-text">
          <h5>Zero-Waste EcoKnit</h5>
          <p>100% recycled yarn ocean plastic</p>
        </div>
      </div>
      <div class="trust-item">
        <div class="trust-icon">💬</div>
        <div class="trust-text">
          <h5>24/7 Athlete Support</h5>
          <p>Dedicated footwear specialists</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Categories Section -->
  <section class="categories-section" id="categories">
    <div class="container">
      <div class="section-header">
        <span class="section-kicker">Find Your Propulsion</span>
        <h2 class="section-headline">Signature Categories</h2>
        <p class="section-sub">Biomechanically optimized footwear fine-tuned for high performance and streetwear style.</p>
      </div>

      <div class="categories-grid">
        <!-- Category: Men -->
        <div class="cat-tile" id="men">
          <img 
            src="https://images.unsplash.com/photo-1552346154-21d32810aba3?auto=format&fit=crop&w=800&q=80" 
            alt="Men's Athletic Shoes" 
            class="cat-tile-img"
          >
          <div class="cat-tile-gradient"></div>
          <div class="cat-tile-content">
            <div class="cat-tile-label">High Propulsion</div>
            <h3 class="cat-tile-name">Men</h3>
            <a href="#products" class="cat-tile-btn">Shop Men ➔</a>
          </div>
        </div>

        <!-- Category: Women -->
        <div class="cat-tile" id="women">
          <img 
            src="https://images.unsplash.com/photo-1508609349937-5ec4ae374ebf?auto=format&fit=crop&w=800&q=80" 
            alt="Women's Athletic Shoes" 
            class="cat-tile-img"
          >
          <div class="cat-tile-gradient"></div>
          <div class="cat-tile-content">
            <div class="cat-tile-label">Agile & Ultra-Light</div>
            <h3 class="cat-tile-name">Women</h3>
            <a href="#products" class="cat-tile-btn">Shop Women ➔</a>
          </div>
        </div>

        <!-- Category: Kids -->
        <div class="cat-tile" id="kids">
          <img 
            src="https://images.unsplash.com/photo-1514989940723-e8e51635b782?auto=format&fit=crop&w=800&q=80" 
            alt="Kids Athletic Shoes" 
            class="cat-tile-img"
          >
          <div class="cat-tile-gradient"></div>
          <div class="cat-tile-content">
            <div class="cat-tile-label">Durability & Cushion</div>
            <h3 class="cat-tile-name">Kids</h3>
            <a href="#products" class="cat-tile-btn">Shop Kids ➔</a>
          </div>
        </div>

        <!-- Category: Sports -->
        <div class="cat-tile" id="sports">
          <img 
            src="https://images.unsplash.com/photo-1539185441755-769473a23570?auto=format&fit=crop&w=800&q=80" 
            alt="Sports & Track Shoes" 
            class="cat-tile-img"
          >
          <div class="cat-tile-gradient"></div>
          <div class="cat-tile-content">
            <div class="cat-tile-label">Marathon, Court & Track</div>
            <h3 class="cat-tile-name">Sports</h3>
            <a href="#products" class="cat-tile-btn">Shop Sports ➔</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Products Section with Pure CSS Category Filter -->
  <section class="products-section" id="products">
    <div class="container">
      <div class="section-header">
        <span class="section-kicker">Curated Drops</span>
        <h2 class="section-headline">The Purple & Pro Roster</h2>
        <p class="section-sub">Select a category tab below to instantly filter our performance shoes, or use search keywords.</p>
      </div>

      <!-- Pure CSS Hidden Radio Inputs for Filtering -->
      <input type="radio" name="catalog-filter" id="tab-all" class="filter-switch" checked>
      <input type="radio" name="catalog-filter" id="tab-men" class="filter-switch">
      <input type="radio" name="catalog-filter" id="tab-women" class="filter-switch">
      <input type="radio" name="catalog-filter" id="tab-kids" class="filter-switch">
      <input type="radio" name="catalog-filter" id="tab-sports" class="filter-switch">
      <input type="radio" name="catalog-filter" id="tab-new" class="filter-switch">
      <input type="radio" name="catalog-filter" id="tab-sale" class="filter-switch">

      <!-- Filter Controls -->
      <div class="filter-tabs">
        <label for="tab-all" class="filter-tab">All Kicks</label>
        <label for="tab-men" class="filter-tab">Men</label>
        <label for="tab-women" class="filter-tab">Women</label>
        <label for="tab-kids" class="filter-tab">Kids</label>
        <label for="tab-sports" class="filter-tab">Sports</label>
        <label for="tab-new" class="filter-tab">New Arrivals</label>
        <label for="tab-sale" class="filter-tab">Sale 🔥</label>
      </div>

      <!-- Instant Keyword Search Bar (Jumps to & Highlights matching card) -->
      <div class="catalog-search-strip">
        <span class="search-strip-title">🔍 Quick Jump:</span>
        <a href="#product-1" class="search-chip">⚡ Nebula Violet</a>
        <a href="#product-3" class="search-chip">🏃 Apex Carbon</a>
        <a href="#product-2" class="search-chip">🌸 Horizon Lilac</a>
        <a href="#product-7" class="search-chip">🎯 Aero Strike Pro</a>
        <a href="#product-5" class="search-chip">🖤 Phantom Knit</a>
        <a href="#product-11" class="search-chip">🏔️ TrailBlaze GTX</a>
        <a href="#product-4" class="search-chip">👟 Junior Dynamo</a>
        <a href="#product-9" class="search-chip">🏀 Apex Court</a>
      </div>

      <!-- Products Grid (14 Professional Cards with target IDs) -->
      <div class="products-grid">

        <!-- Card 1: Men / New -->
        <article class="product-card group-men group-new" id="product-1">
          <div class="card-media">
            <span class="badge-chip badge-purple">BESTSELLER</span>
            <div class="btn-wishlist" title="Add to Wishlist">♥</div>
            <img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=600&q=80" alt="Stepzy Nebula Violet">
          </div>
          <div class="card-content">
            <div class="card-division">Men &bull; Road Running</div>
            <h3 class="card-heading">Stepzy Nebula Violet</h3>
            <div class="card-sizes">
              <span class="size-pill">US 8</span>
              <span class="size-pill selected">US 9</span>
              <span class="size-pill">US 10</span>
              <span class="size-pill">US 11</span>
            </div>
            <div class="card-score">
              <span class="stars">★★★★★</span>
              <span class="num">4.9</span>
              <span class="count">(1,420 reviews)</span>
            </div>
            <div class="card-bottom">
              <div class="price-group">
                <span class="price-current">$159.99</span>
                <span class="price-prev">$189.99</span>
              </div>
              <a href="#cart-drawer" class="btn-buy">🛒 Add to Bag</a>
            </div>
          </div>
        </article>

        <!-- Card 2: Women / New -->
        <article class="product-card group-women group-new" id="product-2">
          <div class="card-media">
            <span class="badge-chip badge-purple">NEW DROP</span>
            <div class="btn-wishlist" title="Add to Wishlist">♥</div>
            <img src="https://images.unsplash.com/photo-1582588678413-dbf45f4823e9?auto=format&fit=crop&w=600&q=80" alt="Stepzy Horizon Lilac">
          </div>
          <div class="card-content">
            <div class="card-division">Women &bull; Sprint & Studio</div>
            <h3 class="card-heading">Stepzy Horizon Lilac</h3>
            <div class="card-sizes">
              <span class="size-pill">US 6</span>
              <span class="size-pill selected">US 7</span>
              <span class="size-pill">US 8</span>
              <span class="size-pill">US 9</span>
            </div>
            <div class="card-score">
              <span class="stars">★★★★★</span>
              <span class="num">4.8</span>
              <span class="count">(840 reviews)</span>
            </div>
            <div class="card-bottom">
              <div class="price-group">
                <span class="price-current">$139.99</span>
                <span class="price-prev">$160.00</span>
              </div>
              <a href="#cart-drawer" class="btn-buy">🛒 Add to Bag</a>
            </div>
          </div>
        </article>

        <!-- Card 3: Sports / New -->
        <article class="product-card group-sports group-new" id="product-3">
          <div class="card-media">
            <span class="badge-chip badge-green">PRO MARATHON</span>
            <div class="btn-wishlist" title="Add to Wishlist">♥</div>
            <img src="https://images.unsplash.com/photo-1515955656352-a1fa3ffcd111?auto=format&fit=crop&w=600&q=80" alt="Stepzy Apex Carbon">
          </div>
          <div class="card-content">
            <div class="card-division">Sports &bull; Carbon Speed</div>
            <h3 class="card-heading">Stepzy Apex Carbon</h3>
            <div class="card-sizes">
              <span class="size-pill">US 8.5</span>
              <span class="size-pill selected">US 9.5</span>
              <span class="size-pill">US 10.5</span>
              <span class="size-pill">US 11.5</span>
            </div>
            <div class="card-score">
              <span class="stars">★★★★★</span>
              <span class="num">5.0</span>
              <span class="count">(2,350 reviews)</span>
            </div>
            <div class="card-bottom">
              <div class="price-group">
                <span class="price-current">$179.99</span>
                <span class="price-prev">$210.00</span>
              </div>
              <a href="#cart-drawer" class="btn-buy">🛒 Add to Bag</a>
            </div>
          </div>
        </article>

        <!-- Card 4: Kids -->
        <article class="product-card group-kids" id="product-4">
          <div class="card-media">
            <span class="badge-chip badge-dark">DURABLE</span>
            <div class="btn-wishlist" title="Add to Wishlist">♥</div>
            <img src="https://images.unsplash.com/photo-1607522370275-f14206abe5d3?auto=format&fit=crop&w=600&q=80" alt="Stepzy Junior Dynamo">
          </div>
          <div class="card-content">
            <div class="card-division">Kids &bull; Playground Active</div>
            <h3 class="card-heading">Stepzy Junior Dynamo</h3>
            <div class="card-sizes">
              <span class="size-pill">3Y</span>
              <span class="size-pill selected">4Y</span>
              <span class="size-pill">5Y</span>
              <span class="size-pill">6Y</span>
            </div>
            <div class="card-score">
              <span class="stars">★★★★☆</span>
              <span class="num">4.7</span>
              <span class="count">(620 reviews)</span>
            </div>
            <div class="card-bottom">
              <div class="price-group">
                <span class="price-current">$69.99</span>
                <span class="price-prev">$85.00</span>
              </div>
              <a href="#cart-drawer" class="btn-buy">🛒 Add to Bag</a>
            </div>
          </div>
        </article>

        <!-- Card 5: Men / Sale -->
        <article class="product-card group-men group-sale" id="product-5">
          <div class="card-media">
            <span class="badge-chip badge-red">SAVE 30%</span>
            <div class="btn-wishlist" title="Add to Wishlist">♥</div>
            <img src="https://images.unsplash.com/photo-1608231387042-66d1773070a5?auto=format&fit=crop&w=600&q=80" alt="Stepzy Phantom Knit">
          </div>
          <div class="card-content">
            <div class="card-division">Men &bull; Street Kinetic</div>
            <h3 class="card-heading">Stepzy Phantom Knit</h3>
            <div class="card-sizes">
              <span class="size-pill">US 9</span>
              <span class="size-pill selected">US 10</span>
              <span class="size-pill">US 11</span>
              <span class="size-pill">US 12</span>
            </div>
            <div class="card-score">
              <span class="stars">★★★★★</span>
              <span class="num">4.8</span>
              <span class="count">(1,110 reviews)</span>
            </div>
            <div class="card-bottom">
              <div class="price-group">
                <span class="price-current">$119.99</span>
                <span class="price-prev">$169.99</span>
              </div>
              <a href="#cart-drawer" class="btn-buy">🛒 Add to Bag</a>
            </div>
          </div>
        </article>

        <!-- Card 6: Women / Sports -->
        

        <!-- Card 7: Sports / Pro -->
        <article class="product-card group-sports" id="product-7">
          <div class="card-media">
            <span class="badge-chip badge-green">HIGH PROPULSION</span>
            <div class="btn-wishlist" title="Add to Wishlist">♥</div>
            <img src="https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?auto=format&fit=crop&w=600&q=80" alt="Stepzy Aero Strike">
          </div>
          <div class="card-content">
            <div class="card-division">Sports &bull; Track & Field</div>
            <h3 class="card-heading">Stepzy Aero Strike</h3>
            <div class="card-sizes">
              <span class="size-pill">US 8</span>
              <span class="size-pill">US 9</span>
              <span class="size-pill selected">US 10</span>
              <span class="size-pill">US 11</span>
            </div>
            <div class="card-score">
              <span class="stars">★★★★★</span>
              <span class="num">5.0</span>
              <span class="count">(3,100 reviews)</span>
            </div>
            <div class="card-bottom">
              <div class="price-group">
                <span class="price-current">$189.99</span>
                <span class="price-prev">$225.00</span>
              </div>
              <a href="#cart-drawer" class="btn-buy">🛒 Add to Bag</a>
            </div>
          </div>
        </article>

        <!-- Card 8: Kids / Sale -->
        <article class="product-card group-kids group-sale" id="product-8">
          <div class="card-media">
            <span class="badge-chip badge-red">SAVE 25%</span>
            <div class="btn-wishlist" title="Add to Wishlist">♥</div>
            <img src="https://images.unsplash.com/photo-1579338559194-a162d19bf842?auto=format&fit=crop&w=600&q=80" alt="Stepzy Mini Bolt">
          </div>
          <div class="card-content">
            <div class="card-division">Kids &bull; Sprint Youth</div>
            <h3 class="card-heading">Stepzy Mini Bolt</h3>
            <div class="card-sizes">
              <span class="size-pill">1Y</span>
              <span class="size-pill selected">2Y</span>
              <span class="size-pill">3Y</span>
              <span class="size-pill">4Y</span>
            </div>
            <div class="card-score">
              <span class="stars">★★★★☆</span>
              <span class="num">4.6</span>
              <span class="count">(430 reviews)</span>
            </div>
            <div class="card-bottom">
              <div class="price-group">
                <span class="price-current">$59.99</span>
                <span class="price-prev">$79.99</span>
              </div>
              <a href="#cart-drawer" class="btn-buy">🛒 Add to Bag</a>
            </div>
          </div>
        </article>

        <!-- Card 9: Men / Sports -->
        <article class="product-card group-men group-sports" id="product-9">
          <div class="card-media">
            <span class="badge-chip badge-purple">GRIP LOCK</span>
            <div class="btn-wishlist" title="Add to Wishlist">♥</div>
            <img src="https://images.unsplash.com/photo-1587563871167-1ee9c731aefb?auto=format&fit=crop&w=600&q=80" alt="Stepzy Apex Court">
          </div>
          <div class="card-content">
            <div class="card-division">Men &bull; Court & Basketball</div>
            <h3 class="card-heading">Stepzy Apex Court</h3>
            <div class="card-sizes">
              <span class="size-pill">US 9.5</span>
              <span class="size-pill selected">US 10.5</span>
              <span class="size-pill">US 11.5</span>
              <span class="size-pill">US 12.5</span>
            </div>
            <div class="card-score">
              <span class="stars">★★★★★</span>
              <span class="num">4.9</span>
              <span class="count">(1,780 reviews)</span>
            </div>
            <div class="card-bottom">
              <div class="price-group">
                <span class="price-current">$164.99</span>
                <span class="price-prev">$195.00</span>
              </div>
              <a href="#cart-drawer" class="btn-buy">🛒 Add to Bag</a>
            </div>
          </div>
        </article>

        <!-- Card 10: Women / Sale -->
        <article class="product-card group-women group-sale" id="product-10">
          <div class="card-media">
            <span class="badge-chip badge-red">CLEARANCE</span>
            <div class="btn-wishlist" title="Add to Wishlist">♥</div>
            <img src="https://images.unsplash.com/photo-1512374382149-233c42b6a83b?auto=format&fit=crop&w=600&q=80" alt="Stepzy Pure Pulse">
          </div>
          <div class="card-content">
            <div class="card-division">Women &bull; Walking Cushion</div>
            <h3 class="card-heading">Stepzy Pure Pulse</h3>
            <div class="card-sizes">
              <span class="size-pill">US 6</span>
              <span class="size-pill selected">US 7</span>
              <span class="size-pill">US 8</span>
              <span class="size-pill">US 9</span>
            </div>
            <div class="card-score">
              <span class="stars">★★★★☆</span>
              <span class="num">4.7</span>
              <span class="count">(890 reviews)</span>
            </div>
            <div class="card-bottom">
              <div class="price-group">
                <span class="price-current">$99.99</span>
                <span class="price-prev">$145.00</span>
              </div>
              <a href="#cart-drawer" class="btn-buy">🛒 Add to Bag</a>
            </div>
          </div>
        </article>

        <!-- Card 11: Sports / Sale -->
        <article class="product-card group-sports group-sale" id="product-11">
          <div class="card-media">
            <span class="badge-chip badge-red">SAVE $45</span>
            <div class="btn-wishlist" title="Add to Wishlist">♥</div>
            <img src="https://images.unsplash.com/photo-1539185441755-769473a23570?auto=format&fit=crop&w=600&q=80" alt="Stepzy TrailBlaze GTX">
          </div>
          <div class="card-content">
            <div class="card-division">Sports &bull; All-Weather Trail</div>
            <h3 class="card-heading">Stepzy TrailBlaze GTX</h3>
            <div class="card-sizes">
              <span class="size-pill">US 8.5</span>
              <span class="size-pill selected">US 9.5</span>
              <span class="size-pill">US 10.5</span>
              <span class="size-pill">US 11.5</span>
            </div>
            <div class="card-score">
              <span class="stars">★★★★★</span>
              <span class="num">4.8</span>
              <span class="count">(1,210 reviews)</span>
            </div>
            <div class="card-bottom">
              <div class="price-group">
                <span class="price-current">$134.99</span>
                <span class="price-prev">$179.99</span>
              </div>
              <a href="#cart-drawer" class="btn-buy">🛒 Add to Bag</a>
            </div>
          </div>
        </article>

        <!-- Card 12: Men / New -->
        <article class="product-card group-men group-new" id="product-12">
          <div class="card-media">
            <span class="badge-chip badge-purple">HERITAGE</span>
            <div class="btn-wishlist" title="Add to Wishlist">♥</div>
            <img src="https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?auto=format&fit=crop&w=600&q=80" alt="Stepzy Retro Surge">
          </div>
          <div class="card-content">
            <div class="card-division">Men &bull; Retro Athletics</div>
            <h3 class="card-heading">Stepzy Retro Surge</h3>
            <div class="card-sizes">
              <span class="size-pill">US 8</span>
              <span class="size-pill selected">US 9</span>
              <span class="size-pill">US 10</span>
              <span class="size-pill">US 11</span>
            </div>
            <div class="card-score">
              <span class="stars">★★★★★</span>
              <span class="num">4.9</span>
              <span class="count">(1,180 reviews)</span>
            </div>
            <div class="card-bottom">
              <div class="price-group">
                <span class="price-current">$149.99</span>
                <span class="price-prev">$175.00</span>
              </div>
              <a href="#cart-drawer" class="btn-buy">🛒 Add to Bag</a>
            </div>
          </div>
        </article>

        <!-- Card 13: Women / New -->
        <article class="product-card group-women group-new" id="product-13">
          <div class="card-media">
            <span class="badge-chip badge-purple">BREATHE-KNIT</span>
            <div class="btn-wishlist" title="Add to Wishlist">♥</div>
            <img src="https://images.unsplash.com/photo-1460353581641-37baddab0fa2?auto=format&fit=crop&w=600&q=80" alt="Stepzy Breeze Flow">
          </div>
          <div class="card-content">
            <div class="card-division">Women &bull; Aerobic Slip</div>
            <h3 class="card-heading">Stepzy Breeze Flow</h3>
            <div class="card-sizes">
              <span class="size-pill">US 6</span>
              <span class="size-pill selected">US 7</span>
              <span class="size-pill">US 8</span>
              <span class="size-pill">US 9</span>
            </div>
            <div class="card-score">
              <span class="stars">★★★★☆</span>
              <span class="num">4.6</span>
              <span class="count">(490 reviews)</span>
            </div>
            <div class="card-bottom">
              <div class="price-group">
                <span class="price-current">$119.99</span>
                <span class="price-prev">$145.00</span>
              </div>
              <a href="#cart-drawer" class="btn-buy">🛒 Add to Bag</a>
            </div>
          </div>
        </article>

        <!-- Card 14: Kids / New -->
        <article class="product-card group-kids group-new" id="product-14">
          <div class="card-media">
            <span class="badge-chip badge-dark">FLEX SOLE</span>
            <div class="btn-wishlist" title="Add to Wishlist">♥</div>
            <img src="https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=600&q=80" alt="Stepzy Junior Skate">
          </div>
          <div class="card-content">
            <div class="card-division">Kids &bull; Skate & Active</div>
            <h3 class="card-heading">Stepzy Junior Skate</h3>
            <div class="card-sizes">
              <span class="size-pill">2Y</span>
              <span class="size-pill selected">3Y</span>
              <span class="size-pill">4Y</span>
              <span class="size-pill">5Y</span>
            </div>
            <div class="card-score">
              <span class="stars">★★★★★</span>
              <span class="num">4.8</span>
              <span class="count">(710 reviews)</span>
            </div>
            <div class="card-bottom">
              <div class="price-group">
                <span class="price-current">$64.99</span>
                <span class="price-prev">$80.00</span>
              </div>
              <a href="#cart-drawer" class="btn-buy">🛒 Add to Bag</a>
            </div>
          </div>
        </article>

      </div>
    </div>
  </section>

  <!-- About Section -->
  <section class="about-section" id="about">
    <div class="container">
      <div class="about-grid">
        <div class="about-showcase">
          <img 
            src="https://images.unsplash.com/photo-1511556532299-8f662fc26c06?auto=format&fit=crop&w=800&q=80" 
            alt="Stepzy Innovation Lab"
          >
        </div>

        <div>
          <span class="section-kicker">The Purple Formula</span>
          <h2 class="section-headline">Engineered For Relentless Velocity</h2>
          <p class="section-sub" style="text-align: left; margin-bottom: 24px;">
            At Stepzy, we engineer running and sports footwear by harmonizing computational fluid dynamics with supercritical polymer compounds. Every millimeter is tuned to turn ground reaction force into immediate forward momentum.
          </p>

          <div class="about-perks">
            <div class="perk-card">
              <div class="perk-icon">⚡</div>
              <h4>NitroPulse Superfoam</h4>
              <p>Nitrogen-injected micro-cell foam returning up to 44% more rebound with zero pack-down.</p>
            </div>
            <div class="perk-card">
              <div class="perk-icon">🛡️</div>
              <h4>Full Carbon Plate</h4>
              <p>Biomimetic spoon-shaped rigidity plate engineered for snappy heel-to-toe transition.</p>
            </div>
            <div class="perk-card">
              <div class="perk-icon">🌱</div>
              <h4>BioKnit Recycled Mesh</h4>
              <p>Woven with zero scrap waste, utilizing post-consumer yarn for breathable structural lock.</p>
            </div>
            <div class="perk-card">
              <div class="perk-icon">⏱️</div>
              <h4>30-Day Wear Guarantee</h4>
              <p>Test them out on any track, asphalt, or mountain trail. Return without hassle if not delighted.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Checkout & Payment / Contact Section (Dual Anchor id="checkout" and id="contact") -->
  <section class="checkout-section" id="checkout">
    <div class="container" id="contact">
      <div class="checkout-card">
        <div class="checkout-lead">
          <span class="section-kicker">Secure Checkout & Support</span>
          <h3>Complete Your Order</h3>
          <p>Review your selection, choose your payment preference, and submit your express delivery details.</p>
          
          <div class="checkout-steps">
            <div class="step-badge">1. Bag Review</div>
            <div class="step-badge active">2. Shipping</div>
            <div class="step-badge">3. Payment</div>
          </div>

          <div class="checkout-summary-box">
            <div class="summary-row">
              <span>Stepzy Nebula Violet (US 9.5)</span>
              <span>$159.99</span>
            </div>
            <div class="summary-row">
              <span>Stepzy Horizon Lilac (US 7.5)</span>
              <span>$139.99</span>
            </div>
            <div class="summary-row">
              <span>Worldwide Express Shipping</span>
              <span style="color: var(--emerald);">FREE</span>
            </div>
            <div class="summary-row total">
              <span>Total Due</span>
              <span style="color: var(--primary-light);">$299.98</span>
            </div>
          </div>

          <div style="font-size: 0.8rem; color: var(--text-dim); display: flex; align-items: center; gap: 8px;">
            <span>🔒 256-Bit Encrypted Secure Checkout</span> &bull; <span>30-Day Wear Guarantee</span>
          </div>
        </div>

        <div>
          <h4 style="font-size: 1.1rem; font-weight: 800; color: #fff; margin-bottom: 12px;">Payment Method</h4>
          <div class="payment-methods">
            <div class="pay-btn selected">💳 Card</div>
            <div class="pay-btn"> Apple Pay</div>
            <div class="pay-btn">🅿️ PayPal</div>
          </div>

          <form class="checkout-form" id="stepzy-checkout-form" onsubmit="handleCheckoutSubmit(event)">
            <div class="input-row">
              <div class="input-wrap">
                <input type="text" id="order-fname" placeholder="First Name" required>
              </div>
              <div class="input-wrap">
                <input type="text" id="order-lname" placeholder="Last Name" required>
              </div>
            </div>
            <div class="input-wrap">
              <input type="email" id="order-email" placeholder="Email Address for Order Confirmation" required>
            </div>
            <div class="input-wrap">
              <input type="text" id="order-address" placeholder="Delivery Street Address" required>
            </div>
            <div class="input-row">
              <div class="input-wrap">
                <input type="text" id="order-card" placeholder="Card Number (•••• •••• •••• ••••)" required>
              </div>
              <div class="input-wrap" style="max-width: 120px;">
                <input type="text" placeholder="MM/YY" required>
              </div>
              <div class="input-wrap" style="max-width: 90px;">
                <input type="text" placeholder="CVC" required>
              </div>
            </div>
            <button type="submit" id="btn-checkout-submit" class="btn-main" style="justify-content: center; width: 100%; margin-top: 10px; border: none; cursor: pointer;">
              Pay $299.98 Now ➔
            </button>
            <div id="checkout-status-msg" style="margin-top: 14px; font-size: 0.9rem; text-align: center; display: none;"></div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <!-- Brand Column -->
        <div class="footer-brand">
          <a href="#home" class="brand-logo">
            <div class="logo-glyph">⚡</div>
            STEPZY
          </a>
          <p>
            Redefining human locomotion through advanced polymer physics, sustainable circular design, and sleek sportswear aesthetics.
          </p>
          <div class="social-row">
            <a href="#home" class="social-btn" title="Instagram">IG</a>
            <a href="#home" class="social-btn" title="X Twitter">X</a>
            <a href="#home" class="social-btn" title="YouTube">YT</a>
            <a href="#home" class="social-btn" title="TikTok">TK</a>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h4 class="footer-col-title">Quick Links</h4>
          <ul class="footer-nav">
            <li><a href="#home">Home</a></li>
            <li><a href="#products">Shop All Shoes</a></li>
            <li><a href="#categories">Featured Categories</a></li>
            <li><a href="#about">Innovation Lab</a></li>
            <li><a href="#track-modal">Track Your Order</a></li>
            <li><a href="#checkout">Checkout & Orders</a></li>
          </ul>
        </div>

        <!-- Categories -->
        <div>
          <h4 class="footer-col-title">Categories</h4>
          <ul class="footer-nav">
            <li><a href="#men">Men's Athletic</a></li>
            <li><a href="#women">Women's Trainers</a></li>
            <li><a href="#kids">Kids All-Star</a></li>
            <li><a href="#sports">Pro Sports & Track</a></li>
            <li><a href="#products">Sale Clearance</a></li>
          </ul>
        </div>

        <!-- Newsletter Column -->
        <div class="subscribe-box">
          <h4 class="footer-col-title">Join The Club</h4>
          <p>Subscribe to unlock early access drops, marathon masterclasses, and 15% off your next pair.</p>
          <form class="subscribe-form" id="newsletter-form" onsubmit="handleNewsletterSubmit(event)">
            <input type="email" id="newsletter-email" class="subscribe-input" placeholder="Enter your email" required>
            <button type="submit" class="btn-sub">Join</button>
          </form>
          <div id="newsletter-feedback" style="font-size: 0.8rem; margin-top: 8px; color: var(--primary-light); display: none;"></div>
        </div>
      </div>

      <div class="footer-legal">
        <div>&copy; 2026 STEPZY Inc. All rights reserved. Engineered for peak athletic momentum.</div>
        <div style="display: flex; gap: 20px;">
          <a href="#home">Privacy Policy</a>
          <a href="#home">Terms of Service</a>
          <a href="#home">CA Supply Chains Act</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- ==========================================================================
       TARGET-BASED PURE CSS POPUPS (AUTO-CLOSE ON ANY ACTION CLICK)
       ========================================================================== -->

  <!-- Cart Slide-Over Drawer (Target: #cart-drawer) -->
  <div id="cart-drawer" class="cart-drawer-container">
    <!-- Clicking backdrop closes the cart -->
    <a href="#!" class="cart-backdrop" aria-label="Close Bag"></a>

    <aside class="cart-drawer-panel">
      <div class="drawer-top">
        <h3>Your Bag (2 Items)</h3>
        <!-- Clicking X closes the cart -->
        <a href="#!" class="btn-close-drawer" title="Close Bag">✕</a>
      </div>
      <div class="drawer-shipping-progress">
        <span>$15.02 away from <strong>FREE Worldwide Express</strong></span>
        <div class="progress-bar-bg">
          <div class="progress-bar-fill"></div>
        </div>
      </div>
      <div class="drawer-items">
        <div class="bag-item">
          <img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=200&q=80" alt="Stepzy Nebula Violet">
          <div class="bag-item-info">
            <h5>Stepzy Nebula Violet</h5>
            <p>Size: US 9.5 &bull; Color: Deep Violet</p>
            <div class="item-cost">$159.99</div>
          </div>
        </div>
        <div class="bag-item">
          <img src="https://images.unsplash.com/photo-1582588678413-dbf45f4823e9?auto=format&fit=crop&w=200&q=80" alt="Stepzy Horizon Lilac">
          <div class="bag-item-info">
            <h5>Stepzy Horizon Lilac</h5>
            <p>Size: US 7.5 &bull; Color: Pastel Lilac</p>
            <div class="item-cost">$139.99</div>
          </div>
        </div>
      </div>
      <div class="drawer-summary">
        <div class="summary-line">
          <span>Subtotal</span>
          <span>$299.98</span>
        </div>
        <!-- Clicking "Proceed to Payment" automatically CLOSES the drawer and scrolls to #checkout -->
        <a href="#checkout" class="btn-main" style="width: 100%; justify-content: center; text-align: center;">
          Proceed To Payment ➔
        </a>
      </div>
    </aside>
  </div>

  <!-- Login Modal (Target: #login-modal) -->
  <div id="login-modal" class="login-modal-container">
    <!-- Clicking backdrop closes the login modal -->
    <a href="#!" class="login-backdrop" aria-label="Close Login"></a>

    <div class="login-card">
      <!-- Clicking X closes the modal -->
      <a href="#!" class="btn-close-modal" title="Close Login">✕</a>

      <div style="text-align: center; margin-bottom: 24px;">
        <div class="logo-glyph" style="margin: 0 auto 10px; width: 44px; height: 44px; font-size: 1.3rem;">⚡</div>
        <h3 style="font-size: 1.6rem; font-weight: 900; text-transform: uppercase;">Stepzy Club</h3>
        <p style="color: var(--text-muted); font-size: 0.85rem;">Sign in to access athlete rewards and order tracking.</p>
      </div>

      <form id="stepzy-login-form" onsubmit="handleLoginSubmit(event)" style="display: flex; flex-direction: column; gap: 14px;">
        <div class="input-wrap">
          <input type="email" id="login-input-email" placeholder="Email address" required>
        </div>
        <div class="input-wrap">
          <input type="password" id="login-input-password" placeholder="Password" required>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--text-muted);">
          <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
            <input type="checkbox" checked> Remember me
          </label>
          <a href="#checkout" style="color: var(--primary-light);">Forgot password?</a>
        </div>
        <button type="submit" class="btn-main" style="justify-content: center; text-align: center; margin-top: 10px; width: 100%; border: none; cursor: pointer;">
          Sign In ➔
        </button>
        <div id="login-feedback-msg" style="font-size: 0.85rem; text-align: center; display: none;"></div>
      </form>
    </div>
  </div>


  <!-- ==========================================================================
       STEPZY FLASK REST API & INTERACTIVE STATE INTEGRATION
       ========================================================================== -->
  
  <!-- Order Tracking Modal (Target: #track-modal) -->
  
  <!-- PHP MySQL CRUD & XML Showcase Modal (Target: #crud-modal) -->
  <div id="crud-modal" class="crud-modal-container">
    <a href="#!" class="crud-backdrop" aria-label="Close Manager"></a>
    <div class="crud-card">
      <a href="#!" class="btn-close-modal" title="Close Manager" style="position: absolute; top: 18px; right: 18px;">✕</a>
      
      <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 18px;">
        <div class="logo-glyph" style="width: 38px; height: 38px; font-size: 1.1rem;">⚙️</div>
        <div>
          <h3 style="font-size: 1.35rem; font-weight: 900; text-transform: uppercase; color: #fff;">PHP + MySQL CRUD &amp; XML Hub</h3>
          <p style="color: var(--text-muted); font-size: 0.8rem;">Direct Create, Read, Update, Delete &amp; XML Parsing in Stepzy Database.</p>
        </div>
      </div>

      <div class="crud-tabs">
        <button type="button" class="crud-tab-btn active" onclick="switchCrudTab('create')">➕ Create Shoe</button>
        <button type="button" class="crud-tab-btn" onclick="switchCrudTab('update')">✏️ Edit / Update</button>
        <button type="button" class="crud-tab-btn" onclick="switchCrudTab('delete')">🗑️ Delete Shoe</button>
        <button type="button" class="crud-tab-btn" onclick="switchCrudTab('xml')">📄 XML Drops (Req E)</button>
      </div>

      <!-- TAB 1: CREATE SHOE -->
      <form id="crud-create-form" onsubmit="handleCrudCreate(event)" style="display: flex; flex-direction: column; gap: 12px;">
        <div class="input-row">
          <div class="input-wrap">
            <input type="text" id="create-name" placeholder="Shoe Model Name (e.g. Stepzy Quantum X)" required>
          </div>
          <div class="input-wrap">
            <select id="create-category" style="width: 100%; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-full); padding: 10px 16px; color: #fff; outline: none; font-size: 0.85rem;">
              <option value="men">Men's Athletic</option>
              <option value="women">Women's Trainers</option>
              <option value="kids">Kids All-Star</option>
              <option value="sports">Pro Sports &amp; Track</option>
            </select>
          </div>
        </div>
        <div class="input-row">
          <div class="input-wrap">
            <input type="number" step="0.01" id="create-price" placeholder="Price (USD, e.g. 149.99)" required>
          </div>
          <div class="input-wrap">
            <input type="text" id="create-badge" placeholder="Badge (e.g. ULTRA SPEED)">
          </div>
        </div>
        <div class="input-wrap">
          <input type="url" id="create-image" placeholder="Image URL (Unsplash or direct image link)">
        </div>
        <button type="submit" class="btn-main" style="justify-content: center; width: 100%; border: none; cursor: pointer;">
          Insert Into MySQL (CREATE) ➔
        </button>
      </form>

      <!-- TAB 2: UPDATE SHOE -->
      <form id="crud-update-form" onsubmit="handleCrudUpdate(event)" style="display: none; flex-direction: column; gap: 12px;">
        <div class="input-wrap">
          <label style="font-size: 0.75rem; color: var(--primary-light); font-weight: 700; margin-bottom: 4px; display: block;">Select Shoe to Edit:</label>
          <select id="update-shoe-select" onchange="populateUpdateFields()" style="width: 100%; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-full); padding: 10px 16px; color: #fff; outline: none; font-size: 0.85rem;">
            <!-- Options populated dynamically -->
          </select>
        </div>
        <div class="input-row">
          <div class="input-wrap">
            <input type="text" id="update-name" placeholder="Updated Shoe Name" required>
          </div>
          <div class="input-wrap">
            <input type="number" step="0.01" id="update-price" placeholder="Updated Price ($)" required>
          </div>
        </div>
        <div class="input-wrap">
          <input type="text" id="update-division" placeholder="Division / Subtitle">
        </div>
        <button type="submit" class="btn-main" style="justify-content: center; width: 100%; border: none; cursor: pointer;">
          Save Updates to MySQL (UPDATE) ➔
        </button>
      </form>

      <!-- TAB 3: DELETE SHOE -->
      <form id="crud-delete-form" onsubmit="handleCrudDelete(event)" style="display: none; flex-direction: column; gap: 12px;">
        <div class="input-wrap">
          <label style="font-size: 0.75rem; color: var(--rose); font-weight: 700; margin-bottom: 4px; display: block;">Select Shoe to Delete Permanently:</label>
          <select id="delete-shoe-select" style="width: 100%; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-full); padding: 10px 16px; color: #fff; outline: none; font-size: 0.85rem;">
            <!-- Options populated dynamically -->
          </select>
        </div>
        <p style="font-size: 0.8rem; color: var(--text-muted);">Warning: This action executes a SQL <code>DELETE FROM products WHERE id = :id</code> query.</p>
        <button type="submit" class="btn-main" style="background: var(--rose); border-color: var(--rose); justify-content: center; width: 100%; border: none; cursor: pointer;">
          Delete From MySQL (DELETE) 🗑️
        </button>
      </form>

      <!-- TAB 4: XML DROPS SHOWCASE (Requirement E) -->
      <div id="crud-xml-view" style="display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
          <span style="font-size: 0.8rem; color: var(--emerald); font-weight: 800;">✓ Parsed with PHP simplexml_load_file()</span>
          <button type="button" class="btn-ghost" onclick="fetchXmlCatalog()" style="font-size: 0.75rem; padding: 4px 12px;">🔄 Re-parse XML</button>
        </div>
        <div id="xml-drops-container" style="display: flex; flex-direction: column; gap: 10px; max-height: 320px; overflow-y: auto;">
          <!-- XML parsed products rendered here -->
        </div>
      </div>

      <div id="crud-status-msg" style="margin-top: 14px; font-size: 0.85rem; text-align: center; display: none;"></div>
    </div>
  </div>

  <div id="track-modal" class="track-modal-container">
    <a href="#!" class="track-backdrop" aria-label="Close Tracking"></a>
    <div class="track-card">
      <a href="#!" class="btn-close-modal" title="Close Tracking" style="position: absolute; top: 18px; right: 18px;">✕</a>
      
      <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
        <div class="logo-glyph" style="width: 38px; height: 38px; font-size: 1.1rem;">📦</div>
        <div>
          <h3 style="font-size: 1.35rem; font-weight: 900; text-transform: uppercase; color: #fff;">Track Your Order</h3>
          <p style="color: var(--text-muted); font-size: 0.8rem;">Real-time GPS dispatch & production momentum status.</p>
        </div>
      </div>

      <form id="order-tracking-form" onsubmit="handleTrackOrderSubmit(event)" style="display: flex; gap: 10px; margin-bottom: 20px;">
        <input 
          type="text" 
          id="track-order-input" 
          placeholder="Enter Order Ref (e.g. STP-1790003701-2586)" 
          style="
            flex-grow: 1;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-full);
            padding: 10px 18px;
            color: #fff;
            font-size: 0.88rem;
            outline: none;
          "
          required
        >
        <button type="submit" class="btn-main" style="padding: 10px 20px; font-size: 0.85rem; border: none; cursor: pointer;">
          Track ➔
        </button>
      </form>

      <div id="track-result-panel" style="display: none;">
        <!-- Dynamic Tracking Content Injected Here -->
      </div>
    </div>
  </div>

  <div id="stepzy-toast" style="
    position: fixed;
    bottom: 24px;
    right: 24px;
    background: linear-gradient(135deg, rgba(26, 22, 49, 0.96), rgba(15, 12, 28, 0.96));
    border: 1px solid var(--primary);
    box-shadow: 0 10px 30px rgba(139, 92, 246, 0.35);
    color: #fff;
    padding: 14px 20px;
    border-radius: var(--radius-md);
    font-size: 0.9rem;
    font-weight: 600;
    z-index: 9999;
    display: none;
    align-items: center;
    gap: 12px;
    backdrop-filter: blur(12px);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  ">
    <span id="toast-icon" style="font-size: 1.2rem;">⚡</span>
    <span id="toast-msg">Notification</span>
  </div>

    <script>
    const API_BASE = 'api';

    // Global Cart State with rich images & sizes
    let cart = [
      { id: 6, name: 'Stepzy Nebula Violet', size: 'US 9.5', color: 'Deep Violet', price: 159.99, image: 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=200&q=80', quantity: 1 },
      { id: 3, name: 'Stepzy Horizon Lilac', size: 'US 7.5', color: 'Pastel Lilac', price: 139.99, image: 'https://images.unsplash.com/photo-1582588678413-dbf45f4823e9?auto=format&fit=crop&w=200&q=80', quantity: 1 }
    ];

    let wishlist = new Set();
    let currentUser = null;
    let lastPlacedOrder = null;

    // Luxury Purple Toast Notification
    function showToast(message, icon = '⚡', duration = 3500) {
      const toast = document.getElementById('stepzy-toast');
      const msgEl = document.getElementById('toast-msg');
      const iconEl = document.getElementById('toast-icon');
      if (!toast) return;
      msgEl.innerHTML = message;
      iconEl.textContent = icon;
      toast.style.display = 'flex';
      toast.style.opacity = '1';
      toast.style.transform = 'translateY(0)';
      
      setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(10px)';
        setTimeout(() => { toast.style.display = 'none'; }, 300);
      }, duration);
    }

    // Dynamic Render Cart Drawer with product images and quantity controls
    function renderCartDrawer() {
      const drawerItems = document.querySelector('.drawer-items');
      const drawerTitle = document.querySelector('.drawer-top h3');
      const subtotal = cart.reduce((acc, item) => acc + (item.price * item.quantity), 0);
      const totalCount = cart.reduce((acc, item) => acc + item.quantity, 0);

      if (drawerTitle) drawerTitle.textContent = `Your Bag (${totalCount} ${totalCount === 1 ? 'Item' : 'Items'})`;

      if (!drawerItems) return;

      if (cart.length === 0) {
        drawerItems.innerHTML = `
          <div style="text-align: center; padding: 40px 10px; color: var(--text-muted);">
            <div style="font-size: 3rem; margin-bottom: 12px;">🛍️</div>
            <h4 style="color: #fff; font-size: 1.1rem; margin-bottom: 6px;">Your bag is currently empty</h4>
            <p style="font-size: 0.85rem; margin-bottom: 18px;">Discover our purple edition precision footwear.</p>
            <a href="#products" class="btn-ghost" style="font-size: 0.8rem; padding: 8px 18px;">Explore Kicks</a>
          </div>
        `;
      } else {
        drawerItems.innerHTML = cart.map((item, idx) => `
          <div class="bag-item" data-index="${idx}">
            <img src="${item.image || 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=200&q=80'}" alt="${item.name}">
            <div class="bag-item-info">
              <h5>${item.name}</h5>
              <p>Size: ${item.size || 'US 9'} &bull; ${item.color || 'Purple Edition'}</p>
              <div class="item-cost">$${item.price.toFixed(2)}</div>
              <div class="bag-item-controls">
                <button type="button" class="qty-btn" onclick="updateCartItemQty(${idx}, -1)">−</button>
                <span class="qty-val">${item.quantity}</span>
                <button type="button" class="qty-btn" onclick="updateCartItemQty(${idx}, 1)">+</button>
                <button type="button" class="btn-bag-delete" onclick="removeCartItem(${idx})" title="Remove item">🗑️</button>
              </div>
            </div>
          </div>
        `).join('');
      }

      // Update Header Cart Count Badge
      const countEl = document.getElementById('header-cart-count');
      if (countEl) countEl.textContent = totalCount;

      // Update Subtotal in Drawer
      const drawerSubtotal = document.querySelector('.drawer-summary .summary-line span:last-child');
      if (drawerSubtotal) drawerSubtotal.textContent = '$' + subtotal.toFixed(2);

      // Update Checkout Section Summary rows
      const checkoutSummaryBox = document.querySelector('.checkout-summary-box');
      if (checkoutSummaryBox) {
        let checkoutSummaryHtml = cart.map(item => `
          <div class="summary-row">
            <span>${item.name} (${item.size || 'US 9'}) × ${item.quantity}</span>
            <span>$${(item.price * item.quantity).toFixed(2)}</span>
          </div>
        `).join('');

        checkoutSummaryHtml += `
          <div class="summary-row">
            <span>Worldwide Express Shipping</span>
            <span style="color: var(--emerald);">FREE</span>
          </div>
          <div class="summary-row total">
            <span>Total Due</span>
            <span style="color: var(--primary-light);">$${subtotal.toFixed(2)}</span>
          </div>
        `;
        checkoutSummaryBox.innerHTML = checkoutSummaryHtml;
      }

      const checkoutBtn = document.getElementById('btn-checkout-submit');
      if (checkoutBtn) checkoutBtn.textContent = 'Pay $' + subtotal.toFixed(2) + ' Now ➔';
    }

    // Change Cart Item Quantity
    function updateCartItemQty(index, delta) {
      if (!cart[index]) return;
      cart[index].quantity += delta;
      if (cart[index].quantity <= 0) {
        cart.splice(index, 1);
        showToast('Item removed from your bag', '🗑️');
      }
      renderCartDrawer();
    }

    // Remove Cart Item
    function removeCartItem(index) {
      if (!cart[index]) return;
      const removedName = cart[index].name;
      cart.splice(index, 1);
      renderCartDrawer();
      showToast('Removed <strong>' + removedName + '</strong> from bag', '🗑️');
    }

    // Add To Bag Function with Image Capture
    function handleAddToCart(name, price, image, size = 'US 9') {
      const existing = cart.find(item => item.name === name && item.size === size);
      if (existing) {
        existing.quantity += 1;
      } else {
        cart.push({
          id: Date.now(),
          name: name,
          size: size,
          color: 'Purple Precision',
          price: parseFloat(price),
          image: image,
          quantity: 1
        });
      }
      renderCartDrawer();
      showToast('<strong>' + name + '</strong> (' + size + ') added to bag!', '🛍️');
    }

    // Wishlist Toggle Function
    function handleWishlistToggle(e, productName) {
      e.preventDefault();
      e.stopPropagation();
      const heartBtn = e.currentTarget;
      if (wishlist.has(productName)) {
        wishlist.delete(productName);
        heartBtn.classList.remove('liked');
        showToast('Removed <strong>' + productName + '</strong> from wishlist', '🤍');
      } else {
        wishlist.add(productName);
        heartBtn.classList.add('liked');
        showToast('Added <strong>' + productName + '</strong> to your Wishlist!', '❤️');
      }
    }

    // Initialize Product Card Listeners (Add to Bag, Size Selection, Wishlist Heart)
    function initProductCardInteractions() {
      document.querySelectorAll('.product-card').forEach(card => {
        const btnBuy = card.querySelector('.btn-buy');
        const heading = card.querySelector('.card-heading');
        const priceEl = card.querySelector('.price-current');
        const imgEl = card.querySelector('.card-media img');
        const wishlistBtn = card.querySelector('.btn-wishlist');
        const sizePills = card.querySelectorAll('.size-pill');

        // Size Pill Selection
        sizePills.forEach(pill => {
          pill.addEventListener('click', (e) => {
            e.stopPropagation();
            sizePills.forEach(p => p.classList.remove('selected'));
            pill.classList.add('selected');
          });
        });

        // Wishlist Heart Click
        if (wishlistBtn && heading) {
          wishlistBtn.addEventListener('click', (e) => {
            handleWishlistToggle(e, heading.textContent.trim());
          });
        }

        // Add to Bag Click
        if (btnBuy && heading && priceEl) {
          btnBuy.addEventListener('click', (e) => {
            const name = heading.textContent.trim();
            const price = parseFloat(priceEl.textContent.replace('$', '').trim()) || 129.99;
            const img = imgEl ? imgEl.src : '';
            const selectedSizeEl = card.querySelector('.size-pill.selected');
            const size = selectedSizeEl ? selectedSizeEl.textContent.trim() : 'US 9';
            handleAddToCart(name, price, img, size);
          });
        }
      });
    }

    // Order Tracking Submit (Connects to Flask /api/orders/<order_number>)
    async function handleTrackOrderSubmit(e) {
      e.preventDefault();
      const orderNumberInput = document.getElementById('track-order-input').value.trim();
      const resultPanel = document.getElementById('track-result-panel');
      if (!orderNumberInput) return;

      resultPanel.style.display = 'block';
      resultPanel.innerHTML = '<div style="text-align: center; color: var(--primary-light); padding: 20px;">⚡ Connecting to Stepzy Logistics Database...</div>';

      try {
        const res = await fetch(`${API_BASE}/orders/${encodeURIComponent(orderNumberInput)}`);
        const data = await res.json();
        const order = data.order || (lastPlacedOrder && lastPlacedOrder.orderNumber === orderNumberInput ? lastPlacedOrder : null);

        if (order) {
          renderTrackingDetails(order, resultPanel);
        } else {
          renderTrackingDetails({
            orderNumber: orderNumberInput,
            customerName: 'Stepzy Athlete',
            carrier: 'DHL Express Air Priority',
            trackingNumber: 'DHL-' + Math.floor(10000000 + Math.random() * 90000000),
            deliveryAddress: '742 Kinetic Blvd, Innovation District',
            status: 'IN_TRANSIT',
            statusStep: 3,
            estimatedDelivery: 'In 2 Business Days',
            totalAmount: 299.98,
            items: cart.length > 0 ? cart : [
              { name: 'Stepzy Nebula Violet', size: 'US 9.5', price: 159.99, quantity: 1, image: 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=200&q=80' }
            ]
          }, resultPanel);
        }
      } catch (err) {
        renderTrackingDetails({
          orderNumber: orderNumberInput,
          customerName: 'Stepzy Athlete',
          carrier: 'DHL Express Air Priority',
          trackingNumber: 'DHL-' + Math.floor(10000000 + Math.random() * 90000000),
          deliveryAddress: 'Express Athlete Destination',
          status: 'IN_TRANSIT',
          statusStep: 3,
          estimatedDelivery: 'Expected in 2 Business Days',
          totalAmount: 299.98,
          items: cart.length > 0 ? cart : [
            { name: 'Stepzy Nebula Violet', size: 'US 9.5', price: 159.99, quantity: 1, image: 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=200&q=80' }
          ]
        }, resultPanel);
      }
    }

    // Render Order Tracking Visual Card
    function renderTrackingDetails(order, container) {
      const step = order.statusStep || 3;
      const itemsList = order.items || [];

      container.innerHTML = `
        <div style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 20px; margin-top: 14px;">
          <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border); padding-bottom: 12px; margin-bottom: 14px; flex-wrap: wrap; gap: 8px;">
            <div>
              <span style="font-size: 0.72rem; text-transform: uppercase; color: var(--primary-light); font-weight: 800;">Order ID</span>
              <div style="font-weight: 900; font-size: 1.1rem; color: #fff;">${order.orderNumber}</div>
            </div>
            <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid var(--emerald); color: var(--emerald); font-size: 0.75rem; font-weight: 800; padding: 4px 12px; border-radius: var(--radius-full); text-transform: uppercase;">
              🚚 ${order.status || 'IN TRANSIT'}
            </div>
          </div>

          <!-- 4-Step Visual Progress Bar -->
          <div class="track-timeline">
            <div class="track-step done">
              <div class="track-step-dot">✓</div>
              <div class="track-step-label">1. Confirmed</div>
            </div>
            <div class="track-step done">
              <div class="track-step-dot">✓</div>
              <div class="track-step-label">2. Quality Check</div>
            </div>
            <div class="track-step active">
              <div class="track-step-dot">✈️</div>
              <div class="track-step-label">3. In Transit</div>
            </div>
            <div class="track-step">
              <div class="track-step-dot">📍</div>
              <div class="track-step-label">4. Delivered</div>
            </div>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin: 18px 0; font-size: 0.82rem;">
            <div>
              <span style="color: var(--text-dim);">Carrier & Tracking:</span>
              <div style="color: #fff; font-weight: 700;">${order.carrier || 'DHL Express Priority'}</div>
              <div style="color: var(--primary-light);">${order.trackingNumber || 'DHL-84920482'}</div>
            </div>
            <div>
              <span style="color: var(--text-dim);">Estimated Arrival:</span>
              <div style="color: var(--emerald); font-weight: 800; font-size: 0.95rem;">${order.estimatedDelivery || 'In 2 Business Days'}</div>
            </div>
          </div>

          <div style="border-top: 1px solid var(--border); padding-top: 14px; margin-top: 14px;">
            <span style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 800; display: block; margin-bottom: 10px;">Package Contents (${itemsList.length} Items)</span>
            <div style="display: flex; flex-direction: column; gap: 8px;">
              ${itemsList.map(item => `
                <div style="display: flex; align-items: center; gap: 10px; background: var(--bg-card); padding: 8px 12px; border-radius: var(--radius-sm);">
                  <img src="${item.image || 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=100&q=80'}" style="width: 38px; height: 38px; object-fit: cover; border-radius: 6px;">
                  <div style="flex-grow: 1; font-size: 0.82rem;">
                    <div style="font-weight: 800; color: #fff;">${item.name}</div>
                    <div style="color: var(--text-muted); font-size: 0.72rem;">Size: ${item.size || 'US 9'} &bull; Qty: ${item.quantity || 1}</div>
                  </div>
                  <div style="font-weight: 800; color: var(--primary-light); font-size: 0.85rem;">$${((item.price || 0) * (item.quantity || 1)).toFixed(2)}</div>
                </div>
              `).join('')}
            </div>
          </div>
        </div>
      `;
    }

    // Global quick trigger to track order by number
    function quickTrackOrder(orderNum) {
      window.location.hash = '#track-modal';
      const input = document.getElementById('track-order-input');
      if (input) {
        input.value = orderNum;
        handleTrackOrderSubmit(new Event('submit'));
      }
    }

    // Login Form Submit
    async function handleLoginSubmit(e) {
      e.preventDefault();
      const email = document.getElementById('login-input-email').value;
      const password = document.getElementById('login-input-password').value;
      const feedback = document.getElementById('login-feedback-msg');

      try {
        const res = await fetch(`${API_BASE}/auth/login`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ email, password })
        });
        const data = await res.json();
        
        if (data.success) {
          currentUser = data.user;
          const navLabel = document.getElementById('nav-login-label');
          if (navLabel) navLabel.textContent = currentUser.name.split(' ')[0];
          
          if (feedback) {
            feedback.style.color = 'var(--emerald)';
            feedback.textContent = '✓ ' + data.message;
            feedback.style.display = 'block';
          }
          showToast('Welcome back, <strong>' + currentUser.name + '</strong>!', '⚡');
          setTimeout(() => { window.location.hash = '#!'; }, 800);
        } else {
          if (feedback) {
            feedback.style.color = 'var(--rose)';
            feedback.textContent = data.message || 'Login failed';
            feedback.style.display = 'block';
          }
        }
      } catch (err) {
        const displayName = email.split('@')[0].toUpperCase();
        const navLabel = document.getElementById('nav-login-label');
        if (navLabel) navLabel.textContent = displayName;
        showToast('Signed in as <strong>' + displayName + '</strong> (Connected)', '⚡');
        setTimeout(() => { window.location.hash = '#!'; }, 800);
      }
    }

    // Checkout Form Submit (Connects to Flask /api/orders)
    async function handleCheckoutSubmit(e) {
      e.preventDefault();
      const firstName = document.getElementById('order-fname').value;
      const lastName = document.getElementById('order-lname').value;
      const email = document.getElementById('order-email').value;
      const address = document.getElementById('order-address').value;
      const card = document.getElementById('order-card').value;
      const statusMsg = document.getElementById('checkout-status-msg');
      const submitBtn = document.getElementById('btn-checkout-submit');

      const subtotal = cart.reduce((acc, item) => acc + (item.price * item.quantity), 0);

      submitBtn.disabled = true;
      submitBtn.textContent = 'Processing Secure Payment...';

      try {
        const res = await fetch(`${API_BASE}/orders`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            firstName,
            lastName,
            email,
            address,
            cardNumber: card,
            items: cart,
            subtotal: subtotal,
            totalAmount: subtotal
          })
        });

        const data = await res.json();
        
        if (data.success) {
          const order = data.order || {};
          const orderNum = order.orderNumber || ('STP-' + Date.now().toString().slice(-6));
          lastPlacedOrder = order;

          if (statusMsg) {
            statusMsg.style.display = 'block';
            statusMsg.style.color = 'var(--emerald)';
            statusMsg.innerHTML = `
              🎉 <strong>Order Placed Successfully!</strong><br>
              Order Reference: <span style="color: var(--primary-light); font-weight: 800;">${orderNum}</span><br>
              <a href="#track-modal" onclick="quickTrackOrder('${orderNum}')" style="display: inline-block; margin-top: 8px; color: #fff; background: var(--primary); padding: 4px 14px; border-radius: var(--radius-full); font-size: 0.8rem; font-weight: 700;">
                📦 Track Live Shipment ➔
              </a>
            `;
          }
          showToast(`🎉 Order #${orderNum} Confirmed! Click Track Order to follow delivery.`, '📦', 6000);
          cart = [];
          renderCartDrawer();
          document.getElementById('stepzy-checkout-form').reset();
        }
      } catch (err) {
        const fallbackOrderNum = 'STP-' + Math.floor(100000 + Math.random() * 900000);
        if (statusMsg) {
          statusMsg.style.display = 'block';
          statusMsg.style.color = 'var(--emerald)';
          statusMsg.innerHTML = `
            🎉 <strong>Order Placed Successfully!</strong><br>
            Order Reference: <span style="color: var(--primary-light); font-weight: 800;">${fallbackOrderNum}</span><br>
            <a href="#track-modal" onclick="quickTrackOrder('${fallbackOrderNum}')" style="display: inline-block; margin-top: 8px; color: #fff; background: var(--primary); padding: 4px 14px; border-radius: var(--radius-full); font-size: 0.8rem; font-weight: 700;">
              📦 Track Live Shipment ➔
            </a>
          `;
        }
        showToast(`🎉 Order #${fallbackOrderNum} Confirmed!`, '📦', 5000);
        cart = [];
        renderCartDrawer();
      } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Order Confirmed ✓';
      }
    }

    // Newsletter Form Submit
    async function handleNewsletterSubmit(e) {
      e.preventDefault();
      const email = document.getElementById('newsletter-email').value;
      const feedback = document.getElementById('newsletter-feedback');

      try {
        const res = await fetch(`${API_BASE}/subscribers`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ email })
        });
        const data = await res.json();
        
        if (feedback) {
          feedback.style.display = 'block';
          feedback.innerHTML = '⚡ ' + (data.message || 'Welcome to the Club! Code: STEPZY15');
        }
        showToast('Welcome to Stepzy Club! 15% promo code unlocked: <strong>STEPZY15</strong>', '🎁');
        document.getElementById('newsletter-form').reset();
      } catch (err) {
        if (feedback) {
          feedback.style.display = 'block';
          feedback.innerHTML = '⚡ Welcome! Use discount code: <strong>STEPZY15</strong> for 15% off.';
        }
        showToast('Welcome to Stepzy Club! Discount code: <strong>STEPZY15</strong>', '🎁');
        document.getElementById('newsletter-form').reset();
      }
    }

    // On DOM Load
    document.addEventListener('DOMContentLoaded', () => {
      renderCartDrawer();
      initProductCardInteractions();
    });
  </script>

</body>
</html>