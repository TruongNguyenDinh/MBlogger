<?php
    require_once __DIR__ . "/../../config/auth.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../../assets/css/profilepage.css">
    <?php include('../../controls/profilecontroller.php') ?>
</head>
<body>
    <header>
        <?php include __DIR__ . '/../header/header.php'; ?>
    </header>
    <main>
        <?php include __DIR__ . '/../../notification/flex/notiflex.php'; ?>
        <div class="pro-container">
            <div class="pro-left-side">
                <div class="pro-profile_user">
                    <div class="pro-avt">
                        <img src="<?= htmlspecialchars($user->getUrl()) ?>" alt="User's avatar">
                    </div>
                    <div class="pro-detail-user">
                        <div class="pro-row">
                            <span class="label">Name:</span>
                            <span class="value"><?= htmlspecialchars($user->getName()) ?></span>
                        </div>
                        <div class="pro-row">
                            <span class="label">Birthday:</span>
                            <span class="value"><?= htmlspecialchars($user->getBirthday() ?? 'N/A') ?></span>
                        </div>
                        <div class="pro-row">
                            <span class="label">Address:</span>
                            <span class="value"><?= htmlspecialchars($user->getAddress() ?? 'N/A') ?></span>
                        </div>
                        <div class="pro-row">
                            <span class="label">Work:</span>
                            <span class="value"><?= htmlspecialchars($user->getWork() ?? 'N/A') ?></span>
                        </div>
                        <div class="pro-row">
                            <span class="label">Email:</span>
                            <span class="value"><?= htmlspecialchars($user->getEmail()) ?></span>
                        </div>
                        <div class="pro-row">
                            <span class="label">Phone:</span>
                            <span class="value"><?= htmlspecialchars($user->getPhone() ?? 'N/A') ?></span>
                        </div>
                    </div>

                </div>
                <div class="pro-github-profile">
                    <div class="pro-row">
                            <span class="label ">Github:</span>
                            <span class="value gitname">
                                <a 
                                href="<?= $gitIf ? htmlspecialchars($gitIf->getLink()) : '#' ?>" 
                                target="_blank" 
                                rel="noopener noreferrer"
                                >
                                
                                <?= $gitIf ? htmlspecialchars($gitIf->getGithubUsername()) : 'N/A' ?>
                                </a>

                            </span>
                    </div>
                    <div class="pro-row">
                        <span class="label">Repo:</span>
                        <span class="value" id="repo-count">--</span>
                    </div>
                    <div class="pro-row">
                        <span class="label">Star:</span>
                        <span class="value" id="star-count">--</span>
                    </div>
                </div>
                <div class="pro-link_and_website">
                </div>
            </div>
            <div class="pro-main-side">
                <div class="pro-title-tab">
                    <div class="pro-ref active">User Reference</div>
                    <div class="pro-post">Post</div>
                </div>
                <div class="pro-main-content" id="pro-main-content"></div>
                <div class="pro-main-post" style="display:none;"id="pro-main-post">
                    <?php $articles; include('../components/post-card.php') ?>
                </div>
                <div class="pro-editBtn"> <a href="http://localhost/mblogger/views/setting/setting.php?page=account">Edit</a></div>
            </div>
            <div class="fcpContainer" id="fcpContainer" style="display:none;">
                <?php include("../components/flex-card-post.php")?>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="../../assets/js/profile.js"></script>
    <script src="../../assets/js/popup.js"></script>
    <script src="../../assets/js/renderRM.js"></script>
    <script src="../../assets/js/utilities.js"></script>
</body>
</html>