<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/reset.css">
    <link rel="stylesheet" href="../CSS/blog.css">

    <title>Blog Page</title>
</head>
<body>
    <header>
        <div>
            <h1>Blog Page - (User Email)</h1>
        </div>
        <div class="navbar">
            <nav>
                <ul>
                    <li><a href="portfolio_creator.php">Creator Page</a></li>
                    <li><a href="portfolio_viewer.php">Viewing Page</a></li>
                    <li><a href="blog.php">Blog Page</a></li>
                    <li><a href="contact.php">Contact Page</a></li>
                </ul>
            </nav>
        </div>
    </header>

     <!-- The <aside> tag defines a portion of the document which is indirectly related to the document's main content -->
        <aside class="form-container">
            <!-- The <form> tag is used to create an HTML form for user input -->
            <form method="POST" action="blog.php">
                <!-- The <fieldset> tag is used to group related elements in a form -->
                <fieldset>
                    <p class="blog_header">
                        <label for="blog_header">Blog Header</label>
                        <br>
                        <input type="text" name="blog_header">
                      </p>
                      
                      <p class="blog_body">
                        <label for="blog_body">Blog Body</label>
                        <br>
                        <textarea name="blog_body"></textarea>
                      </p>
                      
                      <p class="button">
                        <button type="submit">Post</button>
                      </p> 
                </fieldset>
            </form>
        </aside>


</body>
</html>