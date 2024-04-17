<!-- This php document creates a blog post creator page with a form to post blog posts which is stored on a blog_posts table wtihin a database-->

<!-- php code below tracks user sessions -->
<?php
    session_start(); // Start a new or resume the existing session
    if (!isset($_SESSION["logged_in"])){ // Check if the "logged_in" session variable is not set
        header("Location: login.php"); // Redirect to login.php if the user is not logged in
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Links a CSS stylesheet to reset the page located in a 'CSS' folder, using '../' to navigate up one level up from the current directory -->
    <link rel="stylesheet" href="../CSS/reset.css">
    <!-- Links a CSS stylesheet to style the page located in a 'CSS' folder, using '../' to navigate up one level up from the current directory -->
    <link rel="stylesheet" href="../CSS/blog_post_creator.css">

    <!-- The <title> tag sets the name of the webpage seen on the tab in a web browser -->
    <title>Blog Post Creator Page</title>
</head>

<!-- The <body> tag contains all the contents of the HTML document -->
<body>
    <header>
        <div>
            <!-- The <h1> tag defines the main heading of the document. -->
            <h1>Blog Post Creator Page</h1>
        </div>

        <!-- The navbar contains hypelinks to the other pages -->
        <div class="navbar">
            <nav>
                <ul>
                    <!-- Link to the creator page -->
                    <li><a href="portfolio_creator.php">Portfolio Creator Page</a></li>
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
    </header>

     <!-- The <aside> tag defines a portion of the document which is indirectly related to the document's main content -->
        <aside class="form-container">
            <!-- The <form> tag is used to create an HTML form for user input -->
            <!-- POST method is for sending user data-->
            <!-- Form has been linked with the blog_post_creator.php file--> 
            <form method="POST" action="blog_post_creator.php">
                <!-- The <fieldset> tag is used to group related elements in a form -->
                <fieldset>
                <?php
                    if (isset($_POST["post"])){ // Check if contact form was submitted
                        $blog_post_header = $_POST["blog_post_header"]; // Retrieve blog post header from form
                        $blog_post_body = $_POST["blog_post_body"]; // Retrieve blog post body from form
                        $user_id = $_SESSION["user_id"]; // Retrieve user's ID from session
                        $blog_post_date = date('Y-m-d'); // Get the current date of the blog post

                        $errors = array(); // Initialize an array to store potential errors

                        // Check if blog post header is greater than 128 characters
                        if (strlen($blog_post_header) > 128){
                            array_push($errors, "Blog Post header cannot exceed 128 characters"); // Add error message to errors array
                        }
                        // Check if blog post body is greater than 10000 characters
                        if (strlen($blog_post_body) > 10000){
                            array_push($errors, "Blog Post body cannot exceed 10000 characters"); // Add error message to errors array
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
                            $sql = "INSERT INTO blog_posts (user_id, blog_post_header, blog_post_body, blog_post_date) VALUES (?, ?, ?, ?)";
                            $stmt = mysqli_stmt_init($database_connection); // Initialize a statement
                            $prepare_stmt = mysqli_stmt_prepare($stmt, $sql); // Prepare the SQL statement
                            if ($prepare_stmt){
                                mysqli_stmt_bind_param($stmt, "isss", $user_id, $blog_post_header, $blog_post_body, $blog_post_date); // Bind parameters to statement
                                mysqli_stmt_execute($stmt); // Execute statement , safely inserting the data
                                echo "Blog Post Successfully Posted"; // Display success message
                            }
                            else{
                                die("Something went wrong"); // Display error message if statement preparation fails
                            }
                            // Using prepared statements with parameter binding prevents SQL injection by separating SQL logic and data.
                        }
                    }
                    ?>

                    <!-- The <p> tags here are used to group each label-input pair -->
                    <p class="blog_post_header">
                        <!-- The <label> tag defines a label for an <input> element -->
                        <!-- User will input their blog header here -->
                        <label for="blog_post_header">Blog Post Header</label>
                        <br> <!-- The <br> tag is a break which creates a new line -->
                        <!-- The <input> tag specifies an input field where the user can enter data, type="text" is for text -->
                        <input type="text" name="blog_post_header">
                      </p>
                      
                      <!-- The <p> tags here are used to group each label-input pair -->
                      <p class="blog_post_body">
                        <!-- The <label> tag defines a label for an <input> element -->
                        <!-- User will input their blog header here -->
                        <label for="blog_post_body">Blog Post Body</label>
                        <br> <!-- The <br> tag is a break which creates a new line -->
                        <!-- The <input> tag specifies an input field where the user can enter data, type="text" is for text -->
                        <textarea name="blog_post_body"></textarea>
                      </p>
                      
                       <!-- The <p> tags here are used to group each label-input pair -->
                      <p class="button">
                        <!-- Submission button for the form -->
                        <!-- The <button> tag represents a clickable button -->
                        <button type="submit" value="Post" name="post">Post</button>
                      </p> 
                </fieldset>
            </form>
        </aside>


</body>
</html>