<x-guest-layout>
    <div class="login-page">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 auth-status" :status="session('status')" />

    <div class="login-card">
        <div class="login-header">
            <div class="login-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5Zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5Z" fill="currentColor"/>
                </svg>
            </div>
            <h1>Welcome back</h1>
            <p>Sign in to continue to your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="login-form" id="loginForm">
            @csrf

            <!-- Email Address -->
            <div class="field-group">
                <input id="email" class="field-input" type="email" name="email" value="{{ old('email') }}"
                       required autofocus autocomplete="username" placeholder=" " />
                <label for="email" class="field-label">{{ __('Email') }}</label>
                <span class="field-line"></span>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="field-group">
                <input id="password" class="field-input" type="password" name="password"
                       required autocomplete="current-password" placeholder=" " />
                <label for="password" class="field-label">{{ __('Password') }}</label>
                <span class="field-line"></span>
                <button type="button" class="toggle-password" id="togglePassword" aria-label="Toggle password visibility">
                    <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z" stroke="currentColor" stroke-width="1.5"/>
                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                </button>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="options-row">
                <label class="remember-wrap" for="remember_me">
                    <input id="remember_me" type="checkbox" name="remember" class="remember-input">
                    <span class="remember-box">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 13l4 4L19 7" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="remember-text">{{ __('Remember me') }}</span>
                </label>

                {{-- @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif --}}
            </div>

            <button type="submit" class="submit-btn">
                <span class="btn-text">{{ __('Log in') }}</span>
                <span class="btn-shine"></span>
            </button>
        </form>
    </div>
    </div>

    <style>
        .login-page {
            min-height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            box-sizing: border-box;
        }

        .auth-status {
            width: 33.33%;
            max-width: 480px;
            min-width: 320px;
            animation: slideDown .5s ease both;
        }

        .login-card {
            position: relative;
            box-sizing: border-box;
            width: 33.33%;
            max-width: 480px;
            min-width: 320px;
            padding: 2.5rem 2rem;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow:
                0 1px 1px rgba(0,0,0,0.02),
                0 4px 16px rgba(76, 29, 149, 0.06),
                0 20px 40px -12px rgba(76, 29, 149, 0.12);
            border: 1px solid rgba(255,255,255,0.6);
            animation: cardIn .6s cubic-bezier(.19,1,.22,1) both;
            overflow: hidden;
        }

        /* Tablets: let it breathe before jumping to full width */
        @media (max-width: 1024px) {
            .login-card,
            .auth-status {
                width: 60%;
            }
        }

        /* Mobile: full width */
        @media (max-width: 640px) {
            .login-page {
                padding: 1rem;
            }
            .login-card,
            .auth-status {
                width: 100%;
                min-width: 0;
            }
            .login-card {
                padding: 2rem 1.25rem;
                border-radius: 16px;
            }
        }

        .login-card::before {
            content: "";
            position: absolute;
            top: -60%;
            left: -20%;
            width: 140%;
            height: 140%;
            background: radial-gradient(circle at 30% 20%, rgba(99,102,241,0.10), transparent 55%),
                        radial-gradient(circle at 80% 0%, rgba(236,72,153,0.08), transparent 50%);
            pointer-events: none;
            animation: driftGlow 12s ease-in-out infinite alternate;
        }

        @keyframes driftGlow {
            0%   { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(4%, 6%) rotate(8deg); }
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(24px) scale(.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-header {
            text-align: center;
            margin-bottom: 1.75rem;
            position: relative;
            z-index: 1;
        }

        .login-icon {
            width: 52px;
            height: 52px;
            margin: 0 auto 1rem;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            box-shadow: 0 8px 20px -6px rgba(99,102,241,0.55);
            animation: popIn .6s .1s cubic-bezier(.34,1.56,.64,1) both;
        }

        .login-icon svg { width: 26px; height: 26px; }

        @keyframes popIn {
            0%   { opacity: 0; transform: scale(.4) rotate(-15deg); }
            100% { opacity: 1; transform: scale(1) rotate(0deg); }
        }

        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e1b2e;
            margin: 0 0 .35rem;
            letter-spacing: -0.02em;
            animation: fadeUp .5s .15s ease both;
        }

        .login-header p {
            font-size: .875rem;
            color: #6b7280;
            margin: 0;
            animation: fadeUp .5s .2s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-form { position: relative; z-index: 1; }

        .field-group {
            position: relative;
            margin-bottom: 1.5rem;
            animation: fadeUp .5s ease both;
        }

        .field-group:nth-of-type(1) { animation-delay: .25s; }
        .field-group:nth-of-type(2) { animation-delay: .3s; }

        .field-input {
            width: 100%;
            box-sizing: border-box;
            padding: 1.1rem 0.9rem 0.5rem;
            font-size: .95rem;
            color: #1f2937;
            background: rgba(255,255,255,0.8);
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            outline: none;
            transition: border-color .25s ease, box-shadow .25s ease, background .25s ease;
        }

        .field-input:focus {
            border-color: #818cf8;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(129,140,248,0.18);
        }

        .field-label {
            position: absolute;
            left: 0.95rem;
            top: 0.9rem;
            font-size: .95rem;
            color: #9ca3af;
            pointer-events: none;
            transform-origin: left top;
            transition: transform .2s ease, color .2s ease, top .2s ease;
        }

        .field-input:focus + .field-label,
        .field-input:not(:placeholder-shown) + .field-label {
            top: 0.4rem;
            transform: scale(.72) translateY(-2px);
            color: #6366f1;
        }

        .field-line {
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #6366f1, #a855f7);
            border-radius: 2px;
            transition: width .3s ease, left .3s ease;
        }

        .field-input:focus ~ .field-line {
            width: 100%;
            left: 0;
        }

        .toggle-password {
            position: absolute;
            right: 0.75rem;
            top: 0.65rem;
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            padding: 4px;
            display: flex;
            transition: color .2s ease, transform .2s ease;
        }

        .toggle-password:hover { color: #6366f1; transform: scale(1.1); }
        .toggle-password svg { width: 20px; height: 20px; }

        .field-group.shake { animation: shake .4s ease; }
        @keyframes shake {
            10%, 90% { transform: translateX(-2px); }
            20%, 80% { transform: translateX(3px); }
            30%, 50%, 70% { transform: translateX(-5px); }
            40%, 60% { transform: translateX(5px); }
        }

        .options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: .5rem;
            animation: fadeUp .5s .35s ease both;
        }

        .remember-wrap {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            user-select: none;
        }

        .remember-input { display: none; }

        .remember-box {
            width: 19px;
            height: 19px;
            border-radius: 6px;
            border: 1.5px solid #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s ease, border-color .2s ease, transform .15s ease;
        }

        .remember-box svg {
            width: 13px;
            height: 13px;
            opacity: 0;
            transform: scale(.5);
            transition: opacity .15s ease, transform .15s ease;
        }

        .remember-input:checked + .remember-box {
            background: linear-gradient(135deg, #6366f1, #a855f7);
            border-color: transparent;
        }

        .remember-input:checked + .remember-box svg {
            opacity: 1;
            transform: scale(1);
        }

        .remember-wrap:active .remember-box { transform: scale(.9); }

        .remember-text {
            margin-left: .55rem;
            font-size: .85rem;
            color: #4b5563;
        }

        .forgot-link {
            font-size: .85rem;
            color: #6366f1;
            text-decoration: none;
            position: relative;
        }

        .forgot-link::after {
            content: "";
            position: absolute;
            left: 0; bottom: -2px;
            width: 0;
            height: 1.5px;
            background: #6366f1;
            transition: width .25s ease;
        }

        .forgot-link:hover::after { width: 100%; }

        .submit-btn {
            position: relative;
            width: 100%;
            padding: 0.85rem 1rem;
            font-size: .95rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            overflow: hidden;
            box-shadow: 0 8px 20px -6px rgba(99,102,241,0.55);
            transition: transform .15s ease, box-shadow .25s ease;
            animation: fadeUp .5s .4s ease both;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px -6px rgba(99,102,241,0.65);
        }

        .submit-btn:active { transform: translateY(0) scale(.98); }

        .btn-shine {
            position: absolute;
            top: 0;
            left: -75%;
            width: 50%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,0.35), transparent);
            transform: skewX(-20deg);
            pointer-events: none;
        }

        .submit-btn:hover .btn-shine {
            animation: shine .8s ease;
        }

        @keyframes shine {
            to { left: 125%; }
        }

        .submit-btn.loading .btn-text { opacity: 0; }
        .submit-btn.loading::after {
            content: "";
            position: absolute;
            top: 50%; left: 50%;
            width: 18px; height: 18px;
            margin: -9px 0 0 -9px;
            border: 2.5px solid rgba(255,255,255,0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Password visibility toggle
            const toggleBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function () {
                    const isPassword = passwordInput.type === 'password';
                    passwordInput.type = isPassword ? 'text' : 'password';
                    eyeIcon.innerHTML = isPassword
                        ? '<path d="M3 3l18 18M10.6 10.7a3 3 0 0 0 4.2 4.2M9.9 5.1A11 11 0 0 1 23 12s-1.5 2.7-4.2 4.7M6.2 6.9C3.5 8.6 1 12 1 12s4 7 11 7c1.6 0 3-.3 4.3-.9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>'
                        : '<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5"/>';
                });
            }

            // Shake fields that already show a validation error (server-rendered)
            document.querySelectorAll('.field-group').forEach(function (group) {
                if (group.querySelector('.text-red-600, .text-red-500, [role="alert"]')) {
                    group.classList.add('shake');
                }
            });

            // Loading state on submit
            const form = document.getElementById('loginForm');
            const submitBtn = form ? form.querySelector('.submit-btn') : null;
            if (form && submitBtn) {
                form.addEventListener('submit', function () {
                    submitBtn.classList.add('loading');
                    submitBtn.disabled = true;
                });
            }
        });
    </script>
</x-guest-layout>
