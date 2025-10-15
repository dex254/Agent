<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Log In KSG AI  training</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/logo-dark.png">

    <!-- Theme Config Js -->
    <script src="assets/js/config.js"></script>

    <!-- Vendor css -->
    <link href="assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <div class="auth-bg d-flex min-vh-100 justify-content-center align-items-center">
        <div class="row g-0 justify-content-center w-100 m-xxl-5 px-xxl-4 m-3">
            <div class="col-xl-4 col-lg-5 col-md-6">
                <div class="card overflow-hidden text-center h-100 p-xxl-4 p-3 mb-0">
                    <a href="index.html" class="auth-brand mb-3">
                        <img src="assets/images/logo-dark.png" alt="dark logo" height="30" class="logo-dark">
                        <img src="assets/images/logo.png" alt="logo light" height="30" class="logo-light">
                    </a>

                    <h4 class="fw-semibold mb-2">Login your account</h4>

                    <p class="text-muted mb-4">Enter your email address and password to access admin panel.</p>

                   <form method="POST" action="{{ route('agent') }}" class="text-start mb-3">
    @csrf

    {{-- ✅ Email Input --}}
    <div class="mb-3">
        <label class="form-label" for="example-email">Email</label>
        <input 
            type="email" 
            id="example-email" 
            name="email" 
            value="{{ old('email') }}"
            class="form-control @error('email') is-invalid @enderror" 
            placeholder="Enter your email"
            required
        >
        @error('email')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- ✅ Password Input with Animated Show/Hide --}}
   <!-- Include Font Awesome (only once in your layout/head) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- Password field with animated show/hide -->
<div class="mb-3 position-relative">
    <label class="form-label" for="example-password">Password</label>

    <div class="input-group password-wrapper" data-target="example-password">
        <input
            type="password"
            id="example-password"
            name="password"
            class="form-control password-input"
            placeholder="Enter your password"
            autocomplete="current-password"
        >
        <button type="button" class="btn btn-outline-secondary toggle-password" aria-label="Show password">
            <i class="fa fa-eye"></i>
        </button>
    </div>
</div>

<style>
/* Wrapper */
.password-wrapper {
    display: flex;
    align-items: center;
    position: relative;
    overflow: visible;
}

/* Smooth input fade */
.password-input {
    transition: opacity 180ms ease, transform 220ms ease, box-shadow 220ms ease;
    opacity: 1;
}

/* When animating we fade out input slightly */
.password-wrapper.animating .password-input {
    opacity: 0;
    transform: translateY(-4px) scale(0.997);
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
}

/* Active state (password visible) - subtle highlight */
.password-wrapper.active .password-input {
    box-shadow: 0 6px 18px rgba(0,204,102,0.12); /* neon-green glow */
}

/* Toggle button styling + animation */
.toggle-password {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    border-left: 1px solid rgba(0,0,0,0.05);
    transition: transform 220ms cubic-bezier(.2,.9,.2,1), background-color 220ms, color 220ms;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
}

/* Scale the button slightly when active */
.password-wrapper.active .toggle-password {
    transform: scale(1.06);
    background-color: #004d00;      /* royal green */
    color: #fff;
}

/* Eye icon rotation */
.toggle-password i {
    display: inline-block;
    transition: transform 300ms ease;
    font-size: 18px;
}

/* rotate when active */
.password-wrapper.active .toggle-password i {
    transform: rotateY(180deg);
}

/* Accessibility: focus visible for keyboard users */
.toggle-password:focus {
    outline: 2px solid #00cc66;
    outline-offset: 2px;
}

/* Optional input focus glow */
.password-input:focus {
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    border-color: #00cc66;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const wrappers = document.querySelectorAll('.password-wrapper');

    wrappers.forEach(wrapper => {
        const btn = wrapper.querySelector('.toggle-password');
        const input = wrapper.querySelector('.password-input');
        const icon = btn.querySelector('i');

        btn.addEventListener('click', function () {
            // If already animating, ignore clicks
            if (wrapper.classList.contains('animating')) return;

            // Start fade-out animation
            wrapper.classList.add('animating');

            // Duration should match CSS transition opacity (180ms)
            setTimeout(() => {
                // Toggle input type
                if (input.type === 'password') {
                    input.type = 'text';
                    wrapper.classList.add('active'); // visual active state
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                    btn.setAttribute('aria-label', 'Hide password');
                } else {
                    input.type = 'password';
                    wrapper.classList.remove('active');
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                    btn.setAttribute('aria-label', 'Show password');
                }

                // Small pause to allow browser to render changed input type
                setTimeout(() => {
                    // end animation (fade-in)
                    wrapper.classList.remove('animating');
                    // shift focus back to input so caret is visible when showing text
                    input.focus();
                    // Move caret to end for UX
                    const val = input.value;
                    input.value = '';
                    input.value = val;
                }, 180); // match the fade-out time
            }, 180); // match the fade-out time
        });

        // Optional: toggle via pressing Enter when button focused
        btn.addEventListener('keypress', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                btn.click();
            }
        });
    });
});
</script>


    {{-- ✅ Forgot Password Link --}}
    <div class="d-flex justify-content-between mb-3">
        <div class="form-check"></div>
        <a href="{{ route('Agent.Password') }}" class="text-muted border-bottom border-dashed">Forget Password?</a>
    </div>

    {{-- ✅ Submit Button --}}
    <div class="d-grid">
        <button class="btn btn-primary" type="submit">Login</button>
    </div>
</form>



{{-- ✅ SweetAlert for Notifications --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: '{{ session('success') }}',
    confirmButtonColor: '#3085d6',
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Login Failed',
    text: '{{ session('error') }}',
    confirmButtonColor: '#d33',
});
</script>
@endif

@if ($errors->any())
<script>
Swal.fire({
    icon: 'warning',
    title: 'Validation Error',
    html: `{!! implode('<br>', $errors->all()) !!}`,
    confirmButtonColor: '#f39c12',
});
</script>
@endif




                    <p class="text-danger fs-14 mb-4">Don't have an account? <a href="{{ route('Agent.Register') }}" class="fw-semibold text-dark ms-1">Sign Up !</a></p>

                    <p class="fs-13 fw-semibold">Or Login with Social</p>
                     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



                   

                    <p class="mt-auto mb-0">
                        <script>document.write(new Date().getFullYear())</script> © Dexa - By <span class="fw-bold text-decoration-underline text-uppercase text-reset fs-12">Dexasolutions.ltd</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

</body>

</html>
