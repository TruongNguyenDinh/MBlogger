<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
    <link rel="stylesheet" href="../../assets/css/settingpage.css">
    <?php include('../../controls/profilecontroller.php') ?>
</head>
<body>
    <header>
        <?php include("../header/header.php") ?>
    </header>
    <main>
        <div class="setting-container">
            <div class="setting-left-side">
                <div class="setting-account" data-page="account">Account</div>
                <div class="setting-collab" data-page="colab">Colab to Github</div>
                <div class="setting-link" data-page="link">Link</div>
            </div>

            <div class="setting-main-side">
                <?php
                    $page = $_GET['page'] ?? null;

                    if ($page === null) {
                        header("Location: setting.php?page=account");
                        exit;
                    }

                    if ($page === 'account') {
                        include("./account.php");
                    } elseif ($page === 'colab') {
                        include("./colab.php");
                    } elseif ($page === 'link') {
                        include("./link.php");
                    }
                ?>
            </div>
        </div>
    </main>
    <script>
        document.querySelectorAll(".setting-left-side div").forEach(item => {
            item.addEventListener("click", () => {
                let page = item.getAttribute("data-page");
                window.location.href = "?page=" + page; // đổi URL để PHP xử lý
            });
        });

        // Đặt active theo page hiện tại
        let params = new URLSearchParams(window.location.search);
        let current = params.get("page") || "account";
        document.querySelector(`.setting-left-side [data-page="${current}"]`)
                ?.classList.add("active");
    </script>
    <script src="../../assets/js/setting.js"></script>
</body>
</html>