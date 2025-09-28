fetch("https://raw.githubusercontent.com/TruongNguyenDinh/TruongNguyenDinh/main/README.md")
    .then(res => res.text())
    .then(md => {
      document.getElementById("pro-main-content").innerHTML = marked.parse(md);
});