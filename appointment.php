<?php
include 'includes/header.php';
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

if (isset($_POST['appointment-btn'])) {
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    $InsertQuery = "INSERT INTO appointments (user_id, doctor_id, appointment_date, description)
                    VALUES ('$user_id', '$doctor_id', '$appointment_date', '$description')";
    $runQuery = mysqli_query($conn, $InsertQuery);

    if ($runQuery) {
        echo "<script>alert('Appointment Booked Successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<script>
    function loadDoctorDetails(doctorId) {
        if (!doctorId) return;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "doctor_task.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            if (xhr.status === 200) {
                document.getElementById("doctor-info").innerHTML = xhr.responseText;
            }
        };

        xhr.send("doctor_id=" + doctorId);
    }
</script>


<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Appointment</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb text-uppercase mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Appointment</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <p class="d-inline-block border rounded-pill py-1 px-4">Appointment</p>
                <h1 class="mb-4">Make An Appointment To Visit Our Doctor</h1>

                <div class="bg-light rounded d-flex align-items-center p-5 mb-4">
                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-white"
                        style="width: 55px; height: 55px;">
                        <i class="fa fa-phone-alt text-primary"></i>
                    </div>
                    <div class="ms-4">
                        <p class="mb-2">Call Us Now</p>
                        <h5 class="mb-0">+012 345 6789</h5>
                    </div>
                </div>

                <div class="bg-light rounded d-flex align-items-center p-5">
                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-white"
                        style="width: 55px; height: 55px;">
                        <i class="fa fa-envelope-open text-primary"></i>
                    </div>
                    <div class="ms-4">
                        <p class="mb-2">Mail Us Now</p>
                        <h5 class="mb-0">info@example.com</h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-light rounded h-100 d-flex align-items-center p-5">
                    <form action="" method="POST">
                        <div class="row g-3">

                            <div class="col-12 col-sm-12 pb-3">
                                <select name="doctor_id" id="doctor_id" class="form-select border-0"
                                    style="height: 55px;" required onchange="loadDoctorDetails(this.value)">
                                    <option value="" selected disabled>Choose Doctor</option>
                                    <?php
                                    $doctorQuery = "SELECT id, full_name, specialty FROM doctors ORDER BY full_name ASC";
                                    $doctorResult = mysqli_query($conn, $doctorQuery);
                                    if ($doctorResult && mysqli_num_rows($doctorResult) > 0) {
                                        while ($doctor = mysqli_fetch_assoc($doctorResult)) {
                                            $id = $doctor['id'];
                                            $name = htmlspecialchars($doctor['full_name']);
                                            $specialty = htmlspecialchars($doctor['specialty']);
                                            echo "<option value=\"$id\">$name ($specialty)</option>";
                                        }
                                    } else {
                                        echo "<option disabled>No doctors available</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <br>
                            <br>
                            <!-- Show Doctor Info -->
                            <div class="col-12" id="doctor-info"
                                style="margin-top: -10px; padding-left: 12px; color: #333;"></div>


                            <div class="col-12 col-sm-12">
                                <input type="date" name="appointment_date" class="form-control border-0"
                                    placeholder="Appointment Date" style="height: 55px;" required>
                            </div>

                            <div class="col-12">
                                <textarea class="form-control border-0" name="description" rows="5"
                                    placeholder="Describe your problem" required></textarea>
                            </div>

                            <div class="col-12">
                                <input class="btn btn-primary w-100 py-3" name="appointment-btn" type="submit"
                                    value="Book Appointment" />
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>