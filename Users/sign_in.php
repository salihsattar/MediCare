<?php
include 'includes/header.php';
include 'includes/db.php';
if (isset($_POST['create-account'])) {
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mobile_no = $_POST['mobile_no'];
    $createdAt = date('Y-m-d H:i:s');
    $checkEmail = "SELECT id FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email already registered. Try logging in.');</script>";
    } else {
        $query = "INSERT INTO users (full_name, email, password, mobile_no, created_at) 
                  VALUES ('$fullName', '$email', '$password',$mobile_no, '$createdAt')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Account created successfully!'); window.location.href='login.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
<div class="container-fluid page-header py-5 mb-3 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Sign In</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb text-uppercase mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Sign In</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-2">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <p class="d-inline-block border rounded-pill py-1 px-4">Sign In</p>
                <h1 class="mb-4">Create an account to schedule your appointment with a doctor.</h1>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-light rounded h-100 d-flex align-items-center p-5">
                    <form method="POST" action="#">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <input type="text" name="full_name" class="form-control border-0" placeholder="Your Name"
                                    style="height: 55px;">
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="email" name="email" class="form-control border-0" placeholder="Your Email"
                                    style="height: 55px;">
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="text" name="mobile_no" class="form-control border-0" placeholder="Your Mobile"
                                    style="height: 55px;">
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="password" name="password" class="form-control border-0" placeholder="Your Password"
                                    style="height: 55px;">
                            </div>

                            <div class="col-12">
                                <input class="btn btn-success" name="create-account" value="Create Account" type="submit" />
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