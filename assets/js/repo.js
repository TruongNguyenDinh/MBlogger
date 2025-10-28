let currentPath = "User >> Reference";
let repoName = "";
const branchSelect = document.getElementById("branch-select");
const folderTree = document.getElementById("repo-folder-tree");
const dynamicPath = document.querySelector(".dynamic-path");
const showContent = document.querySelector(".repo-show-content");

let selectedRepoData = null; // dữ liệu tạm cho POST


const branchBox = document.querySelector(".repo-folder-branch");

// Lưu URL ban đầu để khi đóng popup có thể trả về
let originalUrl = window.location.origin + window.location.pathname; // luôn là URL gốc

let repoOwner = "";
let GITHUB_TOKEN = "";
let linkgithub = "";
fetch("../../api/get_github_info.php")
  .then(res => {
    return res.text(); // Debug
  })
  .then(txt => {
    try {
      const data = JSON.parse(txt);
      repoOwner = data.username;
      GITHUB_TOKEN = data.token;
      linkgithub = data.link_github;
      
      //  Gán vào thẻ <a> trong nút
      const githubLink = document.querySelector(".openGithub-btn a");
      if (githubLink && linkgithub) {
        githubLink.href = linkgithub;
        githubLink.target = "_blank"; // (tùy chọn) mở trong tab mới
      }

    } catch (err) {
      console.error("❌ JSON parse error:", err);
    }
  })
  .catch(err => console.error("🚫 Fetch error:", err));


function loadBranches(repo) {
    branchSelect.innerHTML = `<option>Loading...</option>`;

    fetch(`https://api.github.com/repos/${repoOwner}/${repo}/branches`, {
      headers: {
        "User-Agent": "Mblogger-App",
        "Authorization": `token ${GITHUB_TOKEN}`
      }
    })

    .then(res => res.json())
    .then(data => {
        branchSelect.innerHTML = "";
        data.forEach(branch => {
            const opt = document.createElement("option");
            opt.value = branch.name;
            opt.textContent = branch.name;
            branchSelect.appendChild(opt);
        });
    })
    .catch(err => {
        branchSelect.innerHTML = `<option>Error loading branch</option>`;
    });
}


// Load toàn bộ tree
async function loadTree(branch) {
  folderTree.innerHTML = "Loading...";
  showContent.innerHTML = "Loading README.md...";

  const res = await fetch(
    `https://api.github.com/repos/${repoOwner}/${repoName}/git/trees/${branch}?recursive=1`,
    {
      headers: {
        "Authorization": `token ${GITHUB_TOKEN}`,
        "Accept": "application/vnd.github.v3+json",
        "User-Agent": "JS Fetch"
      }
    }
  );

  const data = await res.json();

  if (!data.tree) {
    showContent.textContent = "Failed to load directory tree.";
    return;
  }

  const tree = data.tree;

  //  Xây cây thư mục
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

  // Kiểm tra README.md
  const readme = tree.find(f => f.path.toLowerCase() === "readme.md");

  if (readme) {
    //  Gán link README vào selectedRepoData để JS post đi
    selectedRepoData.readmeUrl = `https://github.com/${repoOwner}/${repoName}/blob/${branch}/${readme.path}`;
    console.log("FOUND README:", selectedRepoData.readmeUrl);
    //  Cập nhật nhánh trong cells (ô thứ 3 hoặc 4 tuỳ cấu trúc)
  if (selectedRepoData.cells && selectedRepoData.cells.length >= 4) {
    // cells[3] là nhánh theo như bạn log ở trên
    selectedRepoData.cells[3] = branch;
  }

  //  Cập nhật lại readmePath cho đúng nhánh
  selectedRepoData.readmePath = `https://github.com/${repoOwner}/${repoName}/blob/${branch}/README.md`;

    //  Gán nhánh (để POST về backend nếu cần)
    selectedRepoData.branch = branch;

    // Hiển thị README nội dung lên màn hình
    loadFile(branch, "README.md");
  } else {
    selectedRepoData.readmeUrl = null;
    showContent.innerHTML = "No README.md found.";
  }
  // ✅ Cập nhật giao diện hiển thị nhánh hiện tại
  const branchContainer = document.querySelector(".repo-folder-default");
  if (branchContainer) {
    branchContainer.innerHTML = `
      <div class="branch-select">
        <span>🌿 Branch:</span>
        <strong>None</strong>
      </div>
    `;
  }

  // Cập nhật biến lưu nhánh hiện tại (nếu có)
  selectedRepoData.branch = branch;

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
    `https://api.github.com/repos/${repoOwner}/${repoName}/contents/${path}?ref=${branch}`,
    {
      headers: {
        "Authorization": `token ${GITHUB_TOKEN}`,
        "Accept": "application/vnd.github.v3+json",
        "User-Agent": "JS Fetch"
      }
    }
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
      showContent.style.whiteSpace = "normal";
      showContent.innerHTML = marked.parse(content);
    } else {
      showContent.textContent = content;
      showContent.style.whiteSpace = "pre-wrap";
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
const repoRows = document.querySelectorAll(".repo-table tbody tr");

repoRows.forEach(row => {
  row.addEventListener("click", () => {
    // Lưu toàn bộ data-attribute và cell text
    selectedRepoData = {
      repoID: row.dataset.repoid,
      repoName: row.dataset.repo,
      branch: row.dataset.branch || branchSelect.value,
      cells: Array.from(row.querySelectorAll('td')).map(td => td.innerText)
    };
    
    // Ẩn bảng repo 
    document.querySelector(".repo-show-repo").style.display = "none";
    document.querySelector(".repo-folder-default").style.display = "none";

    // Hiện các phần khác
    document.getElementById("post-btn").style.display = "block";
    document.querySelector(".repo-show-content").style.display = "block";
    document.getElementById("repo-folder-tree").style.display = "block";
    document.querySelector(".repo-folder-branch").style.display = "block";
    document.querySelector(".repo-folder-tree_none").style.display = "none";

    // Lấy tên repo và nhánh từ data của dòng đó
    repoName = row.dataset.repo;
    const branch = row.dataset.branch || branchSelect.value;

    // Gọi lại loadTree() cho repo vừa chọn
    loadTree(branch);
    // Tải danh sách nhánh
    loadBranches(repoName);

    // Cập nhật dynamic path
    dynamicPath.textContent = `${repoOwner} >> ${repoName}`;
    // Cập nhật query repoID trên URL mà không reload trang
    const repoId = row.dataset.repoid;
    const newUrl = new URL(window.location);
    newUrl.searchParams.set("repoID", repoId);
    window.history.replaceState({}, "", newUrl);
    // Hiện nút back
    backBtn.style.display = "inline-block";
  });
});
//Tạo query
//----------------------- Mở repo tự động nếu có query -----------------------
function getQueryParam(param) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(param);
}

function openRepoById(repoId) {
  const targetRow = Array.from(repoRows).find(row => row.dataset.repoid === repoId);
  if (!targetRow) return;

  // Giống như hành động click vào row
  targetRow.click();
}

// Khi load trang, kiểm tra query ?repoID
window.addEventListener("DOMContentLoaded", () => {
  const repoId = getQueryParam("repoID");
  if (repoId) {
    // Đợi DOM sẵn sàng (phòng trường hợp PHP include load hơi chậm)
    setTimeout(() => {
      openRepoById(repoId);
    }, 500);
  }
});


// Xử lý Back
backBtn.addEventListener("click", () => {
  // Trả URL về ban đầu
    window.history.pushState({}, '', originalUrl);
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
