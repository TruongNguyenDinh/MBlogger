<!-- components/change-pass.php -->
<link rel="stylesheet" href="../../assets/css/changepasss.css">

<div class="cp-overlay" id="cp-popup" style="display: none;">
  <div class="cp-container" onclick="event.stopPropagation()">
    <div class="cp-container_checkpass">
      <h2 class="cp-title">Change Password</h2>

      <div class="elem_row">
        <label>Enter your current password</label>
        <div class="input-wrapper">
          <input id="current-pass" type="password" placeholder="Your current password">
          <span class="toggle-pass" onclick="togglePass('current-pass', this)">👁️</span>
        </div>
      </div>

      <div class="elem_row">
        <label>Enter your new password</label>
        <div class="input-wrapper">
          <input id="new-pass" type="password" placeholder="Your new password">
          <span class="toggle-pass" onclick="togglePass('new-pass', this)">👁️</span>
        </div>
      </div>

      <div class="elem_row">
        <label>Enter your new password again</label>
        <div class="input-wrapper">
          <input id="confirm-pass" type="password" placeholder="Repeat new password">
          <span class="toggle-pass" onclick="togglePass('confirm-pass', this)">👁️</span>
        </div>
      </div>

      <!-- 🔹 Dòng thông báo lỗi/thành công -->
      <div class="cp-line-notice" id="cp-notice"> </div>

      <div class="cp-button-send-data" id="cp-send-btn">Send</div>
      <div class="cp-close" onclick="closePopup()">×</div>
    </div>
  </div>
</div>
