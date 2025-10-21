<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Sign Up | KSG AI  training</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/logo-dark.png">

    <!-- Theme Config Js -->
    <script src="{{asset('') }}assets/js/config.js"></script>

    <!-- Vendor css -->
    <link href="{{asset('') }}assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{asset('') }}assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{asset('') }}assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="h-100">

    <div class="auth-bg d-flex min-vh-100 justify-content-center align-items-center">
        <div class="row g-0 justify-content-center w-100 m-xxl-5 px-xxl-4 m-3">
            <div class="col-xl-4 col-lg-5 col-md-6">
                <div class="card overflow-hidden text-center h-100 p-xxl-4 p-3 mb-0">
                    <a href="index.html" class="auth-brand mb-3">
                        <img src="{{asset('') }}assets/images/logo-dark.png" alt="dark logo" height="24" class="logo-dark">
                        <img src="{{asset('') }}assets/images/logo.png" alt="logo light" height="24" class="logo-light">
                    </a>

                    <h4 class="fw-semibold mb-2">Welcome to Reset  Password</h4>

                    <p class="text-muted mb-4">Enter a  strong  password.</p>

                   <form action="{{ route('Agent.set.password') }}" method="POST" class="text-start mb-3">
    @csrf
    <input type="hidden" name="reset_token" value="{{ $agent->reset_token }}">

    <div class="mb-3 position-relative">
        <label class="form-label" for="password">New Password</label>
        <div class="input-group password-wrapper">
            <input type="password" id="password" name="password" class="form-control password-input" placeholder="Enter new password">
            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password">
                <i class="fa fa-eye"></i>
            </button>
        </div>
    </div>

    <div class="mb-3 position-relative">
        <label class="form-label" for="password_confirmation">Confirm Password</label>
        <div class="input-group password-wrapper">
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control password-input" placeholder="Confirm new password">
            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password_confirmation">
                <i class="fa fa-eye"></i>
            </button>
        </div>
    </div>

    <div class="d-grid">
        <button class="btn btn-primary" type="submit">Reset Password</button>
    </div>
</form>

<!-- Password Toggle Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('.toggle-password');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            // Add animation
            input.classList.add('password-toggle-anim');
            setTimeout(() => input.classList.remove('password-toggle-anim'), 200);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                this.classList.add('active');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
                this.classList.remove('active');
            }
        });
    });
});
</script>

<!-- Styling -->
<style>
/* Basic eye button */
.toggle-password {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    transition: all 0.3s ease;
}
.toggle-password.active {
    background-color: #198754;
    color: white;
}

/* Password animation */
.password-input {
    transition: all 0.3s ease;
    position: relative;
}
.password-toggle-anim {
    transform: scale(1.02);
    background-color: #f0fff0;
    box-shadow: 0 0 6px rgba(0, 255, 102, 0.3);
}

/* Icon rotation animation */
.toggle-password i {
    transition: transform 0.3s ease;
}
.toggle-password.active i {
    transform: rotate(180deg);
}

/* Smooth fade on input visibility */
.password-wrapper {
    overflow: hidden;
}
.password-input {
    opacity: 1;
    transition: opacity 0.3s ease;
}
.password-input[type="text"] {
    opacity: 1;
}
.password-input[type="password"] {
    opacity: 1;
}
</style>

<!-- Include Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">



                    <p class="text-danger fs-14 mb-4">Already have an account? <a href="/" class="fw-semibold text-dark ms-1">Login !</a></p>

                    <p class="fs-13 fw-semibold">Or Sign Up with Social</p>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: '{{ session('success') }}',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'OK'
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Registration Failed',
    text: '{{ session('error') }}',
    confirmButtonColor: '#d33',
    confirmButtonText: 'Try Again'
});
</script>
@endif
                   

                    <p class="mt-auto mb-0">
                        <script>document.write(new Date().getFullYear())</script> © Dexa- By <span class="fw-bold text-decoration-underline text-uppercase text-reset fs-12">Dexasolutions.ltd</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor js -->
    <script src="{{asset('') }}assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="{{asset('') }}assets/js/app.js"></script>

</body>

</html>
