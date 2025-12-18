<!doctype html>
<html lang="en-us">
<head>
<meta charset="utf-8">
<title>Login Result</title>
<link rel="stylesheet" href="styles.css"/>
</head>
<body>

<?php
// step 1: set the path to your databases folder
$path = "/home/hna2019/databases";

// step 2: connect to SQLite3 database
$db = new SQLite3($path . '/users.db');

// step 3: get values from POST request
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    die("Please enter both email and password.");
}

// step 4: prepare SELECT query
$sqlSelect = "
SELECT id, firstName, lastName, email, phone
FROM users
WHERE email = :email AND password = :password
";

$stmt = $db->prepare($sqlSelect);
$stmt->bindValue(':email', $email, SQLITE3_TEXT);
$stmt->bindValue(':password', $password, SQLITE3_TEXT);

// step 5: execute query
$result = $stmt->execute();
$user = $result->fetchArray(SQLITE3_ASSOC);

// step 6: check login result
if ($user) {
    echo "<div id='header'>Login Successful</div>";
    echo "<div id='signup-success'>";
    echo "<h2>Welcome Back!</h2>";
    echo "<p>Hello, <strong>" .
         htmlspecialchars($user['firstName']) . " " .
         htmlspecialchars($user['lastName']) .
         "</strong></p>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($user['email']) . "</p>";
    echo "<p><strong>Phone:</strong> " . htmlspecialchars($user['phone']) . "</p>";
    echo "<p><strong>Account Number:</strong> " . htmlspecialchars($user['id']) . "</p>";
    echo "</div>";
} else {
    echo "<div id='login-error'>";
    echo "<h2>Login Failed</h2>";
    echo "<p>Incorrect email or password.</p>";
    echo "<p><a href='login.html'>Try again</a></p>";
    echo "</div>";
}

echo "<div style='text-align:center; margin-top:30px;'>";
echo "<button id='homeBtn' onclick=\"window.location.href='index.html'\">";
echo "Return to Home";
echo "</button>";
echo "</div>";


// step 7: close database
$db->close();
unset($db);
?>

</body>
</html>
