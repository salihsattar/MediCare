<?php
include 'includes/db.php';

if (isset($_POST['doctor_id'])) {
    $doctor_id = $_POST['doctor_id'];
    $query = "SELECT available_days, available_from, available_to FROM doctors WHERE id = $doctor_id";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo "<strong>Available Days:</strong> " . htmlspecialchars($row['available_days']) . "<br>";
        echo "<strong>Time:</strong> " . htmlspecialchars($row['available_from']) . " - " . htmlspecialchars($row['available_to']);
    } else {
        echo "Doctor availability not found.";
    }
}
?>
