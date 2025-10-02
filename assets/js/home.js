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
// Xử lý news
document.querySelectorAll('.news-card_elem a').forEach(a => {
  a.addEventListener('click', function(e) {
    e.preventDefault();
    const id = this.closest('.news-card_elem')?.dataset.id;
    if (!id) return;
    window.location.href = `/mblogger/views/news/news.php?query-newsID=${encodeURIComponent(id)}`;
  });
});




