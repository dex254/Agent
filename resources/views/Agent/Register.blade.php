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
                        <style>
                            #passwordStrength {
    font-weight: 600;
    margin-top: 5px;
}
.input-group .btn {
    border-radius: 0 5px 5px 0;
}

                            </style>
    <label for="password" class="form-label">Password</label>
    <div class="input-group">
        <input type="password" id="password" name="password" class="form-control" required minlength="8" placeholder="Enter password">
        <button type="button" class="btn btn-outline-secondary" id="togglePassword">Show</button>
    </div>
    <small id="passwordStrength" class="form-text text-muted"></small>
</div>

<div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirm Password</label>
    <div class="input-group">
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required minlength="8" placeholder="Confirm password">
        <button type="button" class="btn btn-outline-secondary" id="togglePasswordConfirm">Show</button>
    </div>
</div>

<!-- Password Suggestion -->
 <div class="d-flex justify-content-between mb-3">
                            <label class="form-label">Suggested Strong Password:</label>
    <div class="input-group">
        <input type="text" id="suggestedPassword" class="form-control" readonly>
        <button type="button" class="btn btn-success" id="usePassword">Use This</button>
    </div>
                        </div>

<script>
    // 🔒 Password Strength Checker
    const password = document.getElementById('password');
    const strengthText = document.getElementById('passwordStrength');

    password.addEventListener('input', () => {
        const value = password.value;
        let strength = 0;

        if (value.match(/[a-z]/)) strength++;
        if (value.match(/[A-Z]/)) strength++;
        if (value.match(/[0-9]/)) strength++;
        if (value.match(/[^a-zA-Z0-9]/)) strength++;
        if (value.length >= 8) strength++;

        let text = '';
        let color = '';

        switch (strength) {
            case 0:
            case 1:
                text = 'Weak password 🔴';
                color = 'red';
                break;
            case 2:
            case 3:
                text = 'Medium password 🟡';
                color = 'orange';
                break;
            case 4:
            case 5:
                text = 'Strong password 🟢';
                color = 'green';
                break;
        }

        strengthText.innerHTML = text;
        strengthText.style.color = color;
    });

    // 👁️ Toggle Show/Hide Password
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('password');
        if (input.type === 'password') {
            input.type = 'text';
            this.textContent = 'Hide';
        } else {
            input.type = 'password';
            this.textContent = 'Show';
        }
    });

    document.getElementById('togglePasswordConfirm').addEventListener('click', function () {
        const input = document.getElementById('password_confirmation');
        if (input.type === 'password') {
            input.type = 'text';
            this.textContent = 'Hide';
        } else {
            input.type = 'password';
            this.textContent = 'Show';
        }
    });

    // 🔐 Suggest Random Strong Password
    function generateStrongPassword() {
        const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+~";
        let pass = "";
        for (let i = 0; i < 12; i++) {
            pass += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return pass;
    }

    const suggestedPassword = document.getElementById('suggestedPassword');
    suggestedPassword.value = generateStrongPassword();

    document.getElementById('usePassword').addEventListener('click', function () {
        password.value = suggestedPassword.value;
        document.getElementById('password_confirmation').value = suggestedPassword.value;
        strengthText.innerHTML = 'Strong password 🟢';
        strengthText.style.color = 'green';
    });
</script>

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
