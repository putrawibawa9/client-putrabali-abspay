        document.querySelectorAll('[data-modal-toggle="edit-user-modal"]').forEach(button => {
    button.addEventListener('click', () => {
        // Get modal and form elements
        const modal = document.getElementById('edit-user-modal');
        const form = modal.querySelector('form');

         // Retrieve student ID and populate the form's action URL
        const studentId = button.dataset.id;
        form.action = `/students/${studentId}`;

        // Populate modal fields
        form.querySelector('#name').value = button.dataset.name || '';
        form.querySelector('#wa_number').value = button.dataset.wa_number || '';
        form.querySelector('#gender').value = button.dataset.gender || '';
        form.querySelector('#school').value = button.dataset.school || '';
        form.querySelector('#enroll_date').value = button.dataset.enroll_date || '';

        // Show modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });
});

// Close modal
document.querySelectorAll('[data-modal-close]').forEach(button => {
    button.addEventListener('click', () => {
        const modal = button.closest('.fixed');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });
});

