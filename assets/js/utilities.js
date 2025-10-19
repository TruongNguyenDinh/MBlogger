document.addEventListener("click", function(e) {
  if (e.target.classList.contains("toggle-btn")) {
    const content = e.target.previousElementSibling;
    content.classList.toggle("expanded");
    e.target.textContent = content.classList.contains("expanded")
      ? "Show less"
      : "Show more";
  }
});