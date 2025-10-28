// Render readme
document.addEventListener("DOMContentLoaded", () => {
  const articles = document.querySelectorAll(".article-content");

  articles.forEach(contentEl => {
    const text = contentEl.textContent.trim();
    const isGithubMd = /^https:\/\/github\.com\/.+\/blob\/.+\.md$/i.test(text);

    if (isGithubMd) {
      const rawUrl = text
        .replace("https://github.com/", "https://raw.githubusercontent.com/")
        .replace("/blob/", "/");

      fetch(rawUrl)
        .then(res => res.text())
        .then(md => {
          contentEl.innerHTML = marked.parse(md);
        })
        .catch(err => {
          contentEl.innerHTML = `<p style="color:red;">Lỗi tải nội dung: ${err.message}</p>`;
        });
    }
  });
});