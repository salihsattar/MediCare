<?php
include 'includes/header.php';
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$user_id=$_SESSION['user_id'];
$selectQuery="SELECT * FROM appointments JOIN users ON users.id=appointments.user_id";
$runQuery=mysqli_query($conn,$selectQuery);


?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const approveButtons = document.querySelectorAll('.open-approve-modal');
    const modalAppointmentId = document.getElementById('modalAppointmentId');

    approveButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            modalAppointmentId.value = id;
            const approveModal = new bootstrap.Modal(document.getElementById('approveModal'));
            approveModal.show();
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

<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="approveModalLabel">Approve Appointment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to approve this appointment?
          <input type="hidden" name="appointment_id" id="modalAppointmentId">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <input type="submit" class="btn btn-success" name="Approve"  value="Approve" />
        </div>
      </div>
    </form>
  </div>
</div>


<div class="container-xxl py-2">
    <div class="container mt-2">
        <table class="table table-bordered table-striped">
            <thead class="table">
                <tr>
                    <th>ID</th>
                    <th>Doctor</th>
                    <th>Appoitment Date</th>
                    <th>Description</th>
                    <!-- <th>Timimg</th> -->
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php

                while ($data = mysqli_fetch_array($runQuery)) {
                    ?>
                    <tr>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['full_name']; ?></td>
                        <td><?php echo $data['doctor_name']; ?></td>
                        <td><?php echo $data['appointment_date']; ?></td>
                        <td><?php echo $data['description']; ?></td>
                      <td style="color:<?php echo ($data['status'] == 'Pending') ? 'red' : 'green'; ?>">
                            <?php echo $data['status']; ?>
                        </td>

                        <td>
                        <a href="#" class="btn btn-success btn-sm open-approve-modal" data-id="<?php echo $data['id']; ?>">
                            <i class="fa fa-check"></i>
                        </a>
                        </td>

                    </tr>
                    <?php
                }

                ?>
            </tbody>
        </table>
    </div>

    <?php
    include 'includes/footer.php';




    if(isset($_POST['Approve']))
    {
        $id=$_POST['appointment_id'];

        $Query="UPDATE appointments set status='Approved' where id=$id";
        $runQuery=mysqli_query($conn,$Query);
        if($runQuery)
        {
        echo "<script>window.location.href='manage_appointments.php';</script>";


        }

    }


    ?>


