// 
const comments = document.querySelectorAll(".article-comment");
const fcp = document.querySelector(".fcpContainer");
const fcpLeft = fcp.querySelector(".fcp-left-side");
const fcpComment = fcp.querySelector(".fcp-comment");
const textarea = document.getElementById("wcomment");
const hiddenInput = fcp.querySelector("input[name='article_id']");
// Lưu URL ban đầu để khi đóng popup có thể trả về
let originalUrl = window.location.origin + window.location.pathname; // luôn là URL gốc
//  Đoạn này tự mở popup nếu có query-articleID trên URL
document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    const articleId = params.get("query-articleID");
    if (articleId) {
        // Tìm phần tử comment có data-id tương ứng
        const comment = document.querySelector(`.article-comment[data-id="${articleId}"]`);
        if (comment) comment.click(); // Gọi sự kiện click như người dùng bấm
    }
});
// End
comments.forEach(comment => {
    comment.addEventListener("click", () => {
    const articleId = comment.dataset.id;
    fcp.dataset.currentId = articleId;
    hiddenInput.value = articleId;
    fcp.setAttribute("data-current-id", articleId);
        // Đẩy URL lên thanh trình duyệt mà không reload
        const url = new URL(window.location);
        url.searchParams.set("query-articleID", articleId);
        window.history.pushState({}, '', url);
        // Load comment bằng fetch
        fetch(`../../controls/commentcontroller.php?articleId=${articleId}`)
            .then(response => response.text())
            .then(html => {
                fcpComment.innerHTML = html;
            });
        // Load nội dung bài viết vào fcp-left-side (có thể hardcode trước hoặc từ PHP)
        const articleCard = comment.closest('.container-post').cloneNode(true);
        // Xóa phần comment khỏi bản copy toggle-btn
        const clonedComment = articleCard.querySelector(".article-comment");
        const toggleBtn = articleCard.querySelector(".toggle-btn");
        if (clonedComment && toggleBtn ) {
            clonedComment.remove();
            toggleBtn.remove();
        }

    fcpLeft.innerHTML = '';
    fcpLeft.appendChild(articleCard);

        // Hiển thị popup
        fcp.style.display = "flex";
    });
});

// Đóng popup khi click ra ngoài
fcp.addEventListener("click", (e) => {
    if (e.target === fcp) {
        if (textarea.value.trim() !== "") {
            const confirmExit = confirm("Bạn có chắc muốn thoát không? Nội dung sẽ bị mất.");
            if (!confirmExit) return;
        }
        fcp.style.display = "none";
        textarea.value = "";

        // Trả URL về ban đầu
        window.history.pushState({}, '', originalUrl);
    }
});

// Thêm ngay dưới đoạn trên (AJAX gửi comment)
const fcpForm = document.querySelector(".fcp-wcomment form");
const fcpTextarea = document.getElementById("wcomment");

fcpForm.addEventListener("submit", (e) => {
  e.preventDefault();

  const articleId = fcp.dataset.currentId;
  const content = fcpTextarea.value.trim();
  if (!content) {
    alert("Vui lòng nhập nội dung bình luận!");
    return;
  }

  const formData = new FormData();
  formData.append("article_id", articleId);
  formData.append("wcomment", content);

  //  Gửi bình luận bằng AJAX
  fetch(`../../controls/commentcontroller.php`, {
    method: "POST",
    body: formData
  })
  .then(() => {
    // Sau khi gửi, tải lại danh sách comment
    return fetch(`../../controls/commentcontroller.php?articleId=${articleId}`);
  })
  .then(res => res.text())
  .then(html => {
    fcpComment.innerHTML = html;
    fcpTextarea.value = ""; // reset input
        //  Cập nhật số comment ngoài danh sách
    const commentDiv = document.querySelector(`.article-comment[data-id='${articleId}']`);
    if (commentDiv) {
        // Lấy số hiện tại trong text, ví dụ "Comment: 3"
        const current = parseInt(commentDiv.textContent.replace(/\D/g, "")) || 0;
        commentDiv.textContent = "Comment: " + (current + 1);
    }

  })
  .catch(err => {
    alert("Không gửi được bình luận: " + err.message);
  });
});
;