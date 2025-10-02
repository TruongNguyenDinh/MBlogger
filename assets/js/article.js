// 
const comments = document.querySelectorAll(".article-comment");
const fcp = document.querySelector(".fcpContainer");
const fcpLeft = fcp.querySelector(".fcp-left-side");
const fcpComment = fcp.querySelector(".fcp-comment");
const textarea = document.getElementById("wcomment");

// Lưu URL ban đầu để khi đóng popup có thể trả về
const originalUrl = window.location.href;

comments.forEach(comment => {
    comment.addEventListener("click", () => {
        const articleId = comment.dataset.id;

        // Đẩy URL lên thanh trình duyệt mà không reload
        const url = new URL(window.location);
        url.searchParams.set("query-articleID", articleId);
        window.history.pushState({}, '', url);

        // Load comment bằng fetch
        fetch(`../../controls/get_comments.php?articleId=${articleId}`)
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
