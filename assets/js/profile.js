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
// ==================== GỌI API ĐỂ LẤY SỐ REPO CỦA NGƯỜI DÙNG GITHUB ====================
document.addEventListener('DOMContentLoaded', async () => {
  const CACHE_KEY = 'github_overview_cache';
  const CACHE_TTL = 60 * 60 * 1000; // 1 tiếng

  try {
    const urlParams = new URLSearchParams(window.location.search);
    const query = urlParams.get('query');
    let apiUrl = 'http://localhost/mblogger/api/get_overview_githubuser.php';
    if (query && query !== 'user_reference') {
      apiUrl += `?user_id=${encodeURIComponent(query)}`;
    }

    // 🧠 Kiểm tra cache
    const cached = localStorage.getItem(CACHE_KEY);
    if (cached) {
      const { timestamp, data, url } = JSON.parse(cached);

      // Nếu cùng user & cache chưa hết hạn
      if (url === apiUrl && Date.now() - timestamp < CACHE_TTL) {
        console.log("🟢 Dùng dữ liệu cache GitHub");
        updateUI(data);
        return;
      }
    }

    console.log("🔵 Gọi API GitHub...");
    const response = await fetch(apiUrl);
    const data = await response.json();

    // Lưu cache nếu hợp lệ
    if (data && !data.error) {
      localStorage.setItem(CACHE_KEY, JSON.stringify({
        timestamp: Date.now(),
        url: apiUrl,
        data
      }));
    }

    updateUI(data);
  } 
  catch (error) {
    console.error('Error fetching GitHub data:', error);
    document.getElementById('repo-count').textContent = 'Error';
    document.getElementById('star-count').textContent = 'Error';
  }

  function updateUI(data) {
    if (!data.hasGithub) {
      document.getElementById('repo-count').textContent = '—';
      document.getElementById('star-count').textContent = '—';
      console.log("User chưa liên kết GitHub hoặc không có tài khoản.");
      return;
    }

    document.getElementById('repo-count').textContent = data.public_repos ?? 'N/A';
    document.getElementById('star-count').textContent = data.stars ?? '—';
  }
});





