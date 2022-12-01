<?php
include('config.php');
$mysqli = new mysqli($host,$username,$password,$database);

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

// Perform query 
if ($result = $mysqli -> query("select count(product_id) from reviews")){ 
  // echo "Returned rows are: " . $result -> num_rows;
  $row = $result->fetch_row();
  // echo '#: ', $row[0];
  echo $row[0];  
  // Free result set
  $result -> free_result();
}

$mysqli -> close();
?>
