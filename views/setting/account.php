<link rel="stylesheet" href="../../assets/css/settingelem.css">

<div class="account-container">
    <div class="top-side">
        <div class="show-id">ID: <?= htmlspecialchars($user->getId()) ?></div>
    </div>
    <div class="avatar-container">
        <img src="<?= htmlspecialchars($user->getAvatar()) ?>" alt="user-avt" id="userAvatar">
        <div class="change-avt" id="changeAvtBtn">Change Avatar</div>
        <input type="file" id="avatarInput" accept="image/*" style="display: none;">
    </div>

    <div class="basic-content">
        <form id="account-form" method="POST">
            <div class="row-content">
            <div class="left-input">
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname"
                    value="<?= htmlspecialchars($user->getName()) ?>">
            </div>
            <div class="right-input">
                <label for="birthday">Birthday</label>
                <input type="date" id="birthday" name="birthday" 
                    value="<?= htmlspecialchars($user->getBirthday() ?? '') ?>">
            </div>
            </div>

            <div class="row-content">
            <div class="left-input">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                    value="<?= htmlspecialchars($user->getEmail()) ?>">
            </div>
            <div class="right-input">
                <label for="work">Work</label>
                <input type="text" id="work" name="work"
                    value="<?= htmlspecialchars($user->getWork() ?? 'N/A') ?>">
            </div>
            </div>

            <div class="row-content">
                <div class="left-input">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone"
                        value="<?= htmlspecialchars($user->getPhone() ?? 'N/A') ?>">
                </div>
                <div class="right-input">
                    <div class="role-select">
                        <label for="roleInput">Role</label>
                        <input type="text" id="roleInput" name="role" 
                                value="<?= htmlspecialchars($user->getRole()) ?>" readonly>
                        <div class="role-options" id="roleOptions">
                            <div data-value="person">person</div>
                            <div data-value="company">company</div>
                            <div data-value="employer">employer</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row-content">
            <div class="left-input">
                <label for="address">Address</label>
                <input type="text" id="address"  name="address"
                    value="<?= htmlspecialchars($user->getAddress() ?? 'N/A') ?>">
            </div>
            </div>
            <div class="group-btns">
                <button id="edit-btn" type="button">Edit</button>
                <button id="save-btn" type="submit">Save</button>
            </div>
        </form>
     </div>

    
    <div class="adv-btn" id="adv-btn1">Advantage >></div>
    <div class="adv-btn" id="adv-btn2" style="display: none;">Less <<</div>
    <div class="adv-content" id="adv-content" style="display:none;">
        <div class="row-content">
            <div class="left-input" style="cursor: pointer;text-align: center;">
               Change password
            </div>
    </div>    
</div>

