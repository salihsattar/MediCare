<?php 
session_start();

// Optional: Add your DB connection here if you want to make the badge dynamic
// include('db_connection.php');

// Default pending count
$pendingCount = 0;

// Example dynamic code to fetch pending appointment count
// $conn = mysqli_connect("localhost", "root", "", "your_database_name");
// if ($conn) {
//     $query = "SELECT COUNT(*) AS total FROM appointments WHERE status = 'pending'";
//     $result = mysqli_query($conn, $query);
//     $row = mysqli_fetch_assoc($result);
//     $pendingCount = $row['total'];
// }
?>
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

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 wow fadeIn" data-wow-delay="0.1s">
        <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h1 class="m-0 text-primary"><i class="far fa-hospital me-3"></i>Klinik</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link active">Home</a>
                
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <a href="service.php" class="nav-item nav-link">Manage Service</a>
                    <a href="team.php" class="nav-item nav-link">Manage Doctors</a>
                    <a href="view_appointment.php" class="nav-item nav-link">
                        Manage Appointments
                        <span class="badge bg-info ms-1"><?php echo $pendingCount; ?></span>
                    </a>
                <?php } else { ?>
                    <a href="sign_in.php" class="nav-item nav-link">Sign In</a>
                <?php } ?>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

</body>
</html>
