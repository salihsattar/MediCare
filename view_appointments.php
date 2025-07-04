<?php
include 'includes/header.php';
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$selectQuery = "SELECT a.*, d.full_name AS doctor_name 
                FROM appointments a 
                JOIN doctors d ON a.doctor_id = d.id 
                WHERE a.user_id = $user_id";
$runQuery = mysqli_query($conn, $selectQuery);
?>

<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">View Appointment</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb text-uppercase mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">View Appointment</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-2">
    <div class="container mt-2">
        <table class="table table-bordered table-striped">
            <thead class="table">
                <tr>
                    <th>ID</th>
                    <th>Doctor</th>
                    <th>Appointment Date</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_array($runQuery)) { ?>
                    <tr>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo htmlspecialchars($data['doctor_name']); ?></td>
                        <td><?php echo htmlspecialchars($data['appointment_date']); ?></td>
                        <td><?php echo htmlspecialchars($data['description']); ?></td>
                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
