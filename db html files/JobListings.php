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

// Retrieve job listings from the database
$sql = "SELECT * FROM jobs";
$result = $conn->query($sql);

// Store the job listings in an array
$jobListings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $jobListings[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Job Listings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        
        h1 {
            color:  #4b3aa5;
            text-align: center;
        }
        
        h2 {
            font-weight: bold;
            color: #7963e0;
            margin-bottom: 5px;
        }
        
        h3 {
            font-weight: bold;
            color: #333;
            margin-bottom: 2px;
        }
        p {
           
            margin-bottom: 10px;
        }
        
        hr {
            border: 1px solid #ccc;
            margin: 20px 0;
        }
        .image-logo{
          
           margin-left:620px;
            width:90px;;
            height:90px;;
        }
        
        .job-listing {
            background-color: #fff;
            margin: 20px auto;
            padding: 20px;
            max-width: 600px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<img src="css/icons/logo.png" alt="Logo" class="image-logo">
<h1>
        
        Job Listings
    </h1>
   

    <!-- Loop through the job listings and display them -->
    <?php foreach ($jobListings as $job): ?>
        <div class="job-listing">
        <h2>Job ID</h3>
        <h3><?php echo $job['job_id']; ?></h2>
            <h2><?php echo $job['title']; ?></h2>
            <p><?php echo $job['description']; ?></p>
            <h3>Qualifications</h3>
            <p><?php echo $job['qualifications']; ?></p>
            <h3>Salary</h3>
            <p><?php echo $job['salary']; ?></p>
            <h3>Location</h3>
            <p><?php echo $job['location']; ?></p>
            <h3>Company Name</h3>
            <p><?php echo $job['company_name']; ?></p>
            <h3>Posted Date</h3>
            <p><?php echo $job['posted_date']; ?></p>
        </div>
        <hr>
    <?php endforeach; ?>
</body>
</html>
