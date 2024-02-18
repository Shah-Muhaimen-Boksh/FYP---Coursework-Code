<?php
    session_start();
    if (!isset($_SESSION["user"])){
        header("Location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../CSS/reset.css">
    <link rel="stylesheet" href="../CSS/portfolio_creator.css">

    <title>Portfolio Creator Page</title>
</head>
<body>
    <header>
        <div>
            <h1>Portfolio Creator Page - (User Email)</h1>
        </div>

        <div class="navbar">
            <nav>
                <ul>
                    <li><a href="portfolio_creator.php">Creator Page</a></li>
                    <li><a href="portfolio_viewer.php">Viewing Page</a></li>
                    <li><a href="blog.php">Blog Page</a></li>
                    <li><a href="contact.php">Contact Page</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>

        <div class="toolbar">
            <nav>
                <ul>
                    <li><a>Insert Textbox</a></li>
                    <li><a>Insert Image</a></li>
                    <li><a>Insert Video</a></li>
                    <li><a>Placeholder</a></li>
                    <li><a>Placeholder</a></li>
                    <li><a>Save</a></li>
                </ul>
            </nav>
        <div>
    </header>


</body>
</html>