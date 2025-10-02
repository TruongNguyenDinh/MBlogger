document.getElementById('adv-btn1').addEventListener("click",()=>{
    document.getElementById("adv-content").style.display='block';
    document.getElementById("adv-btn1").style.display='none';
    document.getElementById("adv-btn2").style.display='block';
});
document.getElementById('adv-btn2').addEventListener("click",()=>{
    document.getElementById("adv-content").style.display='none';
    document.getElementById("adv-btn1").style.display='block';
    document.getElementById("adv-btn2").style.display='none';
});
// Cho phép sửa thông tin cá nhân
const editBtn = document.getElementById("edit-btn");
const saveBtn = document.getElementById("save-btn");
const inputs = document.querySelectorAll(".basic-content input, .basic-content select");

editBtn.addEventListener("click", () => {
  inputs.forEach(el => {
    el.removeAttribute("readonly");
    el.removeAttribute("disabled");
    el.style.pointerEvents = "auto";
    el.style.backgroundColor = "white";
  });
  saveBtn.removeAttribute("disabled");
});

saveBtn.addEventListener("click", () => {
  inputs.forEach(el => {
    el.setAttribute("readonly", true);
    if (el.tagName === "SELECT") {
      el.setAttribute("disabled", true);
    }
    el.style.pointerEvents = "none";
    el.style.backgroundColor = "#f0f0f0";
  });
  saveBtn.setAttribute("disabled", true);
});




