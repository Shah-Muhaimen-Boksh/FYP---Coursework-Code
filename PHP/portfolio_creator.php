<?php
    session_start(); // Start a new or resume the existing session
    if (!isset($_SESSION["user"])){ // Check if the "user" session variable is not set
        header("Location: login.php"); // Redirect to login page if the user is not logged in
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
    <link rel="stylesheet" href="../CSS/portfolio_creator.css">

    <!-- Page title, what shows in the tabs -->
    <title>Portfolio Creator Page</title>
</head>
<body>
    <header>
        <div>
            <!-- Page header -->
            <h1>Portfolio Creator Page</h1>
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

         <!-- Toolbar for portfolio creation -->
        <div class="toolbar">
            <nav>
                <ul>
                    <!-- Option to insert a textbox -->
                    <li><a>Insert Textbox</a></li>
                    <!-- Option to insert an image -->
                    <li><a>Insert Image</a></li>
                    <!-- Option to insert a video -->
                    <li><a>Insert Video</a></li>
                    <!-- Option to save the current work -->
                    <li><a>Save</a></li> 
                </ul>
            </nav>
        <div>
    </header>


</body>
</html>