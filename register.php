<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $gender = $_POST['gender'];
    $skills = isset($_POST['skills']) ? implode(", ", $_POST['skills']) : "None";
    $username = $_POST['username'];
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];

    
    if ($captcha !== "Sh68Sa") {
        echo "<h2>Invalid CAPTCHA</h2>";
        exit;
    }

   
    echo "<h2>Registration Successful!</h2>";
    echo "<strong>Name:</strong> $first_name $last_name <br>";
    echo "<strong>Address:</strong> $address <br>";
    echo "<strong>Country:</strong> $country <br>";
    echo "<strong>Gender:</strong> $gender <br>";
    echo "<strong>Skills:</strong> $skills <br>";
    echo "<strong>Username:</strong> $username <br>";
}
?>
