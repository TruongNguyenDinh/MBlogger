document.addEventListener('click', e => {
  if (e.target.classList.contains('article-id')) {
    const text = e.target.innerText.replace("ID: ", "");
    navigator.clipboard.writeText(text).then(() => {
      alert("Copied: " + text);
    });
  }
});
document.addEventListener("click", function(e) {
  if (e.target.classList.contains("toggle-btn")) {
    const content = e.target.previousElementSibling;
    content.classList.toggle("expanded");
    e.target.textContent = content.classList.contains("expanded")
      ? "Show less"
      : "Show more";
  }
});


