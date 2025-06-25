<?php
include 'includes/header.php';
include 'includes/db.php'; // This should define $conn

if (isset($_POST['login-btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the user
    $query = "SELECT * FROM users WHERE email = '$email' and password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        echo "sasa";
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        header("Location: index.php");
        exit();
     
    } else {
        $error = "No user found with that email.";
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
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-light rounded h-100 d-flex align-items-center p-5">
                    <form method="POST" action="#">
                        <div class="row g-3">
                          
                            <div class="col-12 col-sm-12">
                                <input type="email" name="email" class="form-control border-0" placeholder="Your Email"
                                    style="height: 55px;">
                            </div>
                            <div class="col-12 col-sm-12">
                                <input type="password" name="password" class="form-control border-0" placeholder="Your Password"
                                    style="height: 55px;">
                            </div>

                            <div class="col-12">
                                <input class="btn btn-success" name="login-btn" value="Login Account" type="submit" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>