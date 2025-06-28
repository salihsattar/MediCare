<?php
include 'includes/header.php';
include 'includes/db.php';

$error = '';

if (isset($_POST['login-btn'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email !== '' && $password !== '') {
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);

        $query = "SELECT * FROM users WHERE email = '$email' and password='$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['is_admin'] = $user['is_admin'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>

<div class="container-fluid page-header py-5 mb-3 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Login In</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb text-uppercase mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Login In</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-2">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <p class="d-inline-block border rounded-pill py-1 px-4">Log In</p>
                <h1 class="mb-4">Login an account to schedule your appointment with a doctor.</h1>

                <?php if ($error !== ''): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <div id="client-error" class="alert alert-danger d-none"></div>
            </div>

            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-light rounded h-100 d-flex align-items-center p-5">
                    <form id="loginForm" method="POST" action="">
                        <div class="row g-3">
                            <div class="col-12 col-sm-12">
                                <input type="email" id="email" name="email" class="form-control border-0"
                                       placeholder="Your Email" style="height: 55px;"
                                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                            </div>

                            <div class="col-12 col-sm-12 position-relative">
                                <input type="password" id="password" name="password" class="form-control border-0"
                                       placeholder="Your Password" style="height: 55px; padding-right: 40px;">
                                <span id="togglePassword" style="position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;">
                                    👁️
                                </span>
                            </div>

                            <div class="col-12">
                                <input class="btn btn-success w-100" name="login-btn" value="Login Account" type="submit" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for validation + password toggle -->
<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const errorBox = document.getElementById('client-error');

    let errorMsg = '';

    if (!email && !password) {
        errorMsg = 'Email and Password are required.';
    } else if (!email) {
        errorMsg = 'Email is required.';
    } else if (!password) {
        errorMsg = 'Password is required.';
    }

    if (errorMsg !== '') {
        e.preventDefault();
        errorBox.classList.remove('d-none');
        errorBox.innerText = errorMsg;
    } else {
        errorBox.classList.add('d-none');
        errorBox.innerText = '';
    }
});

document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const isPassword = passwordInput.getAttribute('type') === 'password';
    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
    this.innerText = isPassword ? '🙈' : '👁️';
});
</script>

<?php include 'includes/footer.php'; ?>
