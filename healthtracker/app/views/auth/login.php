<!-- Login page updated by Paolo -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthTracker — Sign In</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: #080c14;
            display: flex;
            align-items: stretch;
            overflow: hidden;
        }

        /* ══════════════════════════════
           LEFT PANEL
        ══════════════════════════════ */
        .left-panel {
            flex: 1;
            background: #0d1421;
            border-right: 1px solid rgba(99,174,255,0.10);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px 48px 48px;
            position: relative;
            overflow: hidden;
            animation: panelSlideIn 0.8s cubic-bezier(0.16,1,0.3,1) both;
        }
        @keyframes panelSlideIn {
            from { opacity: 0; transform: translateX(-30px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(99,174,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99,174,255,0.03) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -120px;
            left: -80px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(0,212,170,0.08) 0%, transparent 65%);
            pointer-events: none;
        }

        .left-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            z-index: 2;
        }
        .left-logo-icon { font-size: 24px; filter: drop-shadow(0 0 8px rgba(0,212,170,0.5)); }
        .left-logo-text { font-size: 20px; font-weight: 800; color: #e8f0fe; letter-spacing: -0.5px; }
        .left-logo-text span { color: #00d4aa; }

        .left-hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
            padding: 40px 0;
        }

        .hero-illustration {
            width: 220px;
            height: 220px;
            margin-bottom: 36px;
            animation: floatAnim 5s ease-in-out infinite;
        }
        @keyframes floatAnim {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }

        .hero-glow {
            position: absolute;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0,212,170,0.07) 0%, transparent 70%);
            border: 1px solid rgba(0,212,170,0.08);
            animation: glowPulse 4s ease-in-out infinite;
        }
        @keyframes glowPulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.06); opacity: 0.7; }
        }

        .hero-title {
            font-size: 22px;
            font-weight: 700;
            color: #e8f0fe;
            text-align: center;
            margin-bottom: 12px;
            letter-spacing: -0.4px;
        }
        .hero-subtitle {
            font-size: 14px;
            color: #4a6080;
            text-align: center;
            line-height: 1.6;
            max-width: 300px;
        }

        .feature-pills {
            display: flex;
            gap: 10px;
            margin-top: 28px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .pill {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: rgba(0,212,170,0.06);
            border: 1px solid rgba(0,212,170,0.15);
            border-radius: 20px;
            font-size: 12px;
            color: #00d4aa;
            font-weight: 500;
            animation: fadeUp 0.5s ease both;
        }
        .pill:nth-child(1) { animation-delay: 0.6s; }
        .pill:nth-child(2) { animation-delay: 0.75s; }
        .pill:nth-child(3) { animation-delay: 0.9s; }

        .left-footer { font-size: 12px; color: #2a3a52; position: relative; z-index: 2; }

        /* ══════════════════════════════
           RIGHT PANEL
        ══════════════════════════════ */
        .right-panel {
            width: 600px;
            flex-shrink: 0;
            background: #111827;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 48px;
            position: relative;
            animation: panelFadeIn 0.8s 0.2s cubic-bezier(0.16,1,0.3,1) both;
        }
        @keyframes panelFadeIn {
            from { opacity: 0; transform: translateX(20px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .right-panel::before {
            content: '';
            position: absolute;
            top: -100px; right: -100px;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(79,168,255,0.05) 0%, transparent 65%);
            pointer-events: none;
        }

        .form-container {
            width: 100%;
            max-width: 360px;
            position: relative;
            z-index: 2;
        }

        .form-eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #00d4aa;
            margin-bottom: 10px;
            animation: fadeUp 0.4s 0.3s ease both;
            opacity: 0;
        }

        .form-heading {
            font-size: 30px;
            font-weight: 800;
            color: #e8f0fe;
            letter-spacing: -0.8px;
            margin-bottom: 6px;
            animation: fadeUp 0.4s 0.38s ease both;
            opacity: 0;
        }

        .form-subheading {
            font-size: 14px;
            color: #4a6080;
            margin-bottom: 36px;
            animation: fadeUp 0.4s 0.45s ease both;
            opacity: 0;
        }

        .auth-error {
            background: rgba(255,91,91,0.08);
            border: 1px solid rgba(255,91,91,0.25);
            color: #fca5a5;
            padding: 11px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .field-group {
            margin-bottom: 18px;
            animation: fadeUp 0.4s ease both;
            opacity: 0;
        }
        .field-group:nth-of-type(1) { animation-delay: 0.52s; }
        .field-group:nth-of-type(2) { animation-delay: 0.60s; }

        .field-label {
            display: block;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #4a6080;
            margin-bottom: 8px;
        }

        .field-wrap { position: relative; }
        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            pointer-events: none;
            opacity: 0.5;
        }
        .field-input {
            width: 100%;
            padding: 13px 16px 13px 44px;
            background: #192233;
            border: 1px solid rgba(99,174,255,0.10);
            border-radius: 10px;
            color: #e8f0fe;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            outline: none;
            transition: all 0.2s ease;
        }
        .field-input::placeholder { color: #2a3a52; }
        .field-input:focus {
            border-color: rgba(0,212,170,0.5);
            background: #1e2c3f;
            box-shadow: 0 0 0 3px rgba(0,212,170,0.08);
        }

        .field-meta { display: flex; justify-content: flex-end; margin-top: 8px; }
        .forgot-link { font-size: 12.5px; color: #4a6080; text-decoration: none; transition: color 0.2s; }
        .forgot-link:hover { color: #00d4aa; }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #00d4aa, #00b894);
            color: #080c14;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 800;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.25s ease;
            margin-top: 8px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,212,170,0.25);
            animation: fadeUp 0.4s 0.68s ease both;
            opacity: 0;
        }
        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #1fffc6, #00d4aa);
            box-shadow: 0 6px 28px rgba(0,212,170,0.4);
            transform: translateY(-2px);
        }
        .btn-login:active { transform: translateY(0); }

        .divider-row {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 24px 0;
            animation: fadeUp 0.4s 0.75s ease both;
            opacity: 0;
        }
        .divider-row::before, .divider-row::after {
            content: ''; flex: 1; height: 1px; background: rgba(99,174,255,0.08);
        }
        .divider-row span { font-size: 12px; color: #2a3a52; white-space: nowrap; font-weight: 500; }

        .demo-card {
            background: rgba(0,212,170,0.04);
            border: 1px solid rgba(0,212,170,0.12);
            border-radius: 10px;
            padding: 14px 16px;
            animation: fadeUp 0.4s 0.82s ease both;
            opacity: 0;
        }
        .demo-card-label {
            font-size: 10px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1.2px; color: #2a3a52; margin-bottom: 7px;
        }
        .demo-card p {
            font-size: 12.5px; font-family: 'JetBrains Mono', monospace;
            color: #00d4aa; margin-bottom: 3px;
        }
        .demo-card p:last-child { color: #4a6080; margin-bottom: 0; }

        .register-link {
            text-align: center;
            margin-top: 24px;
            font-size: 13.5px;
            color: #2a3a52;
            animation: fadeUp 0.4s 0.88s ease both;
            opacity: 0;
        }
        .register-link a { color: #00d4aa; font-weight: 700; text-decoration: none; transition: color 0.2s; }
        .register-link a:hover { color: #1fffc6; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 900px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; }
        }
    </style>
</head>
<body>

    <!-- LEFT PANEL -->
    <div class="left-panel">
        <div class="left-logo">
            <span class="left-logo-icon">❤️</span>
            <span class="left-logo-text">Health<span>Tracker</span></span>
        </div>

        <div class="left-hero">
            <div class="hero-glow"></div>

            <svg class="hero-illustration" viewBox="0 0 220 220" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="110" cy="110" r="100" stroke="rgba(0,212,170,0.15)" stroke-width="1.5" stroke-dasharray="6 4"/>
                <circle cx="110" cy="110" r="80" stroke="rgba(0,212,170,0.08)" stroke-width="1"/>
                <!-- Hand -->
                <path d="M68 148 C68 148 58 136 60 122 C62 108 72 100 80 104 L80 78 C80 73.6 83.6 70 88 70 C92.4 70 96 73.6 96 78 L96 104 C96 104 98 100 104 100 C109 100 112 104 112 108 C112 108 114 104 120 104 C126 104 128 108 128 112 C128 112 130 108 136 110 C142 112 142 120 140 128 L138 148 Z" stroke="#00d4aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="rgba(0,212,170,0.04)"/>
                <!-- Heart -->
                <path d="M100 122 C100 122 91 113 91 107 C91 103 94.5 100 98 102 C98 102 99 101 100 101 C101 101 102 102 102 102 C105.5 100 109 103 109 107 C109 113 100 122 100 122Z" fill="rgba(255,91,91,0.15)" stroke="#ff5b5b" stroke-width="1.5" stroke-linecap="round"/>
                <!-- Cross -->
                <rect x="97.5" y="104" width="5" height="9" rx="1.5" fill="#ff5b5b"/>
                <rect x="95" y="107" width="10" height="3.5" rx="1.5" fill="#ff5b5b"/>
                <!-- Sparkles -->
                <line x1="82" y1="88" x2="82" y2="96" stroke="rgba(0,212,170,0.7)" stroke-width="1.5" stroke-linecap="round"/>
                <line x1="78" y1="92" x2="86" y2="92" stroke="rgba(0,212,170,0.7)" stroke-width="1.5" stroke-linecap="round"/>
                <line x1="124" y1="84" x2="124" y2="92" stroke="rgba(0,212,170,0.7)" stroke-width="1.5" stroke-linecap="round"/>
                <line x1="120" y1="88" x2="128" y2="88" stroke="rgba(0,212,170,0.7)" stroke-width="1.5" stroke-linecap="round"/>
                <circle cx="138" cy="95" r="2.5" fill="rgba(79,168,255,0.6)"/>
                <circle cx="74" cy="112" r="2" fill="rgba(0,212,170,0.4)"/>
                <!-- ECG line -->
                <path d="M28 172 L58 172 L68 156 L78 188 L88 164 L98 172 L192 172" stroke="rgba(0,212,170,0.35)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </svg>

            <h2 class="hero-title">Personalized Health Insights</h2>
            <p class="hero-subtitle">Track vitals, manage medications, and monitor your health journey all in one place.</p>

            <div class="feature-pills">
                <div class="pill">💓 Vitals Tracking</div>
                <div class="pill">💊 Medications</div>
                <div class="pill">📅 Appointments</div>
            </div>
        </div>

        <div class="left-footer">© 2026 HealthTracker · All rights reserved</div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="right-panel">
        <div class="form-container">

            <p class="form-eyebrow">Welcome Back</p>
            <h1 class="form-heading">Log in</h1>
            <p class="form-subheading">Sign in to your health dashboard</p>

            <?php if (!empty($error)): ?>
                <div class="auth-error">⚠️ <?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="index.php?page=login">

                <div class="field-group">
                    <label class="field-label">Email Address</label>
                    <div class="field-wrap">
                        <span class="field-icon">✉️</span>
                        <input type="email" name="email" class="field-input" placeholder="username@gmail.com" required>
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label">Password</label>
                    <div class="field-wrap">
                        <span class="field-icon">🔒</span>
                        <input type="password" name="password" class="field-input" placeholder="••••••••" required>
                    </div>
                    <div class="field-meta">
                        <a href="#" class="forgot-link">Forgotten password?</a>
                    </div>
                </div>

                <button type="submit" class="btn-login">Log in →</button>

            </form>

            <div class="divider-row"><span>Demo Credentials</span></div>

            <div class="demo-card">
                <p class="demo-card-label">Test Account</p>
                <p>alex.morgan@healthtracker.com</p>
                <p>password123</p>
            </div>

            <div class="register-link">
                Need an account? <a href="index.php?page=register">Sign up</a>
            </div>

        </div>
    </div>

</body>
</html>