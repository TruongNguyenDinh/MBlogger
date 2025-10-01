<link rel="stylesheet" href="../../assets/css/settingelem.css">
<div class="account-container">
    <div class="top-side">
        <div class="show-id">ID: xxx</div>
    </div>
    <div class="basic-content">
        <div class="row-content">
            <div class="left-input">
               <input type="text" name="" id="fullname" value="Nguyễn Đình Trường"> 
            </div>
            <div class="right-input">
                <input type="date" name="" id="birthday">
            </div>
        </div>
        <div class="row-content">
            <div class="left-input">
               <input type="email" name="" id="email" value="truong@gmail.com"> 
            </div>
            <div class="right-input">
                <input type="text" name="" id="work" value="Software Engineer">
            </div>
        </div>
        <div class="row-content">
            <div class="left-input">
               <input type="text" name="" id="phone" value="0362361299"> 
            </div>
            <div class="right-input">
                <select id="who" name="who" required>
                    <option value="" disabled selected hidden>---None---</option>
                    <option value="person">person</option>
                    <option value="company">company</option>
                    <option value="employer">employer</option>
                </select>
            </div>

        </div>
        <div class="row-content">
            <div class="left-input">
               <input type="text" name="" id="address" value="Hồng Châu, Hải Phòng, Việt Nam"> 
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