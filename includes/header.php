<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Klinik</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="clinic, doctor appointment, medical, healthcare" name="keywords">
    <meta content="Book appointments with doctors online from the comfort of your home." name="description">

    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="bg-dark text-white py-1 px-4 d-flex justify-content-between align-items-center" style="font-size: 14px;">
        <div><strong>Employee Login</strong></div>
        <div class="d-flex align-items-center">
            <i class="bi bi-person-circle mr-2"></i> &nbsp;
            <?= htmlspecialchars($_SESSION['full_name']); ?>
            <a href="logout.php" class="btn btn-sm btn-outline-light ms-2 ml-3" style="padding: 2px 8px; font-size: 13px;">
                <i class="bi bi-box-arrow-right mr-1"></i> Logout
            </a>
        </div>
    </div>
    <?php endif; ?>

<nav style="background-color:#0463fa" class="navbar navbar-expand-lg navbar-light sticky-top p-0 wow fadeIn" data-wow-delay="0.1s">
    <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h1 class="m-0 text-light"><i class="far fa-hospital me-3"></i>Klinik</h1>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="index.php" class="nav-item nav-link text-light active">Home</a>
            <a href="service.php" class="nav-item nav-link text-light">Service</a>
            <a href="team.php" class="nav-item nav-link text-light">Doctors</a>
            <a href="contact.php" class="nav-item nav-link text-light">Contact</a>
            <a href="about.php" class="nav-item nav-link text-light">About</a>

            <?php if (isset($_SESSION['user_id'])) { ?>
                <a href="appointment.php" class="nav-item nav-link text-light">Appointment</a>
                <a href="view_appointments.php" class="nav-item nav-link text-light">My Appointments</a>
            <?php } else { ?>
                <a href="sign_in.php" class="nav-item nav-link text-light">Sign In</a>
                <a href="login.php" class="nav-item nav-link text-light">Login</a>
            <?php } ?>
        </div>
    </div>
</nav>

</body>
</html>
