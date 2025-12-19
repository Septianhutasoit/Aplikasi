@extends('layouts.app')

@section('title', 'Dev Team Profile - DelShop')

@section('content')

<style>
    :root {
        --primary: #10b981;
        --primary-dark: #047857;
        --dark-bg: #0f172a;
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --code-bg: #1e1e1e;
    }

    body {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        background-color: #f8fafc;
        color: var(--text-main);
        overflow-x: hidden;
    }

    /* UTILITIES */
    .text-gradient {
        background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* HERO SECTION */
    .dev-hero {
        position: relative;
        padding: 5rem 1.5rem 6rem;
        background: var(--dark-bg);
        color: white;
        overflow: hidden;
        text-align: center;
    }

    .dev-hero::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background:
            radial-gradient(circle at 15% 50%, rgba(16, 185, 129, 0.15), transparent 25%),
            radial-gradient(circle at 85% 30%, rgba(59, 130, 246, 0.15), transparent 25%);
        z-index: 0;
    }

    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 900px;
        margin: 0 auto;
    }

    .dev-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 99px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #6ee7b7;
        margin-bottom: 1.5rem;
    }

    .hero-title {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        letter-spacing: -0.02em;
    }

    @media(min-width: 768px) {
        .hero-title {
            font-size: 3.5rem;
        }

        .dev-hero {
            padding: 6rem 1.5rem 8rem;
        }
    }

    /* MAIN CONTAINER */
    .dev-container {
        max-width: 1200px;
        margin: -4rem auto 4rem;
        padding: 0 1.5rem;
        position: relative;
        z-index: 10;
        display: flex;
        flex-direction: column;
        gap: 3rem;
    }

    /* TEAM GRID (Responsive 3 Columns) */
    .team-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    @media(min-width: 768px) {
        .team-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(min-width: 1024px) {
        .team-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    /* PROFILE CARD */
    .profile-card {
        background: white;
        border-radius: 1.5rem;
        padding: 2rem;
        text-align: center;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .profile-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.1);
        border-color: var(--primary);
    }

    /* Role Badge on Card */
    .card-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.25rem 0.75rem;
        border-radius: 99px;
        background: #f1f5f9;
        color: var(--text-muted);
        text-transform: uppercase;
    }

    .profile-img-wrap {
        width: 100px;
        height: 100px;
        margin: 0 auto 1.25rem;
        padding: 3px;
        border-radius: 50%;
        background: linear-gradient(135deg, #cbd5e1, #94a3b8);
        transition: 0.3s;
    }

    /* Special border for Lead */
    .profile-card.lead .profile-img-wrap {
        background: linear-gradient(135deg, #10b981, #3b82f6);
        width: 110px;
        height: 110px;
    }

    .profile-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
    }

    .profile-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 0.25rem;
    }

    .profile-role {
        color: var(--primary);
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 1.25rem;
    }

    .mini-stats {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        margin-bottom: 1.25rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px dashed #e2e8f0;
    }

    .mini-stat-item {
        text-align: center;
    }

    .mini-stat-val {
        font-weight: 700;
        display: block;
        color: var(--text-main);
    }

    .mini-stat-lbl {
        font-size: 0.7rem;
        color: var(--text-muted);
        text-transform: uppercase;
    }

    .social-links {
        display: flex;
        justify-content: center;
        gap: 0.8rem;
    }

    .social-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        transition: 0.2s;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .social-btn:hover {
        background: var(--text-main);
        color: white;
        transform: translateY(-2px);
    }

    /* INFO SECTION GRID (Tech + Workflow) */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    @media(min-width: 1024px) {
        .info-grid {
            grid-template-columns: 1fr 1fr;
        }

        /* Make Terminal Full Width or part of the grid */
        .terminal-wrapper {
            grid-column: span 1;
        }
    }

    /* TECH STACK & WORKFLOW COMMON */
    .content-card {
        background: white;
        border-radius: 1.5rem;
        padding: 2rem;
        border: 1px solid #e2e8f0;
        height: 100%;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 0;
    }

    /* TECH ITEMS */
    .tech-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 1rem;
    }

    .tech-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 0.8rem;
        border-radius: 0.75rem;
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        transition: 0.2s;
        text-align: center;
    }

    .tech-item:hover {
        border-color: var(--primary);
        transform: translateY(-3px);
        background: #f0fdf4;
    }

    .tech-icon {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: #334155;
    }

    .tech-name {
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* TERMINAL */
    .terminal-window {
        background: var(--code-bg);
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.4);
        font-family: 'Fira Code', monospace;
        margin-bottom: 2rem;
    }

    .terminal-header {
        background: #2d2d2d;
        padding: 0.6rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .dot.red {
        background: #ef4444;
    }

    .dot.yellow {
        background: #f59e0b;
    }

    .dot.green {
        background: #10b981;
    }

    .terminal-body {
        padding: 1.25rem;
        color: #e5e7eb;
        font-size: 0.85rem;
        line-height: 1.6;
        overflow-x: auto;
    }

    /* Syntax colors */
    .code-key {
        color: #c678dd;
    }

    .code-func {
        color: #61afef;
    }

    .code-str {
        color: #98c379;
    }

    .code-var {
        color: #e06c75;
    }

    .code-comment {
        color: #5c6370;
        font-style: italic;
    }

    /* TIMELINE */
    .timeline {
        position: relative;
        padding-left: 1.5rem;
        border-left: 2px solid #e2e8f0;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-dot {
        position: absolute;
        left: -2.1rem;
        top: 0.25rem;
        width: 1rem;
        height: 1rem;
        background: white;
        border: 3px solid var(--primary);
        border-radius: 50%;
        z-index: 2;
    }

    .timeline-title {
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 0.2rem;
    }

    .timeline-desc {
        font-size: 0.85rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    .status-tag {
        display: inline-block;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
        margin-bottom: 0.3rem;
    }

    .status-tag.backend {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-tag.frontend {
        background: #dcfce7;
        color: #166534;
    }

    .status-tag.db {
        background: #fce7f3;
        color: #9d174d;
    }

    /* RESPONSIVE BUTTONS */
    .hero-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }
</style>

{{-- HERO SECTION --}}
<section class="dev-hero">
    <div class="hero-content">
        <div class="dev-badge">
            <i class="fas fa-code-branch"></i> v2.0.0 Engineering Team
        </div>
        <h1 class="hero-title">
            The Architects Behind <br>
            <span class="text-gradient">DelShop Platform</span>
        </h1>
        <p style="color: #94a3b8; font-size: 1.1rem; max-width: 600px; margin: 0 auto 2rem; line-height: 1.6;">
            Kolaborasi kode, inovasi infrastruktur, dan dedikasi untuk pengalaman pengguna terbaik.
            Membangun ekosistem digital yang aman, cepat, dan *scalable*.
        </p>

        <div class="hero-buttons">
            <a href="{{ url('/dashboard') }}" style="background: var(--primary); color: #064e3b; padding: 0.8rem 1.5rem; border-radius: 99px; font-weight: 600; text-decoration: none; transition: 0.2s; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
            <a href="https://github.com" target="_blank" style="background: rgba(255,255,255,0.1); color: white; padding: 0.8rem 1.5rem; border-radius: 99px; font-weight: 600; text-decoration: none; border: 1px solid rgba(255,255,255,0.2);">
                <i class="fab fa-github"></i> View Repository
            </a>
        </div>
    </div>
</section>

{{-- MAIN CONTAINER --}}
<div class="dev-container">

    {{-- 1. MEET THE TEAM GRID --}}
    <div class="team-grid">

        {{-- Person 1 (Lead) --}}
        <div class="profile-card lead">
            <div class="card-badge" style="color: var(--primary); background: #ecfdf5;">Tech Lead</div>
            <div class="profile-img-wrap">
                <img src="{{ asset('images/saya.jpg') }}" alt="Lead Dev" class="profile-img">
            </div>
            <h2 class="profile-name">Septian Hutasoit</h2>
            <p class="profile-role">Fullstack Developer</p>

            <div class="mini-stats">
                <div class="mini-stat-item">
                    <span class="mini-stat-val">3+</span>
                    <span class="mini-stat-lbl">Years</span>
                </div>
                <div class="mini-stat-item">
                    <span class="mini-stat-val">5</span>
                    <span class="mini-stat-lbl">Projects</span>
                </div>
            </div>

            <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 1.5rem; min-height: 3rem;">
                Architecting core system, API integration & Server management.
            </p>

            <div class="social-links">
                <a href="#" class="social-btn"><i class="fab fa-github"></i></a>
                <a href="#" class="social-btn"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="social-btn"><i class="fas fa-globe"></i></a>
            </div>
        </div>

        {{-- Person 2 --}}
        <div class="profile-card">
            <div class="card-badge">QA Engineer</div>
            <div class="profile-img-wrap">
                <!-- Ganti dengan URL foto rekan tim -->
                <img src="https://ui-avatars.com/api/?name=Andi+Pratama&background=3b82f6&color=fff" alt="Dev 2" class="profile-img">
            </div>
            <h2 class="profile-name">Mirandot</h2>
            <p class="profile-role">Quality Assurance</p>

            <div class="mini-stats">
                <div class="mini-stat-item">
                    <span class="mini-stat-val">2+</span>
                    <span class="mini-stat-lbl">Years</span>
                </div>
                <div class="mini-stat-item">
                    <span class="mini-stat-val">12</span>
                    <span class="mini-stat-lbl">Designs</span>
                </div>
            </div>

            <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 1.5rem; min-height: 3rem;">
                Crafting pixel-perfect interfaces and seamless user interactions.
            </p>

            <div class="social-links">
                <a href="#" class="social-btn"><i class="fab fa-dribbble"></i></a>
                <a href="#" class="social-btn"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        {{-- Person 3 --}}
        <div class="profile-card">
            <div class="card-badge">Design</div>
            <div class="profile-img-wrap">
                <!-- Ganti dengan URL foto rekan tim -->
                <img src="https://ui-avatars.com/api/?name=Siti+Rahma&background=f43f5e&color=fff" alt="Dev 3" class="profile-img">
            </div>
            <h2 class="profile-name">Gracia</h2>
            <p class="profile-role">UI/UX Designer</p>
            <p class="profile-role"></p>

            <div class="mini-stats">
                <div class="mini-stat-item">
                    <span class="mini-stat-val">2+</span>
                    <span class="mini-stat-lbl">Years</span>
                </div>
                <div class="mini-stat-item">
                    <span class="mini-stat-val">99%</span>
                    <span class="mini-stat-lbl">Uptime</span>
                </div>
            </div>

            <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 1.5rem; min-height: 3rem;">
                Optimizing query performance and ensuring data integrity.
            </p>

            <div class="social-links">
                <a href="#" class="social-btn"><i class="fab fa-github"></i></a>
                <a href="#" class="social-btn"><i class="fab fa-stack-overflow"></i></a>
                <a href="#" class="social-btn"><i class="fas fa-envelope"></i></a>
            </div>
        </div>

    </div>

    {{-- 2. TECH & DETAILS SECTION --}}
    <div class="info-grid">

        {{-- LEFT COLUMN: Tech Stack & Terminal --}}
        <div style="display: flex; flex-direction: column; gap: 2rem;">

            {{-- Tech Stack --}}
            <div class="content-card">
                <div class="section-header">
                    <div style="width: 36px; height: 36px; background: #dcfce7; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h3 class="section-title">Technology Use</h3>
                </div>

                <div class="tech-grid">
                    <div class="tech-item">
                        <i class="fab fa-laravel tech-icon" style="color: #F05340;"></i>
                        <span class="tech-name">Laravel</span>
                    </div>
                    <div class="tech-item">
                        <i class="fab fa-php tech-icon" style="color: #777BB4;"></i>
                        <span class="tech-name">PHP 8</span>
                    </div>
                    <div class="tech-item">
                        <svg class="tech-icon" viewBox="0 0 54 33" xmlns="http://www.w3.org/2000/svg" style="height: 1em; width: auto; fill: #38bdf8;">
                            <path d="M27 0c-7.2 0-11.7 3.6-13.5 10.8 2.7-3.6 5.85-4.95 9.45-4.05 2.054.513 3.522 2.004 5.147 3.653C30.744 13.09 33.808 16.2 40.5 16.2c7.2 0 11.7-3.6 13.5-10.8-2.7 3.6-5.85 4.95-9.45 4.05-2.054-.513-3.522-2.004-5.147-3.653C36.756 3.11 33.692 0 27 0zM13.5 16.2C6.3 16.2 1.8 19.8 0 27c2.7-3.6 5.85-4.95 9.45-4.05 2.054.513 3.522 2.004 5.147 3.653C17.244 29.29 20.308 32.4 27 32.4c7.2 0 11.7-3.6 13.5-10.8-2.7 3.6-5.85 4.95-9.45 4.05-2.054-.513-3.522-2.004-5.147-3.653C33.256 19.31 30.192 16.2 23.5 16.2z" />
                        </svg>
                        <span class="tech-name">Tailwind</span>
                    </div>
                    <div class="tech-item">
                        <i class="fas fa-database tech-icon" style="color: #00758F;"></i>
                        <span class="tech-name">MySQL</span>
                    </div>
                    <div class="tech-item">
                        <i class="fab fa-js tech-icon" style="color: #F7DF1E;"></i>
                        <span class="tech-name">ES6+</span>
                    </div>
                    <div class="tech-item">
                        <i class="fab fa-git-alt tech-icon" style="color: #f05032;"></i>
                        <span class="tech-name">Git</span>
                    </div>
                </div>
            </div>

            {{-- Terminal Window --}}
            <div class="terminal-window">
                <div class="terminal-header">
                    <div class="dot red"></div>
                    <div class="dot yellow"></div>
                    <div class="dot green"></div>
                    <span style="margin-left:auto; font-size:0.7rem; color:#9ca3af;">ProductController.php</span>
                </div>
                <div class="terminal-body">
                    <div class="code-line">
                        <span class="code-key">public function</span> <span class="code-func">store</span>(Request <span class="code-var">$request</span>) {
                    </div>
                    <div class="code-line" style="padding-left: 1rem;">
                        <span class="code-comment">// Validate & Create</span>
                    </div>
                    <div class="code-line" style="padding-left: 1rem;">
                        <span class="code-var">$data</span> = <span class="code-var">$request</span>-><span class="code-func">validate</span>([...]);
                    </div>
                    <div class="code-line" style="padding-left: 1rem;">
                        <span class="code-key">return</span> Product::<span class="code-func">create</span>(<span class="code-var">$data</span>);
                    </div>
                    <div class="code-line">}</div>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN: Workflow --}}
        <div class="content-card">
            <div class="section-header">
                <div style="width: 36px; height: 36px; background: #e0f2fe; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #0284c7;">
                    <i class="fas fa-stream"></i>
                </div>
                <h3 class="section-title">Development Workflow</h3>
            </div>

            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <span class="status-tag db">Phase 1: Architecture</span>
                    <h4 class="timeline-title">Database Design</h4>
                    <p class="timeline-desc">
                        Merancang ERD dan relasi tabel Users, Products, dan Orders untuk integritas data maksimal.
                    </p>
                </div>

                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <span class="status-tag backend">Phase 2: Core Logic</span>
                    <h4 class="timeline-title">API Development</h4>
                    <p class="timeline-desc">
                        Implementasi REST API, Authentication middleware, dan business logic yang aman.
                    </p>
                </div>

                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <span class="status-tag frontend">Phase 3: Integration</span>
                    <h4 class="timeline-title">Frontend & Deployment</h4>
                    <p class="timeline-desc">
                        Integrasi UI Blade dengan data dinamis, responsiveness check, dan server provisioning.
                    </p>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection