<?php
    session_start(); // Start a new or resume the existing session
    
    require_once "database.php";

    if (!isset($_SESSION["logged_in"])){ // Check if the "user" session variable is not set
        header("Location: login.php"); // Redirect to login page if the user is not logged in
        exit(); // Prevent further script execution after a redirect
    }

    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Set the content type of the response to application/json
        header('Content-Type: application/json');
        // Decode the JSON received from the request body
        $data = json_decode(file_get_contents('php://input'), true);
        // Retrieve the user's ID from the session
        $user_id = $_SESSION['user_id'];
        // Assign the 'elements' array from the decoded JSON to a variable
        $elements = $data['elements'];

        // Loop through each element in the 'elements' array
        foreach ($elements as $element) {
            // Escape 'element_number' to prevent SQL injection
            $element_number = mysqli_real_escape_string($database_connection, $element['element_number']);
            // Escape 'type' to prevent SQL injection
            $type = mysqli_real_escape_string($database_connection, $element['type']);
            // Escape 'content' to prevent SQL injection
            $content = mysqli_real_escape_string($database_connection, $element['content']);
            // Escape and encode 'size' to prevent SQL injection and convert array to JSON string
            $size = mysqli_real_escape_string($database_connection, json_encode($element['size']));
            // Escape and encode 'position' to prevent SQL injection and convert array to JSON string
            $position = mysqli_real_escape_string($database_connection, json_encode($element['position']));

            // Define the SQL statement for inserting or updating the portfolio element
            $sql = "INSERT INTO portfolio_elements (user_id, element_number, type, content, size, position) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE content = VALUES(content), size = VALUES(size), position = VALUES(position)";
            // Initialize a new statement
            $stmt = mysqli_stmt_init($database_connection);
            // Prepare the SQL statement for execution
            $prepare_stmt = mysqli_stmt_prepare($stmt, $sql);
            // Check if the statement was successfully prepared
            if ($prepare_stmt){
                // Bind user input to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "iissss", $user_id, $element_number, $type, $content, $size, $position);
                // Execute the prepared statement
                mysqli_stmt_execute($stmt);
                // Echo success message as JSON
                echo json_encode(['status' => 'success', 'message' => 'Portfolio Successfully Saved']);
            }
            else{
                // Terminate script execution and display an error message if statement preparation fails
                die("Something went wrong");
            }
        }
        // Echo a final success message (this line seems redundant and might not execute as expected due to prior echoes and exits)
        echo json_encode(['status' => 'success']);
        // Terminate the script
        exit();
    } else if ($_SERVER['REQUEST_METHOD'] == 'GET'){ // Check if the request method is GET
        // Set the content type of the response to application/json
        header('Content-Type: application/json');
        // SQL query to select portfolio elements for the current user
        $sql = "SELECT element_number, type, content, size, position FROM portfolio_elements WHERE user_id = ?";

        // Prepare the SQL statement to prevent SQL injection
        $stmt = mysqli_prepare($database_connection, $sql);

        // Check if the statement was prepared correctly
        if ($stmt) {
            // Bind the user_id parameter to the prepared statement
            mysqli_stmt_bind_param($stmt, "i", $_SESSION["user_id"]);

            // Execute the prepared statement
            mysqli_stmt_execute($stmt);

            // Get the result of the query
            $result = $stmt->get_result();
            $elements = array();
            // Fetch each row of the result set as an associative array
            while($row = $result->fetch_assoc()) {
                // Add each row to the elements array
                $elements[] = $row;
            }
            // Encode the elements array to JSON and output it
            echo json_encode($elements);
        } else {
            // Output an error message in JSON format if statement preparation fails
            echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement.']);
            // Set HTTP response code to 500 - Internal Server Error
            http_response_code(500);
        }
        // Terminate the script
        exit();  
    } else {
        // Handle any request methods other than POST or GET
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        // Set HTTP response code to 405 to indicate the method is not allowed
        http_response_code(405); // Method Not Allowed
        // Terminate the script
        exit();  
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
                    <li><a href="portfolio_creator_nosave.php">Portfolio Creator Page Nosave </a></li>
                    <!-- Link to the creator page -->
                    <li><a href="portfolio_creator.php">Portfolio Creator Page Save (Broken)</a></li>
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
                    <li><button id="insertTextbox">Insert Textbox</button></li>
                    <script>
                        // Global counter for element IDs
                        let element_number = 0;

                        // Wait until the DOM is fully loaded
                        document.addEventListener('DOMContentLoaded', (event) => {
                        // Listen for clicks on the 'insertTextbox' button
                        document.getElementById('insertTextbox').addEventListener('click', function() {
                            
                            // Create a new textarea element
                            const textbox = document.createElement('textarea'); // Set position to absolute for drag functionality
                            textbox.style.position = 'absolute'; // Add 'draggable' class for styling or identification
                            textbox.classList.add('draggable'); // Change cursor to move when over the textbox
                            textbox.style.cursor = 'move'; // Cursor changes to move when over the textbox

                            // Set initial size of the textbox
                            textbox.style.width = '200px'; // Set width
                            textbox.style.height = '50px'; // Set height

                            // Set the font size and text alignment
                            textbox.style.fontSize = '20px'; // Set font size
                            textbox.style.textAlign = 'center'; // Center text horizontally

                            // Center text vertically by adjusting padding
                            textbox.style.paddingTop = '10px'; // Set top padding
                            textbox.style.paddingBottom = '10px'; // set bottom padding

                            // Additional styles for resize and overflow
                            textbox.style.resize = 'both'; // Allows resizing
                            textbox.style.overflow = 'auto'; // Ensures the content inside the textbox can scroll if it exceeds the textbox size

                            // Adjust the center positioning calculation to account for the new size
                            const centerX = (window.innerWidth - parseInt(textbox.style.width)) / 2;
                            const centerY = (window.innerHeight - parseInt(textbox.style.height)) / 2;
                            textbox.style.left = `${centerX}px`;
                            textbox.style.top = `${centerY}px`;

                            // Assign unique ID
                            textbox.setAttribute('data-element-number', element_number++);
                            
                            // Add the new textbox to the body of the document
                            document.body.appendChild(textbox);

                            // Enable dragging functionality for the textbox
                            makeDraggable(textbox);

                           // Add event listener for keydown to delete textbox
                            textbox.addEventListener('keydown', function(e) {
                            if (e.key === 'Delete') { // Check if Delete key was pressed
                                document.body.removeChild(textbox); // Remove the textbox from the document
                            }
                            });

                            // Give focus to the textbox to immediately allow typing
                            textbox.focus();
                        });

                        // Define the makeDraggable function
                        function makeDraggable(elem) {
                            let isResizing = false; // Flag to check if resizing is intended
                            let isDragging = false;
                            
                            // Listen for the mousedown event to initiate dragging
                            elem.addEventListener('mousedown', function(e) {
                                const rect = elem.getBoundingClientRect();
                                // Check if cursor is in resize zone
                                const inResizeZone = e.clientX > rect.right - 10 && e.clientY > rect.bottom - 10;

                                // Calculate starting X position by subtracting element's left offset from mouse X position
                                let startX = e.clientX - elem.offsetLeft;
                                // Calculate starting Y position by subtracting element's top offset from mouse Y position
                                let startY = e.clientY - elem.offsetTop;
                                
                                // if in resizng zone
                                if (inResizeZone) {
                                // Allow textbox resizing, so don't initiate drag
                                 isResizing = true;
                                return; // Exit without attaching move handlers
                                } else {
                                isResizing = false; // Not in resize zone, proceed with drag
                                }
                                
                                // Calculate initial positions
                                let offsetX = e.clientX - parseInt(window.getComputedStyle(elem).left);
                                let offsetY = e.clientY - parseInt(window.getComputedStyle(elem).top);

                                // Handler for moving the element
                                function mouseMoveHandler(e) {
                                let newTop = e.clientY - offsetY;
                                let newLeft = e.clientX - offsetX;

                                // Apply constraints to keep the element within bounds
                                const headerHeight = 125; // Height of header
                                const lowerBound = window.innerHeight - elem.offsetHeight; // Bottom of the window minus the height of the textbox
                                const rightBound = window.innerWidth - elem.offsetWidth; // Right side of the window minus the width of the textbox

                                // Ensure the new position is not above the header or beyond the viewport boundaries
                                if (newTop < headerHeight) {
                                    newTop = headerHeight;
                                } else if (newTop > lowerBound) {
                                    newTop = lowerBound;
                                }

                                if (newLeft < 0) {
                                    newLeft = 0;
                                } else if (newLeft > rightBound) {
                                    newLeft = rightBound;
                                }

                                // Apply the new positions, ensuring the textbox stays within bounds
                                elem.style.top = newTop + 'px';
                                elem.style.left = newLeft + 'px';
                            }

                            // Reset function to remove event listeners after dragging
                            function reset() {
                                window.removeEventListener('mousemove', mouseMoveHandler);
                                window.removeEventListener('mouseup', reset);
                                setTimeout(() => isResizing = false, 0); // Reset the flag after mouse up
                            }

                            // Attach the mouse move and up handlers
                            window.addEventListener('mousemove', mouseMoveHandler);
                            window.addEventListener('mouseup', reset);
                            });
                        }
                    });
                    </script>
                    <!-- Option to insert an image -->
                    <li><button id="insertImage">Insert Image</button></li>
                    <script>
                        // Listen for when the DOM is fully loaded
                        document.addEventListener('DOMContentLoaded', (event) => {
                        // Attach an event listener to the 'insertImage' button
                        document.getElementById('insertImage').addEventListener('click', function insertImage() {
                            // Prompt the user to enter the name of the image file
                            const imageName = prompt('Enter the image name (with extension):', '');
                            // Exit the function if no input is provided
                            if (!imageName) return;

                            // Create a new img element
                            const img = document.createElement('img');
                            // Set the source of the image to the provided name within the Images directory
                            img.src = `../Images/${imageName}`;

                            // If the image fails to load, alert the user and prompt again
                            img.onerror = () => {
                                alert('Image does not exist. Please enter a valid image name.');
                                insertImage(); // Recursively call the function to prompt again
                            };

                            // Once the image has loaded, proceed to set its properties
                            img.onload = () => {
                                let imageWidth; // Initialize variable for image width
                                // Validate the input for image width
                                while (true) {
                                    imageWidth = prompt('Enter desired width (px):');
                                    if (imageWidth === null) return; // User cancelled the prompt
                                    if (!/^\d+$/.test(imageWidth) || imageWidth < 1 || imageWidth > 1700) {
                                        alert('Please enter a positive integer width greater than or equal to 1 and less than or equal to 1700.');
                                    } else {
                                        break; // Valid input
                                    }
                                }

                                let imageHeight; // Initialize variable for image height
                                // Validate the input for image height
                                while (true) {
                                    imageHeight = prompt('Enter desired height (px):');
                                    if (imageHeight === null) return; // User cancelled the prompt
                                    if (!/^\d+$/.test(imageHeight) || imageHeight < 1 || imageHeight > 553) {
                                        alert('Please enter a positive integer height greater than or equal to 1 and less than or equal to 553.');
                                    } else {
                                        break; // Valid input
                                    }
                                }

                                // Set CSS properties to make the image draggable and resizable
                                img.style.position = 'absolute';
                                img.style.cursor = 'move';
                                img.classList.add('resizable');
                                img.style.maxWidth = '100%'; // Ensure image is not bigger than its container

                                // Apply the validated width and height to the image
                                img.style.width = `${imageWidth}px`;
                                img.style.height = `${imageHeight}px`;

                                // Assign unique ID
                                img.setAttribute('data-element-number', element_number++);

                                // Add the image to the body of the document
                                document.body.appendChild(img);
                                const headerHeight = document.querySelector('header').offsetHeight + 20;
                                // Position the image at the center of the screen, respecting the header height
                                img.style.top = `${Math.max(window.innerHeight / 2 - img.offsetHeight / 2, headerHeight)}px`;
                                img.style.left = `${window.innerWidth / 2 - img.offsetWidth / 2}px`;
                                
                                // Call the function to make the image draggable
                                makeDraggable(img);
                            };
                            
                            // Define the function to enable dragging of the element
                            function makeDraggable(elem) {
                                // When mouse is pressed down on the element
                                elem.addEventListener('mousedown', function(e) {
                                    let prevX = e.clientX;
                                    let prevY = e.clientY;
                                    // When the mouse is moved while pressed down
                                    document.addEventListener('mousemove', onMouseMove);
                                    // When the mouse button is released
                                    document.addEventListener('mouseup', onMouseUp);

                                    function onMouseMove(e) {
                                        const newX = prevX - e.clientX;
                                        const newY = prevY - e.clientY;

                                        const rect = elem.getBoundingClientRect();
                                        // Move the element based on mouse movement
                                        elem.style.left = rect.left - newX + "px";
                                        elem.style.top = rect.top - newY + "px";

                                        prevX = e.clientX;
                                        prevY = e.clientY;

                                        // Apply constraints to keep the element within the visible area
                                        const maxTop = document.querySelector('header').offsetHeight;
                                        const maxBottom = window.innerHeight - elem.offsetHeight;
                                        const maxLeft = 0;
                                        const maxRight = window.innerWidth - elem.offsetWidth;

                                        // Adjust the position to respect the constraints
                                        elem.style.top = Math.max(maxTop, Math.min(rect.top - newY, maxBottom)) + "px";
                                        elem.style.left = Math.max(maxLeft, Math.min(rect.left - newX, maxRight)) + "px";
                                    }

                                    function onMouseUp() {
                                        // Remove the event listeners when the mouse button is released
                                        document.removeEventListener('mousemove', onMouseMove);
                                        document.removeEventListener('mouseup', onMouseUp);
                                    }
                                });
                            }

                            // Functionality to delete the image with a delete key press
                            img.tabIndex = 0; // Make img focusable to capture key events
                            img.addEventListener('keydown', (e) => {
                                if (e.key === 'Delete' || e.key === 'Backspace') { // Check if Delete or Backsapce key was pressed
                                    img.remove(); // Delete image from document
                                }
                            });
                        });
                    });
                    </script>
                    <!-- Option to insert a video -->
                    <li><button id="insertVideo">Insert Video</button></li>
                    <script>
                        // Wait for the document to fully load before executing the script
                        document.addEventListener('DOMContentLoaded', (event) => {
                        // Attach an event listener to the 'Insert Video' button
                        document.getElementById('insertVideo').addEventListener('click', function insertVideo() {
                            // Prompt the user to enter the name of the video file
                            const videoName = prompt('Enter the video name (with extension):', '');
                            // Exit the function if no name is entered
                            if (!videoName) return;

                            // Create a new video element
                            const video = document.createElement('video');
                            // Set the source of the video to the entered filename
                            video.src = `../Videos/${videoName}`;
                            // Enable video controls (play, pause, etc.)
                            video.controls = true;

                            // Display an error message if the video cannot be loaded
                            video.onerror = () => {
                                alert('Video does not exist. Please enter a valid video name.');
                                // Prompt the user again for a video name
                                insertVideo(); // Recursively call the function to prompt again
                            };

                            // Function to run once the video metadata is loaded
                            video.onloadedmetadata = () => {
                                // Prompt the user for the desired video width, ensuring it adheres to constraints
                                let videoWidth;
                                while (true) {
                                    // Prompt the user to enter the width of the video
                                    videoWidth = prompt('Enter desired width (px):');
                                    if (videoWidth === null) return; // Exit if the prompt is cancelled
                                    // Validate the entered width
                                    if (!/^\d+$/.test(videoWidth) || videoWidth < 1 || videoWidth > 1696 || videoWidth % 16 !== 0) {
                                        alert('Please enter a positive integer width that is a multiple of 16, greater than or equal to 1 and less than or equal to 1696.');
                                    } else {
                                        break; // Proceed if the width is valid
                                    }
                                }

                                // Prompt the user for the desired video height, ensuring it adheres to constraints
                                let videoHeight;
                                while (true) {
                                    // Prompt the user to enter the heigth of the video
                                    videoHeight = prompt('Enter desired height (px):');
                                    if (videoHeight === null) return; // Exit if the prompt is cancelled
                                    // Validate the entered height
                                    if (!/^\d+$/.test(videoHeight) || videoHeight < 1 || videoHeight > 549 || videoHeight % 9 !== 0) {
                                        alert('Please enter a positive integer height that is a multiple of 9, greater than or equal to 1 and less than or equal to 549.');
                                    } else {
                                        break; // Proceed if the height is valid
                                    }
                                }

                                // Set CSS properties for the video element
                                video.style.position = 'absolute';
                                video.style.cursor = 'move';
                                video.classList.add('resizable');
                                video.style.maxWidth = '100%'; // Prevent the video from exceeding the width of its container

                                // Apply the user-defined dimensions to the video
                                video.style.width = `${videoWidth}px`;
                                video.style.height = `${videoHeight}px`;

                                // Assign unique ID
                                video.setAttribute('data-element-number', element_number++);

                                // Add the video element to the body of the document
                                document.body.appendChild(video);
                                // Position the video element appropriately on the screen
                                const headerHeight = document.querySelector('header').offsetHeight + 20; // Additional margin considered
                                video.style.top = `${Math.max(window.innerHeight / 2 - video.offsetHeight / 2, headerHeight)}px`;
                                video.style.left = `${window.innerWidth / 2 - video.offsetWidth / 2}px`;
                               
                                 // Make the video draggable
                                makeDraggable(video);
                            };

                            // Function to enable dragging of the video element
                            function makeDraggable(elem) {
                                // Listen for the mouse down event on the element
                                elem.addEventListener('mousedown', function(e) {
                                    // Record the initial mouse position
                                    let prevX = e.clientX;
                                    let prevY = e.clientY;
                                    // When moving the mouse, call the onMouseMove function
                                    document.addEventListener('mousemove', onMouseMove);
                                    // When releasing the mouse button, call the onMouseUp function
                                    document.addEventListener('mouseup', onMouseUp);

                                    // Function to handle mouse movement
                                    function onMouseMove(e) {
                                        // Calculate new position based on the current mouse position
                                        const newX = prevX - e.clientX;
                                        const newY = prevY - e.clientY;

                                        // Get the current position of the element
                                        const rect = elem.getBoundingClientRect();
                                        // Update the position of the element
                                        elem.style.left = rect.left - newX + "px";
                                        elem.style.top = rect.top - newY + "px";

                                        // Update previous position for the next movement
                                        prevX = e.clientX;
                                        prevY = e.clientY;

                                        // Define constraints to keep the element within visible area
                                        const maxTop = document.querySelector('header').offsetHeight; // Minimum Y position
                                        const maxBottom = window.innerHeight - elem.offsetHeight; // Maximum Y position
                                        const maxLeft = 0; // Minimum X position
                                        const maxRight = window.innerWidth - elem.offsetWidth; // Maximum X position

                                        // Apply constraints to prevent the element from moving out of the viewport
                                        elem.style.top = Math.max(maxTop, Math.min(rect.top - newY, maxBottom)) + "px";
                                        elem.style.left = Math.max(maxLeft, Math.min(rect.left - newX, maxRight)) + "px";
                                    }

                                    // Function to handle mouse button release
                                    function onMouseUp() {
                                        // Remove event listeners to stop moving the element
                                        document.removeEventListener('mousemove', onMouseMove);
                                        document.removeEventListener('mouseup', onMouseUp);
                                    }
                                });
                            }

                            // Adds functionality to delete the video with a delete or backspace key press
                            video.tabIndex = 0; // Make video focusable to capture key events
                            video.addEventListener('keydown', (e) => {
                                // Check if the pressed key is 'Delete' or 'Backspace'
                                if (e.key === 'Delete' || e.key === 'Backspace') {
                                    // Remove the video element from the document
                                    video.remove();
                                }
                            });
                        });
                    });
                    </script>
                    <!-- Option to save the current work -->
                    <li class="save"><button id="saveButton">Save</button></li> 
                    <script>
                        // Add an event listener for the click event on the save button
                        document.querySelector('#saveButton').addEventListener('click', function() {
                            // Initialize an empty array to store element data
                            let elements = [];
                            // Iterate over each element with the class 'draggable'
                            document.querySelectorAll('.draggable').forEach((elem) => {
                                let element_number, type, content, size, position;

                                // Extract the element number from the element's data attribute and parse it as an integer
                                let element_number = parseInt(elem.getAttribute('data-element-number'), 10);
                                
                                // Check the element's tag to determine its type and extract relevant data
                                if (elem.tagName === 'TEXTAREA') {
                                    type = 'textbox'; // Set type as textbox for textarea elements
                                    content = elem.value; // Use the textarea's content
                                } else if (elem.tagName === 'IMG') {
                                    type = 'image'; // Set type as image for img elements
                                    content = elem.src; // Use the image source URL
                                } else if (elem.tagName === 'VIDEO') {
                                    type = 'video'; // Set type as video for video elements
                                    content = elem.src; // Use the video source URL
                                }

                                // Store the element's size as an object with width and height properties
                                size = {width: elem.style.width, height: elem.style.height};
                                // Store the element's position as an object with left and top properties
                                position = {left: elem.style.left, top: elem.style.top};

                                // Add the element's data to the elements array
                                elements.push({element_number, type, content, size, position});
                            });

                            // Call the function to save elements to the database with the elements array
                            saveElementsToDatabase(elements);

                            // Define the function to save elements to the database
                            function saveElementsToDatabase(elements) {

                                // Use the Fetch API to send a POST request to 'portfolio_creator.php'
                                fetch('portfolio_creator.php', {
                                method: 'POST', // Specify the request method
                                headers: {
                                    'Content-Type': 'application/json', // Set the content type of the request body to JSON
                                },
                                body: JSON.stringify({elements: elements}) // Convert the elements object to a JSON string and set as request body
                            })
                            .then(response => response.json()) // Parse the JSON response
                            .then(data => console.log(data)) // Log the response data to the console
                            .catch(error => console.error('Error:', error)); // Log any errors to the console
                            }
                        });
                    </script>
                </ul>
            </nav>
        <div>
    </header>

    <script>
        // Defines a function to load portfolio elements into the webpage
        function loadPortfolioElements(elements) {
            // Check if the elements array is empty
            if (elements.length === 0) {
                // Log a message to the console if there are no elements
                console.log("No portfolio elements to display.");
                return; // Exit the function early
            }

            // Iterate over each element in the elements array
            elements.forEach(elem => {
                let element;
                // Switch case based on the element type
                switch(elem.type) {
                    case 'image':
                        // Create an img element for type 'image'
                        element = document.createElement('img');
                        element.src = elem.content; // Set the source of the image
                        break;
                    case 'textbox':
                        // Create a textarea element for type 'textbox'
                        element = document.createElement('textarea');
                        element.textContent = elem.content; // Set the text content
                        break;
                    case 'video':
                        // Create a video element for type 'video'
                        element = document.createElement('video');
                        element.src = elem.content; // Set the source of the video
                        element.controls = true; // Enable video controls
                        break;
                }
                if(element) {
                    // Set the CSS styles for width, height, position, left, and top based on element's data
                    element.style.width = elem.size.width;
                    element.style.height = elem.size.height;
                    element.style.position = 'absolute';
                    element.style.left = elem.position.left;
                    element.style.top = elem.position.top;
                    // Append the element to the document body or another specified parent element
                    document.body.appendChild(element);
                }
            });
        }

        // Initiate a fetch call to 'portfolio_creator.php' with the specified options
        fetch('portfolio_creator.php', {
            method: 'GET', // Specify the HTTP method, 'GET' or 'POST' depending on your needs
            headers: {
                'Content-Type': 'application/json', // Set the request's content type header
            }
        })
        .then(response => response.json()) // Parse the JSON response
        .then(data => {
            if(data.length === 0) {
                // Log a message if no elements were found in the response
                console.log("No elements to load, showing creator interface.");
            } else {
                loadPortfolioElements(data); // Call loadPortfolioElements with the response data if elements exist
            }
        })
        .catch(error => console.error('Error:', error)); // Log any errors to the console
    </script>
</body>
</html>