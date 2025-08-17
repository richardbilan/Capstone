<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - Disaster Risk Dashboard</title>
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

        .forgot-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
            max-width: 400px;
            padding: 2.5rem 2rem;
        }

        .forgot-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .forgot-header h2 {
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

        .btn-forgot {
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

        .btn-forgot:hover {
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
            .forgot-container {
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

    <!-- Forgot Password Box -->
    <div class="forgot-container my-3">
        <div class="forgot-header">
            <h2>Forgot Password</h2>
            <p class="mb-0" style="font-size: 1rem; color: #888;">Enter your phone number to receive a reset code</p>
        </div>

        <form id="otpForm">
            <div class="form-floating">
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone Number" pattern="[0-9]{11}" required>
                <label for="phone">
                    <i class="fas fa-phone me-2"></i>Phone Number
                </label>
            </div>

            <button type="submit" class="btn btn-forgot">
                <i class="fas fa-sms me-2"></i> Send Code
            </button>
        </form>

        <div class="back-link">
            <a href="{{ url('login') }}"><i class="fas fa-arrow-left me-1"></i>Back to Login</a>
        </div>
    </div>

    <!-- OTP Modal -->
    <div class="modal fade" id="otpModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-shield-alt me-2"></i>Verify OTP</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div id="otpMessage" class="alert alert-info d-none"></div>
            <p class="mb-2">We have sent a 6-digit code to your phone. Enter it below:</p>
            <form id="verifyOtpForm">
                <div class="form-group mb-3">
                    <input type="text" class="form-control text-center otp-input" id="otpCode" 
                           placeholder="Enter OTP" maxlength="6" pattern="[0-9]{6}" required
                           style="font-size: 1.5rem; letter-spacing: 5px; height: 60px;">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success w-100 mb-3" id="verifyOtpBtn">
                        <i class="fas fa-check-circle me-2"></i> Verify OTP
                    </button>
                    <p style="font-size: 0.9rem;" id="resendText">
                        Didn't receive the code? 
                        <a href="#" class="text-danger" id="resendOtpLink" onclick="resendOtp(); return false;">Resend</a>
                        <span id="countdown" class="text-muted"></span>
                    </p>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Video Speed -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('bgVideo');
            video.playbackRate = 0.5;
        });
    </script>

    <!-- OTP Verification Logic -->
    <script>
        const otpForm = document.getElementById('otpForm');
        const verifyOtpForm = document.getElementById('verifyOtpForm');
        const otpModal = new bootstrap.Modal(document.getElementById('otpModal'));
        const resendOtpLink = document.getElementById('resendOtpLink');
        const countdownElement = document.getElementById('countdown');
        const otpMessage = document.getElementById('otpMessage');
        const verifyOtpBtn = document.getElementById('verifyOtpBtn');
        
        let countdown = 60; // 60 seconds countdown
        let countdownInterval;

        // Handle OTP form submission
        otpForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const phoneNumber = document.getElementById('phone').value;
            
            // Show loading state
            const submitBtn = otpForm.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...';
            
            // In a real app, you would send an AJAX request to your backend here
            // Example:
            // fetch('/send-otp', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            //     },
            //     body: JSON.stringify({ phone: phoneNumber })
            // })
            // .then(response => response.json())
            // .then(data => {
            //     if (data.success) {
                    startCountdown();
                    otpModal.show();
            //     } else {
            //         showOtpMessage('Failed to send OTP. Please try again.', 'danger');
            //     }
            // })
            // .catch(error => {
            //     showOtpMessage('An error occurred. Please try again.', 'danger');
            // })
            // .finally(() => {
            //     submitBtn.disabled = false;
            //     submitBtn.innerHTML = originalBtnText;
            // });

            // For demo purposes, we'll simulate a successful response
            setTimeout(() => {
                startCountdown();
                otpModal.show();
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }, 1000);
        });

        // Handle OTP verification
        verifyOtpForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const otpCode = document.getElementById('otpCode').value;
            
            // Show loading state
            verifyOtpBtn.disabled = true;
            verifyOtpBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Verifying...';
            
            // For demo purposes, accept '123' as a valid OTP
            if (otpCode === '123456') {
                // Show success and proceed with password reset
                showOtpMessage('OTP verified successfully! Redirecting...', 'success');
                const phoneNumber = document.getElementById('phone').value;
                const token = 'demo_reset_token_' + Date.now();
                
                // Build the URL with token and phone
                const resetUrl = '{{ url("/reset-password") }}/' + token + '?phone=' + encodeURIComponent(phoneNumber);
                
                setTimeout(() => {
                    window.location.href = resetUrl;
                }, 1500);
            } else {
                // For other codes, show error and re-enable the button
                showOtpMessage('Invalid OTP code.', 'danger');
                verifyOtpBtn.disabled = false;
                verifyOtpBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i> Verify OTP';
            }
        });

        // Handle OTP resend
        function resendOtp() {
            if (resendOtpLink.classList.contains('disabled')) return;
            
            // Show loading state
            resendOtpLink.innerHTML = 'Sending...';
            
            // In a real app, you would resend the OTP via your backend
            // fetch('/resend-otp', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            //     },
            //     body: JSON.stringify({ 
            //         phone: document.getElementById('phone').value 
            //     })
            // })
            // .then(response => response.json())
            // .then(data => {
            //     if (data.success) {
                        showOtpMessage('New OTP sent successfully!', 'success');
                        startCountdown();
            //     } else {
            //         showOtpMessage('Failed to resend OTP. Please try again.', 'danger');
            //     }
            // })
            // .catch(error => {
            //     showOtpMessage('An error occurred. Please try again.', 'danger');
            // });
            
            // For demo purposes, we'll simulate a successful resend
            setTimeout(() => {
                showOtpMessage('New OTP sent successfully!', 'success');
                startCountdown();
            }, 500);
        }

        // Start countdown timer
        function startCountdown() {
            clearInterval(countdownInterval);
            countdown = 60;
            resendOtpLink.classList.add('disabled');
            resendOtpLink.style.pointerEvents = 'none';
            
            updateCountdownText();
            
            countdownInterval = setInterval(() => {
                countdown--;
                updateCountdownText();
                
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    resendOtpLink.classList.remove('disabled');
                    resendOtpLink.style.pointerEvents = 'auto';
                    resendOtpLink.innerHTML = 'Resend';
                    countdownElement.textContent = '';
                }
            }, 1000);
        }
        
        // Update countdown text
        function updateCountdownText() {
            countdownElement.textContent = ` (${countdown}s)`;
        }
        
        // Show OTP message
        function showOtpMessage(message, type = 'info') {
            otpMessage.textContent = message;
            otpMessage.className = `alert alert-${type} mb-3`;
            otpMessage.classList.remove('d-none');
            
            // Auto-hide after 5 seconds for non-error messages
            if (type !== 'danger') {
                setTimeout(() => {
                    otpMessage.classList.add('d-none');
                }, 5000);
            }
        }
        
        // Auto-focus next input field in OTP
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('otp-input')) {
                if (e.target.value.length === e.target.maxLength) {
                    const nextInput = e.target.nextElementSibling;
                    if (nextInput && nextInput.classList.contains('otp-input')) {
                        nextInput.focus();
                    }
                }
            }
        });
    </script>

</body>
</html>
