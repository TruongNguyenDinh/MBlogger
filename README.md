# MBlogger

## 1. Setup

### 1.1 Download and Run Project

To run this project, you need [XAMPP](https://www.apachefriends.org/download.html):

1. Install XAMPP and open the `htdocs` folder.

2. Clone this project into `htdocs`:
   
   If you have Git installed:
   git clone https://github.com/TruongNguyenDinh/MBlogger.git
   
   If you don't have Git:
   Download the project as a ZIP from GitHub and extract it into `htdocs`.

3. Open XAMPP and start:
   
   - Apache server
   - MySQL server

4. Open your browser and navigate to:
   http://localhost/mblogger

---

### 1.2 Create Database

1. Open phpMyAdmin:
   http://localhost/phpmyadmin/
2. Create a new database or select an existing one.
3. Go to the SQL tab and paste the SQL file content.
4. Execute to create all tables.

---

### 1.3 Get GitHub OAuth Client & Secret

Follow the video tutorial: https://www.youtube.com/watch?v=mX0xCyQ5GVY

- Application Name: MBlogger  
- Homepage URL: http://localhost/mblogger/views/home/home.php  
- Application Description: Custom description  
- Authorization Callback URL: http://localhost/mblogger/github_callback.php

Finally, paste your GITHUB_CLIENT_ID and GITHUB_CLIENT_SECRET into config.php.

---

### 1.4 Get Email App Password

To send emails (notifications, password reset, etc.), create an App Password for your email:

Gmail:

1. Go to https://myaccount.google.com/security
2. Enable 2-Step Verification if not already enabled.
3. Under "Signing in to Google", select App Passwords.
4. Choose Mail as the app, Other as the device, and name it MBlogger.
5. Click Generate and copy the 16-character password.
6. Paste it as AUTH_PASSWORD in config.php.

Other Email Providers:

- Check account settings for App Password or SMTP password.
- Enable access for less secure apps if required.

---

### 1.5 Configure config.php

define('GITHUB_CLIENT_ID', 'your_client_id_here');
define('GITHUB_CLIENT_SECRET', 'your_client_secret_here');

define('AUTH_EMAIL', 'your_email@example.com');
define('AUTH_PASSWORD', 'your_app_password_here');


---

### 1.6 Run the Project

1. Make sure Apache and MySQL are running.
2. Navigate to: http://localhost/mblogger
3. Test GitHub OAuth login and email features.

---

### 1.7 Troubleshooting

- GitHub OAuth not working? Ensure the Authorization Callback URL matches exactly.  
- Email issues? Check SMTP settings and allow less secure apps if using Gmail.

### 1.8 Contact

- Gmail: truongnd1124@gmail.com  
- Facebook: https://web.facebook.com/ndtruong24

**Note:**  
This is only a practice project, not a complete app. There are many limitations. The structure is not fully optimized and the code may not be perfect.  
If you have suggestions or improvements, please contact me using the information above. Thank you!