let currentPath = "User >> Reference";
const repoOwner = "TruongNguyenDinh";
const repoName = "MBlogger";

const branchSelect = document.getElementById("branch-select");
const folderTree = document.getElementById("repo-folder-tree");
const dynamicPath = document.querySelector(".dynamic-path");
const showContent = document.querySelector(".repo-show-content");

// Load toàn bộ tree
async function loadTree(branch) {
  folderTree.innerHTML = "Loading...";
  showContent.innerHTML = "Loading README.md...";

  const res = await fetch(
    `https://api.github.com/repos/${repoOwner}/${repoName}/git/trees/${branch}?recursive=1`
  );
  const data = await res.json();
  const tree = data.tree;

  // Tạo root object
  const root = {};
  tree.forEach(item => {
    const parts = item.path.split("/");
    let current = root;
    parts.forEach((part, i) => {
      if (!current[part]) {
        current[part] = { __children: {}, __isFile: false, __path: item.path };
      }
      if (i === parts.length - 1 && item.type === "blob") {
        current[part].__isFile = true;
      }
      current = current[part].__children;
    });
  });

  folderTree.innerHTML = "";
  folderTree.appendChild(renderTree(root, branch));

  // Hiển thị README mặc định nếu có
  const readme = tree.find(f => f.path.toLowerCase() === "readme.md");
  if (readme) {
    loadFile(branch, "README.md");
  } else {
    showContent.innerHTML = "No README.md found.";
  }
}

// Render cây thư mục
function renderTree(obj, branch, parentPath = "") {
  const ul = document.createElement("ul");

  for (const key in obj) {
    const node = obj[key];
    const li = document.createElement("li");

    if (node.__isFile) {
      li.classList.add("file");
      li.innerHTML = `📄 ${key}`;
      li.addEventListener("click", () => {
        loadFile(branch, parentPath ? `${parentPath}/${key}` : key);
      });
    } else {
      li.classList.add("folder");

      const span = document.createElement("span");
      span.innerHTML = `📂 ${key}`;
      span.classList.add("folder-name");

      const childUl = renderTree(node.__children, branch, parentPath ? `${parentPath}/${key}` : key);
      childUl.style.display = "none";

      span.addEventListener("click", () => {
        const isOpen = childUl.style.display === "block";
        childUl.style.display = isOpen ? "none" : "block";
        span.innerHTML = `${isOpen ? "📂" : "📁"} ${key}`;
      });

      li.appendChild(span);
      li.appendChild(childUl);
    }

    ul.appendChild(li);
  }

  return ul;
}

// Load nội dung file
async function loadFile(branch, path) {
  currentPath = path;
  dynamicPath.textContent = `${repoOwner} >> ${repoName} >> ${path}`;
  showContent.innerHTML = "Loading...";

  const res = await fetch(
    `https://api.github.com/repos/${repoOwner}/${repoName}/contents/${path}?ref=${branch}`
  );
  const data = await res.json();

  if (data.content) {
    // Nếu là ảnh
    if (/\.(png|jpg|jpeg|gif|svg)$/i.test(path)) {
      const imgUrl = `https://raw.githubusercontent.com/${repoOwner}/${repoName}/${branch}/${path}`;
      showContent.innerHTML = `<img src="${imgUrl}" alt="${path}" style="max-width:100%;height:auto;">`;
      return;
    }

    // Decode chuẩn UTF-8
    const binary = atob(data.content);
    const bytes = new Uint8Array(binary.length);
    for (let i = 0; i < binary.length; i++) {
      bytes[i] = binary.charCodeAt(i);
    }
    const content = new TextDecoder("utf-8").decode(bytes);

    if (path.toLowerCase().endsWith(".md")) {
      showContent.innerHTML = marked.parse(content);
    } else {
      showContent.textContent = content;
    }
  } else {
    showContent.textContent = "Unable to load file.";
  }
}



branchSelect.addEventListener("change", (e) => {
  loadTree(e.target.value);
});

// Load branch mặc định
loadTree(branchSelect.value);

//----------------------- Chọn repo -----------------------
const backBtn = document.querySelector(".back-btn");

document.querySelectorAll(".repo-table tbody tr").forEach(row => {
    row.addEventListener("click", () => {
        // Ẩn bảng repo 
        document.querySelector(".repo-show-repo").style.display = "none";
        document.querySelector(".repo-folder-default").style.display = "none";

        // Hiện các phần khác
        document.getElementById("post-btn").style.display ="block";
        document.querySelector(".repo-show-content").style.display = "block";
        document.getElementById("repo-folder-tree").style.display = "block";
        document.querySelector(".repo-folder-branch").style.display = "block";
        document.querySelector(".repo-folder-tree_none").style.display = "none";

        // Cập nhật dynamic path
        const repoName = row.querySelector("td:first-child").textContent.trim();
        dynamicPath.textContent = `${repoOwner} >> ${repoName} >> ${currentPath}`;

        // Hiện nút back
        backBtn.style.display = "inline-block";
    });
});

// Xử lý Back
backBtn.addEventListener("click", () => {
    // Ẩn phần repo details
    document.getElementById("post-btn").style.display ="none";
    document.querySelector(".repo-show-content").style.display = "none";
    document.getElementById("repo-folder-tree").style.display = "none";
    document.querySelector(".repo-folder-branch").style.display = "none";

    // Hiện lại bảng repo
    document.querySelector(".repo-show-repo").style.display = "block";
    document.querySelector(".repo-folder-tree_none").style.display = "flex";
    document.querySelector(".repo-folder-default").style.display = "block";
    

    // Ẩn dynamic path
    document.querySelector(".dynamic-path").textContent = "";
    backBtn.style.display = "none";
});

//bật post
document.getElementById('post-btn').addEventListener('click',()=>{
  document.getElementById("show-post-repo-card").style.display="flex";
});

// tắt post
// Chọn nút Cancel
const cancelBtn = document.getElementById('cancel-post-btn');
const postCard = document.getElementById('show-post-repo-card');

cancelBtn.addEventListener('click', () => {
    postCard.style.display = 'none';
});
// Is used readme
const isUsedCheckbox = document.getElementById('isused');
const useReadmeDiv = document.getElementById('use-readme');
const customContentDiv = document.getElementById('custom-content');

function toggleContent() {
    if (isUsedCheckbox.checked) {
        // Nếu chọn Use README → tắt textarea
        useReadmeDiv.style.display = 'block';
        customContentDiv.style.display = 'none';
    } else {
        // Ngược lại → bật textarea
        useReadmeDiv.style.display = 'none';
        customContentDiv.style.display = 'block';
    }
}
// Gọi lần đầu để set đúng trạng thái mặc định
toggleContent();
// Lắng nghe sự kiện thay đổi checkbox
isUsedCheckbox.addEventListener('change', toggleContent);
