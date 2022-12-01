<?php
include('config.php');
$mysqli = new mysqli($host,$username,$password,$database);
// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

// Perform query
if ($result = $mysqli -> query("SELECT distinct product_title, product_category FROM reviews WHERE product_id = 'B008TQ16OG'")) {
  // echo "Returned rows are: " . $result -> num_rows;
  if ($result->num_rows > 0)
  {
      // OUTPUT DATA OF EACH ROW
      while($row = $result->fetch_assoc())
      {
          echo "<H4>Product Name: " . $row["product_title"]. "</H4>".
          "<H4>Product Category: " . $row["product_category"]. "</H4>";
      }
  }
  else {
      echo "0 results";
  }
  // Free result set
  $result -> free_result();
}

$mysqli -> close();
?>
