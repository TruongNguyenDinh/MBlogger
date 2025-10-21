// ====================== TOGGLE MORE BUTTON ======================
const toggleBtn = document.querySelector(".news-scene_more_toglebtn");
const groupBtns = document.querySelector(".group_btns");

if (toggleBtn && groupBtns) {
  toggleBtn.addEventListener("click", () => {
    groupBtns.style.display =
      groupBtns.style.display === "none" || groupBtns.style.display === ""
        ? "block"
        : "none";
  });
}

// ====================== CLICK NEWS ITEM ======================
const newsCard = document.querySelector(".news-card");
if (newsCard) {
  newsCard.addEventListener("click", function (e) {
    const link = e.target.closest(".news-card_elem a");
    if (!link) return;

    e.preventDefault();
    const newsId = link.closest(".news-card_elem").dataset.id;

    // Ghi query vào URL rồi reload trang
    const url = new URL(window.location);
    url.searchParams.set("query-newsID", newsId);
    window.location.href = url.toString();
  });
}

// ====================== PAGE LOAD HANDLING ======================
document.addEventListener("DOMContentLoaded", function () {
  const url = new URL(window.location);
  const newsId = url.searchParams.get("query-newsID");

  if (newsId) {
    fetch("../../views/components/news-detail.php?id=" + newsId)
      .then((res) => res.json())
      .then((data) => {
        if (newsCard) newsCard.style.display = "none";
        document.querySelector(".news-modal").style.display = "block";

        const groupBtns = document.querySelector(".group_btns");
        const moreBtn = document.getElementById("more-btn");
        if (groupBtns) groupBtns.style.display = "none";
        if (moreBtn) moreBtn.style.display = "none";

        document.getElementById("who-post").innerHTML = `
          <strong>${data.author}</strong>, ${data.date}
        `;

        const htmlContent = marked.parse(data.content);
        document.getElementById("news-detail").innerHTML = `
          <h2>${data.title}</h2>
          <div class="markdown-body">${htmlContent}</div>
        `;
      });
  }

  if (url.searchParams.get("query-recruitment") === "true") {
    if (newsCard) newsCard.style.display = "none";
    document.querySelector(".recruitment-news").style.display = "block";

    const newsScene = document.querySelector(".news-scene_more");
    if (newsScene) newsScene.style.display = "none";
  }
});

// ====================== BACK BUTTON ======================
const backBtn = document.getElementById("backBtn");
if (backBtn) {
  backBtn.addEventListener("click", () => {
    const url = new URL(window.location);
    url.searchParams.delete("query-newsID");

    if (newsCard) newsCard.style.display = "grid";
    document.querySelector(".news-modal").style.display = "none";

    const moreBtn = document.getElementById("more-btn");
    if (moreBtn) moreBtn.style.display = "block";

    window.location.href = url.toString();
  });
}

// ====================== RECRUITMENT HANDLING ======================
const recruitmentBtn = document.getElementById("recruitment-btn");
if (recruitmentBtn) {
  recruitmentBtn.addEventListener("click", () => {
    if (newsCard) newsCard.style.display = "none";
    document.querySelector(".recruitment-news").style.display = "block";

    const newsScene = document.querySelector(".news-scene_more");
    if (newsScene) newsScene.style.display = "none";

    const url = new URL(window.location);
    url.searchParams.set("query-recruitment", "true");
    window.location.href = url.toString();
  });
}

// ====================== EXIT RECRUITMENT ======================
const backBtnRe = document.getElementById("backBtn_re");
if (backBtnRe) {
  backBtnRe.addEventListener("click", () => {
    const textarea = document.getElementById("re-content");
    if (!textarea) return;

    if (textarea.value.trim() !== "") {
      const confirmExit = confirm(
        "Bạn có chắc muốn thoát không? Mọi thay đổi sẽ không được lưu."
      );
      if (confirmExit) recruit_news();
      else console.log("Người dùng chọn ở lại");
    } else {
      recruit_news();
    }

    const url = new URL(window.location);
    url.searchParams.delete("query-recruitment");
    window.location.href = url.toString();
  });
}

function recruit_news() {
  const textarea = document.getElementById("re-content");
  const bannerBox = document.getElementById("bannerBox");
  const bannerInput = document.getElementById("bannerInput");

  if (textarea) textarea.value = "";
  if (newsCard) newsCard.style.display = "grid";
  document.querySelector(".recruitment-news").style.display = "none";

  const newsScene = document.querySelector(".news-scene_more");
  const groupBtns = document.querySelector(".group_btns");
  if (newsScene) newsScene.style.display = "block";
  if (groupBtns) groupBtns.style.display = "none";

  if (bannerBox && bannerInput) {
    bannerBox.innerHTML = "+ Add banner";
    bannerBox.style.border = "2px dashed #aaa";
    bannerInput.value = "";
  }
}

// ====================== BANNER PREVIEW ======================
const bannerInput = document.getElementById("bannerInput");
if (bannerInput) {
  bannerInput.addEventListener("change", function (e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (evt) {
        const bannerBox = document.getElementById("bannerBox");
        bannerBox.innerHTML = `<img src="${evt.target.result}" alt="Banner">`;
        bannerBox.style.border = "none";
      };
      reader.readAsDataURL(file);
    }
  });
}

// ====================== RECRUITMENT EDITOR (RAW/PREVIEW) ======================
const rawTab = document.getElementById("tab-raw");
const previewTab = document.getElementById("tab-preview");
const textarea = document.getElementById("re-content");
const titlearea = document.getElementById("re-title");
const previewBox = document.getElementById("previewBox");

if (rawTab && previewTab && textarea && titlearea && previewBox) {
  const converter = new showdown.Converter({
    tables: true,
    strikethrough: true,
    ghCodeBlocks: true,
  });

  rawTab.addEventListener("click", () => {
    rawTab.classList.add("active");
    previewTab.classList.remove("active");

    titlearea.classList.remove("active");
    titlearea.removeAttribute("readonly");

    textarea.style.display = "block";
    textarea.removeAttribute("readonly");
    previewBox.style.display = "none";
  });

  previewTab.addEventListener("click", () => {
    previewTab.classList.add("active");
    rawTab.classList.remove("active");

    titlearea.classList.add("active");
    titlearea.setAttribute("readonly", true);

    textarea.style.display = "none";
    textarea.setAttribute("readonly", true);
    previewBox.style.display = "block";

    const html = converter.makeHtml(textarea.value);
    previewBox.innerHTML = html;
    previewBox.classList.add("markdown-body");

    previewBox.querySelectorAll("pre code").forEach((block) => {
      hljs.highlightElement(block);
    });

    previewBox.querySelectorAll('a[href^="http"]').forEach((link) => {
      link.setAttribute("target", "_blank");
    });
  });
}
