//----------------------- Hiện ẩn input search -----------------------
const icon_search = document.getElementById("search_icon");
const input_search = document.getElementById("form_search");

icon_search.addEventListener("click", (e) => {
  e.stopPropagation();
  if (input_search.style.display === "none" || input_search.style.display === "") {
    input_search.style.display = "inline-block";
    input_search.focus();
  } else {
    input_search.style.display = "none";
  }
});

document.addEventListener("click", (e) => {
  if (!icon_search.contains(e.target) && !input_search.contains(e.target)) {
    input_search.style.display = "none";
  }
});

//----------------------- Gợi ý search -----------------------
const suggestions = [
  { text: "Support >> Account >> I forgot my password", url: "/support/forgot-password" },
];

const input = document.getElementById("form_search");
const box = document.getElementById("suggestions");

input.addEventListener("focus", () => {
  box.innerHTML = "";
  suggestions.forEach((item) => {
    const div = document.createElement("div");
    div.textContent = item.text;
    div.addEventListener("click", () => (window.location.href = item.url));
    box.appendChild(div);
  });
  box.style.display = "inherit";
});

input.addEventListener("blur", () => {
  setTimeout(() => (box.style.display = "none"), 200);
});

//----------------------- Chuyển login <-> register (có reload) -----------------------
document.addEventListener("click", function (e) {
  // Chuyển sang form đăng ký
  if (e.target.id === "toggle-register") {
    e.preventDefault();
    window.location.href = "form.php?page=register"; // reload thật
  }

  // Quay lại form đăng nhập
  if (e.target.id === "back-btn") {
    e.preventDefault();
    window.location.href = "form.php?page=login"; // reload thật
  }
});

//----------------------- Tự động mở form theo query -----------------------
window.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);
  const page = params.get("page");

  // Không cần fetch vì PHP đã render sẵn đúng form
  // Nhưng nếu muốn dùng fetch để chuyển "mượt" mà không reload, dùng code cũ bên dưới:
  /*
  if (page === "register") loadForm("register");
  else loadForm("login");
  */
});
