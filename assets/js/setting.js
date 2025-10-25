// --- Nút "Advantage" ---
document.getElementById('adv-btn1').addEventListener("click", () => {
  document.getElementById("adv-content").style.display = 'block';
  document.getElementById("adv-btn1").style.display = 'none';
  document.getElementById("adv-btn2").style.display = 'block';
});

document.getElementById('adv-btn2').addEventListener("click", () => {
  document.getElementById("adv-content").style.display = 'none';
  document.getElementById("adv-btn1").style.display = 'block';
  document.getElementById("adv-btn2").style.display = 'none';
});

// --- Xử lý Edit / Save ---
const editBtn = document.getElementById("edit-btn");
const saveBtn = document.getElementById("save-btn");
const inputs = document.querySelectorAll(".basic-content input, .basic-content select");

// 🔒 Khóa tất cả ô khi load trang
window.addEventListener("DOMContentLoaded", () => {
  inputs.forEach(el => {
    if (el.tagName === "SELECT") {
      el.disabled = true;
    } else {
      el.readOnly = true;
    }
    el.style.pointerEvents = "none";
    el.style.backgroundColor = "#f0f0f0";
  });
  saveBtn.disabled = true;
});

// ✏️ Khi nhấn "Edit" → mở khóa
editBtn.addEventListener("click", () => {
  inputs.forEach(el => {
    if (el.tagName === "SELECT") {
      el.disabled = false;
    } else {
      el.readOnly = false;
    }
    el.style.pointerEvents = "auto";
    el.style.backgroundColor = "white";
  });
  saveBtn.disabled = false;
});

// 💾 Khi nhấn "Save" → khóa lại
saveBtn.addEventListener("click", () => {
  inputs.forEach(el => {
    if (el.tagName === "SELECT") {
      el.disabled = true;
    } else {
      el.readOnly = true;
    }
    el.style.pointerEvents = "none";
    el.style.backgroundColor = "#f0f0f0";
  });
  saveBtn.disabled = true;
});
//
document.addEventListener("DOMContentLoaded", () => {
  const saveBtn = document.getElementById("save-btn");
  const input = document.getElementById("roleInput");
  const optionsBox = document.getElementById("roleOptions");

  

  // ✅ Khi click vào input → hiện dropdown
  input.addEventListener("click", (e) => {
    e.stopPropagation(); // tránh bị đóng ngay
    optionsBox.style.display =
      optionsBox.style.display === "block" ? "none" : "block";
  });

  // ✅ Khi chọn một option → ghi vào input
  optionsBox.querySelectorAll("div").forEach(opt => {
    opt.addEventListener("click", () => {
      input.value = opt.dataset.value;
      optionsBox.style.display = "none";
    });
  });

  // ✅ Ẩn dropdown khi click ra ngoài
  document.addEventListener("click", (e) => {
    if (!e.target.closest(".role-select")) {
      optionsBox.style.display = "none";
    }
  });

  // ✅ Khi nhấn Save → AJAX lưu
  saveBtn.addEventListener("click", function (e) {
    e.preventDefault();

    const form = document.getElementById("account-form");
    const formData = new FormData(form);

    for (const [key, value] of formData.entries()) {
      console.log(`📦 ${key}: ${value}`);
    }

    fetch("../../controls/settingcontroller.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          alert(data.message);
          document
            .querySelectorAll(".basic-content input")
            .forEach((el) => {
              el.setAttribute("readonly", true);
              el.style.pointerEvents = "none";
              el.style.backgroundColor = "#f0f0f0";
            });
        } else {
          alert("Lỗi: " + data.message);
        }
      })
      .catch((err) => {
        console.error("❌ Fetch error:", err);
        alert("Có lỗi xảy ra khi gửi dữ liệu!");
      });
  });
});
//thay đổi ảnh đại diện
document.addEventListener("DOMContentLoaded", function() {
    const changeAvtBtn = document.getElementById("changeAvtBtn");
    const avatarInput = document.getElementById("avatarInput");
    const userAvatar = document.getElementById("userAvatar");
    const saveAvtBtn = document.getElementById("saveAvtBtn");

    let selectedFile = null;

    // Khi bấm Change Avatar → chọn file
    changeAvtBtn.addEventListener("click", () => {
        avatarInput.click();
    });

    // Khi chọn file → xem trước + bật nút Save
    avatarInput.addEventListener("change", (event) => {
        const file = event.target.files[0];
        if (file) {
            selectedFile = file;

            const reader = new FileReader();
            reader.onload = (e) => {
                userAvatar.src = e.target.result;
                saveAvtBtn.style.display = "inline-block"; // ⚡ hiện nút Save
            };
            reader.readAsDataURL(file);
        }
    });
    console.log('SaveBtn:', document.getElementById("saveAvtBtn"));


    // Khi nhấn Save → gửi tên file lên PHP
    saveAvtBtn.addEventListener("click", () => {
      if (!selectedFile) return;

      const formData = new FormData();
      formData.append("avatar", selectedFile);

      fetch("../../api/setAvatar.php", {
          method: "POST",
          body: formData
      })
      .then(res => res.json())
      .then(data => {
          console.log(data);
          if (data.success) {
              alert("✅ Avatar updated successfully!");
              saveAvtBtn.style.display = "none";
          } else {
              alert("❌ " + (data.message || "Upload failed"));
          }
      })
      .catch(err => console.error(err));
  });

});










