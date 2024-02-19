# FYP---Coursework-Code
All the files related to the actual implementation of my final year project which is the creation of a digital portfolio website with integrated blog features. 

Instructions to run the project:

- Downlaod xampp: https://www.apachefriends.org/
- Run the xampp application, noting the folder location of xampp
- Open xampp use this website if more help is needed: https://phpandmysql.com/extras/installing-xampp/
- Start Apache and MySQL
- Locate the xampp folder 
- Locate the htdocs folder within the xampp folder
- Clone this repositry (https://github.com/Shah-Muhaimen-Boksh/FYP---Coursework-Code.git) to the htdocs folder
- In your browser type the url: http://localhost/FYP---Coursework-Code/
- All folders & files will be viewable in your browser
- You will now be able to use the 
- Use the php version of each file to properly use the project

- when opening php files on a IDE i.e VS code an error message might pop up: 
    "Cannot validate since no PHP executable is set. Use the setting 'php.validate.executablePath' to configure the PHP executable."
    is this occurs follow these steps:
        - locate setting.json
        - paste this line "php.validate.executablePath": "your_drive:/xampp/php/php.exe" at the end of settings.json
        - replace "your_drive" with the name of your drive
        - the error message should be gone now
        - more help can be found in this website: https://dev.to/3rchuss/how-to-set-up-php-executable-path-in-vscode-xampp-user-s-15ag

Project Main Components: 
Register Page - User wil register an account with their email address and a password 
Login Page - User wil login with the same information they registred thier account with
Portfolio Creator Page - Allows the user to create their own digital portfolio using a toolbar with diffrent functions
Portfolio Viewer Page - Allows other people to view the users digital portfolio
Blog Post Creator - Allows the user to post blog posts
Bog Post Viewer - Allows other people to view the users blog posts
Contact Page - Allows the user to send messages to admin for any questions, complaints or suggestions 

If any queries or questions please contact me:
 - email: ec21377@qmul.ac.uk