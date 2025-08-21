<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration - Camaligtas</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .bg-image {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            object-fit: cover;
            z-index: -2;
            filter: blur(5px) brightness(0.7);
        }
        .bg-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            background: rgba(44,44,44,0.3);
            z-index: -1;
        }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
        }
        .register-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            max-width: 520px;
            padding: 2.5rem 2rem;
            z-index: 1;
        }
        .register-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .register-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
        }
        .form-row {
            display: flex;
            gap: 1rem;
        }
        .form-row .form-floating {
            flex: 1;
        }
        .form-floating {
            margin-bottom: 1.2rem;
        }
        .btn-register {
            background: #4caf50;
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
        }
        .btn-register:hover {
            background: #388e3c;
        }
        .login-link {
            text-align: center;
            margin-top: 1rem;
        }
        /* Modal styles */
        .modal-backdrop.show {
            opacity: 0.5;
        }
        .modal-content {
            border-radius: 16px;
        }
        @media (max-width: 600px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            .register-container {
                max-width: 98vw;
                padding: 1.2rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <img src="{{ asset('assets/img/register-bg.png') }}" alt="Background" class="bg-image">
    <div class="bg-overlay"></div>
    <div class="register-container">
        <div class="register-header">
            <h2>Register as User</h2>
            <p style="font-size: 1rem; color: #888;">Create your account</p>
        </div>
        <div id="registrationErrors" class="alert alert-danger" style="display:none;"></div>
        <form id="registerForm" method="POST" action="{{ url('register') }}">
            @csrf
            <div class="form-row">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name" required>
                    <label for="first_name"><i class="fas fa-user me-2"></i>First name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle name">
                    <label for="middle_name">Middle name (optional)</label>
                </div>
            </div>
            <div class="form-row">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name" required>
                    <label for="last_name">Last name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="suffix" name="suffix" placeholder="Jr., III">
                    <label for="suffix">Suffix (optional)</label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-floating mb-3">
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="09123456789" pattern="[0-9]{11}">
                    <label for="phone"><i class="fas fa-phone me-2"></i>Phone (optional)</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="age" name="age" min="0" placeholder="Age" required>
                    <label for="age">Age</label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-floating mb-3">
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="" selected disabled>Select</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    <label for="gender">Gender</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="birthday" name="birthday" required>
                    <label for="birthday"><i class="fas fa-calendar-day me-2"></i>Birthday</label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-floating mb-3">
                    <select class="form-select" id="purok" name="purok" required>
                        <option value="" selected disabled>Select Purok</option>
                        <option value="Purok1">Purok 1</option>
                        <option value="Purok2">Purok 2</option>
                        <option value="Purok3">Purok 3</option>
                        <option value="Purok4">Purok 4</option>
                        <option value="Purok5">Purok 5</option>
                        <option value="Relocation">Relocation</option>
                    </select>
                    <label for="purok"><i class="fas fa-map-pin me-2"></i>Purok</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="rbi_no" name="rbi_no" placeholder="RBI Number" required>
                    <label for="rbi_no"><i class="fas fa-id-card me-2"></i>RBI Number</label>
                </div>
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                <label for="email"><i class="fas fa-envelope me-2"></i>Email</label>
            </div>
          
            <div class="form-row">
    <div class="form-floating position-relative mb-3">
        <input type="password" class="form-control" id="password" name="password" 
               placeholder="Password" minlength="8" required
               pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
               title="Must be at least 8 characters long and include uppercase, lowercase, number, and special character"
               oncopy="return false" oncut="return false" onpaste="return false"
               autocomplete="new-password">
        <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
        <span class="toggle-password" toggle="#password" style="position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;">
            <i class="fas fa-eye" id="togglePassword"></i>
        </span>
        
    </div>
    <div class="form-floating position-relative">
        <input type="password" class="form-control" id="confirm_password" 
               name="password_confirmation" placeholder="Confirm Password" 
               minlength="8" required
               title="Please confirm your password"
               oncopy="return false" oncut="return false" onpaste="return false"
               autocomplete="new-password">
        <label for="confirm_password"><i class="fas fa-lock me-2"></i>Confirm Password</label>
        <span class="toggle-password" toggle="#confirm_password" style="position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;">
            <i class="fas fa-eye" id="toggleConfirmPassword"></i>
        </span>
    </div>
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
            <button type="submit" class="btn btn-register" id="registerBtn">
                <i class="fas fa-user-plus me-2"></i>Register
            </button>
        </form>
        <div class="login-link">

        <div class="modal fade" id="registrationSuccessModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Registration Complete</h5>
              </div>
              <div class="modal-body text-center">
                <div class="mb-2">Registration complete. Redirecting to Login in <span id="countdown">2</span> seconds.</div>
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

            <a href="{{ url('login') }}" style="color: #e53935; text-decoration: underline; font-size: 0.95rem;">Back to Login</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Helper to enable/disable registration fields
        document.getElementById('registerForm').addEventListener('submit', async function(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const errorsDiv = document.getElementById('registrationErrors');
            const submitBtn = document.getElementById('registerBtn');
            errorsDiv.style.display = 'none';
            errorsDiv.innerHTML = '';

            // Basic client-side checks
            const pw = formData.get('password');
            const pwc = formData.get('password_confirmation');
            if (!pw || pw.length < 8) {
                errorsDiv.textContent = 'Password must be at least 8 characters long';
                errorsDiv.style.display = 'block';
                return;
            }
            if (pw !== pwc) {
                errorsDiv.textContent = 'Passwords do not match';
                errorsDiv.style.display = 'block';
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Registering...';

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });
                const data = await response.json().catch(() => ({ message: 'Unexpected response' }));

                if (response.ok) {
                    window.location.href = '{{ route('login') }}?registered=1';
                } else {
                    let messages = '';
                    if (data && data.errors) {
                        messages = Object.values(data.errors).flat().join('<br>');
                    } else if (data && data.message) {
                        messages = data.message;
                    } else {
                        messages = 'Registration failed. Please check your input and try again.';
                    }
                    errorsDiv.innerHTML = messages;
                    errorsDiv.style.display = 'block';
                }
            } catch (e) {
                errorsDiv.textContent = 'Network error. Please try again.';
                errorsDiv.style.display = 'block';
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-user-plus me-2"></i>Register';
            }
        });
    </script>
</body>
</html>