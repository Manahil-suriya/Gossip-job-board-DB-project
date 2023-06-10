<?php
session_start();

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
    $title = $conn->real_escape_string($_POST["title"]);
    $description = $conn->real_escape_string($_POST["description"]);
    $qualifications = $conn->real_escape_string($_POST["qualifications"]);
    $salary = $_POST["salary"];
    $location = $conn->real_escape_string($_POST["location"]);
    $company_name = $conn->real_escape_string($_POST["company_name"]);
    $posted_date = $_POST["posted_date"];

    // Prepare and bind the statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO jobs (title, description, qualifications, salary, location, company_name, posted_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $title, $description, $qualifications, $salary, $location, $company_name, $posted_date);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the JobListings.php page after successful submission
        header("Location: JobListings.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
