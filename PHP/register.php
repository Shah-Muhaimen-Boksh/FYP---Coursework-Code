<?php
    session_start();
    if (isset($_SESSION["user"])){
        header("Location: portfolio_creator.php");
    }
?>

<!-- This HTML document creates a register page with a form to store user login information -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Links a CSS stylesheet to reset the page located in a 'CSS' folder, using '../' to navigate up one level up from the current directory -->
    <link rel="stylesheet" href="../CSS/reset.css">
    <!-- Links a CSS stylesheet to style the page located in a 'CSS' folder, using '../' to navigate up one level up from the current directory -->
    <link rel="stylesheet" href="../CSS/register.css">

    <!-- The <title> tag sets the name of the webpage seen on the tab in a web browser -->
    <title>Portfolio Creator - Register</title>

</head>

<!-- The <body> tag contains all the contents of the HTML document -->
<body>

    <!-- The <hgroup> tag is used to group header elements -->
    <hgroup>
        <!-- The <h1> tag defines the main heading of the document. -->
        <h1>Register</h1>
    </hgroup>

    <!-- The <section> tag defines a section in a document -->
    <section>
        <!-- The <p> tag represents a paragraph of text -->
        <p>
            Please fill in the form in order to create an account
        </p>
    </section>

    <!-- The <aside> tag defines a portion of the document which is indirectly related to the document's main content -->
    <aside>
        <!-- The <form> tag is used to create an HTML form for user input -->
        <!-- POST method is for sending user data-->
        <!-- Form has been linked with the login.php file-->   
        <form action="register.php" method="post">
            <!-- The <fieldset> tag is used to group related elements in a form -->
            <fieldset>
                    <?php

                    if(isset($_POST["submit"])){
                        $email = $_POST["email"];
                        $password = $_POST["password"];
                        $confirm_password = $_POST["confirm_password"];

                        $password_hash = password_hash($password, PASSWORD_DEFAULT);

                        $errors = array();

                        if  (empty($email) OR empty($password) OR empty($confirm_password)){
                            array_push($errors, "All fields are required");
                        }

                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                            array_push($errors, "Email is not valid");
                        }

                        if (strlen($password) < 10 OR strlen($password) > 15){
                            array_push($errors, "Password must be between 10-15 characters long");
                        }

                        if($password !== $confirm_password){
                            array_push($errors, "Passwords do not match");
                        }

                        require_once "database.php";

                        $sql = "SELECT * FROM users WHERE email = '$email'";
                        $result = mysqli_query($database_connection, $sql);
                        $row_count = mysqli_num_rows($result);
                        if($row_count > 0){
                            array_push($errors, "Email already exists");
                        }

                        if (count($errors) > 0){
                            foreach($errors as $error){
                                echo $error;
                            }
                        }
                        else{
                            $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
                            $stmt = mysqli_stmt_init($database_connection);
                            $prepare_stmt = mysqli_stmt_prepare($stmt, $sql);
                            if ($prepare_stmt){
                                mysqli_stmt_bind_param($stmt, "ss", $email, $password_hash);
                                mysqli_stmt_execute($stmt);
                                echo "Account Successfully Registered";
                            }
                            else{
                                die("Something went wrong");
                            }
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
                        <input type="email" name="email">
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
                        <p class="confirm_password">
                            <!-- The <label> tag defines a label for an <input> element -->
                            <!-- User will input their password here again to confirm the password, which must meet specified criteria -->    
                            <label for="confirm_password">Confirm Password</label>
                            <br> <!-- The <br> tag is a break which creates a new line -->
                            <!-- type="password" is for password fields, hiding the input text -->
                            <!-- The pattern attribute specifies a regex for the password validation -->
                            <!-- The password must be between 10-15 characters, include at least one number, one uppercase letter, and one special character -->
                            <input type="password" name="confirm_password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{10,15}" title="Password must be between 10-15 characters and include at least one number, one uppercase letter, and one special character.">
                        </p>

                    <!-- The <p> tags here are used to group each label-input pair -->
                    <p class="button">
                        <!-- Submission button for the form -->
                        <!-- The <button> tag represents a clickable button -->
                        <button type="submit" name="submit">Register</button>
                    </p>
            </fieldset>
        </form>
    </aside>

    <!-- The <footer> tag defines the footer section of the document -->
    <footer>
        <!-- The <footer> tag defines the footer section of the document -->
        <a href="login.php">Login</a>
    </footer>

</body>
<!-- The closing </html> tag signifies the end of the HTML document -->
</html>
