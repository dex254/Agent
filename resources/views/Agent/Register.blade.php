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
    <script src="assets/js/config.js"></script>

    <!-- Vendor css -->
    <link href="assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="h-100">

    <div class="auth-bg d-flex min-vh-100 justify-content-center align-items-center">
        <div class="row g-0 justify-content-center w-100 m-xxl-5 px-xxl-4 m-3">
            <div class="col-xl-4 col-lg-5 col-md-6">
                <div class="card overflow-hidden text-center h-100 p-xxl-4 p-3 mb-0">
                    <a href="index.html" class="auth-brand mb-3">
                        <img src="assets/images/logo-dark.png" alt="dark logo" height="24" class="logo-dark">
                        <img src="assets/images/logo.png" alt="logo light" height="24" class="logo-light">
                    </a>

                    <h4 class="fw-semibold mb-2">Welcome to Marketing   Admin</h4>

                    <p class="text-muted mb-4">Enter your name , email address and password to access account.</p>

                    <form action="{{ route('agent.register') }}" method="POST" class="text-start mb-3">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="example-email">Email</label>
                            <input type="email" id="example-email" name="email" class="form-control" placeholder="Enter your email">
                        </div>
                        @error('email')
            <small class="text-danger">{{ $message }}</small>
        @enderror

                        <div class="mb-3">
                            <label class="form-label" for="example-password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
                        </div>
                         @error('password')
            <small class="text-danger">{{ $message }}</small>
        @enderror

                         <div class="mb-3">
                            <label class="form-label" for="example-password">  Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Enter your password">
                        </div>
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
                      

                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit">Sign Up</button>
                        </div>
                    </form>

                    <p class="text-danger fs-14 mb-4">Already have an account? <a href="/" class="fw-semibold text-dark ms-1">Login !</a></p>

                    <p class="fs-13 fw-semibold">Or Sign Up with Social</p>

                   

                    <p class="mt-auto mb-0">
                        <script>document.write(new Date().getFullYear())</script> © Dexa- By <span class="fw-bold text-decoration-underline text-uppercase text-reset fs-12">Dexasolutions.ltd</span>
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
