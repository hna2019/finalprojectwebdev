<!doctype html>
<html lang="en-us">
<head>
<meta charset="utf-8">
<title>Receipt</title>
<link rel="stylesheet" href="../styles.css"/>
</head>
<body>

<?php

echo "<p>Thanks for your purchase!</p>";

$q0 = $_POST['q0'];
$q1 = $_POST['q1'];
$q2 = $_POST['q2'];
$q3 = $_POST['q3'];

$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$zip = $_POST['zip'];
$credit = $_POST['credit'];

$price_pikachu = 18.00;
$price_charmander = 15.00;
$price_bulbasaur = 15.00;
$price_squirtle = 15.00;
$shipping_method = $_POST['shipping_method'];
if ($shipping_method === "Will-Call"){
	$shipping_cost = 0;
} else {
	$shipping_cost = 10;
}

$subtotal_pikachu = $q0 * $price_pikachu;
$subtotal_charmander = $q1 * $price_charmander;
$subtotal_bulbasaur = $q2 * $price_bulbasaur;
$subtotal_squirtle = $q3 * $price_squirtle;
$subtotal = $subtotal_pikachu + $subtotal_charmander + $subtotal_bulbasaur + $subtotal_squirtle;
$grand_total = $subtotal + $shipping_cost;

$maskedCredit = str_repeat("*", strlen($credit) - 4) . substr($credit, -4);
$date = date("Y-m-d H:i:s");

/* --- SQL --- */

try {
	$path = "/home/kd2684/databases";
	$db = new SQLite3($path . '/orders.db'); //SUBMIT THIS PATH
	//$db = new SQLite3('orders.db'); //FOR TESTING PURPOSES ONLY
	echo "Successfully connected to the orders.db <br>";
} catch (Exception $e) {
	echo "Error connecting to the database: " . $e->getMessage() . "<br>";
    exit();
}

$sqlCreateTable = "CREATE TABLE IF NOT EXISTS orders (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	q0 INTEGER,
    q1 INTEGER,
    q2 INTEGER,
    q3 INTEGER,
	name TEXT NOT NULL,
	email TEXT NOT NULL,
	address TEXT NOT NULL,
	phone TEXT NOT NULL,
	zip TEXT NOT NULL,
	credit_card TEXT NOT NULL,
	order_date TEXT NOT NULL,
	subtotal_pikachu REAL,
    subtotal_charmander REAL,
    subtotal_bulbasaur REAL,
    subtotal_squirtle REAL,
	grand_total REAL NOT NULL
);";

try {
    $db->exec($sqlCreateTable);
    echo "Table 'orders' created successfully or already exists.<br>";
} catch (Exception $e) {
    echo "Error creating table: " . $e->getMessage() . "<br>";
}

$sqlInsert = "INSERT INTO orders (q0, q1, q2, q3, name, email, address, phone, zip, credit_card, order_date, subtotal_pikachu, subtotal_charmander, subtotal_bulbasaur, subtotal_squirtle, grand_total) 
              VALUES (:q0, :q1, :q2, :q3, :name, :email, :address, :phone, :zip, :credit, :date, :sub_pika, :sub_char, :sub_bulb, :sub_squir, :grand)";

try {
    $stmt = $db->prepare($sqlInsert);
    $stmt->bindValue(':q0', $q0, SQLITE3_INTEGER);
    $stmt->bindValue(':q1', $q1, SQLITE3_INTEGER);
    $stmt->bindValue(':q2', $q2, SQLITE3_INTEGER);
    $stmt->bindValue(':q3', $q3, SQLITE3_INTEGER);
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->bindValue(':address', $address, SQLITE3_TEXT);
    $stmt->bindValue(':phone', $phone, SQLITE3_TEXT);
    $stmt->bindValue(':zip', $zip, SQLITE3_TEXT);
    $stmt->bindValue(':credit', $maskedCredit, SQLITE3_TEXT);
    $stmt->bindValue(':date', $date, SQLITE3_TEXT);
    $stmt->bindValue(':sub_pika', $subtotal_pikachu, SQLITE3_FLOAT);
    $stmt->bindValue(':sub_char', $subtotal_charmander, SQLITE3_FLOAT);
    $stmt->bindValue(':sub_bulb', $subtotal_bulbasaur, SQLITE3_FLOAT);
    $stmt->bindValue(':sub_squir', $subtotal_squirtle, SQLITE3_FLOAT);
    $stmt->bindValue(':grand', $grand_total, SQLITE3_FLOAT);
    
    $stmt->execute();
    echo "Info inserted: Order data inserted successfully.<br>";

} catch (Exception $e) {
	echo "Error inserting data: " . $e->getMessage() . "<br>";
}

/* --- */

/* --- Display Receipt --- */

print("<h2>Receipt</h2>");
print("Name: ${name}<br>");
print("Email: ${email}<br>");
print("Address: ${address}<br>");
print("Phone number: ${phone}<br>");
print("Zip code: ${zip}<br>");
print("Credit card: ${maskedCredit}<br>");
print("Date: ${date}<br><br>");
print("<strong>Sub Total:</strong> $${subtotal}<br>");
print("<strong>Grand Total:</strong> $${grand_total}");

$db->close();
unset($db);

echo "Database connection closed.<br>";

?>
</body>	
</html>