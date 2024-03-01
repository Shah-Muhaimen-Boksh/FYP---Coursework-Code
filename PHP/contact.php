<?php
    session_start(); // Start a new or resume the existing session
    if (!isset($_SESSION["logged_in"])){ // Check if the "logged_in" session variable is not set
        header("Location: login.php"); // Redirect to login.php if the user is not logged in
    }
?>

<!-- This php document creates a contact page with a form to send messages which is stored in a messages table wtihin a database-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Links a CSS stylesheet to reset the page located in a 'CSS' folder, using '../' to navigate up one level up from the current directory -->
    <link rel="stylesheet" href="../CSS/reset.css">
    <!-- Links a CSS stylesheet to style the page located in a 'CSS' folder, using '../' to navigate up one level up from the current directory -->
    <link rel="stylesheet" href="../CSS/contact.css">

    <!-- The <title> tag sets the name of the webpage seen on the tab in a web browser -->
    <title>Contact Page</title>
</head>

<!-- The <body> tag contains all the contents of the HTML document -->
<body>
     <!-- The <header> tag defines the header of the document -->
    <header>
        <div>
            <!-- The <h1> tag defines the main heading of the document -->
            <h1>Contact Page</h1>
        </div>

        <!-- The navbar contains hypelinks to the other pages -->
        <div class="navbar">
            <nav>
                <ul>
                    <!-- Link to the creator page -->
                    <li><a href="portfolio_creator.php">Portfolio Creator Page</a></li>
                    <!-- Link to the viewing page -->
                    <li><a href="portfolio_viewer.php">Portfolio Viewing Page</a></li>
                    <!-- Link to the blog post creator page -->
                    <li><a href="blog_post_creator.php">Blog Post Creator Page</a></li>
                    <!-- Link to the blog post viewer page -->
                    <li><a href="blog_post_viewer.php">Blog Post Viewer Page</a></li>
                    <!-- Link to the contact page -->
                    <li><a href="contact.php">Contact Page</a></li>
                    <!-- Link for logging out -->
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>

    <!-- The <aside> tag defines a portion of the document which is indirectly related to the document's main content -->
        <aside class="form-container">
            <!-- The <form> tag is used to create an HTML form for user input -->
            <!-- POST method is for sending user data-->
            <!-- Form has been linked with the contact.php file-->  
            <form action="contact.php" method = "post">
                <!-- The <fieldset> tag is used to group related elements in a form -->
                <fieldset>
                    <?php
                    if (isset($_POST["send"])){ // Check if contact form was submitted
                        $message_subject = $_POST["message_subject"]; // Retrieve message subject from form
                        $contact_email = $_POST["contact_email"]; // Retrieve contact email from form
                        $message_body = $_POST["message_body"]; // Retrieve message body from form

                        $errors = array(); // Initialize an array to store potential errors

                        // Check if message subject is greater than 128 characters
                        if (strlen($message_subject) > 128){
                            array_push($errors, "Message subject cannot exceed 128 characters"); // Add error message to errors array
                        }
                        // Check if message body is greater than 1000 characters
                        if (strlen($message_body) > 1000){
                            array_push($errors, "Message body cannot exceed 1000 characters"); // Add error message to errors array
                        }
                        

                        // Display errors if any
                        if (count($errors) > 0){
                            // Loop through and display each error
                            foreach($errors as $error){
                                echo $error; // Display each error
                            }
                        }
                        else{
                            // Include database connection file, using prepared statements to counter SQL injections
                            require_once "database.php";
                            // Prepare SQL to insert user message into the table
                            $sql = "INSERT INTO messages (message_subject, contact_email, message_body) VALUES (?, ?, ?)";
                            $stmt = mysqli_stmt_init($database_connection); // Initialize a statement
                            $prepare_stmt = mysqli_stmt_prepare($stmt, $sql); // Prepare the SQL statement
                            if ($prepare_stmt){
                                mysqli_stmt_bind_param($stmt, "sss", $message_subject, $contact_email, $message_body); // Bind parameters to statement
                                mysqli_stmt_execute($stmt); // Execute statement , safely inserting the data
                                echo "Message Successfully Sent"; // Display success message
                            }
                            else{
                                die("Something went wrong"); // Display error message if statement preparation fails
                            }
                            // Using prepared statements with parameter binding prevents SQL injection by separating SQL logic and data.

                        }

                    }
                    ?>

                    <!-- The <p> tags here are used to group each label-input pair -->
                    <p class="message_subject">
                        <!-- The <label> tag defines a label for an <input> element -->
                        <!-- User will input their message subject here -->
                        <label for="message_subject">Message Subject</label>
                        <br> <!-- The <br> tag is a break which creates a new line -->
                        <!-- The <input> tag specifies an input field where the user can enter data, type="text" is for text -->
                        <input type="text" name="message_subject" required>
                      </p>

                      <!-- The <p> tags here are used to group each label-input pair -->
                      <p class="contact_email">
                        <!-- The <label> tag defines a label for an <input> element -->
                        <!-- User will input their email address here -->
                        <label for="contact_email">Contact Email</label>
                        <br> <!-- The <br> tag is a break which creates a new line -->
                        <!-- The <input> tag specifies an input field where the user can enter data, type="email" is for email addresses -->
                        <input type="email" name="contact_email" required>
                      </p>
                      
                      <!-- The <p> tags here are used to group each label-input pair -->
                      <p class="message_body">
                        <!-- The <label> tag defines a label for an <input> element -->
                        <!-- User will input their message subject here -->
                        <label for="message_body">Message Body</label>
                        <br> <!-- The <br> tag is a break which creates a new line -->
                        <!-- The <input> tag specifies an input field where the user can enter data, type="text" is for text -->
                        <textarea name="message_body" required></textarea>
                      </p>
                      
                      <!-- The <p> tags here are used to group each label-input pair -->
                      <p class="button">
                        <!-- Submission button for the form -->
                        <!-- The <button> tag represents a clickable button -->
                        <button type="submit" value="Send" name="send">Send</button>
                      </p> 
                </fieldset>
            </form>
        </aside>


</body>
<!-- The closing </html> tag signifies the end of the HTML document -->
</html>