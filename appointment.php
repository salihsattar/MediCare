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
    $appointment_type = $_POST['appointment_type'];
    $person_id = $_POST['person_id'];

    $InsertQuery = "INSERT INTO appointments (user_id, doctor_id, appointment_date, description, appointment_type, person_id)
                    VALUES ('$user_id', '$doctor_id', '$appointment_date', '$description', '$appointment_type', '$person_id')";
    $runQuery = mysqli_query($conn, $InsertQuery);

    if ($runQuery) {
        echo "<script>alert('Appointment Booked Successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<script>
function togglePersonFields() {
    const type = document.getElementById('appointment_for').value;
    document.getElementById('appointment_type').value = type;

    if (type === 'self') {
        document.getElementById('employee_fields').style.display = 'block';
        document.getElementById('family_fields').style.display = 'none';
    } else if (type === 'family') {
        document.getElementById('employee_fields').style.display = 'none';
        document.getElementById('family_fields').style.display = 'block';
    } else {
        document.getElementById('employee_fields').style.display = 'none';
        document.getElementById('family_fields').style.display = 'none';
    }
}

function fetchEmployeeDetails() {
    const serviceNo = document.getElementById('service_no').value;
    if (!serviceNo) return;

    fetch("fetch_employee_family.php", {
        method: "POST",
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: "service_no=" + serviceNo
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('employee_name').value = data.employee.full_name;
            document.getElementById('employee_designation').value = data.employee.designation;
            document.getElementById('person_id').value = data.employee.id;

            const famSelect = document.getElementById('family_member_select');
            famSelect.innerHTML = '<option value="">-- Select Family Member --</option>';
            data.family.forEach(member => {
                famSelect.innerHTML += `<option value="${member.id}" data-name="${member.name}" data-rel="${member.relationship}">${member.name} (${member.relationship})</option>`;
            });
        } else {
            alert("Service number not found.");
        }
    });
}

function fillFamilyMemberDetails() {
    const selected = document.getElementById('family_member_select');
    const selectedId = selected.value;
    document.getElementById('person_id').value = selectedId;
}
</script>

<div class="container-xxl py-5">
    <div class="container">
        <form action="" method="POST">
            <div class="row g-3">
                <div class="col-12">
                    <label>Service Number</label>
                    <input type="text" id="service_no" class="form-control border-0" placeholder="Enter Service Number" required onblur="fetchEmployeeDetails()" style="height: 55px;" />
                </div>

                <div class="col-12">
                    <label>Appointment For</label>
                    <select id="appointment_for" class="form-select border-0" required onchange="togglePersonFields()" style="height: 55px;">
                        <option value="">-- Select --</option>
                        <option value="self">Employee (Self)</option>
                        <option value="family">Family Member</option>
                    </select>
                </div>

                <div id="employee_fields" style="display: none;">
                    <div class="col-12">
                        <label>Employee Name</label>
                        <input type="text" id="employee_name" class="form-control border-0" readonly />
                    </div>
                    <div class="col-12">
                        <label>Designation</label>
                        <input type="text" id="employee_designation" class="form-control border-0" readonly />
                    </div>
                </div>

                <div id="family_fields" class="col-12" style="display: none;">
                    <label>Select Family Member</label>
                    <select id="family_member_select" class="form-select border-0" onchange="fillFamilyMemberDetails()" style="height: 55px;">
                        <option value="">-- Select Family Member --</option>
                    </select>
                </div>

                <div class="col-12 col-sm-12">
                    <input type="date" name="appointment_date" class="form-control border-0" style="height: 55px;" required>
                </div>

                <div class="col-12">
                    <textarea class="form-control border-0" name="description" rows="5" placeholder="Describe your problem" required></textarea>
                </div>

                <input type="hidden" name="appointment_type" id="appointment_type" />
                <input type="hidden" name="person_id" id="person_id" />

                <div class="col-12">
                    <input class="btn btn-primary w-100 py-3" name="appointment-btn" type="submit" value="Book Appointment" />
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>