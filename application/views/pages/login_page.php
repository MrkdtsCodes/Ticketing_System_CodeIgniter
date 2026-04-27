<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
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
    </style>
</head>

<body class="bg-noise min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md fade-in">

        <!-- Card -->
        <div class="card-glow rounded-2xl p-8 backdrop-blur-sm" style="background: rgba(16,16,24,0.85);">

            <!-- Header -->
            <div class="mb-8">
                <h1 class="serif text-white text-3xl mb-1.5">Welcome Admin</h1>
                <p class="text-sm" style="color:rgba(255,255,255,0.4);">Sign in to continue to your workspace</p>
            </div>

            <!-- Form -->
            <form class="space-y-4" action="<?= base_url('validate/user') ?>" method="POST">

                <div>
                    <label class=" block text-xs font-medium mb-2"
                        style="color:rgba(255,255,255,0.5); letter-spacing:0.06em; text-transform:uppercase;">Email
                        address</label>
                    <input type="email" placeholder="you@example.com" id="emailInput" name="email"
                        class="input-field w-full rounded-xl px-4 py-3 text-sm text-white" />
                    <small class=" text-red-400" id="error_section"><?= form_error('email') ?></small>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs font-medium"
                            style="color:rgba(255,255,255,0.5); letter-spacing:0.06em; text-transform:uppercase;">Password</label>

                    </div>

                    <div class="relative">
                        <input type="password" id="passwordInput" placeholder="Enter Valid Password"
                            class="input-field w-full rounded-xl px-4 py-3 pr-11 text-sm text-white" name="password" />

                        <button type="button" id="passwordbtn" class="absolute right-3 top-1/2 -translate-y-1/2 p-1"
                            style="color:rgba(255,255,255,0.3);" title="Toggle visibility">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                <circle cx="12" cy="12" r="3" stroke-linecap="round" />
                            </svg>
                        </button>
                    </div>
                    <small class="text-red-400" id="error_section"><?= form_error('password') ?></small>
                </div>

                <div class="">
                    <small class="text-red-500  ">
                        <?php if ($this->session->flashdata('error')) {
                            echo "<div class='alert'>" . $this->session->flashdata('error') . "</div>";
                        } ?>
                    </small>
                </div>

                <button type="submit" id="sbmt_btnn"
                    class="btn-primary w-full rounded-xl py-3 text-sm font-semibold text-white mt-2">
                    Sign in
                </button>

            </form>

        </div>

        `
    </div>

    <script>

    </script>

</body>
<script>
    const email_inpt = document.getElementById('emailInput');
    const pass_inpt = document.getElementById('passwordInput');
    const eyebtn = document.getElementById('passwordbtn');
    const sbmt_btnn = document.getElementById('sbmt_btnn');
    const error_section = document.querySelectorAll('#error_section');


    eyebtn.addEventListener('click', (e) => {
        if (pass_inpt.type === 'text') {
            pass_inpt.type = 'password';
        } else {
            pass_inpt.type = 'text';
        }
    });
</script>

</html>