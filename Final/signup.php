<!doctype html>
<html lang="en-us">
<head>
<meta charset="utf-8">
<title>Registration Complete</title>
<link rel="stylesheet" href="styles.css"/>
</head>
<body>

<?php
// step 1: set the path to your databases folder
$path = "/home/hna2019/databases";

// step 2: connect to SQLite3 database
$db = new SQLite3($path . '/users.db');

// step 3: create table 'users' if it doesn't exist
$sqlCreateTable = "
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    firstName TEXT NOT NULL,
    lastName TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    phone TEXT NOT NULL,
    password TEXT NOT NULL
);";
$db->exec($sqlCreateTable);

// step 4: get values from POST request
$firstName = $_POST['firstName'] ?? '';
$lastName = $_POST['lastName'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($password)) {
    die("Please fill in all required fields.");
}

// step 5: insert user into database
$sqlInsert = "
INSERT INTO users (firstName, lastName, email, phone, password)
VALUES (:firstName, :lastName, :email, :phone, :password)
";
$stmt = $db->prepare($sqlInsert);
$stmt->bindValue(':firstName', $firstName, SQLITE3_TEXT);
$stmt->bindValue(':lastName', $lastName, SQLITE3_TEXT);
$stmt->bindValue(':email', $email, SQLITE3_TEXT);
$stmt->bindValue(':phone', $phone, SQLITE3_TEXT);
$stmt->bindValue(':password', $password, SQLITE3_TEXT);

$result = $stmt->execute();

// step 6: display success message with all info
if ($result) {
    print("<div id = 'header'>Signup Complete</div>");
    echo "<div id='signup-success'>";
    echo "<h2>Registration Successful!</h2>";
    echo "<p>Welcome, <strong>" . htmlspecialchars($firstName) . " " . htmlspecialchars($lastName) . "</strong>!</p>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
    echo "<p><strong>Phone:</strong> " . htmlspecialchars($phone) . "</p>";
    echo "<p><a href='login.html'>Click here to log in</a></p>";
    echo "</div>";
} else {
    echo "<p>Error: " . $db->lastErrorMsg() . "</p>";
}

// step 7: close the database
$db->close();
unset($db);
?>

</body>
</html>