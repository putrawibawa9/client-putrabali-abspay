document.addEventListener("DOMContentLoaded", function () {
    // Tangkap semua tombol edit dengan atribut data-modal-toggle="edit-modal"
    const editButtons = document.querySelectorAll(
        '[data-modal-toggle="edit-modal"]'
    );

    editButtons.forEach((button) => {
        button.addEventListener("click", function () {
            // Ambil data dari atribut data-* pada tombol
            
            const studentCourseId = this.getAttribute("data-student_course_id");
            const alias = this.getAttribute("data-alias");
            const customPaymentRate = this.getAttribute(
                "data-custom_payment_rate"
            );

            // Isi data ke dalam modal
            document.querySelector("#edit-modal h3").textContent = alias;
            document.querySelector("#student_course_id").value =
                studentCourseId;
            document.querySelector("#old_custom_payment_rate").value =
                customPaymentRate || "No Discount Rate";

            // Optional: Set placeholder untuk input baru berdasarkan nilai lama
            document.querySelector("#mapel_payment").placeholder =
                customPaymentRate
                    ? `Current: ${customPaymentRate}`
                    : "Enter Discount Rate";
        });
    });
});
