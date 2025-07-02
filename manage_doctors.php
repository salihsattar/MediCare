<?php
include 'includes/header.php';
include 'includes/db.php';

if (isset($_POST['create-doctor'])) {
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $mobile_no = $_POST['mobile_no'];
    $specialty = $_POST['specialty'];
    $available_days = isset($_POST['available_days']) ? implode(',', $_POST['available_days']) : '';
    $available_from = $_POST['available_from'];
    $available_to = $_POST['available_to'];
    $createdAt = date('Y-m-d H:i:s');

    $checkEmail = "SELECT id FROM doctors WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email already registered.');</script>";
    } else {
        $query = "INSERT INTO doctors (full_name, email, mobile_no, specialty, available_days, available_from, available_to, created_at) 
                  VALUES ('$fullName', '$email', '$mobile_no', '$specialty', '$available_days', '$available_from', '$available_to', '$createdAt')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Doctor account created successfully!'); window.location.href='manage_doctors.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<div class="container-fluid page-header py-5 mb-3 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Doctors</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb text-uppercase mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Doctors</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-2">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <p class="d-inline-block border rounded-pill py-1 px-4">Doctors</p>
                <h1 class="mb-4">Register Doctor Profile</h1>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-light rounded h-100 d-flex align-items-center p-5">
                    <form method="POST" action="#">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <input type="text" name="full_name" class="form-control border-0"
                                    placeholder="Doctor Name" style="height: 55px;" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="email" name="email" class="form-control border-0" placeholder="Email"
                                    style="height: 55px;" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="text" name="mobile_no" class="form-control border-0"
                                    placeholder="Mobile No" style="height: 55px;" required>
                            </div>

                            <div class="col-12 col-sm-6">
                                <input type="text" name="specialty" class="form-control border-0"
                                    placeholder="Specialty (e.g., Dentist)" style="height: 55px;" required>
                            </div>
                            <div class="col-12">
                                <label><strong>Available Days:</strong></label><br />
                                <?php
                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                foreach ($days as $day) {
                                    echo "<label class='me-3'><input type='checkbox' name='available_days[]' value='$day'> $day</label>";
                                }
                                ?>
                            </div>
                            <div class="col-6">
                                <label>Available From</label>
                                <input type="time" name="available_from" class="form-control border-0"
                                    style="height: 55px;" required>
                            </div>
                            <div class="col-6">
                                <label>Available To</label>
                                <input type="time" name="available_to" class="form-control border-0"
                                    style="height: 55px;" required>
                            </div>
                            <div class="col-12">
                                <input class="btn btn-success w-100" name="create-doctor" value="Create Doctor Account"
                                    type="submit" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container-xxl py-5">
            <div class="container">
                <h3 class="mb-4">Registered Doctors</h3>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Doctor Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Specialty</th>
                                <th>Available Days</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM doctors ORDER BY id DESC";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $i++ . "</td>";
                                    echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['mobile_no']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['specialty']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['available_days']) . "</td>";
                                    echo "<td>" . date('h:i A', strtotime($row['available_from'])) . "</td>";
                                    echo "<td>" . date('h:i A', strtotime($row['available_to'])) . "</td>";
                                    echo "<td>" . date('d-m-Y h:i A', strtotime($row['created_at'])) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='9' class='text-center'>No doctors registered yet.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
include 'includes/footer.php';
?>