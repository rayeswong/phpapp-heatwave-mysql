<?php
include('config.php');
$mysqli = new mysqli($host,$username,$password,$database);
// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

// Perform query 
if ($result = $mysqli -> query("select year(review_date) yearReview, month(review_date) monthReview, SUM(if(star_rating = 1, 1, 0)) 1_stars, SUM(if(star_rating = 2, 1, 0)) 2_stars, SUM(if(star_rating = 3, 1, 0)) 3_stars, SUM(if(star_rating = 4, 1, 0)) 4_stars, SUM(if(star_rating = 5, 1, 0)) 5_stars from reviews where product_category = (select product_category from reviews where product_id = 'B0008G2WAW' LIMIT 1) GROUP BY YEAR(review_date), MONTH(review_date) ORDER BY YEAR(review_date), MONTH(review_date)")) {
  echo "Returned rows are: " . $result -> num_rows;
  // Free result set
  $result -> free_result();
}

$mysqli -> close();
?>
