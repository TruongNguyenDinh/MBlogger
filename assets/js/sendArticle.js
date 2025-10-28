document.getElementById('post-post-btn').addEventListener('click', () => {
  // 🔹 Kiểm tra repo đã chọn
  console.log("selectedRepoData =", selectedRepoData);

  //  Lấy ghi chú (note)
  const noteEl = document.querySelector('.pre-note-write textarea');
  const note = noteEl ? noteEl.value.trim() : '';
  console.log("NOTE VALUE:", note);

  //  Lấy topic
  const topicInputEl = document.querySelector('.pre-topic-input input');
  const topicInput = topicInputEl ? topicInputEl.value.trim() : '';
  const topics = topicInput ? topicInput.split(',').map(t => t.trim()) : [];
  console.log("TOPIC INPUT:", topicInput);
  console.log("TOPICS ARRAY:", topics);

  //  Kiểm tra checkbox "Use README"
  const isUseReadme = document.getElementById('isused').checked;
  console.log("USE README:", isUseReadme);

  //  Lấy nội dung hoặc đường dẫn README
  let mainContent = '';
  let readmePath = null;

  if (isUseReadme) {
    // Nếu chọn README
    readmePath = selectedRepoData.readmeUrl || '(README not found)';
  } else {
    const contentEl = document.querySelector('#custom-content textarea');
    mainContent = contentEl ? contentEl.value.trim() : '';
  }

  console.log("README PATH:", readmePath);
  console.log("MAIN CONTENT:", mainContent);

  //  Gom dữ liệu
  const postData = {
    ...selectedRepoData,
    note,
    topics,
    useReadme: isUseReadme,
    readmePath,
    content: mainContent
  };

  console.log("FINAL POST DATA:", postData);

  //  Gửi đến PHP
  fetch('../../api/post_repo.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(postData)
  })
  .then(async res => {
  const text = await res.text();
  console.log("🧾 RAW RESPONSE TỪ SERVER:", text);

  try {
    const json = JSON.parse(text);
    return json;
  } catch (e) {
    throw e;
  }
})

  .then(data => {
    if (data.status === 'success') {
      alert("✅ Đã POST repo " + selectedRepoData.repoName);
    } else {
      alert("❌ Lỗi: " + data.message);
    }
  })
  .catch(err => {
    console.error("FETCH ERROR:", err);
  });
  const postCard = document.getElementById('show-post-repo-card');
  postCard.style.display = 'none';
});
