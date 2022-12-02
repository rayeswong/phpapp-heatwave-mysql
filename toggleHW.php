<?php
include('config.php');
$mysqli = new mysqli($host,$username,$password,$database);
// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

$queryString = "select /*+ SET_VAR(use_secondary_engine = OFF) */ year(review_date) yearReview, month(review_date) monthReview, SUM(if(star_rating = 1, 1, 0)) 1_stars, SUM(if(star_rating = 2, 1, 0)) 2_stars, SUM(if(star_rating = 3, 1, 0)) 3_stars, SUM(if(star_rating = 4, 1, 0)) 4_stars, SUM(if(star_rating = 5, 1, 0)) 5_stars from reviews where product_category = (select product_category from reviews where product_id = 'B00CXSISJW' LIMIT 1) GROUP BY YEAR(review_date), MONTH(review_date) ORDER BY YEAR(review_date), MONTH(review_date)";

// Perform query
if ($result = $mysqli -> query("SELECT ID, STATUS FROM performance_schema.rpd_nodes")) {
  // echo "Returned rows are: " . $result -> num_rows;
  if ($result->num_rows > 0)
  {
      // OUTPUT DATA OF EACH ROW
      while($row = $result->fetch_assoc())
      {
        if ($row["STATUS"] == "AVAIL_RNSTATE"){
          $hwstatus = "Yes";         
        } else {
          $hwstatus = "No";
        }
      }


      if($hwstatus == "Yes"){
        ?>
        <script type="text/javascript">
           document.getElementById("hwstatus").innerHTML = "Yes";
        </script>
       <?php
      } else {
        ?>
          <script type="text/javascript">
           document.getElementById("hwstatus").innerHTML = "No";
          </script>
         <?php
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
