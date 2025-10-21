document.addEventListener("click", function(e) {
  if (e.target.classList.contains("toggle-btn")) {
    const content = e.target.previousElementSibling;
    content.classList.toggle("expanded");
    e.target.textContent = content.classList.contains("expanded")
      ? "Show less"
      : "Show more";
  }
});
document.addEventListener("DOMContentLoaded", () => {
    const popup = document.getElementById("loginPopup");
    const cancel = document.getElementById("loginCancel");

    if (cancel && popup) {
        cancel.addEventListener("click", () => {
            popup.style.display = "none";
        });
    }
});
