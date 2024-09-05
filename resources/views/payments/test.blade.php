<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<div class="container">
    <label for="studentSelect">Select Student:</label>
    <select id="studentSelect" class="form-control">
        <option value="">Select Student</option>
        <!-- Options will be populated dynamically -->
    </select>

    <div id="courseContainer" style="display:none;">
        <label for="courseSelect">Select Course:</label>
        <select id="courseSelect" class="form-control">
            <option value="">Select Course</option>
            <!-- Options will be populated dynamically -->
        </select>

        <div id="paymentRateContainer" style="display:none;">
            <label for="paymentRate">Payment Rate:</label>
            <input type="text" id="paymentRate" name="payment_rate" class="form-control" readonly>

            <label for="customPaymentRate">Custom Payment Rate:</label>
            <input type="text" id="customPaymentRate" name="custom_payment_rate" class="form-control" readonly>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const studentSelect = document.getElementById('studentSelect');
    const courseContainer = document.getElementById('courseContainer');
    const courseSelect = document.getElementById('courseSelect');
    const paymentRateContainer = document.getElementById('paymentRateContainer');
    const paymentRateInput = document.getElementById('paymentRate');
    const customPaymentRateInput = document.getElementById('customPaymentRate');

    // Function to populate students
    function populateStudents(students) {
        students.forEach(student => {
            const option = document.createElement('option');
            option.value = student.id;
            option.textContent = student.name;
            studentSelect.appendChild(option);
        });
    }

    // Fetch students from API
    fetch('http://localhost:8000/api/v1/payments')  // Replace with your actual API endpoint
        .then(response => response.json())
        .then(data => populateStudents(data));

    // Event listener for student selection
    studentSelect.addEventListener('change', function() {
        const studentId = this.value;
        if (studentId) {
            fetch(`/api/students/${studentId}/courses`)  // Replace with your actual API endpoint
                .then(response => response.json())
                .then(data => {
                    courseContainer.style.display = 'block';
                    populateCourses(data.courses);
                });
        } else {
            courseContainer.style.display = 'none';
        }
    });

    // Function to populate courses
    function populateCourses(courses) {
        courseSelect.innerHTML = '<option value="">Select Course</option>'; // Reset course options
        courses.forEach(course => {
            const option = document.createElement('option');
            option.value = course.id;
            option.dataset.paymentRate = course.payment_rate;
            option.dataset.customPaymentRate = course.custom_payment_rate || 'No custom payment rate';
            option.textContent = `${course.name} || Rp. ${new Intl.NumberFormat('id-ID').format(course.payment_rate)}`;
            courseSelect.appendChild(option);
        });

        // Show the course selection and payment rate container
        courseSelect.addEventListener('change', function() {
            const selectedOption = courseSelect.options[courseSelect.selectedIndex];
            const paymentRate = selectedOption.dataset.paymentRate;
            const customPaymentRate = selectedOption.dataset.customPaymentRate;

            if (selectedOption.value) {
                paymentRateContainer.style.display = 'block';
                paymentRateInput.value = `Rp. ${new Intl.NumberFormat('id-ID').format(paymentRate)}`;
                customPaymentRateInput.value = customPaymentRate !== 'No custom payment rate' 
                    ? `Rp. ${new Intl.NumberFormat('id-ID').format(customPaymentRate)}` 
                    : customPaymentRate;
            } else {
                paymentRateContainer.style.display = 'none';
            }
        });
    }
});

</script>
</body>
</html>