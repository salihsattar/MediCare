<?php
include 'includes/db.php';

header('Content-Type: application/json');

if (isset($_POST['service_no'])) {
    $service_no = mysqli_real_escape_string($conn, $_POST['service_no']);
    $response = ['success' => false];

    // Fetch employee by service number
    $empQuery = "SELECT * FROM employees WHERE service_no = '$service_no' LIMIT 1";
    $empResult = mysqli_query($conn, $empQuery);

    if (mysqli_num_rows($empResult) > 0) {
        $employee = mysqli_fetch_assoc($empResult);
        $emp_id = $employee['id'];

        // Fetch related family members
        $famQuery = "SELECT id, name, relationship FROM employee_family WHERE employee_id = '$emp_id' ORDER BY name ASC";
        $famResult = mysqli_query($conn, $famQuery);

        $family = [];
        while ($row = mysqli_fetch_assoc($famResult)) {
            $family[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'relationship' => $row['relationship']
            ];
        }

        $response = [
            'success' => true,
            'employee' => [
                'id' => $employee['id'],
                'full_name' => $employee['full_name'],
                'designation' => $employee['designation']
            ],
            'family' => $family
        ];
    }

    echo json_encode($response);
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Missing service number']);
    exit;
}
