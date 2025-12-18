<!doctype html>
<html lang="en-us">
<head>
<meta charset="utf-8">
<title>Search Results</title>
<link rel="stylesheet" href="../styles.css"/>
</head>
<body>

<?php

print("<div id = 'header'>Search Results</div>");

$search_query = $_POST['search'];

try {
	$path = "/home/hna2019/databases";
	$db = new SQLite3($path . '/plushies.db');
} 

catch (Exception $e) {
	echo "Error connecting to the database: " . $e->getMessage() . "<br>";
	exit();
}

$sqlCreateTable = "
CREATE TABLE IF NOT EXISTS plushies (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	name TEXT NOT NULL,
	price REAL NOT NULL,
	image TEXT NOT NULL,
	plushie_id TEXT NOT NULL
);";

try {
	$db->exec($sqlCreateTable);
} 

catch (Exception $e) {
	echo "Error creating table: " . $e->getMessage() . "<br>";
}

// check if table is empty before inserting
$countQuery = "SELECT COUNT(*) as count FROM plushies";
$countResult = $db->querySingle($countQuery, true);

// only inserts plushies if table is empty to prevents duplicates
if ($countResult['count'] == 0) {

	$sqlInsert = "INSERT INTO plushies (name, price, image, plushie_id) VALUES (:name, :price, :image, :plushie_id)";

	// insert Pikachu
	try {
		$stmt = $db->prepare($sqlInsert);
		$stmt->bindValue(':name', 'Pikachu', SQLITE3_TEXT);
		$stmt->bindValue(':price', 18.00, SQLITE3_FLOAT);
		$stmt->bindValue(':image', '../images/pikachu_plushie.jpg', SQLITE3_TEXT);
		$stmt->bindValue(':plushie_id', 'pikachu_plushie', SQLITE3_TEXT);
		$stmt->execute();
	} 
	catch (Exception $e) {
		echo "Error inserting data: " . $e->getMessage() . "<br>";
	}

	// insert Charmander
	try {
		$stmt = $db->prepare($sqlInsert);
		$stmt->bindValue(':name', 'Charmander', SQLITE3_TEXT);
		$stmt->bindValue(':price', 15.00, SQLITE3_FLOAT);
		$stmt->bindValue(':image', '../images/charmander_plushie.jpg', SQLITE3_TEXT);
		$stmt->bindValue(':plushie_id', 'charmander_plushie', SQLITE3_TEXT);
		$stmt->execute();
	} 
	catch (Exception $e) {
		echo "Error inserting data: " . $e->getMessage() . "<br>";
	}

	// insert Bulbasaur
	try {
		$stmt = $db->prepare($sqlInsert);
		$stmt->bindValue(':name', 'Bulbasaur', SQLITE3_TEXT);
		$stmt->bindValue(':price', 15.00, SQLITE3_FLOAT);
		$stmt->bindValue(':image', '../images/bulbasaur_plushie.jpg', SQLITE3_TEXT);
		$stmt->bindValue(':plushie_id', 'bulbasaur_plushie', SQLITE3_TEXT);
		$stmt->execute();
	} 
	catch (Exception $e) {
		echo "Error inserting data: " . $e->getMessage() . "<br>";
	}

	// insert Squirtle
	try {
		$stmt = $db->prepare($sqlInsert);
		$stmt->bindValue(':name', 'Squirtle', SQLITE3_TEXT);
		$stmt->bindValue(':price', 15.00, SQLITE3_FLOAT);
		$stmt->bindValue(':image', '../images/squirtle_plushie.jpg', SQLITE3_TEXT);
		$stmt->bindValue(':plushie_id', 'squirtle_plushie', SQLITE3_TEXT);
		$stmt->execute();
	} 
	catch (Exception $e) {
		echo "Error inserting data: " . $e->getMessage() . "<br>";
	}
}

// finds plushies with partial name match
$sqlSearch = "SELECT * FROM plushies WHERE name LIKE :search";

try {
	$stmt = $db->prepare($sqlSearch);
	$stmt->bindValue(':search', '%' . $search_query . '%', SQLITE3_TEXT);
	
	$result = $stmt->execute();
	
	print("<div id='search-results'>");
	print("<h2>Search Results for: \"" . htmlspecialchars($search_query) . "\"</h2>");

	$found = false;
	print("<div id='products'>");

	// loops through matching plushies
	while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
		$found = true;
		print("<div class='product' id='{$row['plushie_id']}'>");
		print("<img src='{$row['image']}' alt='{$row['name']}'>");
		print("<h1>{$row['name']}</h1>");
		print("<p>Price: $" . number_format($row['price'], 2) . "</p>");
		print("</div>");
	}
	
	print("</div>");
	
	if (!$found) {
		print("<p>No plushies found matching your search.</p>");
	}

	print("<div id='returnBtn'>");
	print("<button onclick=\"window.location.href='products.html'\">Return to Shopping</button>");
	print("</div>");
	
	print("</div>");
} 

catch (Exception $e) {
	echo "Error searching database: " . $e->getMessage() . "<br>";
}


$db->close();
unset($db);

?>

</body>	
</html>