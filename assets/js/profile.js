fetch("https://raw.githubusercontent.com/TruongNguyenDinh/TruongNguyenDinh/main/README.md")
    .then(res => res.text())
    .then(md => {
      document.getElementById("pro-main-content").innerHTML = marked.parse(md);
});
// Chuyển tab
const tabs = document.querySelectorAll(".pro-title-tab div");
const mainContent = document.getElementById("pro-main-content");
const mainPost = document.getElementById("pro-main-post");

tabs.forEach(tab => {
  tab.addEventListener("click", () => {
    // reset active
    tabs.forEach(t => t.classList.remove("active"));
    tab.classList.add("active");

    // toggle content
    if (tab.classList.contains("pro-ref")) {
      mainContent.style.display = "block";
      mainPost.style.display = "none";
    } else if (tab.classList.contains("pro-post")) {
      mainContent.style.display = "none";
      mainPost.style.display = "block";
    }
  });
});

