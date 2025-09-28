<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../../assets/css/profilepage.css">
</head>
<body>
    <header>
        <?php include('../header/header.html') ?>
    </header>
    <main>
        <div class="pro-container">
            <div class="pro-left-side">
                <div class="pro-profile_user">
                    <div class="pro-avt">
                        <img src="../../assets/imgs/avt.jpg" alt="User's avatar">
                    </div>
                    <div class="pro-detail-user">
                        <div class="pro-row">
                            <span class="label">Name:</span>
                            <span class="value">Nguyen Dinh Truong</span>
                        </div>
                        <div class="pro-row">
                            <span class="label">Birthday:</span>
                            <span class="value">01/01/2000</span>
                        </div>
                        <div class="pro-row">
                            <span class="label">Address:</span>
                            <span class="value">Hong Chau, Hai Phong, Hanoi, Vietnam</span>
                        </div>
                        <div class="pro-row">
                            <span class="label">Work:</span>
                            <span class="value">Software Engineer</span>
                        </div>
                        <div class="pro-row">
                            <span class="label">Email:</span>
                            <span class="value">truong@example.com</span>
                        </div>
                        <div class="pro-row">
                            <span class="label">Phone:</span>
                            <span class="value">+84 123 456 789</span>
                        </div>
                    </div>

                </div>
                <div class="pro-github-profile">
                    <div class="pro-row">
                            <span class="label ">Github:</span>
                            <span class="value gitname"><a href="#">Nguyen Dinh Truong</a></span>
                    </div>
                    <div class="pro-row">
                        <span class="label">Repo:</span>
                        <span class="value">10</span>
                    </div>
                    <div class="pro-row">
                        <span class="label">Star:</span>
                        <span class="value">5</span>
                    </div>
                    <div class="pro-row">
                        <span class="label">Activity:</span>
                        <span class="value">Regular</span>
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
                <div class="pro-editBtn">Edit</div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="../../assets/js/profile.js"></script>
</body>
</html>