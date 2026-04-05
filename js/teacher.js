        document.querySelectorAll('[data-modal-toggle="edit-user-modal-teacher"]').forEach(button => {
    button.addEventListener('click', () => {
        // Get modal and form elements
        const modal = document.getElementById('edit-user-modal-teacher');
        const form = modal.querySelector('form');

         // Retrieve student ID and populate the form's action URL
        const studentId = button.dataset.id;
        form.action = `/teachers/${studentId}`;

        // Populate modal fields
        form.querySelector('#name').value = button.dataset.name || '';
        form.querySelector('#username').value = button.dataset.username || '';
        form.querySelector('#alias').value = button.dataset.alias || '';
        form.querySelector('#password').value = button.dataset.password || '';

       

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

// delete teacher
document.addEventListener("DOMContentLoaded", () => {
    const deleteButtons = document.querySelectorAll('[data-modal-toggle="delete-user-modal"]');

    deleteButtons.forEach(button => {
        button.addEventListener("click", () => {
            // Retrieve the teacher ID from the button's data attribute
            const teacherId = button.getAttribute("data-id");

            // Update the form action dynamically
            const deleteForm = document.getElementById("delete-teacher-form");
            deleteForm.action = `/teachers/${teacherId}`;
        });
    });
});




