<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration - Camaligtas</title>
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
                <div class="form-floating">
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>
                    <label for="first_name"><i class="fas fa-user me-2"></i>First Name</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name" required>
                    <label for="middle_name"><i class="fas fa-user me-2"></i>Middle Name</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
                    <label for="last_name"><i class="fas fa-user me-2"></i>Last Name</label>
                </div>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="rib_no" name="rib_no" placeholder="RIB No." required>
                <label for="rib_no"><i class="fas fa-id-card me-2"></i>RIB No.</label>
            </div>
            <div id="residentCheckMsg" class="alert alert-info d-none" role="alert"></div>

            <div class="form-row">
                <div class="form-floating">
                    <input type="number" min="1" class="form-control" id="age" name="age" placeholder="Age" required disabled>
                    <label for="age"><i class="fas fa-calendar me-2"></i>Age</label>
                </div>
                <div class="form-floating">
                    <select class="form-control" id="gender" name="gender" required disabled>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    <label for="gender"><i class="fas fa-venus-mars me-2"></i>Gender</label>
                </div>
            </div>
            <div class="form-floating">
                <input type="tel" class="form-control" id="contact" name="contact" placeholder="Contact Number" pattern="[0-9]{11}" required disabled>
                <label for="contact"><i class="fas fa-phone me-2"></i>Contact Number</label>
            </div>
          
            <div class="form-row">
    <div class="form-floating position-relative mb-3">
        <input type="password" class="form-control" id="password" name="password" 
               placeholder="Password" minlength="8" required disabled
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
               minlength="8" required disabled
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
            <button type="submit" class="btn btn-register" id="registerBtn" disabled>
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
        function setRegistrationFieldsEnabled(enabled) {
            document.getElementById('age').disabled = !enabled;
            document.getElementById('gender').disabled = !enabled;
            document.getElementById('contact').disabled = !enabled;
            document.getElementById('password').disabled = !enabled;
            document.getElementById('confirm_password').disabled = !enabled;
            document.getElementById('registerBtn').disabled = !enabled;
        }

        async function checkResidentMatch() {
            const firstName = document.getElementById('first_name').value.trim();
            const middleName = document.getElementById('middle_name').value.trim();
            const lastName = document.getElementById('last_name').value.trim();
            const ribNo = document.getElementById('rib_no').value.trim();
            const msgDiv = document.getElementById('residentCheckMsg');
            msgDiv.classList.remove('d-none', 'alert-success', 'alert-danger', 'alert-info');
            msgDiv.innerText = '';

            if (!firstName || !middleName || !lastName || !ribNo) {
                setRegistrationFieldsEnabled(false);
                msgDiv.classList.add('d-none');
                return;
            }
            msgDiv.classList.add('alert-info');
            msgDiv.innerText = 'Checking resident record...';
            try {
                const resp = await fetch("{{ url('register/check-resident') }}", {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        first_name: firstName,
                        middle_name: middleName,
                        last_name: lastName,
                        rib_no: ribNo
                    })
                });
                const data = await resp.json();
                if (resp.ok && data.exists && !data.registered) {
                    setRegistrationFieldsEnabled(true);
                    msgDiv.classList.remove('alert-info', 'alert-danger');
                    msgDiv.classList.add('alert-success');
                    msgDiv.innerText = 'Resident found. Please complete your registration.';
                } else if (data.exists && data.registered) {
                    setRegistrationFieldsEnabled(false);
                    msgDiv.classList.remove('alert-info', 'alert-success');
                    msgDiv.classList.add('alert-danger');
                    msgDiv.innerText = 'This resident is already registered.';
                } else {
                    setRegistrationFieldsEnabled(false);
                    msgDiv.classList.remove('alert-info', 'alert-success');
                    msgDiv.classList.add('alert-danger');
                    msgDiv.innerText = data.message || 'No matching resident found.';
                }
            } catch (e) {
                setRegistrationFieldsEnabled(false);
                msgDiv.classList.remove('alert-info', 'alert-success');
                msgDiv.classList.add('alert-danger');
                msgDiv.innerText = 'Error checking resident. Please try again.';
            }
        }

        ['first_name','middle_name','last_name','rib_no'].forEach(id => {
            document.getElementById(id).addEventListener('blur', checkResidentMatch);
            document.getElementById(id).addEventListener('input', function() {
                setRegistrationFieldsEnabled(false);
                document.getElementById('residentCheckMsg').classList.add('d-none');
            });
        });

        // On page load, disable fields except name/rbi
        setRegistrationFieldsEnabled(false);


        document.getElementById('registerForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const errorsDiv = document.getElementById('registrationErrors');
            errorsDiv.style.display = 'none'; // Hide previous errors
            errorsDiv.innerHTML = ''; // Clear previous error messages

            // Client-side validation for password match
            if (password !== confirmPassword) {
                errorsDiv.innerHTML = '<div>Passwords do not match. Please ensure both password fields are identical.</div>';
                errorsDiv.style.display = 'block';
                return;
            }

            // Client-side validation for empty fields (basic check)
            const requiredFields = ['first_name', 'middle_name', 'last_name', 'rib_no', 'age', 'gender', 'contact', 'password', 'confirm_password'];
            let hasEmptyFields = false;
            let missingFields = [];

            requiredFields.forEach(fieldId => {
                const inputElement = document.getElementById(fieldId);
                // Check if the element exists and its value is empty or just whitespace
                if (inputElement && inputElement.value.trim() === '') {
                    hasEmptyFields = true;
                    // Format field names for better user readability
                    const fieldName = inputElement.previousElementSibling ? inputElement.previousElementSibling.textContent.trim().replace('*', '') : fieldId.replace('_', ' ');
                    missingFields.push(fieldName);
                }
            });

            if (hasEmptyFields) {
                errorsDiv.innerHTML = `<div>Please fill in all required fields: ${missingFields.join(', ')}.</div>`;
                errorsDiv.style.display = 'block';
                return;
            }


            const form = event.target;
            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                });

                if (response.ok) {
                    // Registration successful
                    var successModal = new bootstrap.Modal(document.getElementById('registrationSuccessModal'));
                    successModal.show();

                    let countdown = 2;
                    const countdownElement = document.getElementById('countdown');
                    countdownElement.innerText = countdown;

                    const interval = setInterval(() => {
                        countdown--;
                        countdownElement.innerText = countdown;
                        if (countdown <= 0) {
                            clearInterval(interval);
                            window.location.href = "{{ url('login') }}";
                        }
                    }, 1000);
                } else {
                    // Registration failed, display errors
                    const data = await response.json();
                    let messages = '';

                    if (response.status === 422 && data.errors) {
                        // Laravel validation errors (most common for specific messages)
                        Object.entries(data.errors).forEach(([field, errArr]) => {
                            errArr.forEach(msg => {
                                if (field === 'contact') {
                                    messages += `<div>Error with Contact Number: ${msg}. Please use a unique 11-digit phone number.</div>`;
                                } else if (field === 'password') {
                                    messages += `<div>Password Error: ${msg}. Passwords must be at least 8 characters long and include a mix of uppercase, lowercase, numbers, and symbols.</div>`;
                                } else if (field === 'rib_no') {
                                    messages += `<div>RIB No. Error: ${msg}. The RIB number you entered may be invalid or already registered.</div>`;
                                }
                                else {
                                    messages += `<div>${msg}</div>`;
                                }
                            });
                        });
                    } else if (data.message) {
                        // General error message from the server (e.g., integrity constraint)
                        if (data.message.includes('Duplicate entry') && data.message.includes('users_phone_unique')) {
                            messages = '<div>Registration failed: The contact number you entered is already registered. Please use a different phone number.</div>';
                        } else if (data.message.includes('Integrity constraint violation')) {
                            messages = '<div>Registration failed due to a data conflict. This might mean your details are already registered. Please check or try different inputs.</div>';
                        } else {
                            messages = `<div>Registration failed: ${data.message}</div>`;
                        }
                    } else {
                        messages = '<div>Registration failed. Please check your input and try again.</div>';
                    }
                    errorsDiv.innerHTML = messages;
                    errorsDiv.style.display = 'block';
                }
            } catch (error) {
                console.error('Fetch error:', error);
                errorsDiv.innerHTML = '<div>An unexpected error occurred. Please check your internet connection and try again.</div>';
                errorsDiv.style.display = 'block';
            }
        });
    </script>
</body>
</html>