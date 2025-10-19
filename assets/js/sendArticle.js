document.getElementById('post-post-btn').addEventListener('click', () => {
  console.log(">>> Bắt đầu gửi repo...");

  // 🔹 Kiểm tra repo đã chọn
  console.log("selectedRepoData =", selectedRepoData);
  if (!selectedRepoData) {
    alert("Chưa chọn repo nào!");
    return;
  }

  // 🔹 1️⃣ Lấy ghi chú (note)
  const noteEl = document.querySelector('.pre-note-write textarea');
  const note = noteEl ? noteEl.value.trim() : '';
  console.log("NOTE VALUE:", note);

  // 🔹 2️⃣ Lấy topic
  const topicInputEl = document.querySelector('.pre-topic-input input');
  const topicInput = topicInputEl ? topicInputEl.value.trim() : '';
  const topics = topicInput ? topicInput.split(',').map(t => t.trim()) : [];
  console.log("TOPIC INPUT:", topicInput);
  console.log("TOPICS ARRAY:", topics);

  // 🔹 3️⃣ Kiểm tra checkbox "Use README"
  const isUseReadme = document.getElementById('isused').checked;
  console.log("USE README:", isUseReadme);

  // 🔹 4️⃣ Lấy nội dung hoặc đường dẫn README
  let mainContent = '';
  let readmePath = null;

  if (isUseReadme) {
    // Nếu chọn README
    readmePath = selectedRepoData.readmeUrl || '(Không tìm thấy README)';
  } else {
    const contentEl = document.querySelector('#custom-content textarea');
    mainContent = contentEl ? contentEl.value.trim() : '';
  }

  console.log("README PATH:", readmePath);
  console.log("MAIN CONTENT:", mainContent);

  // 🔹 5️⃣ Gom dữ liệu
  const postData = {
    ...selectedRepoData,
    note,
    topics,
    useReadme: isUseReadme,
    readmePath,
    content: mainContent
  };

  console.log("FINAL POST DATA:", postData);

  // 🔹 6️⃣ Gửi đến PHP
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
    console.log("✅ PARSED JSON:", json);
    return json;
  } catch (e) {
    console.error("❌ KHÔNG PARSE ĐƯỢC JSON. Server trả HTML hoặc lỗi PHP:", text);
    throw e;
  }
})

  .then(data => {
    console.log("SERVER RESPONSE:", data);
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
