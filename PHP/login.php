<?php
    session_start(); // Start a new or resume the existing session
    if (isset($_SESSION["logged_in"])){ // Check if the "logged_in" session variable is set
        header("Location: portfolio_creator_nosave.php"); // Redirect to portfolio_creator_nosave.php if the user is logged in
    }
?>

<!-- This php document creates a login page with a form for user authentication and checks the information with what is stored on a users table wtihin a database-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Links a CSS stylesheet to reset the page located in a 'CSS' folder, using '../' to navigate up one level up from the current directory -->
    <link rel="stylesheet" href="../CSS/reset.css">
    <!-- Links a CSS stylesheet to style the page located in a 'CSS' folder, using '../' to navigate up one level up from the current directory -->
    <link rel="stylesheet" href="../CSS/login.css">

    <!-- The <title> tag sets the name of the webpage seen on the tab in a web browser -->
    <title>Portfolio Creator - Login</title>

</head>

<!-- The <body> tag contains all the contents of the HTML document -->
<body>

    <!-- The <hgroup> tag is used to group header elements -->
    <hgroup>
        <!-- The <h1> tag defines the main heading of the document -->
        <h1>Login</h1>     
    </hgroup>

    <!-- The <section> tag defines a section in a document -->
    <section>
        <!-- The <p> tag represents a paragraph of text -->
        <p>
            Please enter your details in order to proceed further
        </p>
    </section>

    <!-- The <aside> tag defines a portion of the document which is indirectly related to the document's main content -->
    <aside>
        <!-- The <form> tag is used to create an HTML form for user input -->
        <!-- POST method is for sending user data-->
        <!-- Form has been linked with the login.php file-->    
        <form action="login.php" method="post">
            <!-- The <fieldset> tag is used to group related elements in a form -->
            <fieldset>
                    <?php
                    if(isset($_POST["login"])){ // Check if login form was submitted
                        $email = $_POST["email"]; // Retrieve email from form
                        $password = $_POST["password"]; // Retrieve password from form

                            require_once "database.php"; // Include database connection file

                            $sql = "SELECT * FROM users WHERE email = '$email'"; // Prepare SQL to fetch user by email
                            $result = mysqli_query($database_connection, $sql); // Execute the query
                            $user = mysqli_fetch_array($result, MYSQLI_ASSOC); // Fetch the user's data

                            if ($user){ // Check if user exists
                                if(password_verify($password, $user["password"])){ // Verify password
                                    session_start(); // Start a new session
                                    $_SESSION["logged_in"] = "yes"; // Set session variable for checking if the user is logged in
                                    $_SESSION["user_id"] = $user["user_id"]; // Set session variable to store user_id
                                    header("Location: portfolio_creator.php"); // Redirect to portfolio creator page
                                    exit(); // Terminate script execution
                                }
                                else{
                                    echo "Password is not correct"; // Display error message for incorrect password
                                }
                            }
                            else{
                                echo "Email does not exist"; // Display error message for non-existent email
                            }
                    }
                    ?>

                    <!-- The <p> tags here are used to group each label-input pair -->
                    <p class="email">
                        <!-- The <label> tag defines a label for an <input> element -->
                        <!-- User will input their email address here -->   
                        <label for="email">Email Address</label>
                        <br> <!-- The <br> tag is a break which creates a new line -->
                        <!-- The <input> tag specifies an input field where the user can enter data, type="email" is for email addresses -->
                        <input type="email" name="email" required>
                    </p>

                    <!-- The <p> tags here are used to group each label-input pair -->
                    <p class="password">
                        <!-- The <label> tag defines a label for an <input> element -->
                        <!-- User will input their password here, which must meet specified criteria -->
                        <label for="password">Password</label>
                        <br> <!-- The <br> tag is a break which creates a new line -->
                        <!-- type="password" is for password fields, hiding the input text -->
                        <!-- The pattern attribute specifies a regex for the password validation -->
                        <!-- The password must be between 10-15 characters, include at least one number, one uppercase letter, and one special character -->
                        <input type="password" name="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{10,15}" title="Password must be between 10-15 characters and include at least one number, one uppercase letter, and one special character.">
                    </p>

                    <!-- The <p> tags here are used to group each label-input pair -->
                    <p class="button">
                        <!-- The <button> tag represents a clickable button -->
                        <!-- Submission button for the form -->
                        <button type="submit" value="Login" name="login">Login</button>
                    </p>
            </fieldset>
        </form>
    </aside>

    <!-- The <footer> tag defines the footer section of the document -->
    <footer>
        <!-- Provides a link to the registration page for new users -->
        <a href="register.php">Register Account</a>
    </footer>

</body>
<!-- The closing </html> tag signifies the end of the HTML document -->
</html>
