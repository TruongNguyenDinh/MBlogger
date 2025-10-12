<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<form id="newsForm">
  <div class="recuit-container">
    <div class="re-left">
      <div class="re-header">
        <div class="re-header_left">
          <div class="re-raw active" id="tab-raw">raw</div>
          <div class="re-preview" id="tab-preview">preview</div>
        </div>
        <div class="re-header_right">
          Text | Markdown
        </div>
      </div>
      <div class="re-content">
        <textarea name="title" id="re-title" placeholder="Write your news headline here ... "></textarea>
        <textarea name="content" id="re-content" placeholder="Write your content here ... "></textarea>
        <div id="previewBox"></div>
      </div>
    </div>

    <div class="re-right">
      <div class="re-right_top">
        <div class="re-title-mode">Edit</div>
        <div class="re-add-banner" id="bannerBox" onclick="document.getElementById('bannerInput').click()">
          + Add banner
        </div>
        <input type="file" name="banner" id="bannerInput" accept="image/*" style="display:none">

        <div class="topicInput">
          <input type="text" name="topic" id="topicInput" placeholder="topic...">
        </div>
        <div class="re-add-topic"></div>
      </div>
      <div class="re-right_bottom">
        <button id="postBtn">POST</button>
      </div>
    </div>
  </div>
</form>
