<?php
include 'includes/header.php';
include 'includes/db.php';

if (isset($_POST['create-family'])) {
    $employee_id = $_POST['employee_id'];
    $medical_card_no = $_POST['medical_card_no'];
    $name = $_POST['name'];
    $relationship = $_POST['relationship'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $created_at = date('Y-m-d H:i:s');

    $query = "INSERT INTO employee_family (employee_id, medical_card_no, name, relationship, dob, gender, created_at)
              VALUES ('$employee_id', '$medical_card_no', '$name', '$relationship', '$dob', '$gender', '$created_at')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Family member added successfully!'); window.location.href='manage_employee_family.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="container-fluid page-header py-5 mb-3 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Employee Family</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb text-uppercase mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Family</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-2">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <p class="d-inline-block border rounded-pill py-1 px-4">Family</p>
                <h1 class="mb-4">Add Employee Family Member</h1>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-light rounded h-100 d-flex align-items-center p-5">
                    <form method="POST" action="">
                        <div class="row g-3">
                            <div class="col-12">
                                <label>Select Employee</label>
                                <select name="employee_id" class="form-control border-0 select2" required>
                                    <option value="">-- Select Employee --</option>
                                    <?php
                                    $empQuery = "SELECT id, full_name, service_no FROM employees ORDER BY full_name ASC";
                                    $empResult = mysqli_query($conn, $empQuery);
                                    while ($emp = mysqli_fetch_assoc($empResult)) {
                                        echo "<option value='{$emp['id']}'>{$emp['full_name']} (SN: {$emp['service_no']})</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label>Medical Card No</label>
                                <input type="text" name="medical_card_no" class="form-control border-0" placeholder="Card No">
                            </div>
                            <div class="col-12 col-sm-6">
                                <label>Family Member Name</label>
                                <input type="text" name="name" class="form-control border-0" placeholder="Name" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label>Relationship</label>
                                <select name="relationship" class="form-control border-0" required>
                                    <option value="">-- Select Relationship --</option>
                                    <option value="Father">Father</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Wife">Wife</option>
                                    <option value="Husband">Husband</option>
                                    <option value="Son">Son</option>
                                    <option value="Daughter">Daughter</option>
                                    <option value="Brother">Brother</option>
                                    <option value="Sister">Sister</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" class="form-control border-0" required>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label>Gender</label>
                                <select name="gender" class="form-control border-0" required>
                                    <option value="">-- Select Gender --</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <input class="btn btn-success w-100" name="create-family" value="Add Family Member" type="submit" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Family Members Table -->
        <div class="container-xxl py-5">
            <div class="container">
                <h3 class="mb-4">Registered Family Members</h3>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Employee</th>
                                <th>Medical Card No</th>
                                <th>Member Name</th>
                                <th>Relationship</th>
                                <th>DOB</th>
                                <th>Gender</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "
                                SELECT ef.*, e.full_name, e.service_no
                                FROM employee_family ef
                                JOIN employees e ON ef.employee_id = e.id
                                ORDER BY ef.id DESC
                            ";
                            $result = mysqli_query($conn, $sql);
                            $i = 1;
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $i++ . "</td>";
                                    echo "<td>" . htmlspecialchars($row['full_name']) . " (SN: " . htmlspecialchars($row['service_no']) . ")</td>";
                                    echo "<td>" . htmlspecialchars($row['medical_card_no']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['relationship']) . "</td>";
                                    echo "<td>" . date('d-m-Y', strtotime($row['dob'])) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                                    echo "<td>" . date('d-m-Y h:i A', strtotime($row['created_at'])) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>No family members registered yet.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Initialize Select2 -->
<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "-- Select Employee --",
        allowClear: true,
        width: '100%'
    });
});
</script>

<?php include 'includes/footer.php'; ?>
