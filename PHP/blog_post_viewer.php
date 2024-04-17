<!-- This php document creates a blog post viewer page with a table that show the users blog posts -->

<!-- THe php code below tracks user sessions and also retrives the all of the users blog posts form the database -->
<?php
    session_start(); // Start a new or resume the existing session
    if (!isset($_SESSION["logged_in"])){ // Check if the "logged_in" session variable is not set
        header("Location: login.php"); // Redirect to login.php if the user is not logged in
    }

    require_once "database.php"; // Connect to database

    // SQL statement to retrieve blog posts for the logged-in user, ordered by date descending
    $sql = "SELECT blog_post_header, blog_post_body, blog_post_date FROM blog_posts WHERE user_id = ? ORDER BY blog_post_date DESC";
    
    // Prepare the SQL statement for execution to prevent SQL injection
    $stmt = mysqli_prepare($database_connection, $sql);

    // Check if the statement was prepared correctly
    if ($stmt) {
        // Bind the user_id parameter to the prepared statement
        mysqli_stmt_bind_param($stmt, "i", $_SESSION["user_id"]);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Bind the result variables
        mysqli_stmt_bind_result($stmt, $blog_post_header, $blog_post_body, $blog_post_date);

        // Initialize an array to store the fetched blog posts
        $blog_posts = [];
        // Fetch values from the prepared statement into the bound variables for each row
        while (mysqli_stmt_fetch($stmt)) {
            // Append each blog post to the blog_posts array with key-value pairs
            $blog_posts[] = [
                'blog_post_header' => $blog_post_header,
                'blog_post_body' => $blog_post_body,
                'blog_post_date' => $blog_post_date,
            ];
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } 
    else {
        // Display an error message if the SQL statement failed to prepare
        echo "Error preparing statement.";
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
    <!-- Link this page to the CSS styling file -->
    <link rel="stylesheet" href="../CSS/blog_post_viewer.css">

    <!-- The <title> tag sets the name of the webpage seen on the tab in a web browser -->
    <title>Blog Post Viewer Page</title>
</head>

<!-- The <body> tag contains all the contents of the HTML document -->
<body>
    <header>
        <div>
            <!-- The <h1> tag defines the main heading of the document -->
            <h1>Blog Post Viewer Page</h1>
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

    <?php
    // Check if the $blog_posts array is empty
    if (empty($blog_posts)): ?>
        <!-- Display a message if there are no blog posts -->
        <p class = "no_blog_post_message">This user has no blog posts</p>
    <?php
    // If $blog_posts is not empty, execute the else block
    else: ?>
        <!-- Create a table for displaying blog posts -->
        <table class="blog_post_table">
            <!-- Table header -->
            <thead>
                <tr>
                    <!-- Define columns for the blog post header, body, and date -->
                    <th>Blog Post Header</th>
                    <th>Blog Post Body</th>
                    <th>Blog Post Date</th>
                </tr>
            </thead>
            <!-- Table body -->
            <tbody>
                <!-- Loop through each blog post in the $blog_posts array -->
                <?php foreach ($blog_posts as $blog_post): ?>
                    <tr>
                        <!-- Display the blog post header, escaping any special HTML characters to prevent XSS attacks -->
                        <td><?= htmlspecialchars($blog_post['blog_post_header']) ?></td>
                        <!-- Display the blog post body, escaping any special HTML characters to prevent XSS attacks -->
                        <td><?= htmlspecialchars($blog_post['blog_post_body']) ?></td>
                        <!-- Display the blog post date, escaping any special HTML characters to prevent XSS attacks -->
                        <td><?= htmlspecialchars($blog_post['blog_post_date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php
    // End the if-else block
    endif; ?>

</body>
</html>