
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Disaster Risk Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">

    <style>
        #bgVideo {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            object-fit: cover;
            z-index: -2;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(44, 44, 44, 0.5);
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
            font-size: 4.2rem;
            font-weight: bold;
            letter-spacing: 2px;
            text-align: center;
            margin-top: -120px;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        .title-camaligtas .camalig {
            color: #ff4d4d;
        }

        .title-camaligtas .tas {
            color: #4caf50;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
            max-width: 400px;
            padding: 2.5rem 2rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .login-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
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

        .btn-login {
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

        .btn-login:hover {
            background: rgb(124, 36, 35);
            color:rgb(255, 255, 255);
        }

        .alert {
            border-radius: 12px;
            border: none;
        }

        .signup-link {
            text-align: center;
        }

        @media (max-width: 576px) {
            .login-container {
                max-width: 95vw;
                padding: 1.5rem;
            }
            .title-camaligtas {
                font-size: 2.5rem;
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
    <div class="title-camaligtas">
        <br>
        <span class="camalig">Camalig</span><span class="tas">tas</span>
    </div>

    <!-- Login Box -->
    <div class="login-container">
        <div class="login-header">
            <h2>Login</h2>
            <p style="font-size: 1rem; color: #888;">Sign In with your Phone Number</p>
        </div>

        <!-- Session Alerts -->
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" id="loginForm">

            @csrf
            <div class="form-floating">
                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                       id="phone" name="phone" placeholder="Phone Number" pattern="[0-9]{11}" 
                       value="{{ old('phone') }}" required>
                <label for="phone">
                    <i class="fas fa-phone me-2"></i> Phone Number
                </label>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating">
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" placeholder="Password" required>
                <label for="password">
                    <i class="fas fa-lock me-2"></i> Password
                </label>
                <span class="toggle-password" toggle="#password" style="position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;">
            <i class="fas fa-eye" id="togglePassword"></i>
        </span>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordInput = document.getElementById('confirm_password');

        togglePassword && togglePassword.addEventListener('click', function() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            this.classList.toggle('fa-eye-slash');
        });
        toggleConfirmPassword && toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordInput.type === 'password' ? 'text' : 'password';
            confirmPasswordInput.type = type;
            this.classList.toggle('fa-eye-slash');
        });
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
</script>

            <button type="submit" class="btn btn-login" id="loginBtn">
                <i class="fas fa-sign-in-alt me-2"></i> Access Dashboard
            </button>
        </form>

        <!-- RBI No Modal -->
        <div class="modal fade" id="rbiModal" tabindex="-1" aria-labelledby="rbiModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rbiModalLabel">Enter Registered RBI No.</h5>
                    </div>
                    <div class="modal-body">
                        <div id="rbiModalError" class="alert alert-danger d-none"></div>
                        <input type="text" class="form-control" id="modalRbiNo" placeholder="RBI No." required autofocus>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="submitRbiModal">Submit</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="signup-link">
            <a href="{{ url('forgot_password') }}" style="color: #e53935; text-decoration: underline; font-size: 0.95rem;">Forgot Password?</a>
        </div>
        <div class="signup-link mt-2">
            <a href="{{ url('register') }}" style="color: #4caf50; text-decoration: underline; font-size: 0.95rem;">Register as User</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Slow Down Video -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('bgVideo');
            video.playbackRate = 0.5;
        });
    </script>

    <!-- Login Simulation Script -->
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();
            // Show RBI modal
            document.getElementById('modalRbiNo').value = '';
            document.getElementById('rbiModalError').classList.add('d-none');
            var rbiModal = new bootstrap.Modal(document.getElementById('rbiModal'));
            rbiModal.show();
        });

        document.getElementById('submitRbiModal').addEventListener('click', async function() {
            const phone = document.getElementById('phone').value.trim();
            const password = document.getElementById('password').value;
            const rib_no = document.getElementById('modalRbiNo').value.trim();
            const rbiModalError = document.getElementById('rbiModalError');
            rbiModalError.classList.add('d-none');
            rbiModalError.innerHTML = '';
            if (!phone || !password || !rib_no) {
                rbiModalError.innerHTML = 'Please enter all fields.';
                rbiModalError.classList.remove('d-none');
                return;
            }
            // Send AJAX login
            try {
                const response = await fetch("{{ route('login') }}", {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        phone: phone,
                        password: password,
                        rib_no: rib_no
                    })
                });
                const data = await response.json();
                if (response.ok && data.success) {
                    window.location.href = data.redirect || "{{ url('dashboard') }}";
                } else {
                    rbiModalError.innerHTML = data.message || 'Invalid credentials. Please check your details.';
                    rbiModalError.classList.remove('d-none');
                }
            } catch (e) {
                rbiModalError.innerHTML = 'Login failed. Please try again.';
                rbiModalError.classList.remove('d-none');
                    window.location.href = '/admin/dashboard';
                }, 1000);
                return false;
            }

            // User
            if (phone === '09112233445' && password === 'user123') {
                event.preventDefault();
                document.getElementById('loginBtn').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Accessing...';
                setTimeout(() => {
                    window.location.href = '/user/dashboard';
                }, 1000);
                return false;
            }

            return true;
        }
    </script>

</body>
</html>