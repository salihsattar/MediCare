<?php
include 'includes/header.php';
include 'includes/db.php';

if (isset($_POST['create-employee'])) {
    $service_no = $_POST['service_no'];
    $full_name = $_POST['full_name'];
    $designation = $_POST['designation'];
    $dob = $_POST['dob'];
    $doj = $_POST['doj'];
    $retirement_date = $_POST['retirement_date'];
    $created_at = date('Y-m-d H:i:s');

    // Check for duplicate service number
    $checkQuery = "SELECT id FROM employees WHERE service_no = '$service_no'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Service number already exists.');</script>";
    } else {
        $query = "INSERT INTO employees (service_no, full_name, designation, dob, doj, retirement_date, created_at)
                  VALUES ('$service_no', '$full_name', '$designation', '$dob', '$doj', '$retirement_date', '$created_at')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Employee registered successfully!'); window.location.href='manage_employees.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<div class="container-fluid page-header py-5 mb-3 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Employee</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb text-uppercase mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Employee</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-2">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <p class="d-inline-block border rounded-pill py-1 px-4">Employees</p>
                <h1 class="mb-4">Register Employee Profile</h1>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-light rounded h-100 d-flex align-items-center p-5">
                    <form method="POST" action="">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label>Service Number</label>
                                <input type="text" name="service_no" class="form-control border-0"
                                    placeholder="Service Number" style="height: 55px;" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label>Full Name</label>
                                <input type="text" name="full_name" class="form-control border-0"
                                    placeholder="Full Name" style="height: 55px;" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label>Designation</label>

                                <input type="text" name="designation" class="form-control border-0"
                                    placeholder="Designation" style="height: 55px;" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" class="form-control border-0" style="height: 55px;" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label>Date of Joining</label>
                                <input type="date" name="doj" class="form-control border-0" style="height: 55px;" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label>Retirement Date</label>
                                <input type="date" name="retirement_date" class="form-control border-0" style="height: 55px;" required>
                            </div>
                            <div class="col-12">
                                <input class="btn btn-success w-100" name="create-employee" value="Create Employee"
                                    type="submit" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Employee Table -->
        <div class="container-xxl py-5">
            <div class="container">
                <h3 class="mb-4">Registered Employees</h3>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Service No</th>
                                <th>Full Name</th>
                                <th>Designation</th>
                                <th>Date of Birth</th>
                                <th>Joining Date</th>
                                <th>Retirement Date</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM employees ORDER BY id DESC";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $i++ . "</td>";
                                    echo "<td>" . htmlspecialchars($row['service_no']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['designation']) . "</td>";
                                    echo "<td>" . date('d-m-Y', strtotime($row['dob'])) . "</td>";
                                    echo "<td>" . date('d-m-Y', strtotime($row['doj'])) . "</td>";
                                    echo "<td>" . date('d-m-Y', strtotime($row['retirement_date'])) . "</td>";
                                    echo "<td>" . date('d-m-Y h:i A', strtotime($row['created_at'])) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>No employees registered yet.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>
