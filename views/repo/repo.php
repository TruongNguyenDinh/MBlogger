<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repostories</title>
    <link rel="stylesheet" href="../../assets/css/repopage.css">

</head>
<body>
    <header>
        <?php include('../header/header.html')?>
    </header>
    <main>
       <div class="repo-container">
            <div class="repo-folder">
                <div class="repo-folder-branch" style = "display:none;">
                    <!-- select branch -->
                    <select id="branch-select">
                        <option value="main">main</option>
                        <option value="dev">dev</option>
                    </select>
                </div>
                <div class="repo-folder-default">
                    <!-- Branch -->
                     select branch
                </div>
                <div class="repo-folder-tree" id="repo-folder-tree" style = "display:none;"></div>
                <div class="repo-folder-tree_none" id="repo-folder-tree_none">
                    Choose any repostories to watch
                </div>
            </div>
            <div class="repo-show">
                <div class="repo-show_header">
                    <div class="dynamic-path"></div>
                    <div class="header-btns">
                        <div class="back-btn" style="display:none;">⬅ Back</div>
                        <div class="openGithub-btn">Open in Github</div>
                    </div>
                </div>
                <div class="repo-show-content" style="display:none;"></div>
                <div class="repo-show-repo">
                    <table class="repo-table">
                        <thead>
                            <tr>
                                <th>Repo Name</th>
                                <th>Latest Commit</th>
                                <th>Total Star</th>
                                <th>Branch</th>
                                <th>Comments</th>
                                <th>ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php include '../../controls/RepoController.php'; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="post-btns" id="post-btn" style="display:none;">POST</div>
            <div id="show-post-repo-card" style="display:none;">
                <?php include('../components/post-repo.php') ?>
            </div>
        </div>
    </main>
    <script src="../../assets/js/repo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
</body>
</html>