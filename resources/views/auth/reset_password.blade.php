<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - Disaster Risk Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
    <style>
        /* Background Video */
        #bgVideo {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            object-fit: cover;
            z-index: -2;
        }

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: -1;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .title-camaligtas {
            font-family: 'Lobster', cursive;
            font-size: 3rem;
            font-weight: bold;
            letter-spacing: 2px;
            text-align: center;
            margin-top: -60px;
            color: white;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.7);
        }

        .title-camaligtas .camalig {
            color: #ff4d4d;
        }

        .title-camaligtas .tas {
            color: #4caf50;
        }

        .reset-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
            max-width: 400px;
            padding: 2.5rem 2rem;
        }

        .reset-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .reset-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .form-floating {
            margin-bottom: 1.2rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.75rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #e53935;
            box-shadow: 0 0 0 0.2rem rgba(229,57,53,0.10);
        }

        .btn-reset {
            background: rgb(175, 62, 60);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
            width: 100%;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 2px 8px rgba(229,57,53,0.10);
        }

        .btn-reset:hover {
            background: rgb(124, 36, 35);
        }

        .back-link {
            text-align: center;
            margin-top: 1rem;
        }

        .back-link a {
            color: #43a047;
            text-decoration: underline;
            font-size: 0.95rem;
        }

        @media (max-width: 576px) {
            .reset-container {
                max-width: 98vw;
                padding: 1rem;
            }
            .title-camaligtas {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>
    <!-- Background Video -->
    <video autoplay muted loop playsinline id="bgVideo">
        <source src="{{ asset('Video-bg/system bg.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Overlay -->
    <div class="overlay"></div>

    <!-- Title -->
    <div class="title-camaligtas"><br>
        <span class="camalig">Camalig</span><span class="tas">tas</span>
    </div>

    <!-- Reset Password Box -->
    <div class="reset-container my-3">
        <div class="reset-header">
            <h2>Reset Password</h2>
            <p class="mb-0" style="font-size: 1rem; color: #888;">Enter your new password below</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token ?? old('token') }}">
            <input type="hidden" name="phone" value="{{ $phone ?? old('phone') }}">
            
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" 
                       name="phone" value="{{ $phone ?? old('phone') }}" required autofocus readonly>
                <label for="phone">
                    <i class="fas fa-phone me-2"></i>Phone Number
                </label>
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" required autocomplete="new-password">
                <label for="password">
                    <i class="fas fa-lock me-2"></i>New Password
                </label>
                <span class="toggle-password" toggle="#password" style="position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;">
            <i class="fas fa-eye" id="togglePassword"></i>
        </span>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                
            </div>

            <div class="form-floating mb-4">
                <input type="password" class="form-control" id="password-confirm" 
                       name="password_confirmation" required autocomplete="new-password">
                <label for="password-confirm">
                    <i class="fas fa-lock me-2"></i>Confirm New Password
                </label>
                <span class="toggle-password" toggle="#password-confirm" style="position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;">
            <i class="fas fa-eye" id="toggleConfirmPassword"></i>
        </span>                
            </div>

            <button type="submit" class="btn btn-reset">
                <i class="fas fa-key me-2"></i> Reset Password
            </button>
        </form>

        <div class="back-link">
            <a href="{{ route('login') }}"><i class="fas fa-arrow-left me-1"></i>Back to Login</a>
        </div>
        
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Video Speed -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Video speed control
            const video = document.getElementById('bgVideo');
            if (video) {
                video.playbackRate = 0.5;
            }

            // Password toggle functionality using event delegation
            document.addEventListener('click', function(e) {
                // For new password
                if (e.target.matches('#togglePassword, #togglePassword *')) {
                    const icon = e.target.matches('#togglePassword') ? e.target : e.target.closest('#togglePassword');
                    const passwordInput = document.getElementById('password');
                    if (passwordInput) {
                        const type = passwordInput.type === 'password' ? 'text' : 'password';
                        passwordInput.type = type;
                        icon.classList.toggle('fa-eye');
                        icon.classList.toggle('fa-eye-slash');
                    }
                }
                
                // For confirm password
                if (e.target.matches('#toggleConfirmPassword, #toggleConfirmPassword *')) {
                    const icon = e.target.matches('#toggleConfirmPassword') ? e.target : e.target.closest('#toggleConfirmPassword');
                    const confirmPasswordInput = document.getElementById('password-confirm');
                    if (confirmPasswordInput) {
                        const type = confirmPasswordInput.type === 'password' ? 'text' : 'password';
                        confirmPasswordInput.type = type;
                        icon.classList.toggle('fa-eye');
                        icon.classList.toggle('fa-eye-slash');
                    }
                }
            });

            // Prevent context menu (right-click) on password fields
            document.addEventListener('contextmenu', function(e) {
                if (e.target.type === 'password') {
                    e.preventDefault();
                    return false;
                }
            });

            // Prevent keyboard shortcuts for copy/paste
            document.addEventListener('keydown', function(e) {
                const activeElement = document.activeElement;
                if (activeElement.type === 'password' && 
                    (e.ctrlKey || e.metaKey) && 
                    (e.key === 'c' || e.key === 'C' || e.key === 'v' || e.key === 'V' || e.key === 'x' || e.key === 'X')) {
                    e.preventDefault();
                    return false;
                }
            });
        });

    </script>
</body>
</html>
