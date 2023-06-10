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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jobId = $_POST["job_id"];

    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM jobs WHERE job_id = ?");
    $stmt->bind_param("i", $jobId);

    // Execute the delete statement
    if ($stmt->execute()) {
        echo "Enter your job you want to delete";
    } else {
        echo "Error deleting job: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Job</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        form {
            margin: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"] {
            padding: 5px;
            width: 200px;
        }

        button {
            padding: 5px 10px;
            background-color: #7963e0;
            color: white;
            border: none;
            cursor: pointer;
        }
        .home-style h4{
            margin-left:600px;
        }
        .home-style a{
            text-decoration:none;
            color:white;
            padding:10px;
        }
        .a-tag{
            margin-left:620px;
            background-color:#7963e0;
            width:5%;
            height:15px;
           padding:10px;
        }
    </style>
</head>
<body>
    <h2>Delete Job</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="job_id">Job ID:</label>
        <input type="text" name="job_id" id="job_id" required>
        <button type="submit">Delete</button>
    </form>
    <div class="home-style">
    <h4>Move to home page</h4>
    <div class="a-tag">
    <a href="index.html" title="home">Home</a>
</div>
</div>
</body>
</html>

