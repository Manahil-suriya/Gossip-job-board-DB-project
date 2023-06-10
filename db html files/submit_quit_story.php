<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "gossip_job_board";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $job_id = $_POST["job_id"];
    $content = $_POST["story_content"];
    $post_date = $_POST["story_date"];
    
    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO quitstories (user_id, job_id, story_content, story_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Bind the values to the placeholders and execute the statement
    $stmt->bind_param("iiss", $user_id, $job_id, $content, $post_date);
    if ($stmt->execute()) {
        echo "Quit story submitted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();
}

// Retrieve all quit stories from the database
$selectSql = "SELECT * FROM quitstories";
$result = $conn->query($selectSql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quit Story Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        h3 {
            font-weight: bold;
            color: #7963e0;
            margin-bottom: 5px;
        }

        p {
            margin-bottom: 10px;
        }

        .post-container {
            background-color: #fff;
            margin: 20px auto;
            padding: 20px;
            max-width: 600px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
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

        .form-container button[type="submit"]:hover {
            background-color: #6745c7;
            
        }
    .image-logo {
            margin-left: 400px;
            width: 90px;
            height: 90px;
        }

    </style>
</head>
<body>
<img src="css/icons/logo.png" alt="Logo" class="image-logo">
    <h1>Quit Stories</h1>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="post-container">';
            echo "<h3>User ID:</h3> " . $row['user_id'] . "<br>";
            
            echo "<h3>Story Content:</h3> " . $row['story_content'] . "<br>";
            echo "<h3>Story Date:</h3> " . $row['story_date'] . "<br>";
            echo '</div>';
        }
    } else {
        echo "No quit stories found.";
    }

    $conn->close();
    ?>

<h2 style="color: #333; text-align: center;">Add a New Story</h2>
<form action="submit_quit_story.php" method="POST" class="form-container">
    <label for="user_id" class="form-label">User ID:</label>
    <input type="text" id="user_id" name="user_id" required ><br>

    <label for="job_id" class="form-label">Job ID:</label>
    <input type="text" id="job_id" name="job_id" required><br>

    <label for="story_content" class="form-label">Story:</label>
    <textarea id="story_content" name="story_content" required ></textarea><br>

    <label for="story_date" class="form-label">Date:</label>
    <input type="date" id="story_date" name="story_date" required ><br>

    <button type="submit" >Submit</button>
</form>
</body>
</html>
