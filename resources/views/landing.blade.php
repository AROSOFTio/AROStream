<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $appSettings['brand_name'] ?? 'AROStream' }}</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap');

            :root {
                --bg-dark: #0b0f1a;
                --bg-deep: #0f1b2d;
                --accent: {{ $appSettings['primary_color'] ?? '#ff6b35' }};
                --accent-2: #ffd166;
                --text: #e6eaf2;
                --muted: #a6b0c3;
                --card: rgba(255, 255, 255, 0.06);
                --card-border: rgba(255, 255, 255, 0.12);
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                font-family: "Montserrat", "Segoe UI", sans-serif;
                color: var(--text);
                background:
                    radial-gradient(800px 400px at 10% -10%, rgba(255, 107, 53, 0.25), transparent 70%),
                    radial-gradient(600px 500px at 90% 10%, rgba(255, 209, 102, 0.2), transparent 70%),
                    linear-gradient(180deg, var(--bg-dark), var(--bg-deep));
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .shell {
                width: min(1100px, 92vw);
                padding: 48px 32px;
            }

            header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 48px;
            }

            .logo {
                font-weight: 800;
                letter-spacing: 1px;
                text-transform: uppercase;
                font-size: 20px;
            }

            .cta {
                display: flex;
                gap: 12px;
            }

            .btn {
                padding: 10px 18px;
                border-radius: 999px;
                border: 1px solid var(--card-border);
                color: var(--text);
                text-decoration: none;
                font-weight: 600;
                transition: transform 160ms ease, background 160ms ease, border-color 160ms ease;
            }

            .btn.primary {
                background: var(--accent);
                border-color: transparent;
                color: #0b0f1a;
            }

            .btn:hover {
                transform: translateY(-2px);
            }

            .hero {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
                gap: 28px;
                align-items: center;
            }

            .hero-card {
                background: var(--card);
                border: 1px solid var(--card-border);
                border-radius: 24px;
                padding: 28px;
                backdrop-filter: blur(8px);
            }

            .hero h1 {
                margin: 0 0 16px 0;
                font-size: clamp(28px, 4vw, 44px);
                line-height: 1.1;
            }

            .hero p {
                margin: 0 0 22px 0;
                color: var(--muted);
                font-size: 16px;
            }

            .features {
                display: grid;
                gap: 14px;
                margin-top: 16px;
            }

            .feature {
                padding: 14px 16px;
                border-radius: 16px;
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.08);
                font-size: 14px;
            }

            .badge {
                display: inline-block;
                padding: 6px 12px;
                border-radius: 999px;
                background: rgba(255, 209, 102, 0.15);
                color: var(--accent-2);
                font-size: 12px;
                letter-spacing: 0.6px;
                text-transform: uppercase;
                font-weight: 600;
                margin-bottom: 16px;
            }

            .live-grid {
                margin-top: 36px;
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 16px;
            }

            .live-card {
                border-radius: 18px;
                padding: 16px;
                background: rgba(5, 8, 18, 0.7);
                border: 1px solid rgba(255, 255, 255, 0.08);
            }

            .live-card h3 {
                margin: 0 0 6px 0;
                font-size: 16px;
            }

            .live-meta {
                font-size: 12px;
                color: var(--muted);
            }

            .live-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 11px;
                color: var(--accent-2);
                margin-bottom: 8px;
                text-transform: uppercase;
                letter-spacing: 0.8px;
            }

            .dot {
                width: 8px;
                height: 8px;
                border-radius: 999px;
                background: var(--accent);
                box-shadow: 0 0 12px rgba(255, 107, 53, 0.8);
            }

            @media (max-width: 640px) {
                header {
                    flex-direction: column;
                    gap: 16px;
                }

                .shell {
                    padding: 36px 20px;
                }
            }
        </style>
    </head>
    <body>
        <div class="shell">
            <header>
                <div class="logo">{{ $appSettings['brand_name'] ?? 'AROStream' }}</div>
                <nav class="cta">
                    <a class="btn" href="/login">Login</a>
                    <a class="btn primary" href="/admin/tenants">Admin Panel</a>
                </nav>
            </header>

            <section class="hero">
                <div class="hero-card">
                    <span class="badge">Streaming Control</span>
                    <h1>{{ $appSettings['brand_tagline'] ?? 'Number one streaming software in the world' }}</h1>
                    <p>Provision stations, verify domains, and monitor live status in one place. Built for fast, reliable streaming operations.</p>
                    <div class="cta">
                        <a class="btn primary" href="/login">Sign in</a>
                        @if(($appSettings['allow_registration'] ?? '1') === '1')
                            <a class="btn" href="/register">Create account</a>
                        @endif
                    </div>
                </div>
                <div class="hero-card">
                    <h1>What you can manage</h1>
                    <div class="features">
                        <div class="feature">Provision Icecast containers via Node Agent API.</div>
                        <div class="feature">Track station health and listener stats.</div>
                        <div class="feature">Verify custom domains and enforce plans.</div>
                    </div>
                </div>
            </section>

            <section class="live-grid">
                @if(($liveSessions ?? collect())->isEmpty())
                    <div class="live-card">
                        <div class="live-badge"><span class="dot"></span> Live now</div>
                        <h3>Midnight Pulse</h3>
                        <div class="live-meta">Station: Aurora Media Live</div>
                        <div class="live-meta">DJ Nova • 420 listeners</div>
                    </div>
                    <div class="live-card">
                        <div class="live-badge"><span class="dot"></span> Live now</div>
                        <h3>Morning Signal</h3>
                        <div class="live-meta">Station: BlueWave Chill</div>
                        <div class="live-meta">Luna Beats • 318 listeners</div>
                    </div>
                    <div class="live-card">
                        <div class="live-badge"><span class="dot"></span> Live now</div>
                        <h3>Drive Time</h3>
                        <div class="live-meta">Station: Echo Peaks Live</div>
                        <div class="live-meta">Auto DJ • 205 listeners</div>
                    </div>
                @else
                    @foreach($liveSessions as $session)
                        <div class="live-card">
                            <div class="live-badge"><span class="dot"></span> Live now</div>
                            <h3>{{ $session->metadata['now_playing'] ?? ($session->station?->name ?? 'Live Show') }}</h3>
                            <div class="live-meta">Station: {{ $session->station?->name ?? 'Unknown' }}</div>
                            <div class="live-meta">
                                {{ $session->streamer?->name ?? 'Auto DJ' }} • {{ $session->listeners_current }} listeners
                            </div>
                        </div>
                    @endforeach
                @endif
            </section>
        </div>
    </body>
</html>
