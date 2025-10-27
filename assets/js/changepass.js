// === Toggle hiển thị/ẩn mật khẩu ===
function togglePass(id, el) {
  const input = document.getElementById(id);
  input.type = input.type === "password" ? "text" : "password";
  el.textContent = input.type === "password" ? "👁️" : "🙈";
}

// === Mở và đóng popup ===
function openPopup() {
  document.getElementById("cp-popup").style.display = "flex";
}
function closePopup() {
  document.getElementById("cp-popup").style.display = "none";
  clearMessage();
}

// === Hiển thị thông báo ===
function showMessage(text, isSuccess = false) {
  let msg = document.getElementById("cp-message");
  if (!msg) {
    msg = document.createElement("div");
    msg.id = "cp-message";
    msg.className = "cp-message";
    document.querySelector(".cp-container_checkpass").prepend(msg);
  }
  msg.textContent = text;
  msg.style.color = isSuccess ? "green" : "red";
}

function clearMessage() {
  const msg = document.getElementById("cp-message");
  if (msg) msg.remove();
}

// === Gửi yêu cầu đổi mật khẩu ===
document.querySelector(".cp-button-send-data").addEventListener("click", async () => {
  clearMessage();

  const current = document.getElementById("current-pass").value.trim();
  const newPass = document.getElementById("new-pass").value.trim();
  const confirm = document.getElementById("confirm-pass").value.trim();

  if (!current || !newPass || !confirm) {
    showMessage("Please fill in all fields.");
    return;
  }

  try {
    const response = await fetch("../../api/change_pass.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ current, new: newPass, confirm }),
    });

    const data = await response.json();
    showMessage(data.message, data.success);

    if (data.success) {
      // Xoá input sau khi đổi thành công
      setTimeout(() => {
        closePopup();
        document.getElementById("current-pass").value = "";
        document.getElementById("new-pass").value = "";
        document.getElementById("confirm-pass").value = "";
      }, 1500);
    }
  } catch (error) {
    showMessage("Server error, please try again later.");
  }
});

// === Mở popup khi nhấn "Change password" trong account setting ===
document.addEventListener("DOMContentLoaded", () => {
  const changePassBtn = document.querySelector(".left-input[style*='cursor: pointer']");
  if (changePassBtn) {
    changePassBtn.addEventListener("click", openPopup);
  }
});
