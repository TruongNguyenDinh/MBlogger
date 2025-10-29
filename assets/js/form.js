//-------------- Xử lý tìm kiếm icon và gợi ý----------------
document.addEventListener("DOMContentLoaded", () => {
  const icon_search = document.getElementById("search_icon");
  const input_search = document.getElementById("form_search");
  const box = document.getElementById("suggestions");

  const suggestions = [
    { text: "Support >> Account >> I forgot my password", url: "http://localhost/mblogger/views/form/form.php?page=fogotpassword" }
  ];

  const renderSuggestions = () => {
    box.innerHTML = "";
    suggestions.forEach(item => {
      const div = document.createElement("div");
      div.textContent = item.text;
      div.classList.add("suggestion-item");
      div.addEventListener("click", () => {
        window.location.href = item.url;
      });
      box.appendChild(div);
    });
    box.style.display = "block";
  };

  // Click icon toggle input + render suggestion
  icon_search.addEventListener("click", (e) => {
    e.stopPropagation();
    input_search.classList.toggle("visible");
    if (input_search.classList.contains("visible")) {
      input_search.focus();
      renderSuggestions();
    } else {
      box.style.display = "none";
    }
  });

  // Focus input hiện suggestion
  input_search.addEventListener("focus", () => {
    if (input_search.classList.contains("visible")) renderSuggestions();
  });

  // Blur ẩn suggestion
  input_search.addEventListener("blur", () => {
    setTimeout(() => box.style.display = "none", 200);
  });

  // Click ngoài ẩn input + suggestion
  document.addEventListener("click", (e) => {
    if (!input_search.contains(e.target) && !icon_search.contains(e.target) && !box.contains(e.target)) {
      input_search.classList.remove("visible");
      box.style.display = "none";
    }
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
//----------------------- Gửi check email ----------------------------------
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("fogot-form");
  const emailInput = form.querySelector("input[name='email']");
  const codeGroup = form.querySelector(".input-group:nth-of-type(2)");
  const codeInput = form.querySelector("input[name='confirm-code']");
  const checkBtn = document.getElementById("check-btn");
  const sendBtn = document.getElementById("send-btn");

  let sentCode = null; // Lưu mã được gửi từ server

  // --- B1: Kiểm tra email và gửi mã ---
  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    // Nếu đang ở bước kiểm tra email
    if (checkBtn.style.display !== "none") {
      showError("Đang gửi email, vui lòng đợi trong giây lát", "success");
      const email = emailInput.value.trim();
      if (!email) return showError("Vui lòng nhập email!");

      try {
        // Kiểm tra email + gửi code
        const res = await fetch("../../api/check_email.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ email }),
        });
        const data = await res.json();

        const codeGroup = codeInput.parentElement; // luôn lấy đúng container
        if (data.success) {
          sentCode = data.code;
          showError("Đã gửi mã xác nhận tới email!", "success");

          emailInput.disabled = true;
          checkBtn.style.display = "none";

          codeGroup.style.display = "flex"; // bật input code
          codeInput.disabled = false;
          sendBtn.style.display = "inline-block";
        } else {
          showError(data.message || "Email không tồn tại hoặc gửi thất bại!");
        }
      } catch (err) {
        console.error(err);
        showError("Lỗi kết nối server!");
      }
    }
    // --- B2: Khi nhấn nút gửi mã (send) ---
    else if (sendBtn.style.display !== "none") {
      const enteredCode = codeInput.value.trim();
      if (!enteredCode) return showError("Vui lòng nhập mã xác nhận!");

      if (enteredCode === String(sentCode)) {
        showError("Xác nhận thành công!", "success");

        // Ở đây bạn có thể redirect sang trang đặt lại mật khẩu
        // Khi code đúng
        const email = emailInput.value.trim();
        window.location.href = `http://localhost/mblogger/views/form/form.php?page=resetpassword&email=${encodeURIComponent(email)}`;

      } else {
        showError("Mã xác nhận không đúng!");
      }
    }
  });
});
//----------------------- Cài lại mật khẩu ---------------------------------
document.addEventListener("DOMContentLoaded", () => {
  const urlParams = new URLSearchParams(window.location.search);
  const email = urlParams.get("email");
  if (email) {
    document.getElementById("email-hidden").value = email;
  }
});
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("reset-form");
  const emailInput = document.getElementById("email-hidden");
  const passwordInput = form.querySelector("input[name='password']");
  const confirmInput = form.querySelector("input[name='confirm-password']");

  // Lấy email từ URL query string
  const urlParams = new URLSearchParams(window.location.search);
  const email = urlParams.get("email");
  if (email) {
    emailInput.value = email;
  }

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const password = passwordInput.value.trim();
    const confirm = confirmInput.value.trim();

    if (!password || !confirm) {
      showError("Vui lòng nhập đầy đủ mật khẩu mới và xác nhận mật khẩu!");
      return;
    }

    if (password !== confirm) {
      showError("Mật khẩu mới và xác nhận mật khẩu không trùng khớp!");
      return;
    }

    try {
      const res = await fetch("../../api/reset_password.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          email: emailInput.value,
          password: password,
          "confirm-password": confirm
        })
      });

      const data = await res.json();

      if (data.success) {
        showError("Đổi mật khẩu thành công! Chuyển hướng đến trang đăng nhập...", "success");
        setTimeout(() => {
          window.location.href = "form.php?page=login";
        }, 2000);
      } else {
        showError(data.message || "Đổi mật khẩu thất bại!");
      }
    } catch (err) {
      console.error(err);
      showError("Lỗi kết nối server!");
    }
  });
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
