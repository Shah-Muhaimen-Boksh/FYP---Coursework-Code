# FYP---Coursework-Code
All the files related to the actual implementation of my final year project which is the creation of a digital portfolio website with integrated blog features. 

Setting Up and Running the Project:
Requirements
XAMPP: Download and install XAMPP from here: https://www.apachefriends.org/.

Steps:
1. Start XAMPP:
    - Open the XAMPP application.
    - Start the Apache and MySQL services.
2. Locate XAMPP Folder:
    - Navigate to the folder where XAMPP is installed on your system. Typically, it's located at C:/xampp/.
3. Clone Repository:
    - Clone this project repository (https://github.com/Shah-Muhaimen-Boksh/FYP---Coursework-Code.git) into the htdocs folder within the XAMPP directory.
4. Access Project:
    - Open your web browser and type the following URL: http://localhost/FYP---Coursework-Code/.
    - You should now be able to view all folders and files of the project.
5. Using PHP Files:
    - Ensure to use the PHP version of each file to properly utilize the project's functionalities.
6. IDE Configuration (Optional):
    - If using Visual Studio Code and encountering a PHP executable path error ( "Cannot validate since no PHP executable is set. Use the setting 'php.validate.executablePath' to configure the PHP executable."):
        - Locate the settings.json file.
        - Add the following line at the end: "php.validate.executablePath": "your_drive:/xampp/php/php.exe".
        - Replace "your_drive" with your actual drive name.
        - Save the file. The error message should disappear.
        - more help can be found on this website: https://dev.to/3rchuss/how-to-set-up-php-executable-path-in-vscode-xampp-user-s-15ag

Project Components
1. Register Page:
    - Allows users to register an account with their email address and password.
2. Login Page:
    - Allows users to login with the credentials they registered their account with.
3. Portfolio Creator Page:
    - Enables users to create their digital portfolio using various toolbar functions.
4. Portfolio Viewer Page:
    - Allows others to view the user's digital portfolio.
5. Blog Post Creator:
    - Lets users post blog entries.
6. Blog Post Viewer:
    - Allows others to view the user's blog posts.
7. Contact Page:
    - Enables users to send messages to the admin for questions, complaints, or suggestions.


Contact Information
For any queries or assistance, please reach out via email:
Email: ec21377@qmul.ac.uk