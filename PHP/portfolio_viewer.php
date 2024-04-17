<!-- This php document is the portfolio viewer page and is supposed to allow othe people to view the users portfolios -->

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
    <!-- Link this page to the CSS reset file -->
    <link rel="stylesheet" href="../CSS/reset.css">
    <!-- Link this page to a CSS styling file -->
    <link rel="stylesheet" href="../CSS/portfolio_viewer.css">

    <title>Portfolio Viewer Page</title>
</head>
<body>
    <header>
        <div>
            <h1>Portfolio Viewer Page </h1>
        </div>
        
        <!-- The navbar contains hypelinks to the other pages -->
        <div class="navbar">
            <nav>
                <ul>
                    <!-- Link to the creator page -->
                    <li><a href="portfolio_creator_nosave.php">Portfolio Creator Page</a></li>
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


</body>
</html>