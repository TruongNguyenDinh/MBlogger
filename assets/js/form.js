document.addEventListener("DOMContentLoaded", () => {
  //----------------------- Hiện ẩn input search -----------------------
  const icon_search = document.getElementById("search_icon");
  const input_search = document.getElementById("form_search");

  icon_search?.addEventListener("click", (e) => {
    e.stopPropagation();
    input_search.classList.toggle("visible");
    if (input_search.classList.contains("visible")) input_search.focus();
  });

  document.addEventListener("click", (e) => {
    if (!icon_search.contains(e.target) && !input_search.contains(e.target)) {
      input_search.classList.remove("visible");
    }
  });

  //----------------------- Gợi ý search -----------------------
  const suggestions = [
    { text: "Support >> Account >> I forgot my password", url: "/support/forgot-password" },
  ];
  const box = document.getElementById("suggestions");

  input_search?.addEventListener("focus", () => {
    box.innerHTML = "";
    suggestions.forEach((item) => {
      const div = document.createElement("div");
      div.textContent = item.text;
      div.addEventListener("click", () => (window.location.href = item.url));
      box.appendChild(div);
    });
    box.style.display = "block";
  });

  input_search?.addEventListener("blur", () => {
    setTimeout(() => (box.style.display = "none"), 200);
  });

  //----------------------- Chuyển login <-> register -----------------------
  document.addEventListener("click", (e) => {
    if (e.target.id === "toggle-register") {
      e.preventDefault();
      window.location.href = "form.php?page=register";
    }

    if (e.target.id === "back-btn") {
      e.preventDefault();
      window.location.href = "form.php?page=login";
    }
  });

  //----------------------- Xử lý login không reload -----------------------
  const loginForm = document.getElementById("loginForm");
  if (loginForm) {
    loginForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const data = new FormData(loginForm);

      try {
        const response = await fetch("../../controls/logincontroller.php", {
          method: "POST",
          body: data,
        });

        const result = await response.json();

        if (result.success) {
          if (result.success) {
            window.location.href = result.redirect || "../home/home.php";
          } else {
            showError(result.message || "Tên đăng nhập hoặc mật khẩu sai.");
          }
        } else {
          showError(result.message || "Tên đăng nhập hoặc mật khẩu sai.");
        }
      } catch (err) {
        console.error("Lỗi fetch:", err);
        showError("Không thể kết nối đến máy chủ.");
      }
    });
  }

  //----------------------- Xử lý register không reload -----------------------
  const registerForm = document.querySelector('form[action*="registercontroller.php"]');
  if (registerForm) {
    registerForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const data = new FormData(registerForm);

      try {
        const response = await fetch("../../controls/registercontroller.php", {
          method: "POST",
          body: data,
        });

        const result = await response.json();

        if (result.success) {
          showError("Đăng ký thành công! Mời bạn đăng nhập.", "success");
          setTimeout(() => (window.location.href = "form.php?page=login"), 2000);
        } else {
          showError(result.message || "Không thể đăng ký tài khoản.");
        }
      } catch (err) {
        console.error("Lỗi fetch:", err);
        showError("Không thể kết nối đến máy chủ.");
      }
    });
  }
});

//----------------------- Hiển thị thông báo lỗi nổi -----------------------
function showError(message, type = "error") {
  let container = document.getElementById("notification-area");
  if (!container) {
    container = document.createElement("div");
    container.id = "notification-area";
    document.body.appendChild(container);
  }

  const div = document.createElement("div");
  div.className = `error-form ${type}`;
  div.innerHTML = `
    <div class="error-header">
        <div class="icon"><i class="fa-solid ${type === "success" ? "fa-circle-check" : "fa-circle-exclamation"}"></i></div>
        <div class="error-type">${type === "success" ? "Thành công" : "Lỗi"}</div>
    </div>
    <div class="error-content">${message}</div>
    <div class="error-timeline"></div>
  `;

  container.appendChild(div);

  setTimeout(() => {
    div.style.opacity = "0";
    div.style.transform = "translateX(120%)";
    setTimeout(() => div.remove(), 500);
  }, 4000);
}
