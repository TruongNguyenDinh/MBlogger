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
// Render readme + đang mất comment
document.addEventListener("DOMContentLoaded", () => {
  const articles = document.querySelectorAll(".article-content");

  articles.forEach(contentEl => {
    const text = contentEl.textContent.trim();

    // Kiểm tra xem có phải link GitHub README.md hoặc file .md nào không
    const isGithubMd = /^https:\/\/github\.com\/.+\/blob\/.+\.md$/i.test(text);

    if (isGithubMd) {
      // Chuyển sang link raw GitHub
      const rawUrl = text
        .replace("https://github.com/", "https://raw.githubusercontent.com/")
        .replace("/blob/", "/");

      // Fetch nội dung markdown
      fetch(rawUrl)
        .then(res => {
          if (!res.ok) throw new Error("Không thể tải file markdown");
          return res.text();
        })
        .then(md => {
          // Parse Markdown sang HTML và chèn vào bài viết
          contentEl.innerHTML = marked.parse(md);
        })
        .catch(err => {
          contentEl.innerHTML = `<p style="color:red;">Lỗi tải nội dung: ${err.message}</p>`;
        });
    }
  });
}); 



