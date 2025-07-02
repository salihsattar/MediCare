<?php
include 'includes/header.php';
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

$selectQuery = "
    SELECT appointments.id AS appointment_id, appointments.*, users.full_name 
    FROM appointments 
    JOIN users ON users.id = appointments.user_id
";
$runQuery = mysqli_query($conn, $selectQuery);
?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const approveButtons = document.querySelectorAll('.open-approve-modal');
    const cancelledButtons = document.querySelectorAll('.cancel-approve-modal');
    const modalAppointmentId = document.getElementById('modalAppointmentId');
    const modalCancelledAppointmentId = document.getElementById('modalCancelledAppointmentId');

    approveButtons.forEach(button => {
        button.addEventListener('click', function () {
            modalAppointmentId.value = this.getAttribute('data-id');
            const approveModal = new bootstrap.Modal(document.getElementById('approveModal'));
            approveModal.show();
        });
    });

    cancelledButtons.forEach(button => {
        button.addEventListener('click', function () {
            modalCancelledAppointmentId.value = this.getAttribute('data-id');
            const cancelledModal = new bootstrap.Modal(document.getElementById('cancelledModal'));
            cancelledModal.show();
        });
    });
});
</script>

<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Manage Appointments</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb text-uppercase mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Manage Appointments</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to approve this appointment?
                    <input type="hidden" name="appointment_id" id="modalAppointmentId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" name="Approve" value="Approve" />
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelledModal" tabindex="-1" aria-labelledby="cancelledModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cancel Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to cancel this appointment?
                    <input type="hidden" name="appointment_id" id="modalCancelledAppointmentId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-danger" name="Cancelled" value="Cancel" />
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Appointment Table -->
<div class="container-xxl py-2">
    <div class="container mt-2">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Doctor</th>
                    <th>Patient</th>
                    <th>Appointment Date</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_array($runQuery)) { ?>
                    <tr>
                        <td><?php echo $data['appointment_id']; ?></td>
                        <td><?php echo $data['doctor_name']; ?></td>
                        <td><?php echo $data['full_name']; ?></td>
                        <td><?php echo $data['appointment_date']; ?></td>
                        <td><?php echo $data['description']; ?></td>
                        <td>
                            <?php if ($data['status'] == 'Pending') { ?>
                                <a href="#" class="btn btn-success btn-sm open-approve-modal" data-id="<?php echo $data['appointment_id']; ?>" title="Approve Appointment">
                                    <i class="fa fa-check"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm cancel-approve-modal" data-id="<?php echo $data['appointment_id']; ?>" title="Cancel Appointment">
                                    <i class="fa fa-times"></i>
                                </a>
                            <?php } else { ?>
                                <span class="text-<?php echo ($data['status'] == 'Approved') ? 'success' : 'danger'; ?>">
                                    <?php echo $data['status']; ?>
                                </span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include 'includes/footer.php';

if (isset($_POST['Approve'])) {
    $id = $_POST['appointment_id'];

    $getDetailsQuery = "
        SELECT appointments.id AS appointment_id, appointments.*, users.full_name, users.email 
        FROM appointments 
        JOIN users ON users.id = appointments.user_id 
        WHERE appointments.id = $id
    ";
    $result = mysqli_query($conn, $getDetailsQuery);
    $appointment = mysqli_fetch_assoc($result);

    $updateQuery = "UPDATE appointments SET status='Approved' WHERE id=$id";
    $runUpdate = mysqli_query($conn, $updateQuery);

    if ($runUpdate) {
        $to = $appointment['email'];
        $subject = "Your Appointment is Approved";
        $message = "Dear " . $appointment['full_name'] . ",\n\n";
        $message .= "We are pleased to inform you that your appointment on " . $appointment['appointment_date'];
        $message .= " with Dr. " . $appointment['doctor_name'] . " has been successfully approved.\n\n";
        $message .= "Thank you for choosing our clinic.\n\nRegards,\nClinic Team";

        $headers = "From: noreply@yourdomain.com\r\n";
        $message = wordwrap($message, 70);

        mail($to, $subject, $message, $headers);
        echo "<script>window.location.href='manage_appointments.php';</script>";
    }
}

if (isset($_POST['Cancelled'])) {
    $id = $_POST['appointment_id'];

    $getDetailsQuery = "
        SELECT appointments.id AS appointment_id, appointments.*, users.full_name, users.email 
        FROM appointments 
        JOIN users ON users.id = appointments.user_id 
        WHERE appointments.id = $id
    ";
    $result = mysqli_query($conn, $getDetailsQuery);
    $appointment = mysqli_fetch_assoc($result);

    $updateQuery = "UPDATE appointments SET status='Cancelled' WHERE id=$id";
    $runUpdate = mysqli_query($conn, $updateQuery);

    if ($runUpdate) {
        $to = $appointment['email'];
        $subject = "Your Appointment is Cancelled";
        $message = "Dear " . $appointment['full_name'] . ",\n\n";
        $message .= "We regret to inform you that your appointment on " . $appointment['appointment_date'];
        $message .= " with Dr. " . $appointment['doctor_name'] . " has been cancelled.\n\n";
        $message .= "If you have any questions or wish to reschedule, please contact our clinic.\n\nRegards,\nClinic Team";

        $headers = "From: noreply@yourdomain.com\r\n";
        $message = wordwrap($message, 70);

        mail($to, $subject, $message, $headers);
        echo "<script>window.location.href='manage_appointments.php';</script>";
    }
}
?>
