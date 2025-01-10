
  // Get modal elements
  const modal = document.getElementById("modal");
  const modalTitle = document.getElementById("modal-title");
  const modalMessage = document.getElementById("modal-message");
  const closeModalBtn = document.querySelector(".close-btn");
  const modalActionBtn = document.getElementById("modal-action");

  // Function to show the modal with custom title and message
  function showModal(title, message, actionCallback = null) {
    modalTitle.textContent = title;
    modalMessage.textContent = message;
    modal.style.display = "block";

    // Add action callback for the button
    modalActionBtn.onclick = () => {
      if (actionCallback) actionCallback();
      modal.style.display = "none"; // Close modal
    };
  }

  // Close modal when "X" is clicked
  closeModalBtn.onclick = () => {
    modal.style.display = "none";
  };

  // Close modal if user clicks outside the modal
  window.onclick = (event) => {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  };

showModal("Error", "Invalid password. Please try again.");
showModal("Warning", "Please login to access this feature.", () => {
    // window.location.href = "/login";
});
