<?php

if (strlen(session_id()) === 0) {
    session_start();
}
insertRows();

function insertRows(){

include('../config.php');


$completed = 0;
$total = 1000000;
$batch_size = 25000;
$sql_values_begin = "('US', 1, '";
$sql_values_end = "', 1, 1, 'manual product', 'manual', 5, 1, 1, 'Y', 'N', 'Manual review', 'Dummy', '2015-01-01')";
$dbconn = new mysqli($host,$username,$password,$database);


if ($dbconn->connect_error) {
  die("Connection failed: " . $dbconn->connect_error);
}

if (strlen(session_id()) === 0) {
    session_start();
}

//echo "Start time is " . date("h:i:sa");
do {
  //echo "Completed number: $completed <br>";
  $sql = "Insert into reviews (marketplace, customer_id, review_id, product_id, product_parent, product_title, product_category, star_rating, helpful_votes, total_vote, vine, verified_purchase, review_headline, review_body, review_date ) values";
  for ($x = 0; $x < $batch_size; $x++) {
    $sql .= $sql_values_begin . uniqid() . $sql_values_end;
    if($x >= $batch_size - 1){
      $sql .= ";";
    } else {
      $sql .= ",";
    }
  }
  if ($dbconn->query($sql) === TRUE) {
    //echo "New records created successfully";
  } else {
    echo "Error: " . "<br>" . $dbconn->error;
  }
  if (isset($_SESSION['progress'])) {
    session_start(); //IMPORTANT!
  }
  // echo $sql . "<br>";
  $completed += $batch_size;
  $progress = $completed*100/$total;
  $_SESSION['progress'] = $progress;
  session_write_close();
  // echo "Completed number: $completed <br>";
  do {
  } while ($dbconn -> next_result());
} while ($completed < $total );

//echo "End time is " . date("h:i:sa");

$dbconn -> close();

}

?>
