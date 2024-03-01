<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/reset.css">
    <link rel="stylesheet" href="../CSS/blog_post_creator.css">

    <title>Blog Post Creator Page</title>
</head>
<body>
    <header>
        <div>
            <h1>Blog Post Creator Page</h1>
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
    </header>

     <!-- The <aside> tag defines a portion of the document which is indirectly related to the document's main content -->
        <aside class="form-container">
            <!-- The <form> tag is used to create an HTML form for user input -->
            <!-- POST method is for sending user data-->
            <!-- Form has been linked with the blog_post_creator.php file--> 
            <form method="POST" action="blog_post_creator.php">
                <!-- The <fieldset> tag is used to group related elements in a form -->
                <fieldset>
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