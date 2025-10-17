
let repoOwner = "";

fetch("../../api/get_github_info.php")
  .then(res => {
    console.log("📥 Raw response:", res);
    return res.text(); // lấy text để debug
  })
  .then(txt => {
    console.log("📄 Response text:", txt);
    try {
      const data = JSON.parse(txt);
      repoOwner = data.username;

      // Sau khi đã có repoOwner mới fetch README
      return fetch(`https://raw.githubusercontent.com/${repoOwner}/${repoOwner}/main/README.md`);
    } catch (err) {
      console.error("❌ JSON parse error:", err);
    }
  })
  .then(res => res.text())
  .then(md => {
    if (md) {
      document.getElementById("pro-main-content").innerHTML = marked.parse(md);
    }
  })
  .catch(err => console.error("🚫 Fetch error:", err));

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

