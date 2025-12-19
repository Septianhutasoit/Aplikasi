@extends('layouts.app')

@section('title', 'Tentang DelShop')

@section('content')

<style>
    :root {
        --blue: #2563eb;
        --indigo: #4f46e5;
        --purple: #7c3aed;
        --slate-50: #f8fafc;
        --slate-100: #e2e8f0;
        --slate-200: #cbd5f5;
        --slate-600: #4b5563;
        --slate-900: #0f172a;
        --green: #16a34a;
    }

    body {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .about-page {
        background: radial-gradient(circle at top left, #dbeafe 0, transparent 45%),
            radial-gradient(circle at bottom right, #ede9fe 0, transparent 45%),
            #ffffff;
        color: var(--slate-900);
    }

    .about-container {
        max-width: 1120px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    /* ========== HERO ========== */

    @keyframes float {
        0% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-14px);
        }

        100% {
            transform: translateY(0);
        }
    }

    .about-hero {
        position: relative;
        overflow: hidden;
        padding: 4rem 0 5rem;
    }

    @media (min-width: 768px) {
        .about-hero {
            padding: 6rem 0 6.5rem;
        }
    }

    .about-hero-pattern {
        position: absolute;
        inset: 0;
        pointer-events: none;
        background-image: radial-gradient(#e5e7eb 1px, transparent 1px);
        background-size: 24px 24px;
        opacity: 0.3;
        mix-blend-mode: soft-light;
    }

    .about-hero-blob {
        position: absolute;
        border-radius: 999px;
        filter: blur(36px);
        opacity: 0.6;
        pointer-events: none;
        animation: float 8s ease-in-out infinite;
    }

    .about-hero-blob--top-right {
        top: -4rem;
        right: -3rem;
        width: 22rem;
        height: 22rem;
        background: linear-gradient(135deg, #dbeafe, #e0e7ff);
    }

    .about-hero-blob--bottom-left {
        bottom: -4rem;
        left: -3rem;
        width: 18rem;
        height: 18rem;
        background: linear-gradient(135deg, #fee2e2, #ede9fe);
        animation-delay: 2s;
    }

    .about-hero-inner {
        position: relative;
        z-index: 1;
    }

    @media (min-width: 1024px) {
        .about-hero-inner {
            display: grid;
            grid-template-columns: minmax(0, 6.5fr) minmax(0, 5.5fr);
            gap: 3rem;
            align-items: center;
        }
    }

    .about-hero-left {
        text-align: center;
    }

    @media (min-width: 1024px) {
        .about-hero-left {
            text-align: left;
        }
    }

    .about-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1.25rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--blue);
        border: 1px solid #bfdbfe;
        background-color: #eff6ffcc;
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.08);
        margin-bottom: 1.75rem;
    }

    .about-badge-dot {
        position: relative;
        width: 0.5rem;
        height: 0.5rem;
    }

    .about-badge-dot::before,
    .about-badge-dot::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 999px;
    }

    .about-badge-dot::before {
        background-color: rgba(59, 130, 246, 0.6);
        animation: ping 1.2s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    .about-badge-dot::after {
        background-color: var(--blue);
    }

    @keyframes ping {

        75%,
        100% {
            transform: scale(2);
            opacity: 0;
        }
    }

    .about-hero-title {
        font-weight: 800;
        letter-spacing: -0.04em;
        color: var(--slate-900);
        margin-bottom: 1.25rem;
        line-height: 1.1;
        font-size: 2.4rem;
    }

    @media (min-width: 640px) {
        .about-hero-title {
            font-size: 3rem;
        }
    }

    @media (min-width: 768px) {
        .about-hero-title {
            font-size: 3.4rem;
        }
    }

    @media (min-width: 1024px) {
        .about-hero-title {
            font-size: 3.7rem;
        }
    }

    .about-hero-title span {
        background: linear-gradient(to right, var(--blue), var(--indigo), var(--purple));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .about-hero-subtitle {
        max-width: 32rem;
        margin: 0 auto;
        font-size: 0.98rem;
        line-height: 1.8;
        color: var(--slate-600);
    }

    @media (min-width: 1024px) {
        .about-hero-subtitle {
            margin-left: 0;
        }
    }

    .about-hero-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1.75rem;
        justify-content: center;
    }

    @media (min-width: 1024px) {
        .about-hero-tags {
            justify-content: flex-start;
        }
    }

    .about-hero-tag {
        padding: 0.45rem 0.95rem;
        border-radius: 999px;
        font-size: 0.8rem;
        border: 1px solid rgba(148, 163, 184, 0.6);
        background-color: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        color: #475569;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .about-hero-tag i {
        font-size: 0.85rem;
        color: var(--blue);
    }

    .about-hero-right {
        margin-top: 2.5rem;
    }

    @media (min-width: 1024px) {
        .about-hero-right {
            margin-top: 0;
        }
    }

    .about-hero-panel {
        border-radius: 1.75rem;
        background: rgba(15, 23, 42, 0.03);
        border: 1px solid rgba(148, 163, 184, 0.35);
        padding: 1.75rem 1.5rem;
        box-shadow: 0 18px 50px rgba(15, 23, 42, 0.18);
        backdrop-filter: blur(10px);
    }

    @media (min-width: 640px) {
        .about-hero-panel {
            padding: 2rem;
        }
    }

    .about-hero-panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        gap: 0.75rem;
    }

    .about-hero-panel-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #0f172a;
    }

    .about-hero-panel-badge {
        font-size: 0.75rem;
        padding: 0.3rem 0.75rem;
        border-radius: 999px;
        background-color: #dcfce7;
        color: #166534;
        font-weight: 600;
    }

    .about-hero-panel-grid {
        display: grid;
        gap: 0.75rem;
    }

    @media (min-width: 640px) {
        .about-hero-panel-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    .about-hero-metric {
        padding: 0.9rem 0.9rem;
        border-radius: 1rem;
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
    }

    .about-hero-metric-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #6b7280;
        margin-bottom: 0.2rem;
        font-weight: 600;
    }

    .about-hero-metric-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f172a;
    }

    .about-hero-metric-caption {
        font-size: 0.78rem;
        color: #6b7280;
        margin-top: 0.1rem;
    }

    .about-hero-footnote {
        margin-top: 1.25rem;
        font-size: 0.8rem;
        color: #6b7280;
        border-top: 1px dashed #e5e7eb;
        padding-top: 0.75rem;
    }

    /* ========== STORY / IMAGE SECTION ========== */

    .about-story {
        padding: 3.5rem 0 5rem;
        background-color: #ffffff;
    }

    @media (min-width: 768px) {
        .about-story {
            padding: 4rem 0 5.5rem;
        }
    }

    .about-story-grid {
        display: grid;
        gap: 2.5rem;
        align-items: center;
    }

    @media (min-width: 1024px) {
        .about-story-grid {
            grid-template-columns: repeat(12, minmax(0, 1fr));
        }

        .about-story-image {
            grid-column: span 6;
            order: 2;
        }

        .about-story-content {
            grid-column: span 6;
            order: 1;
            padding-right: 3rem;
        }
    }

    @media (max-width: 1023.98px) {
        .about-story-image {
            order: 2;
        }

        .about-story-content {
            order: 1;
        }
    }

    .about-image-wrapper {
        position: relative;
    }

    .about-image-border {
        position: absolute;
        inset: 0;
        border-radius: 1.75rem;
        background: linear-gradient(to top right, var(--blue), var(--indigo));
        opacity: 0.18;
        transform: rotate(3deg);
        transition: transform 0.5s ease;
    }

    .about-image-card {
        position: relative;
        border-radius: 1.75rem;
        overflow: hidden;
        border: 4px solid #ffffff;
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.25);
        background-color: rgba(15, 23, 42, 0.03);
    }

    .about-image-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transform: scale(1.01);
        transition: transform 0.7s ease;
    }

    .about-image-wrapper:hover .about-image-border {
        transform: rotate(1deg);
    }

    .about-image-wrapper:hover .about-image-card img {
        transform: scale(1.08);
    }

    .about-image-stats {
        position: absolute;
        left: 1.5rem;
        right: 1.5rem;
        bottom: 1.5rem;
        background-color: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        padding: 1rem 1.25rem;
        border-radius: 1rem;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.25);
        border: 1px solid rgba(255, 255, 255, 0.7);
    }

    .about-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        text-align: center;
    }

    .about-stat-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #6b7280;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .about-stat-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--slate-900);
    }

    @media (min-width: 640px) {
        .about-stat-value {
            font-size: 1.4rem;
        }
    }

    .about-story-eyebrow {
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 0.75rem;
    }

    .about-story-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        color: var(--slate-900);
    }

    @media (min-width: 768px) {
        .about-story-title {
            font-size: 2.3rem;
        }
    }

    .about-story-title span {
        color: var(--blue);
    }

    .about-story-text {
        font-size: 0.98rem;
        line-height: 1.8;
        color: var(--slate-600);
        margin-bottom: 1.5rem;
    }

    .about-story-list {
        margin: 0;
        padding-left: 1.1rem;
        margin-bottom: 1.4rem;
    }

    .about-story-list li {
        font-size: 0.95rem;
        color: #4b5563;
        margin-bottom: 0.4rem;
    }

    .about-feature-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .about-feature-icon {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 3rem;
        height: 3rem;
        border-radius: 1rem;
        background-color: #dbeafe;
        color: var(--blue);
        font-size: 1.3rem;
    }

    .about-feature-icon--indigo {
        background-color: #e0e7ff;
        color: var(--indigo);
    }

    .about-feature-title {
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--slate-900);
    }

    .about-feature-text {
        margin-top: 0.25rem;
        font-size: 0.95rem;
        color: var(--slate-600);
    }

    /* ========== VALUES SECTION ========== */

    .about-values {
        position: relative;
        padding: 4rem 0 5rem;
        background-color: var(--slate-50);
        overflow: hidden;
    }

    @media (min-width: 768px) {
        .about-values {
            padding: 5rem 0 6rem;
        }
    }

    .about-values-blob {
        position: absolute;
        border-radius: 999px;
        filter: blur(32px);
        mix-blend-mode: multiply;
        opacity: 0.55;
        pointer-events: none;
    }

    .about-values-blob--left {
        top: -4rem;
        left: 0;
        width: 16rem;
        height: 16rem;
        background-color: #e9d5ff;
    }

    .about-values-blob--right {
        bottom: -4rem;
        right: 0;
        width: 16rem;
        height: 16rem;
        background-color: #fee2e2;
    }

    .about-values-header {
        position: relative;
        z-index: 1;
        max-width: 40rem;
        margin: 0 auto 2.5rem;
        text-align: center;
    }

    .about-values-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--slate-900);
    }

    @media (min-width: 768px) {
        .about-values-title {
            font-size: 2.4rem;
        }
    }

    .about-values-subtitle {
        margin-top: 0.75rem;
        font-size: 0.95rem;
        color: #6b7280;
    }

    @media (min-width: 768px) {
        .about-values-subtitle {
            font-size: 1.05rem;
        }
    }

    .about-values-grid {
        position: relative;
        z-index: 1;
        display: grid;
        gap: 1.5rem;
    }

    @media (min-width: 768px) {
        .about-values-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    .about-card {
        position: relative;
        overflow: hidden;
        border-radius: 1.5rem;
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        padding: 1.75rem;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    @media (min-width: 640px) {
        .about-card {
            padding: 2rem;
        }
    }

    .about-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12);
    }

    .about-card-blob {
        position: absolute;
        top: -2.5rem;
        right: -2.5rem;
        width: 6rem;
        height: 6rem;
        border-radius: 999px;
        background-color: #eff6ff;
        transition: transform 0.5s ease;
    }

    .about-card:hover .about-card-blob {
        transform: scale(1.6);
    }

    .about-card-blob--indigo {
        background-color: #e0e7ff;
    }

    .about-card-blob--green {
        background-color: #dcfce7;
    }

    .about-card-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 1.25rem;
        margin-bottom: 1.25rem;
        color: #ffffff;
        font-size: 1.6rem;
        transform: rotate(0deg);
        transition: transform 0.25s ease;
    }

    .about-card-icon--blue {
        background-color: var(--blue);
        box-shadow: 0 14px 30px rgba(37, 99, 235, 0.35);
    }

    .about-card-icon--indigo {
        background-color: var(--indigo);
        box-shadow: 0 14px 30px rgba(79, 70, 229, 0.35);
    }

    .about-card-icon--green {
        background-color: var(--green);
        box-shadow: 0 14px 30px rgba(22, 163, 74, 0.35);
    }

    .about-card:hover .about-card-icon {
        transform: rotate(-6deg);
    }

    .about-card-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--slate-900);
    }

    @media (min-width: 768px) {
        .about-card-title {
            font-size: 1.25rem;
        }
    }

    .about-card-text {
        font-size: 0.95rem;
        color: var(--slate-600);
    }

    @media (min-width: 768px) {
        .about-card-text {
            font-size: 1rem;
        }
    }

    /* ========== INFO CTA (NO BUTTON) ========== */

    .about-cta {
        padding: 4rem 0 4.5rem;
        background-color: #ffffff;
    }

    @media (min-width: 768px) {
        .about-cta {
            padding: 5rem 0 5.5rem;
        }
    }

    .about-cta-card {
        position: relative;
        overflow: hidden;
        border-radius: 2.25rem;
        background-image: linear-gradient(to right, #1d4ed8, #4338ca, #7c3aed);
        padding: 3rem 1.5rem;
        text-align: center;
        box-shadow: 0 30px 80px rgba(15, 23, 42, 0.4);
    }

    @media (min-width: 640px) {
        .about-cta-card {
            padding: 3rem 2.5rem;
        }
    }

    @media (min-width: 768px) {
        .about-cta-card {
            padding: 4rem 3rem;
        }
    }

    @media (min-width: 1024px) {
        .about-cta-card {
            padding: 4.5rem 4.5rem;
        }
    }

    .about-cta-blob {
        position: absolute;
        border-radius: 999px;
        filter: blur(32px);
        opacity: 0.3;
        pointer-events: none;
    }

    .about-cta-blob--left {
        top: -3rem;
        left: -3rem;
        width: 10rem;
        height: 10rem;
        background-color: #ffffff;
    }

    .about-cta-blob--right {
        top: 50%;
        right: -4rem;
        width: 14rem;
        height: 14rem;
        background-color: #60a5fa;
    }

    .about-cta-inner {
        position: relative;
        z-index: 1;
        max-width: 40rem;
        margin: 0 auto;
    }

    .about-cta-title {
        font-size: 2rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 1rem;
    }

    @media (min-width: 768px) {
        .about-cta-title {
            font-size: 2.5rem;
        }
    }

    .about-cta-text {
        font-size: 0.95rem;
        color: #e5edff;
        margin-bottom: 1.75rem;
        line-height: 1.8;
    }

    @media (min-width: 768px) {
        .about-cta-text {
            font-size: 1.02rem;
        }
    }

    .about-cta-pills {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.75rem;
    }

    .about-cta-pill {
        padding: 0.55rem 1.1rem;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.6);
        font-size: 0.8rem;
        color: #e0ecff;
        background-color: rgba(15, 23, 42, 0.18);
        backdrop-filter: blur(10px);
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }

    .about-cta-pill i {
        font-size: 0.85rem;
    }
</style>

<div class="about-page">

    {{-- HERO (bisa dipakai sebagai section di halaman utama) --}}
    <section class="about-hero">
        <div class="about-hero-pattern"></div>
        <div class="about-hero-blob about-hero-blob--top-right"></div>
        <div class="about-hero-blob about-hero-blob--bottom-left"></div>

        <div class="about-container about-hero-inner">
            {{-- Left copy --}}
            <div class="about-hero-left">
                <div class="about-badge">
                    <span class="about-badge-dot"></span>
                    <span>Tentang DelShop</span>
                </div>

                <h1 class="about-hero-title">
                    Ruang Belanja Digital
                    <br />
                    <span>yang dekat dengan kamu</span>
                </h1>

                <p class="about-hero-subtitle">
                    DelShop adalah platform belanja berbasis komunitas yang dirancang
                    untuk menghadirkan produk terkurasi, pengalaman yang nyaman, dan
                    informasi yang transparan untuk setiap pengguna, tanpa ribet.
                </p>

                <div class="about-hero-tags">
                    <div class="about-hero-tag">
                        <i class="fas fa-store"></i>
                        Marketplace komunitas
                    </div>
                    <div class="about-hero-tag">
                        <i class="fas fa-shield-alt"></i>
                        Fokus keamanan & kualitas
                    </div>
                    <div class="about-hero-tag">
                        <i class="fas fa-info-circle"></i>
                        Informasi yang jelas & rapi
                    </div>
                </div>
            </div>

            {{-- Right info panel --}}
            <div class="about-hero-right">
                <div class="about-hero-panel">
                    <div class="about-hero-panel-header">
                        <p class="about-hero-panel-title">Sekilas DelShop</p>
                        <span class="about-hero-panel-badge">Dibangun dengan teknologi modern</span>
                    </div>

                    <div class="about-hero-panel-grid">
                        <div class="about-hero-metric">
                            <p class="about-hero-metric-label">Pengguna Terlayani</p>
                            <p class="about-hero-metric-value">15.000+</p>
                            <p class="about-hero-metric-caption">Transaksi dari berbagai kategori</p>
                        </div>
                        <div class="about-hero-metric">
                            <p class="about-hero-metric-label">Rating Kepuasan</p>
                            <p class="about-hero-metric-value">4.9/5.0</p>
                            <p class="about-hero-metric-caption">Berdasarkan ulasan pengguna</p>
                        </div>
                        <div class="about-hero-metric">
                            <p class="about-hero-metric-label">Jangkauan</p>
                            <p class="about-hero-metric-value">34 Prov</p>
                            <p class="about-hero-metric-caption">Pengiriman ke seluruh Indonesia</p>
                        </div>
                        <div class="about-hero-metric">
                            <p class="about-hero-metric-label">Kategori Produk</p>
                            <p class="about-hero-metric-value">100+</p>
                            <p class="about-hero-metric-caption">Kebutuhan harian hingga gaya hidup</p>
                        </div>
                    </div>

                    <p class="about-hero-footnote">
                        Semua informasi di halaman ini bersifat informatif untuk mengenal DelShop
                        lebih dalam, tanpa kewajiban membuat akun atau langsung berbelanja.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- STORY --}}
    <section class="about-story">
        <div class="about-container">
            <div class="about-story-grid">

                {{-- Image & stats --}}
                <div class="about-story-image">
                    <div class="about-image-wrapper">
                        <div class="about-image-border"></div>

                        <div class="about-image-card">
                            <img
                                src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80"
                                alt="Tim DelShop dan kolaborasi">

                            <div class="about-image-stats">
                                <div class="about-stats-grid">
                                    <div>
                                        <p class="about-stat-label">Merchant Aktif</p>
                                        <p class="about-stat-value">250+</p>
                                    </div>
                                    <div>
                                        <p class="about-stat-label">Tingkat Repeat Order</p>
                                        <p class="about-stat-value">78%</p>
                                    </div>
                                    <div>
                                        <p class="about-stat-label">Waktu Respon</p>
                                        <p class="about-stat-value">&lt; 5 mnt</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Text --}}
                <div class="about-story-content">
                    <p class="about-story-eyebrow">CERITA DI BALIK PLATFORM</p>

                    <h2 class="about-story-title">
                        DelShop hadir untuk membuat
                        <span>belanja online lebih manusiawi</span>
                    </h2>

                    <p class="about-story-text">
                        DelShop lahir dari kebutuhan sederhana: sebuah platform belanja
                        yang terasa dekat, transparan, dan tidak membingungkan. Bukan hanya
                        soal banyaknya produk, tapi bagaimana setiap pengguna merasa aman,
                        mengerti apa yang mereka beli, dan tahu ke mana harus bertanya.
                    </p>

                    <ul class="about-story-list">
                        <li>Informasi produk yang jelas, rapi, dan mudah dibandingkan.</li>
                        <li>Penjual yang melalui proses seleksi dan verifikasi.</li>
                        <li>Alur belanja yang dirancang agar tidak membuang waktu pengguna.</li>
                    </ul>

                    <div>
                        <div class="about-feature-item">
                            <div class="about-feature-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <p class="about-feature-title">Kualitas Terkurasi</p>
                                <p class="about-feature-text">
                                    Setiap merchant dan produk melalui proses kurasi dan pengecekan,
                                    sehingga informasi yang tampil tetap relevan dan dapat dipercaya.
                                </p>
                            </div>
                        </div>

                        <div class="about-feature-item">
                            <div class="about-feature-icon about-feature-icon--indigo">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <div>
                                <p class="about-feature-title">Pengalaman yang konsisten</p>
                                <p class="about-feature-text">
                                    Desain dan alur sistem disusun agar pengguna bisa fokus pada keputusan
                                    belanja, bukan berjuang memahami cara pakainya.
                                </p>
                            </div>
                        </div>
                    </div>

                </div> {{-- end story-content --}}
            </div>
        </div>
    </section>

    {{-- VALUES --}}
    <section class="about-values">
        <div class="about-values-blob about-values-blob--left"></div>
        <div class="about-values-blob about-values-blob--right"></div>

        <div class="about-container">
            <div class="about-values-header">
                <h2 class="about-values-title">Nilai Inti DelShop</h2>
                <p class="about-values-subtitle">
                    Tiga prinsip yang kami pegang saat membangun fitur, memilih merchant,
                    dan menyusun kebijakan untuk pengguna.
                </p>
            </div>

            <div class="about-values-grid">
                {{-- Card 1 --}}
                <article class="about-card">
                    <div class="about-card-blob"></div>
                    <div class="about-card-icon about-card-icon--blue">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3 class="about-card-title">Integritas</h3>
                    <p class="about-card-text">
                        Kami mengutamakan kejujuran dan transparansi dalam setiap informasi
                        yang ditampilkan, mulai dari harga, stok, hingga ulasan pembeli.
                    </p>
                </article>

                {{-- Card 2 --}}
                <article class="about-card">
                    <div class="about-card-blob about-card-blob--indigo"></div>
                    <div class="about-card-icon about-card-icon--indigo">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3 class="about-card-title">Inovasi Berkelanjutan</h3>
                    <p class="about-card-text">
                        Fitur dikembangkan secara bertahap, dari kebutuhan nyata pengguna:
                        mulai dari pencarian yang lebih pintar hingga tampilan yang ringan
                        dan nyaman di berbagai perangkat.
                    </p>
                </article>

                {{-- Card 3 --}}
                <article class="about-card">
                    <div class="about-card-blob about-card-blob--green"></div>
                    <div class="about-card-icon about-card-icon--green">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="about-card-title">Fokus pada Pengguna</h3>
                    <p class="about-card-text">
                        Kritik, kendala, dan saran pengguna adalah bahan utama kami untuk
                        memperbaiki sistem dan memastikan DelShop tetap relevan dipakai
                        dalam jangka panjang.
                    </p>
                </article>
            </div>
        </div>
    </section>

    {{-- INFO CTA tanpa tombol ajakan belanja/daftar --}}
    <section class="about-cta">
        <div class="about-container">
            <div class="about-cta-card">
                <div class="about-cta-blob about-cta-blob--left"></div>
                <div class="about-cta-blob about-cta-blob--right"></div>

                <div class="about-cta-inner">
                    <h2 class="about-cta-title">Kenali DelShop, Pahami Cara Kerjanya</h2>
                    <p class="about-cta-text">
                        Halaman ini dirancang sebagai pusat informasi singkat mengenai DelShop:
                        siapa yang ada di baliknya, bagaimana kami memilih merchant, dan
                        prinsip apa yang kami pegang. Gunakan informasi ini untuk memahami
                        karakter platform, sebelum memutuskan ingin memakai layanan kami atau tidak.
                    </p>

                    <div class="about-cta-pills">
                        <div class="about-cta-pill">
                            <i class="fas fa-info-circle"></i>
                            Informasi platform yang transparan
                        </div>
                        <div class="about-cta-pill">
                            <i class="fas fa-users"></i>
                            Dibangun untuk pengguna yang kritis
                        </div>
                        <div class="about-cta-pill">
                            <i class="fas fa-mobile-alt"></i>
                            Nyaman diakses dari berbagai perangkat
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection