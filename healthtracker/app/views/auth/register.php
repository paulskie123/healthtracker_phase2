<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthTracker — Create Account</title>
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
            bottom: -120px; left: -80px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(0,212,170,0.08) 0%, transparent 65%);
            pointer-events: none;
        }

        .left-logo {
            display: flex; align-items: center; gap: 10px;
            position: relative; z-index: 2;
        }
        .left-logo-icon { font-size: 24px; filter: drop-shadow(0 0 8px rgba(0,212,170,0.5)); }
        .left-logo-text { font-size: 20px; font-weight: 800; color: #e8f0fe; letter-spacing: -0.5px; }
        .left-logo-text span { color: #00d4aa; }

        .left-hero {
            flex: 1;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            position: relative; z-index: 2;
            padding: 40px 0;
        }

        .hero-illustration {
            width: 220px; height: 220px;
            margin-bottom: 36px;
            animation: floatAnim 5s ease-in-out infinite;
        }
        @keyframes floatAnim {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }

        .hero-glow {
            position: absolute;
            width: 280px; height: 280px;
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
            font-size: 22px; font-weight: 700; color: #e8f0fe;
            text-align: center; margin-bottom: 12px; letter-spacing: -0.4px;
        }
        .hero-subtitle {
            font-size: 14px; color: #4a6080;
            text-align: center; line-height: 1.6; max-width: 300px;
        }

        .steps-list {
            margin-top: 28px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
            max-width: 300px;
        }
        .step-item {
            display: flex;
            align-items: center;
            gap: 12px;
            animation: fadeUp 0.5s ease both;
            opacity: 0;
        }
        .step-item:nth-child(1) { animation-delay: 0.6s; }
        .step-item:nth-child(2) { animation-delay: 0.75s; }
        .step-item:nth-child(3) { animation-delay: 0.9s; }

        .step-num {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: rgba(0,212,170,0.1);
            border: 1px solid rgba(0,212,170,0.25);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 800;
            color: #00d4aa;
            flex-shrink: 0;
        }
        .step-text { font-size: 13px; color: #4a6080; font-weight: 500; }
        .step-text strong { color: #8ba3c7; font-weight: 600; }

        .left-footer { font-size: 12px; color: #2a3a52; position: relative; z-index: 2; }

        /* ══════════════════════════════
           RIGHT PANEL
        ══════════════════════════════ */
        .right-panel {
            width: 580px;
            flex-shrink: 0;
            background: #111827;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 48px;
            position: relative;
            overflow-y: auto;
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
            font-size: 11px; font-weight: 700;
            letter-spacing: 2px; text-transform: uppercase;
            color: #00d4aa; margin-bottom: 10px;
            animation: fadeUp 0.4s 0.3s ease both; opacity: 0;
        }
        .form-heading {
            font-size: 30px; font-weight: 800;
            color: #e8f0fe; letter-spacing: -0.8px; margin-bottom: 6px;
            animation: fadeUp 0.4s 0.38s ease both; opacity: 0;
        }
        .form-subheading {
            font-size: 14px; color: #4a6080; margin-bottom: 32px;
            animation: fadeUp 0.4s 0.45s ease both; opacity: 0;
        }

        /* Alerts */
        .auth-error {
            background: rgba(255,91,91,0.08);
            border: 1px solid rgba(255,91,91,0.25);
            color: #fca5a5;
            padding: 11px 16px; border-radius: 10px;
            font-size: 13px; margin-bottom: 18px;
        }
        .auth-success {
            background: rgba(52,211,153,0.08);
            border: 1px solid rgba(52,211,153,0.25);
            color: #6ee7b7;
            padding: 11px 16px; border-radius: 10px;
            font-size: 13px; margin-bottom: 18px;
        }

        /* Form fields */
        .field-group {
            margin-bottom: 16px;
            animation: fadeUp 0.4s ease both; opacity: 0;
        }
        .field-group:nth-of-type(1) { animation-delay: 0.50s; }
        .field-group:nth-of-type(2) { animation-delay: 0.57s; }
        .field-group:nth-of-type(3) { animation-delay: 0.64s; }
        .field-group:nth-of-type(4) { animation-delay: 0.71s; }

        .field-label {
            display: block; font-size: 11.5px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.8px;
            color: #4a6080; margin-bottom: 7px;
        }
        .field-wrap { position: relative; }
        .field-icon {
            position: absolute; left: 14px; top: 50%;
            transform: translateY(-50%);
            font-size: 15px; pointer-events: none; opacity: 0.5;
        }
        .field-input {
            width: 100%;
            padding: 13px 16px 13px 44px;
            background: #192233;
            border: 1px solid rgba(99,174,255,0.10);
            border-radius: 10px;
            color: #e8f0fe;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px; outline: none;
            transition: all 0.2s ease;
        }
        .field-input::placeholder { color: #2a3a52; }
        .field-input:focus {
            border-color: rgba(0,212,170,0.5);
            background: #1e2c3f;
            box-shadow: 0 0 0 3px rgba(0,212,170,0.08);
        }

        /* Password hint */
        .field-hint {
            font-size: 11px; color: #2a3a52;
            margin-top: 5px; margin-left: 2px;
        }

        /* Submit */
        .btn-register {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #00d4aa, #00b894);
            color: #080c14;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px; font-weight: 800;
            border: none; border-radius: 10px;
            cursor: pointer; transition: all 0.25s ease;
            margin-top: 8px; position: relative; overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,212,170,0.25);
            animation: fadeUp 0.4s 0.78s ease both; opacity: 0;
        }
        .btn-register::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
        }
        .btn-register:hover {
            background: linear-gradient(135deg, #1fffc6, #00d4aa);
            box-shadow: 0 6px 28px rgba(0,212,170,0.4);
            transform: translateY(-2px);
        }
        .btn-register:active { transform: translateY(0); }

        .signin-link {
            text-align: center; margin-top: 22px;
            font-size: 13.5px; color: #2a3a52;
            animation: fadeUp 0.4s 0.85s ease both; opacity: 0;
        }
        .signin-link a {
            color: #00d4aa; font-weight: 700;
            text-decoration: none; transition: color 0.2s;
        }
        .signin-link a:hover { color: #1fffc6; }

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

            <!-- SVG: Shield + pulse illustration for "sign up / security" -->
            <svg class="hero-illustration" viewBox="0 0 220 220" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="110" cy="110" r="100" stroke="rgba(0,212,170,0.15)" stroke-width="1.5" stroke-dasharray="6 4"/>
                <circle cx="110" cy="110" r="80" stroke="rgba(0,212,170,0.08)" stroke-width="1"/>

                <!-- Shield body -->
                <path d="M110 62 L148 78 L148 110 C148 132 130 150 110 158 C90 150 72 132 72 110 L72 78 Z"
                    stroke="#00d4aa" stroke-width="2" stroke-linejoin="round"
                    fill="rgba(0,212,170,0.05)"/>

                <!-- Shield inner glow ring -->
                <path d="M110 70 L142 84 L142 110 C142 129 126 145 110 152 C94 145 78 129 78 110 L78 84 Z"
                    stroke="rgba(0,212,170,0.12)" stroke-width="1" stroke-linejoin="round" fill="none"/>

                <!-- Checkmark inside shield -->
                <path d="M96 110 L106 120 L126 100"
                    stroke="#00d4aa" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round"/>

                <!-- Cross/plus top-right decoration -->
                <line x1="150" y1="72" x2="150" y2="80" stroke="rgba(0,212,170,0.7)" stroke-width="1.5" stroke-linecap="round"/>
                <line x1="146" y1="76" x2="154" y2="76" stroke="rgba(0,212,170,0.7)" stroke-width="1.5" stroke-linecap="round"/>

                <!-- Star top-left -->
                <line x1="70" y1="72" x2="70" y2="80" stroke="rgba(79,168,255,0.6)" stroke-width="1.5" stroke-linecap="round"/>
                <line x1="66" y1="76" x2="74" y2="76" stroke="rgba(79,168,255,0.6)" stroke-width="1.5" stroke-linecap="round"/>

                <!-- Dots -->
                <circle cx="148" cy="150" r="2.5" fill="rgba(0,212,170,0.4)"/>
                <circle cx="72" cy="142" r="2" fill="rgba(79,168,255,0.4)"/>
                <circle cx="155" cy="105" r="1.5" fill="rgba(0,212,170,0.3)"/>

                <!-- ECG line bottom -->
                <path d="M28 172 L58 172 L68 156 L78 188 L88 164 L98 172 L192 172"
                    stroke="rgba(0,212,170,0.35)" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </svg>

            <h2 class="hero-title">Start Your Health Journey</h2>
            <p class="hero-subtitle">Join thousands tracking their health with HealthTracker.</p>

            <div class="steps-list">
                <div class="step-item">
                    <div class="step-num">1</div>
                    <p class="step-text"><strong>Create</strong> your free account</p>
                </div>
                <div class="step-item">
                    <div class="step-num">2</div>
                    <p class="step-text"><strong>Set up</strong> your health profile</p>
                </div>
                <div class="step-item">
                    <div class="step-num">3</div>
                    <p class="step-text"><strong>Track</strong> vitals & appointments</p>
                </div>
            </div>
        </div>

        <div class="left-footer">© 2026 HealthTracker · All rights reserved</div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="right-panel">
        <div class="form-container">

            <p class="form-eyebrow">Get Started</p>
            <h1 class="form-heading">Create Account</h1>
            <p class="form-subheading">Start your health journey today</p>

            <?php if (!empty($error)): ?>
                <div class="auth-error">⚠️ <?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="auth-success">✅ <?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="POST" action="index.php?page=register">

                <div class="field-group">
                    <label class="field-label">Full Name</label>
                    <div class="field-wrap">
                        <span class="field-icon">👤</span>
                        <input type="text" name="full_name" class="field-input" placeholder="Juan Dela Cruz" required>
                    </div>
                </div>

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
                    <p class="field-hint">Minimum 6 characters</p>
                </div>

                <div class="field-group">
                    <label class="field-label">Confirm Password</label>
                    <div class="field-wrap">
                        <span class="field-icon">✅</span>
                        <input type="password" name="confirm_password" class="field-input" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn-register">Create Account →</button>

            </form>

            <div class="signin-link">
                Already have an account? <a href="index.php?page=login">Sign in</a>
            </div>

        </div>
    </div>

</body>
</html>