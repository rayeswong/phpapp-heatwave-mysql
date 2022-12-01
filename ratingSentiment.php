<?php
// var_dump(function_exists('json_encode'));

include('config.php');
$mysqli = new mysqli($host,$username,$password,$database);
// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

echo "Connected to MySQL: " ;

$mysqli->query('set profiling=1');

// Perform query
if ($result = $mysqli -> query("SELECT year(review_date) yearReview, month(review_date) monthReview, SUM(if(star_rating = 1, 1, 0)) 1_stars, SUM(if(star_rating = 2, 1, 0)) 2_stars, SUM(if(star_rating = 3, 1, 0)) 3_stars, SUM(if(star_rating = 4, 1, 0)) 4_stars, SUM(if(star_rating = 5, 1, 0)) 5_stars FROM reviews WHERE product_category = (SELECT product_category FROM reviews WHERE product_id = 'B008TQ16OG' LIMIT 1) GROUP BY YEAR(review_date), MONTH(review_date) ORDER BY YEAR(review_date), MONTH(review_date)")) {
  //echo "Returned rows are: " . $result -> num_rows;
  $array = array();
  $yearReview = array();
  $monthReview = array();
  $monthYear = array();
  // $month = array();  
  $stars1 = array();
  $stars2 = array();
  $stars3 = array();
  $stars4 = array();
  $stars5 = array();
  $allArrays = array();

  $res = $mysqli-> query("show profiles");
  $records = $res->fetch_assoc();
  $duration = $records['Duration'];


  ?>
          <script type="text/javascript">
           document.getElementById("queryDuration").innerHTML =  <?php echo $duration  ?>;
          </script>
         <?php

$res1 = $mysqli-> query("explain select * from reviews");
$records1 = $res1->fetch_assoc();

    $_id = json_encode($records1['id']);
    $_select_type = json_encode($records1['select_type']);
    $_table = json_encode($records1['table']);
    $_partitions = json_encode($records1['partitions']);
    $_type = json_encode($records1['type']);
    $_possible_keys = json_encode($records1['possible_keys']);
    $_key = json_encode($records1['key']);
    $_key_len = json_encode($records1['key_len']);
    $_ref = json_encode($records1['ref']);
    $_rows = json_encode($records1['rows']);
    $_filtered = json_encode($records1['filtered']);
    $_Extra = json_encode($records1['Extra']);




?>
        <script type="text/javascript">
         document.getElementById("explain-content").innerHTML =  '<table class="table-bordered"><thead><tr><th>id</th><th>select_type</th><th>table</th><th>partitions</th><th>type</th><th>possible_keys</th><th>key</th><th>key_len</th><th>ref</th><th>rows</th><th>filtered</th><th>Extra</th></tr></thead><tbody><tr><td><?php echo $_id  ?></td><td><?php echo $_select_type  ?></td><td><?php echo $_table  ?></td><td><?php echo $_partitions  ?></td><td><?php echo $_type  ?></td><td><?php echo $_possible_keys  ?></td><td><?php echo $_key  ?></td><td><?php echo $_key_len  ?></td><td><?php echo $_ref  ?></td><td><?php echo $_rows  ?></td><td><?php echo $_filtered  ?></td><td><?php echo $_Extra  ?></td></tr></tbody></table>';
        </script>
       <?php


  
  if ($result->num_rows > 0) 
  {
      // OUTPUT DATA OF EACH ROW
      while($row = $result->fetch_assoc())
      {
        // add each row returned into an array
        $array[] = $row;
        $monthYear[] = $row['monthReview']. "/". $row['yearReview'];
        $yearReview[] = $row['yearReview'];
        $monthReview[] = $row['monthReview'];
        $stars1[] = $row['1_stars'];
        $stars2[] = $row['2_stars'];
        $stars3[] = $row['3_stars'];
        $stars4[] = $row['4_stars'];
        $stars5[] = $row['5_stars'];  
      }
  } 
  else {
      echo "0 results";
  }
  // debug:
    // print_r($array); // show all array data
    // echo json_encode($array), "\n";
    $yearReviewOut = json_encode($yearReview);
    $monthReviewOut = json_encode($monthReview);
    $monthYearOut = json_encode($monthYear);
    $stars1Out = json_encode($stars1);
    $stars2Out = json_encode($stars2);
    $stars3Out = json_encode($stars3);
    $stars4Out = json_encode($stars4);
    $stars5Out = json_encode($stars5);
    
    //$allArrays = [$yearReviewOut,$monthReviewOut,$stars1Out,$stars2Out,$stars3Out,$stars4Out,$stars5Out];
    $allArrays = [$yearReview,$monthReview,$stars1,$stars2,$stars3,$stars4,$stars5];
    ?>
    <script type="text/javascript">
    const yearReviewOut = <?php echo  $yearReviewOut ?>;
    const monthReviewOut = <?php echo  $monthReviewOut ?>;
    const monthYearOut = <?php echo  $monthYearOut ?>;
    const stars1Out = <?php echo  $stars1Out ?>;
    const stars2Out = <?php echo  $stars2Out ?>;
    const stars3Out = <?php echo  $stars3Out ?>;
    const stars4Out = <?php echo  $stars4Out ?>;
    const stars5Out = <?php echo  $stars5Out ?>;
    </script>
    <?php
    // print_r($allArrays);
    
  // Free result set
  $result -> free_result();
}

$mysqli -> close();
?>
