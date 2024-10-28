@dd($meetings['data'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Absence Form</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Student Absence Form</h1>
        
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="meeting-select" class="form-label">Select Meeting:</label>
                <select id="meeting-select" class="form-select">
                    
                    <option value="">-- Select Meeting --</option>
                    <option value="meeting-1">Meeting 1</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table id="absence-table" class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Student Name</th>
                        <th>Present</th>
                        <th>Absent</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Student rows will be added dynamically -->
                </tbody>
            </table>
        </div>

        <button id="submit-btn" class="btn btn-primary mt-3">Submit</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script>
        const classSelect = document.getElementById('class-select');
        const meetingSelect = document.getElementById('meeting-select');
        const absenceTable = document.getElementById('absence-table');
        const submitBtn = document.getElementById('submit-btn');

        const students = {
            'class-a': ['John Doe', 'Jane Smith', 'Mike Johnson'],
            'class-b': ['Emily Brown', 'David Lee', 'Sarah Wilson'],
            'class-c': ['Tom Clark', 'Lisa Anderson', 'Chris Taylor']
        };

        function populateTable(className) {
            const tbody = absenceTable.querySelector('tbody');
            tbody.innerHTML = '';
            students[className].forEach(student => {
                const row = `
                    <tr>
                        <td>${student}</td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="${student}" value="present" checked>
                            </div>
                        </td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="${student}" value="absent">
                            </div>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        classSelect.addEventListener('change', (e) => {
            if (e.target.value) {
                populateTable(e.target.value);
            } else {
                absenceTable.querySelector('tbody').innerHTML = '';
            }
        });

        submitBtn.addEventListener('click', () => {
            const selectedClass = classSelect.value;
            const selectedMeeting = meetingSelect.value;
            if (!selectedClass || !selectedMeeting) {
                alert('Please select both a class and a meeting.');
                return;
            }

            const absences = [];
            students[selectedClass].forEach(student => {
                const status = document.querySelector(`input[name="${student}"]:checked`).value;
                if (status === 'absent') {
                    absences.push(student);
                }
            });

            alert(`Absences submitted for ${selectedClass}, ${selectedMeeting}:\n${absences.join(', ') || 'No absences'}`);
        });
    </script>
</body>
</html>