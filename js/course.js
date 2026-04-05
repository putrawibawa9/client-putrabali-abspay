document
    .querySelectorAll('[data-modal-toggle="edit-user-modal-course"]')
    .forEach((button) => {
        button.addEventListener("click", () => {
            // Get modal and form elements
            const modal = document.getElementById("edit-user-modal-course");
            const form = modal.querySelector("form");

            // Retrieve course ID and populate the form's action URL
            const courseId = button.dataset.id;
            form.action = `/courses/${courseId}`;

            // Populate modal fields
            form.querySelector("#alias").value = button.dataset.alias || "";
            form.querySelector("#level").value = button.dataset.level || "";
            form.querySelector("#section").value = button.dataset.section || "";
            form.querySelector("#subject").value = button.dataset.subject || "";
            form.querySelector("#payment_rate").value = button.dataset.payment_rate || "";

            // Show modal
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        });
    });

// Close modal
document.querySelectorAll("[data-modal-close]").forEach((button) => {
    button.addEventListener("click", () => {
        const modal = button.closest(".fixed");
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    });
});
