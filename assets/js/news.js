  const toggleBtn = document.querySelector(".news-scene_more_toglebtn");
  const groupBtns = document.querySelector(".group_btns");

  toggleBtn.addEventListener("click", () => {
    if (groupBtns.style.display === "none" || groupBtns.style.display === "") {
      groupBtns.style.display = "block";
    } else {
      groupBtns.style.display = "none";
    }
  });
//
// Xử lý click vào 1 news
// Xử lý click vào 1 news
document.querySelector(".news-card").addEventListener("click", function(e) {
  const link = e.target.closest(".news-card_elem a");
  if (!link) return;

  e.preventDefault();
  const newsId = link.closest(".news-card_elem").dataset.id;

  // Ghi query vào URL rồi reload trang
  const url = new URL(window.location);
  url.searchParams.set("query-newsID", newsId);
  window.location.href = url.toString();
});

document.addEventListener("DOMContentLoaded", function() {
  const url = new URL(window.location);
  const newsId = url.searchParams.get("query-newsID");

  if (newsId) {
    fetch("../../views/components/news-detail.php?id=" + newsId)
      .then(res => res.json())
      .then(data => {
        document.querySelector(".news-card").style.display = "none";
        document.querySelector(".news-modal").style.display = "block";
        document.querySelector(".group_btns").style.display = "none";
        document.getElementById("more-btn").style.display = "none";

        document.getElementById("who-post").innerHTML = `
          <strong>${data.author}</strong>, ${data.date}
        `;

        // ✅ Chuyển Markdown → HTML
        const htmlContent = marked.parse(data.content);

        document.getElementById("news-detail").innerHTML = `
          <h2>${data.title}</h2>
          <div class="markdown-body">${htmlContent}</div>
        `;
      });
  }

  if (url.searchParams.get("query-recruitment") === "true") {
    document.querySelector(".news-card").style.display = "none";
    document.querySelector(".recruitment-news").style.display = "block";
    document.querySelector(".news-scene_more").style.display = "none";
  }
});



// Gắn Back 1 lần duy nhất
document.getElementById("backBtn").addEventListener("click", () => {
  const url = new URL(window.location);
  url.searchParams.delete("query-newsID");
  document.querySelector(".news-card").style.display = "grid";
  document.querySelector(".news-modal").style.display = "none";
  // Hiện lại nút More
  document.getElementById("more-btn").style.display = "block";
  // Reload về URL gốc
  window.location.href = url.toString();
});
// Nút quay lại
document.getElementById("backBtn").addEventListener("click", () => {
  document.querySelector(".news-card").style.display = "grid";
  document.querySelector(".news-modal").style.display = "none";
});
// Đăng tin tuyển dụng
document.getElementById("recruitment-btn").addEventListener("click",()=>{
  document.querySelector(".news-card").style.display = "none";
  document.querySelector(".recruitment-news").style.display="block";
  // Ẩn nút More
  document.querySelector(".news-scene_more").style.display = "none";
  const url = new URL(window.location);
  url.searchParams.set("query-recruitment", "true");
  window.location.href = url.toString(); // reload trang
})
// Thoát đăng tin
document.getElementById("backBtn_re").addEventListener("click", () => {
  if (textarea.value.trim() !== "") {
    // Nếu textarea khác rỗng, hỏi xác nhận
    const confirmExit = confirm("Bạn có chắc muốn thoát không? Mọi thay đổi sẽ không được lưu.");
    if (confirmExit) {
      recruit_news();
    }
    else{
      // Ở lại, không làm gì
      console.log("Người dùng chọn ở lại");
            }
    }
    else {
      // Nếu rỗng thì thoát luôn
      recruit_news();
  }
  const url = new URL(window.location);
  url.searchParams.delete("query-recruitment");
  // Reload về URL gốc
  window.location.href = url.toString();
});
function recruit_news(){
  textarea.value = "";
  document.querySelector(".news-card").style.display = "grid";
  document.querySelector(".recruitment-news").style.display = "none";
  // Hiện lại nút More và ẩn Group 
  document.querySelector(".news-scene_more").style.display = "block";
  document.querySelector(".group_btns").style.display = "none";

  // 👉 Reset banner về trạng thái ban đầu
  const bannerBox = document.getElementById("bannerBox");
  bannerBox.innerHTML = "+ Add banner";
  bannerBox.style.border = "2px dashed #aaa";
  document.getElementById("bannerInput").value = ""; // xoá file đã chọn
}
// Hiển thị banner
document.getElementById("bannerInput").addEventListener("change", function (e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (evt) {
      const bannerBox = document.getElementById("bannerBox");
      bannerBox.innerHTML = `<img src="${evt.target.result}" alt="Banner">`;
      bannerBox.style.border = "none"; // 👈 bỏ border
    };
    reader.readAsDataURL(file);
  }
});
//
const rawTab = document.getElementById("tab-raw");
const previewTab = document.getElementById("tab-preview");
const textarea = document.getElementById("re-content");
const titlearea = document.getElementById("re-title");
const previewBox = document.getElementById("previewBox");

// Markdown converter
const converter = new showdown.Converter({
  tables: true,
  strikethrough: true,
  ghCodeBlocks: true,
});

// Khi nhấn tab Raw (soạn thảo)
rawTab.addEventListener("click", () => {
  rawTab.classList.add("active");
  previewTab.classList.remove("active");
  
  titlearea.classList.remove("active");
  titlearea.removeAttribute("readonly"); // cho nhập lại tiêu đề

  textarea.style.display = "block";
  textarea.removeAttribute("readonly"); // cho nhập nội dung
  previewBox.style.display = "none";
});

// Khi nhấn tab Preview (xem trước)
previewTab.addEventListener("click", () => {
  previewTab.classList.add("active");
  rawTab.classList.remove("active");

  titlearea.classList.add("active");
  titlearea.setAttribute("readonly", true); // ❌ không cho nhập tiêu đề

  textarea.style.display = "none";
  textarea.setAttribute("readonly", true); // ❌ không cho nhập nội dung
  previewBox.style.display = "block";

  // Convert Markdown
  const html = converter.makeHtml(textarea.value);
  previewBox.innerHTML = html;
  previewBox.classList.add("markdown-body");

  // Highlight tất cả code trong preview
  previewBox.querySelectorAll("pre code").forEach((block) => {
    hljs.highlightElement(block);
  });

  // Tự động mở liên kết trong tab mới
  previewBox.querySelectorAll('a[href^="http"]').forEach(link => {
    link.setAttribute('target', '_blank');
  });
});




