<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        
        h1 {
            color: #333;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h1 img {
            height: 30px;
            margin-right: 10px;
        }
        
        h3 {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        
        p {
            margin-top: 0;
            margin-bottom: 10px;
        }
        .image-logo{
          
          margin-left:620px;
           width:90px;;
           height:90px;;
       }
        .user-info {
            background-color: #fff;
            margin: 20px auto;
            padding: 20px;
            max-width: 600px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .home-style h2{
            margin-left:420px;
        }
        .home-style a{
            text-decoration:none;
            color:white;
            padding:10px;
        }
        .a-tag{
            margin-left:420px;
            background-color:#7963e0;
            width:5%;
            height:25px;
           padding:10px;
        }
    </style>
</head>
<body>
<img src="css/icons/logo.png" alt="Logo" class="image-logo">
    <h1>
       
        User Registation Information
    </h1>

    <?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the form data
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Connect to the database
        $host = "localhost";
        $username = "root";
        $dbpassword = ""; // Change this to your actual database password
        $database = "gossip_job_board";

        $conn = new mysqli($host, $username, $dbpassword, $database);
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }
        
        
        // Prepare and execute the SQL query to insert the data
        $sql = "INSERT INTO users (username, email, password) VALUES ('$name', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            $user_id = $conn->insert_id; // Get the auto-generated user_id
            $sql_signup = "INSERT INTO signup (user_id, signup_date) VALUES ('$user_id', NOW())";
            if ($conn->query($sql_signup) === TRUE) {
                echo "Sign-up successful";
            } else {
                echo "Error: " . $sql_signup . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
    
        if ($conn->query($sql) === true) {
            // Data inserted successfully

            // Retrieve the inserted data from the database
            $selectSql = "SELECT * FROM users WHERE email = '$email'";
            $result = $conn->query($selectSql);

            if ($result->num_rows > 0) {
                // Display the submitted data
                $row = $result->fetch_assoc();
                echo '<div class="user-info">';
                echo "<h3>ID</h3>" . $row['user_id'] . '<br>';
                echo "<h3>Name</h3>" . $row['username'] . '<br>';
                echo "<h3>Email</h3>" . $row['email'] . '<br>';
                echo "<h3>Password</h3>" . $password . '<br>';
                echo '</div>';
            }
        } else {
            // Error inserting data
            echo 'Error: ' . $sql . '<br>' . $conn->error;
        }

        $conn->close();
    }
    ?>
    <div class="home-style">
    <h2>Move to home page</h2>
    <div class="a-tag">
    <a href="index.html" title="home">Home</a>
</div>
</div>
</body>
</html>
