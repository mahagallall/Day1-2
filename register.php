<?php

$file = 'users.txt';


function readUsers($file) {
    $users = [];
    if (file_exists($file)) {
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $users[] = explode('|', $line);
        }
    }
    return $users;
}


function writeUsers($file, $users) {
    $data = [];
    foreach ($users as $user) {
        $data[] = implode('|', $user);
    }
    file_put_contents($file, implode("\n", $data));
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $users = readUsers($file);
    if (isset($_POST['add'])) {
        $users[] = [$_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['country'], $_POST['gender'], isset($_POST['skills']) ? implode(", ", $_POST['skills']) : "None", $_POST['username'], $_POST['password']];
    } elseif (isset($_POST['update'])) {
        $index = $_POST['index'];
        $users[$index] = [$_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['country'], $_POST['gender'], isset($_POST['skills']) ? implode(", ", $_POST['skills']) : "None", $_POST['username'], $_POST['password']];
    } elseif (isset($_POST['delete'])) {
        $index = $_POST['index'];
        unset($users[$index]);
        $users = array_values($users);
    }
    writeUsers($file, $users);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$users = readUsers($file);
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
</head>
<body>
    <h2>User Management</h2>
    <?php echo '<form method="POST">'; ?>
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="text" name="country" placeholder="Country" required>
        <input type="text" name="gender" placeholder="Gender" required>
        <input type="text" name="skills" placeholder="Skills (comma separated)" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="add">Add User</button>
    <?php echo '</form>'; ?>
    <table border="1">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Address</th>
            <th>Country</th>
            <th>Gender</th>
            <th>Skills</th>
            <th>Username</th>
            <th>Actions</th>
        </tr>
        <?php 
        foreach ($users as $index => $user) {
            echo '<tr>';
            echo '<form method="POST">';
            echo '<td><input type="text" name="first_name" value="' . $user[0] . '" required></td>';
            echo '<td><input type="text" name="last_name" value="' . $user[1] . '" required></td>';
            echo '<td><input type="text" name="address" value="' . $user[2] . '" required></td>';
            echo '<td><input type="text" name="country" value="' . $user[3] . '" required></td>';
            echo '<td><input type="text" name="gender" value="' . $user[4] . '" required></td>';
            echo '<td><input type="text" name="skills" value="' . $user[5] . '" required></td>';
            echo '<td><input type="text" name="username" value="' . $user[6] . '" required></td>';
            echo '<td>';
            echo '<input type="hidden" name="index" value="' . $index . '">';
            echo '<button type="submit" name="update">Update</button>';
            echo '<button type="submit" name="delete">Delete</button>';
            echo '</td>';
            echo '</form>';
            echo '</tr>';
        }
        ?>
    </table>
</body>
</html>
