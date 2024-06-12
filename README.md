# Resume_builder

Description: A web application developed using PHP, HTML, Bootstrap, CSS, and jQuery that allows users to create, edit, delete, and clone resumes. The application includes user authentication, ensuring that only registered users can manage their resumes. Additionally, users can customize their resumes by changing fonts, share them via WhatsApp, and download them in a preferred format.

Features
User Authentication:

Registration Page: Collects full name, email address, and password.

-Login Page: Authenticates users before allowing access to resume management features.
-User Data Storage: Stores registration details in a MySQL database accessible via phpMyAdmin.
-Resume Management (CRUD Operations):

Create: Users can create new resumes with various sections like personal information, education, experience, skills, etc.
Read: Users can view their created resumes.
Update: Users can edit existing resumes to update information.
Delete: Users can delete resumes they no longer need.
Clone: Users can duplicate an existing resume to use it as a template for a new one.
Resume Customization:

Font Customization: Users can change the font style of their resumes.
Download Option: Users can download their resumes in a preferred format (e.g., PDF).
Share Option: Users can share their resumes via WhatsApp directly from the application.
Components
Database:

User Table: Stores user information (full name, email, password).
Resume Table: Stores resume details associated with each user.
Backend (PHP):

Registration Script: Handles user registration and stores data in the database.
Login Script: Authenticates users and starts a session.
CRUD Scripts: Manage create, read, update, delete, and clone operations for resumes.
Frontend:

HTML: Structure of the web pages.
Bootstrap: Styling and layout of the web pages.
CSS: Custom styles for the application.
jQuery: Handles dynamic interactions and AJAX requests.
Pages:

Registration Page: Form to collect user details for registration.
Login Page: Form for user login.
My Resume Page: Interface for managing resumes (create, edit, delete, clone).
Resume View Page: Displays the resume with options for customization, sharing, and downloading.
