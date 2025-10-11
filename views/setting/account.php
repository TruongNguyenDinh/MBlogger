<link rel="stylesheet" href="../../assets/css/settingelem.css">
<div class="account-container">
    <div class="top-side">
        <div class="show-id">ID: <?= htmlspecialchars($user->getId()) ?></div>
    </div>
    <div class="basic-content">
        <div class="row-content">
            <div class="left-input">
               <input type="text" name="" id="fullname" value="Full Name: <?= htmlspecialchars($user->getName()) ?>"> 
            </div>
            <div class="right-input">
                <input type="date" id="birthday" name="birthday" 
                    value="<?= htmlspecialchars($user->getBirthday() ??  '') ?>">
            </div>
        </div>
        <div class="row-content">
            <div class="left-input">
               <input type="email" name="" id="email" value="Email: <?= htmlspecialchars($user->getEmail()) ?>"> 
            </div>
            <div class="right-input">
                <input type="text" name="" id="work" value="Work: <?= htmlspecialchars($user->getWork() ?? 'N/A') ?>">
            </div>
        </div>
        <div class="row-content">
            <div class="left-input">
               <input type="text" name="" id="phone" value="Phone: <?= htmlspecialchars($user->getPhone() ?? 'N/A') ?>"> 
            </div>
            <div class="right-input">
                <select id="who" name="who" required>
                    <option value="" disabled selected hidden>Role: <?= htmlspecialchars($user->getRole()) ?></option>
                    <option value="person">person</option>
                    <option value="company">company</option>
                    <option value="employer">employer</option>
                </select>
            </div>

        </div>
        <div class="row-content">
            <div class="left-input">
               <input type="text" name="" id="address" value="Address: <?= htmlspecialchars($user->getAddress() ?? 'N/A') ?>"> 
            </div>
        </div>
    </div>
    <div class="group-btns">
        <button id="edit-btn">Edit</button>
        <button id="save-btn">Save</button>
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