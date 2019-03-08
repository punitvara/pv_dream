<?php
// This guide demonstrates the five fundamental steps
// of database interaction using PHP.

// Credentials
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'pv_data';

echo "database to connect\n";
// 1. Create a database connection
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Test if connection succeeded
if(mysqli_connect_errno()) {
  $msg = "Database connection failed: ";
  $msg .= mysqli_connect_error();
  $msg .= " (" . mysqli_connect_errno() . ")";
  exit($msg);
}

$image_array = array();

// 2. Perform database query
$query = "SELECT * FROM container";
$result_set = mysqli_query($connection, $query);

if ($result_set) {
  echo "REcord success\n";
} else {
   echo "NOT SUCESS\n";
}

// Test if query succeeded
if (!$result_set) {
	exit("Database query failed.");
}

// 3. Use returned data (if any)
while($subject = mysqli_fetch_assoc($result_set)) {
  echo $subject["ImageColumnName"] . "<br />";
}

// 4. Release returned data
mysqli_free_result($result_set);

// 5. Close database connection
mysqli_close($connection);

echo "end of connect";

 ?>
