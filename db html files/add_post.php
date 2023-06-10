<!DOCTYPE html>
<html>
<head>
    <title>User Posts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .image-logo{
          
          margin-left:620px;
           width:90px;;
           height:90px;;
       }
       

        h1 {
            color: #333;
            text-align: center;
        }

        h2 {
            font-weight: bold;
            color: #7963e0;
            margin-bottom: 10px;
        }

        h3 {
            font-weight: bold;
            color: #7963e0;
            margin-bottom: 5px;
        }

        p {
            margin-bottom: 10px;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin-bottom: 10px;
        }

        .post-container {
           
            background-color: #fff;
            margin: 20px auto;
            padding: 20px;
            max-width: 600px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .image-logo {
            margin-left: 620px;
            width: 90px;
            height: 90px;
        }

        .form-container {
            width: 400px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            background-color: #f6f6f6;
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
        }

        .form-container input[type="text"],
        .form-container textarea {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }

        .form-container button[type="submit"] {
            background-color: #7963e0;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-top:30px;
            margin-left:180px;
        }
        .heading{
            margin-left:580px;
        }

        .form-container button[type="submit"]:hover {
            background-color: #6745c7;
            
        }
        .my-image{
            width:20%;
            height:30%;
            padding:10px;
           
        }
        
    </style>
</head>
<body>
    <img src="css/icons/logo.png" alt="Logo" class="image-logo">
    <h1>User Posts</h1>

    <?php
    // Establish database connection
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "gossip_job_board";

    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle form submission and insert user records
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userId = $conn->real_escape_string($_POST["user_id"]);
        $content = $conn->real_escape_string($_POST["content"]);
        $postDate = date("Y-m-d H:i:s");

        // Handle image file upload
        $imagePath = '';
        if (isset($_FILES["image_path"]) && $_FILES["image_path"]["error"] === UPLOAD_ERR_OK) {
            $uploadDirectory = "uploads/";
            $imageName = uniqid() . "_" . $_FILES["image_path"]["name"];
            $imagePath = $uploadDirectory . $imageName;

            if (move_uploaded_file($_FILES["image_path"]["tmp_name"], $uploadDirectory . $imageName)) {
                // File moved successfully
            } else {
                echo "Error uploading image.";
            }
        }

        // Prepare and bind the statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO social_media (user_id, content, post_date, image_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $userId, $content, $postDate, $imagePath);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Post added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    // Retrieve user posts from the database
    $selectSql = "SELECT * FROM social_media";
    $result = $conn->query($selectSql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="post-container">';
            echo "<h3>Content:</h3> " . $row['content'] . "<br>";
            echo "<h3>Post Date:</h3> " . $row['post_date'] . "<br>";

            // Display the uploaded image if available
            if (!empty($row['image_path'])) {
                echo '<img src="' . $row['image_path'] . '" alt="Image" class="my-image">';
            }

            echo '</div>';
        }
    } else {
        echo "No posts found.";
    }

    $conn->close();
    ?>

<h2 class="heading">Add a New Post</h2>
    <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
            <label for="user_id">User ID:</label>
            <input type="text" id="user_id" name="user_id" required>

            <label for="content">Content:</label>
            <textarea id="content" name="content" required></textarea>

            <label for="image_path">Image File:</label>
            <input type="file" id="image_path" name="image_path" accept="image/*">
            <br>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>