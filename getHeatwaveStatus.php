<?php
include('config.php');
$mysqli = new mysqli($host,$username,$password,$database);
// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

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
           document.getElementById("toggleHW").innerHTML = "Heatwave is Enabled <button onclick="toggleHW('off')" type="button" class="btn btn-success btn-lg" id="HW" value="1">HW Enabled</button>";
              
        </script>
       <?php
      } else {
        ?>
          <script type="text/javascript">
           document.getElementById("hwstatus").innerHTML = "No";
           document.getElementById("toggleHW").innerHTML = "Heatwave is Disabled <button onclick="toggleHW('on')" type="button" class="btn btn-success btn-lg" id="HW" value="1">HW Enabled</button>";
             
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
