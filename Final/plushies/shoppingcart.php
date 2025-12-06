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

$filepath = __DIR__ . "/db.txt";
$files = fopen($filepath, "a") or die ("Error opening file");
$line =  $q0 . "," . $q1 . "," . $q2 . "," . $q3 . "," . $name . "," . $email . "," . $address . "," . $phone . "," . $zip . "," . $maskedCredit . "," . $date . "," . $subtotal_pikachu . "," . $subtotal_charmander . "," . $subtotal_bulbasaur . "," . $subtotal_squirtle . "," . $grand_total . "\n"; 
fwrite($files, $line);
fclose($files);

print("<p>check the db.txt file on the server to see info written in the file");

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

?>
</body>	
</html>