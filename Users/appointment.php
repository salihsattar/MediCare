<?php
include 'includes/header.php';
include 'includes/db.php';
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}
if (isset($_POST['appointment-btn'])) {
    $doctor_name = $_POST['doctor_name'];
    $appointment_date = $_POST['appointment_date'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];
    $InsertQuery = "INSERT INTO appointments set user_id=$user_id, doctor_name='$doctor_name', appointment_date='$appointment_date', description='$description'";
    $runQuery = mysqli_query($conn, $InsertQuery);
    if ($runQuery) {
        echo "<script>alert('Appoitment Booked Successfully!'); window.location.href='index.php';</script>";
    }
}

?>

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
                <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et
                    eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo magna dolore erat amet</p>
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
                            <div class="col-12 col-sm-6">
                                <input type="text" name="doctor_name" class="form-control border-0" placeholder="Doctor Name"
                                    style="height: 55px;">
                                <!-- <select class="form-select border-0" style="height: 55px;">
                                    <option selected>Choose Doctor</option>
                                    <option value="1">Doctor 1</option>
                                    <option value="2">Doctor 2</option>
                                    <option value="3">Doctor 3</option>
                                </select> -->
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="date" id="date" data-target-input="nearest">
                                    <input type="date" name="appointment_date" class="form-control border-0 datetimepicker-input"
                                        placeholder="Appointment Date"  
                                        style="height: 55px;">
                                </div>
                            </div>

                            <div class="col-12">
                                <textarea class="form-control border-0" name="description" rows="5"
                                    placeholder="Describe your problem"></textarea>
                            </div>
                            <div class="col-12">
                                <input class="btn btn-primary w-100 py-3" name="appointment-btn" type="submit" value="Book Appointment" />
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