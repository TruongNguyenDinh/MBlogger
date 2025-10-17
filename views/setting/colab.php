
<link rel="stylesheet" href="../../assets/css/githubpage.css">
<div class="account-container">
    <div class="top-side">
        <div class="show-id">ID: <?= htmlspecialchars($user->getId()) ?></div>
    </div>
    <div class="basic-content">
        <div class="row-content">
            <div class="left-input">
                <button>Github >></button>
                <?php if (!empty($status_git)): ?>
                    <div class="connected active">You connected</div>
                <?php else: ?>
                    <div class="unconnect active">You haven't connected to Github</div>
                <?php endif; ?>
            </div>

        </div>
        <div class="row-content">
            <div class="left-input">
                 <div class="github-info">
                    <label if="gitusername">Github's username</label>
                    <input type="email" name="" id="gitusername" value="NguyenDinhTruong" readonly> 
                 </div>   
            </div>
        </div>
        <div class="row-content">
            <div class="left-input">
               <div class="change-con">
                 Change connection
               </div>
            </div>
        </div>
    </div>
</div>