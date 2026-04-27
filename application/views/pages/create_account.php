<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }

        .serif {
            font-family: 'DM Serif Display', serif;
        }

        .bg-noise {
            background-color: #0a0a0f;
            background-image:
                radial-gradient(ellipse 80% 60% at 20% 80%, rgba(99, 60, 180, 0.25) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 10%, rgba(30, 90, 200, 0.18) 0%, transparent 55%);
        }

        .card-glow {
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.06),
                0 32px 80px rgba(0, 0, 0, 0.6),
                inset 0 1px 0 rgba(255, 255, 255, 0.08);
        }

        .input-field {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: border-color 0.2s, background 0.2s;
        }

        .input-field:focus {
            outline: none;
            border-color: rgba(140, 100, 255, 0.6);
            background: rgba(255, 255, 255, 0.07);
        }

        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.25);
        }

        .input-field.error {
            border-color: rgba(255, 80, 80, 0.6);
        }

        .input-field.success {
            border-color: rgba(60, 200, 130, 0.6);
        }

        .btn-primary {
            background: linear-gradient(135deg, #7c4dff 0%, #448aff 100%);
            transition: opacity 0.2s, transform 0.15s;
        }

        .btn-primary:hover {
            opacity: 0.88;
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: translateY(0);
            opacity: 1;
        }

        .btn-primary:disabled {
            opacity: 0.5;
            transform: none;
            cursor: not-allowed;
        }

        .divider-line {
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.12), transparent);
        }

        .social-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: background 0.2s, border-color 0.2s;
        }

        .social-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.15);
        }

        .accent-dot {
            width: 6px;
            height: 6px;
            background: #7c4dff;
            border-radius: 50%;
            animation: pulse 2.5s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.4;
                transform: scale(0.7);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Password strength bar */
        .strength-bar {
            height: 3px;
            border-radius: 2px;
            background: rgba(255, 255, 255, 0.08);
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            border-radius: 2px;
            transition: width 0.35s ease, background 0.35s ease;
            width: 0%;
        }

        /* Terms checkbox */
        input[type="checkbox"] {
            accent-color: #7c4dff;
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-noise min-h-screen flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-md fade-in">

        <!-- Logo / Brand -->
        <div class="flex items-center gap-2.5 mb-10 justify-center">
            <div class="accent-dot"></div>
            <span class="serif text-white text-2xl tracking-tight">Aurum</span>
        </div>

        <!-- Card -->
        <div class="card-glow rounded-2xl p-8 backdrop-blur-sm" style="background: rgba(16,16,24,0.85);">

            <!-- Header -->
            <div class="mb-8">
                <h1 class="serif text-white text-3xl mb-1.5">Create account</h1>
                <p class="text-sm" style="color:rgba(255,255,255,0.4);">Start your journey — it's free forever</p>
            </div>

            <!-- Form -->
            <form class="space-y-4" action="<?php echo base_url('create/account'); ?>" method="POST">
                <!-- Personal Details Section -->
                <div class="pt-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="divider-line h-px flex-1"></div>
                        <span class="text-xs font-medium"
                            style="color:rgba(255,255,255,0.35); letter-spacing:0.08em; text-transform:uppercase;">Personal
                            details</span>
                        <div class="divider-line h-px flex-1"></div>
                    </div>

                    <div class="space-y-4">
                        <!-- First / Middle / Last name row -->
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label class="block text-xs font-medium mb-2"
                                    style="color:rgba(255,255,255,0.5); letter-spacing:0.06em; text-transform:uppercase;">First
                                    name</label>
                                <input type="text" name="lname" placeholder="Jane"
                                    class="input-field w-full rounded-xl px-4 py-3 text-sm text-white" />
                                <small class="text-red-500"><?= form_error('lname') ?></small>
                            </div>
                            <div>
                                <label class="block text-xs font-medium mb-2"
                                    style="color:rgba(255,255,255,0.5); letter-spacing:0.06em; text-transform:uppercase;">Middle
                                    name</label>
                                <input type="text" placeholder="Marie" name="fname"
                                    class="input-field w-full rounded-xl px-4 py-3 text-sm text-white" />
                                <small class="text-red-500"><?= form_error('fname') ?></small>
                            </div>
                            <div>
                                <label class="block text-xs font-medium mb-2"
                                    style="color:rgba(255,255,255,0.5); letter-spacing:0.06em; text-transform:uppercase;">Last
                                    name</label>
                                <input type="text" placeholder="Doe" name="mname"
                                    class="input-field w-full rounded-xl px-4 py-3 text-sm text-white" />
                                <small class="text-red-500"><?= form_error('mname') ?></small>
                            </div>
                        </div>

                        <!-- Birthdate -->
                        <div>
                            <label class="block text-xs font-medium mb-2"
                                style="color:rgba(255,255,255,0.5); letter-spacing:0.06em; text-transform:uppercase;">Birthdate</label>
                            <input type="date" class="input-field w-full rounded-xl px-4 py-3 text-sm text-white"
                                name="bday" style="color-scheme: dark;" />
                            <small class="text-red-500"><?= form_error('bday') ?></small>
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-xs font-medium mb-2"
                                style="color:rgba(255,255,255,0.5); letter-spacing:0.06em; text-transform:uppercase;">Address</label>
                            <input type="text" placeholder="123 Main St, City" name="address"
                                class="input-field w-full rounded-xl px-4 py-3 text-sm text-white" />
                            <small class="text-red-500"><?= form_error('address') ?></small>
                        </div>

                        <!-- Zipcode -->
                        <div>
                            <label class="block text-xs font-medium mb-2"
                                style="color:rgba(255,255,255,0.5); letter-spacing:0.06em; text-transform:uppercase;">Zip
                                code</label>
                            <input type="text" placeholder="e.g. 1000" maxlength="10" name="zipcode"
                                class="input-field w-full rounded-xl px-4 py-3 text-sm text-white" />
                            <small class="text-red-500"><?= form_error('zipcode') ?></small>
                        </div>

                        <div class="">
                        </div>

                        <div>
                            <label class=" block text-xs font-medium mb-2"
                                style="color:rgba(255,255,255,0.5); letter-spacing:0.06em; text-transform:uppercase;">
                                Role
                            </label>

                            <select name="roles" id="">
                                <?php
                                ?>
                                <option value="" disabled selected>-- SELECTED ROLES --</option>

                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role['id'] ?>"><?= $role['role_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-red-500"><?= form_error('roles') ?></small>
                        </div>

                    </div>
                </div>

                <!-- Account Section Divider -->
                <div class="pt-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="divider-line h-px flex-1"></div>
                        <span class="text-xs font-medium"
                            style="color:rgba(255,255,255,0.35); letter-spacing:0.08em; text-transform:uppercase;">Account
                            credentials</span>
                        <div class="divider-line h-px flex-1"></div>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-medium mb-2"
                            style="color:rgba(255,255,255,0.5); letter-spacing:0.06em; text-transform:uppercase;">Email
                            address</label>
                        <input type="email" placeholder="you@example.com" name="email"
                            class="input-field w-full rounded-xl px-4 py-3 text-sm text-white" />
                    </div>
                    <label class="block text-xs font-medium mb-2"
                        style="color:rgba(255,255,255,0.5); letter-spacing:0.06em; text-transform:uppercase;">Password</label>
                    <div class="relative">
                        <input type="password" id="passwordInput" placeholder="Min. 8 characters" name="password"
                            class="input-field w-full rounded-xl px-4 py-3 pr-11 text-sm text-white" />
                        <button type="button" onclick="togglePassword('passwordInput','eyeIcon1')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 p-1" style="color:rgba(255,255,255,0.3);">
                            <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                <circle cx="12" cy="12" r="3" stroke-linecap="round" />
                            </svg>
                        </button>
                    </div>
                    <!-- Strength meter -->
                    <div class="mt-2 space-y-1.5">
                        <div class="flex gap-1.5">
                            <div class="strength-bar flex-1">
                                <div id="bar1" class="strength-fill"></div>
                            </div>
                            <div class="strength-bar flex-1">
                                <div id="bar2" class="strength-fill"></div>
                            </div>
                            <div class="strength-bar flex-1">
                                <div id="bar3" class="strength-fill"></div>
                            </div>
                            <div class="strength-bar flex-1">
                                <div id="bar4" class="strength-fill"></div>
                            </div>
                        </div>
                        <p id="strengthLabel" class="text-xs" style="color:rgba(255,255,255,0.3);">Enter a password</p>
                    </div>
                </div>

                <!-- Confirm Password -->
                <!-- <div>
                    <label class="block text-xs font-medium mb-3 p-2"
                        style="color:rgba(255,255,255,0.5); letter-spacing:0.06em; text-transform:uppercase;">Confirm
                        password</label>
                    <div class="relative">
                        <input type="password" id="confirmInput" placeholder="Re-enter your password"
                            oninput="checkMatch()"
                            class="input-field w-full rounded-xl px-4 py-3 pr-11 text-sm text-white" />
                        <button type="button" onclick="togglePassword('confirmInput','eyeIcon2')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 p-1" style="color:rgba(255,255,255,0.3);">
                            <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                <circle cx="12" cy="12" r="3" stroke-linecap="round" />
                            </svg>
                        </button>
                        <span id="matchIcon" class="absolute right-9 top-1/2 -translate-y-1/2 text-xs hidden"></span>
                    </div>
                    <p id="matchMsg" class="text-xs mt-1.5 hidden" style="color:rgba(255,80,80,0.85);">Passwords do not
                        match</p>
                </div> -->

                <!-- Terms -->
                <!-- <div class="flex items-start gap-2.5 pt-1">
                    <input type="checkbox" id="terms" class="mt-0.5 w-4 h-4 rounded" required />
                    <label for="terms" class="text-sm leading-relaxed" style="color:rgba(255,255,255,0.45);">
                        I agree to the
                        <a href="#" class="hover:text-white transition-colors"
                            style="color:rgba(140,100,255,0.85);">Terms of Service</a>
                        and
                        <a href="#" class="hover:text-white transition-colors"
                            style="color:rgba(140,100,255,0.85);">Privacy Policy</a>
                    </label>
                </div> -->

                <input id="submitBtn" type="submit"
                    class="btn-primary w-full rounded-xl py-3 text-sm font-semibold text-white mt-2">
                Create account
                </input>

            </form>

        </div>

        <!-- Footer -->
        <p class="text-center text-sm mt-6" style="color:rgba(255,255,255,0.3);">
            Already have an account?
            <a href="login.html" class="font-medium hover:text-white transition-colors"
                style="color:rgba(140,100,255,0.85);">Sign in</a>
        </p>

    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden ?
                `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>` :
                `<path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/><circle cx="12" cy="12" r="3" stroke-linecap="round"/>`;
        }

        function checkStrength(val) {
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const colors = ['#ff5050', '#ffaa00', '#4db8ff', '#3cc882'];
            const labels = ['Weak', 'Fair', 'Good', 'Strong'];
            const label = document.getElementById('strengthLabel');

            for (let i = 1; i <= 4; i++) {
                const bar = document.getElementById('bar' + i);
                if (i <= score) {
                    bar.style.width = '100%';
                    bar.style.background = colors[score - 1];
                } else {
                    bar.style.width = '0%';
                }
            }

            if (val.length === 0) {
                label.textContent = 'Enter a password';
                label.style.color = 'rgba(255,255,255,0.3)';
            } else {
                label.textContent = labels[score - 1] || 'Weak';
                label.style.color = colors[score - 1];
            }

            checkMatch();
        }

        function checkMatch() {
            const pw = document.getElementById('passwordInput').value;
            const cf = document.getElementById('confirmInput').value;
            const msg = document.getElementById('matchMsg');
            const field = document.getElementById('confirmInput');
            if (!cf) {
                msg.classList.add('hidden');
                field.classList.remove('error', 'success');
                return;
            }
            if (pw === cf) {
                msg.classList.add('hidden');
                field.classList.remove('error');
                field.classList.add('success');
            } else {
                msg.classList.remove('hidden');
                field.classList.remove('success');
                field.classList.add('error');
            }
        }

        function handleRegister(e) {
            e.preventDefault();
            const btn = document.getElementById('submitBtn');
            const pw = document.getElementById('passwordInput').value;
            const cf = document.getElementById('confirmInput').value;
            if (pw !== cf) return;
            btn.textContent = 'Creating account…';
            btn.disabled = true;
            setTimeout(() => {
                btn.textContent = 'Create account';
                btn.disabled = false;
            }, 2000);
        }
    </script>

</body>

</html>