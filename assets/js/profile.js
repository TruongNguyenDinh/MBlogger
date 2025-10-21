// ==================== ĐẢM BẢO URL MẶC ĐỊNH ====================
const url = new URL(window.location);
if (!url.searchParams.has("query")) {
  url.searchParams.set("query", "user_reference");
  window.history.replaceState({}, "", url.toString()); // không reload
}

// ==================== LẤY README TỪ GITHUB ====================
let repoOwner = "";
const urlParams = new URLSearchParams(window.location.search);
const query = urlParams.get("query") || "user_reference"; // lấy user hiện tại hoặc session

fetch(`../../api/get_github_info.php?query=${query}`)
  .then(res => res.text())
  .then(txt => {
    console.log("📄 Response text:", txt);
    try {
      const data = JSON.parse(txt);
      repoOwner = data.username;

      if (!repoOwner) {
        document.getElementById("pro-main-content").innerHTML = "<p>Người này chưa liên kết GitHub.</p>";
        return;
      }

      // Sau khi đã có repoOwner mới fetch README
      return fetch(`https://raw.githubusercontent.com/${repoOwner}/${repoOwner}/main/README.md`);
    } catch (err) {
      console.error("❌ JSON parse error:", err);
    }
  })
  .then(res => res ? res.text() : null)
  .then(md => {
    if (md) {
      document.getElementById("pro-main-content").innerHTML = marked.parse(md);
    }
  })
  .catch(err => console.error("🚫 Fetch error:", err));


// ==================== CHUYỂN TAB ====================
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
