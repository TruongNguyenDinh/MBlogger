document.getElementById("newsForm").addEventListener("submit", async (e) => {
    e.preventDefault(); // 🛑 Chặn form tự submit

    const title = document.getElementById("re-title").value.trim();
    const content = document.getElementById("re-content").value.trim();
    const topic = document.getElementById("topicInput").value.trim();
    const banner = document.getElementById("bannerInput").files[0];

    if (!title || !content) {
        alert("Vui lòng nhập đầy đủ tiêu đề và nội dung!");
        return;
    }

    const formData = new FormData();
    formData.append("title", title);
    formData.append("content", content);
    formData.append("topic", topic);
    if (banner) formData.append("banner", banner);

    try {
        const response = await fetch("../../controls/recuitmentcontroller.php", {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            alert("✅ Đăng bài thành công!");
            window.location.href = "../news/news.php";
        } else {
            alert("❌ " + result.message);
        }
    } catch (error) {
        console.error("Lỗi:", error);
        alert("Đã xảy ra lỗi khi đăng bài!");
    }
});
