<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
      <link rel="icon" type="image/png" href="./img/mysqlIcon.png" />
      <!-- JQuery js and css -->
      <script src="./src/jquery-3.6.1.min.js"></script>
      <!-- Bootstrap 4.0 js and css -->
      <link rel="stylesheet" href="./src/bootstrap.min.css">
      <script src="./src/bootstrap.min.js"></script>
      <script src="./src/popper.js"></script>
      <!-- Our js and styles (if any) -->
      <!-- <script src="https://mysql.withoracle.cloud/demos/hw/src/scripts.js?v=80510"></script> -->
      <link rel="stylesheet" href="./src/style.css">
      <!-- Chart.js -->
      <!-- <script src="./src/Chart.bundle.min.js"></script> -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
      <!-- highlight -->
      <link rel="stylesheet" href="./src/default.min.css">
      <script src="./src/highlight.min.js"></script>
      <!-- https://github.com/alrusdi/jquery-plugin-query-object -->
      <script src="./src/jquery.query-object.js"></script>
      <title>MySQL Heatwave Demo</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
      
<style>
.column {
  float: left;
  width: 50%;
  padding: 5px;
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}

.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 25%;
}
</style>
</head>
<body>
<div>
<img src="img/header_logo.png" alt="Paris" class="center">
</div>




<div class="row">
  <div class="column" >
  <div class="container-fluid"  >
             
                <div class="row mt-4">
                        <div class="col-md-12">
                                <div class="jumbotron jumbotron-fluid">
                                        <div class="container">
                                                <h1 class="display-4">Add new product rows</h1>
                                                <div class="p-3 mb-2 bg-warning text-dark">Currently <b><span id="numberOfRows"></span></b> rows</div>
                                                <p class="lead">Adding new demo product from the database.</p>
                                                <hr class="my-4">
                                                <button id="startInsert" type="button" class="btn btn-success btn-lg" name="startInsert" value="Insert Rows">Add 1,000,000 Rows</button>
                                                <!-- <button type="button" class="btn btn-success btn-lg" name="action" value="2000">Add 2,000 rows</button>
                                                <button type="button" class="btn btn-success btn-lg" name="action" value="100000"> Add 100,000 rows</button>
                                                <button type="button" class="btn btn-success btn-lg" name="action" value="500000"> Add 500,000 rows</button>
                                                <button type="button" class="btn btn-success btn-lg" name="action" value="1000000"> Add 1,000,000 rows</button>
                                                <button type="button" class="btn btn-danger btn-lg" name="action" value="-1">Delete ALL</button> -->                                             
                                        </div>
                                           
                                </div>
                        </div>
                </div>
                <div class="row mt-4">
                        <div class="col-md-12" id="progressBarDiv">
                            <!-- <div class="progress" style="height: 40px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" id="progressbar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"><span id="progressBarText">0% Complete</span></div>
                            </div> -->
                        </div>                               
                </div>
        </div>

        <div class="footer">
                MySQL Database Service (MDS) & Heatwave demo by Ronen Baram 2022
        </div>

        <script type="text/javascript">
                $(document).ready(function() {
                        updateNumberOfRows();

                        // $('#startInsert').click(function () {
                        $("button[name='startInsert']").on('click', function(){
                            
                            $("#progressBarDiv").html("\
                                <div class=\"progress\" style=\"height: 40px;\"> \
                                    <div class=\"progress-bar progress-bar-striped progress-bar-animated\" role=\"progressbar\" style=\"width: 0%\" id=\"progressbar\"><span id=\"progressBarText\">0% Complete</span> \
                                    </div> \
                                </div>");

                            getProgress();
                            
                            console.log('startInsert');
                            $.ajax({
                                url: "./rh/insert.php",
                                type: "POST",
                                data: {
                                    'rows': '10000'
                                },
                                async: true, //IMPORTANT!
                                contentType: false,
                                processData: false,
                                success: function(data){
                                    if(data!==''){
                                        alert(data);
                                    }
                                    return false;
                                }
                            });
                            
                            return false;
                        });

                });

                $("#productPage").on('click', function(){
                        window.open('productPage.php?productID=29c01a32-&HW=1', '_blank').focus()
                });

                function updateNumberOfRows(){
                        $.ajax({
                                type: "GET",
                                url: "getTotalNumber.php",
                                success: function(result) {
                                        $("#numberOfRows").html(result);
                                }
                        });
                }

                function getProgress() {
                    console.log('getProgress');
                    
                    $.ajax({
                        url: "./rh/getProgress.php",
                        type: "GET",
                        contentType: false,
                        processData: false,
                        async: false,
                        success: function (data) {
                            console.log(data);
                            // $('#progressbar').css('width', data+'%').children('.sr-only').html(data+"% Complete");
                            $('#progressbar').css('width', data+'%');
                            $("#progressBarText").text(data+'% Completed');
                            if (parseInt(data)%10 == 0) {
						        
					        }
                            if(data!=='100'){
                                setTimeout('getProgress()', 200);
                                // updateNumberOfRows();
                            } else {
                                $("#progressbar").removeClass("progress-bar-animated");
                                updateNumberOfRows();
                            }
                            
                        }
                    });
                }
        </script>
</div>
  <div class="column">
  <div class="container-fluid">
         <div class="row mt-4">
            <div class="col-md-10 productPageTitleClass" id="productPageTitle">
            </div>
            <div class="col-md-10" id="debugInfo">
            </div>
            <div id="toggleHW" class="col-md-2">
              <button onclick="toggleHW('off')" type="button" class="btn btn-warning btn-lg" id="HW" value="1">HW Disable</button>
            </div>
         </div>
         <!--
            <div class="row mt-4">
            	<div class="col-md-6">
            		<div class="card">
                           <canvas id="myChart" width="800" height="200"></canvas>
            		</div>
            	</div>
            		<div class="col-md-6">
            			<div class="card">
            				<div class="card-body" id="cardGraph6">
            				</div>
            			</div>
            		</div>
            	</div>
            	
                      <div class="row">
            		<div class="col-md-6">
            			<div class="card">
            				<div class="card-body" id="cardGraph2">
            				</div>
            			</div>
            		</div>
            		<div class="col-md-6">
            			<div class="card">
            				<div class="card-body" id="cardGraph5">
            				</div>
            			</div>
            		</div>
            	</div>
            	<div class="row">
            		<div class="col-md-6">
            			<div class="card">
            				<div class="card-body" id="cardGraph4">
            				</div>
            			</div>
            		</div>
            		<div class="col-md-6">
            			<div class="card">
            				<div class="card-body" id="cardGraph3">
            				</div>
            			</div>
            		</div>
            </div> -->
         <div onclick="openModal()">
            <canvas id="myChart" width="800" height="400"></canvas>
         </div>
      </div>
      <script type="text/javascript">

 function toggleHW(type){
   $.ajax({
         	type: "GET",
         	url: "toggleHW.php",
         	success: function(result) {
              

               
         	}
         });

         if(type == "on"){
                   document.getElementById("toggleHW").innerHTML = 'Heatwave is Enabled <button onclick=toggleHW("off") type="button" class="btn btn-warning btn-lg" id="HW" value="1">HW Disable</button>';
               } else {
                  document.getElementById("toggleHW").innerHTML = 'Heatwave is Disabled <button onclick=toggleHW("on") type="button" class="btn btn-success btn-lg" id="HW" value="1">HW Enable</button>';
             }
 }

         $.ajax({
         	type: "GET",
         	url: "getHeaderInfo.php",
         	success: function(result) {
         		$("#productPageTitle").html(result);
                    $("#productPageTitle").html(result.html).removeClass("blurText");
         	}
         });

         $.ajax({
         	type: "GET",
         	url: "getHeatwaveStatus.php",
         	success: function(result) {
         		$("#productPageTitle").html(result);
                    $("#productPageTitle").html(result.html).removeClass("blurText");
         	}
         });
         
         $.ajax({
         	type: "GET",
         	url: "ratingSentiment.php",
         	success: function(result) {
         		$("#debugInfo").html(result);
                    console.log(yearReviewOut);
                    console.log(monthReviewOut);
                    console.log(monthYearOut);
                    console.log(stars1Out);
                    console.log(stars2Out);
                    console.log(stars3Out);
                    console.log(stars4Out);
                    console.log(stars5Out);
         
                    const ctx = document.getElementById('myChart');
                    //const ratingNumbers = yearReviewOut.map((year, index) => {
                    const ratingNumbers = monthYearOut.map((year, index) => {    
                        let yearObject = {};
                        yearObject.year = year;
                        yearObject.ratings = {};
                        yearObject.ratings.one = stars1Out[index];
                        yearObject.ratings.two = stars2Out[index];
                        yearObject.ratings.three = stars3Out[index];
                        yearObject.ratings.four = stars4Out[index];
                        yearObject.ratings.five = stars5Out[index];
                        console.log(yearObject);
                        return yearObject;
                    })
         
                    // const labels = yearReviewNew;
                    const data = {
                    // labels: labels,
                    datasets: [
                        {
                        label: '1 Star',
                        data: ratingNumbers,
                        borderColor: 'rgba(255, 1, 0, 0.2)',
                        backgroundColor: 'rgba(255, 1, 0, 0.2)',
                        tension: 0.4,
                        fill: true,
                        parsing:{
                            xAxisKey: 'year',
                            yAxisKey: 'ratings.one'
                        }
                        },
                        {
                        label: '2 Stars',
                        data: ratingNumbers,
                        borderColor: 'rgba(255, 105, 180, 0.2)',
                        backgroundColor: 'rgba(255, 105, 180, 0.2)',
                        tension: 0.4,
                        fill: true,
                        parsing:{
                            xAxisKey: 'year',
                            yAxisKey: 'ratings.two'
                        }
                        },
                        {
                        label: '3 Stars',
                        data: ratingNumbers,
                        borderColor: 'rgba(139, 13, 139, 0.1)',
                        backgroundColor: 'rgba(139, 13, 139, 0.1)',
                        tension: 0.4,
                        fill: true,
                        parsing:{
                            xAxisKey: 'year',
                            yAxisKey: 'ratings.three'
                        }
                        },
                        {
                        label: '4 Stars',
                        data: ratingNumbers,
                        borderColor: 'rgba(29, 144, 255, 0.1)',
                        backgroundColor: 'rgba(29, 144, 255, 0.1)',
                        tension: 0.4,
                        fill: true,
                        parsing:{
                            xAxisKey: 'year',
                            yAxisKey: 'ratings.four'
                        }
                        },
                        {
                        label: '5 Stars',
                        data: ratingNumbers,
                        borderColor: 'rgba(34, 139, 33, 0.1)',
                        backgroundColor: 'rgba(34, 139, 33, 0.1)',
                        tension: 0.4,
                        fill: true,
                        parsing:{
                            xAxisKey: 'year',
                            yAxisKey: 'ratings.five'
                        }
                        }
                    ]
                    };
                    const myChart = new Chart(ctx, {
                    type: 'line',
                    data: data,
                    options: {
                        responsive: true,
                        plugins: {
                        title: {
                            display: true,
                            text: (ctx) => 'Rating sentiment for the category'
                        },
                        tooltip: {
                            mode: 'index'
                        },
                        },
                        interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                        },
                        scales: {
                        x: {
                            title: {
                            display: true,
                            text: 'Year'
                            }
                        },
                        y: {
                            stacked: true,
                            title: {
                            display: true,
                            text: 'Value'
                            }
                        }
                        }
                    }
                    });
            
            }
            });    
            /*
         
         $("#HW").on('click', function(){
         	if ($("#HW").attr("value") == 0) {
         		window.location.search = jQuery.query.set("HW", 1);
         	} else {
         		window.location.search = jQuery.query.set("HW", 0);
         	}
         });
            */  
         
         
           // When the user clicks on the button, open the modal
         function openModal() {
            var modal = document.getElementById("modal");
          modal.style.display = "block";
          document.body.style.overflow = 'hidden';
         }
         
         // When the user clicks on <span> (x), close the modal
         function closeModal() {
            var modal = document.getElementById("modal");
          modal.style.display = "none";
          document.body.style.removeProperty('overflow');
         }
         
   
      </script>
      <div class="footer">
         MySQL Database Service (MDS) & Heatwave demo by Ronen Baram 2022
      </div>


      <!-- Modal -->
      <div class="modal" tabindex="-1" role="dialog" id="modal" style="overflow-y: scroll">
         <div class="modal-dialog " role="document" style="max-width: 90%;">
            <div class="modal-content  " >
               <div class="modal-header">
                  <h5 class="modal-title">Query information</h5>
                  <button type="button" onclick="closeModal()" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body" id="modalBody" >
                  <table class="table " style="border-top: 2px solid black; border-bottom: 2px solid black; border-collapse: collapse;">
                     <tbody>
                        <tr>
                           <td style="width: 10%;"><b>Comment</b></td>
                           <td>
                              <h5>Number of reviews and average star rating per year for the single product</h5>
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <b>Duration</b><br>
                           </td>
                           <td>
                             <p> <span id='queryDuration'>'queryDuration'</span> seconds (Heatwave: <span id='hwstatus'>'heatwaveStatus'</span>)</p>
                           </td>
                        </tr>
                        <tr>
                           <td><b>Explain</b></td>
                           <td id="explain-content">result 0</td>
                     
                        </tr>
                        <tr>
                           <td><b>Query</b></td>
                           <td>
                              <font face="Courier New" size="2">
                              <font color = "blue">SELECT</font>&nbsp;&nbsp;&nbsp;<font color = "fuchsia"><i>Year</i></font><font color = "maroon">(</font><font color = "maroon">review_date</font><font color = "maroon">)</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color = "maroon">yearreview</font><font color = "silver">,</font>
                              <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color = "fuchsia"><i>Month</i></font><font color = "maroon">(</font><font color = "maroon">review_date</font><font color = "maroon">)</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color = "maroon">monthreview</font><font color = "silver">,</font>
                              <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color = "maroon">sum</font><font color = "maroon">(</font><font color = "blue">IF</font><font color = "maroon">(</font><font color = "maroon">star_rating</font>&nbsp;<font color = "silver">=</font>&nbsp;<font color = "black">1</font><font color = "silver">,</font>&nbsp;<font color = "black">1</font><font color = "silver">,</font>&nbsp;<font color = "black">0</font><font color = "maroon">)</font><font color = "maroon">)</font>&nbsp;<font color = "black">1</font><font color = "maroon">_stars</font><font color = "silver">,</font>
                              <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color = "maroon">sum</font><font color = "maroon">(</font><font color = "blue">IF</font><font color = "maroon">(</font><font color = "maroon">star_rating</font>&nbsp;<font color = "silver">=</font>&nbsp;<font color = "black">2</font><font color = "silver">,</font>&nbsp;<font color = "black">1</font><font color = "silver">,</font>&nbsp;<font color = "black">0</font><font color = "maroon">)</font><font color = "maroon">)</font>&nbsp;<font color = "black">2</font><font color = "maroon">_stars</font><font color = "silver">,</font>
                              <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color = "maroon">sum</font><font color = "maroon">(</font><font color = "blue">IF</font><font color = "maroon">(</font><font color = "maroon">star_rating</font>&nbsp;<font color = "silver">=</font>&nbsp;<font color = "black">3</font><font color = "silver">,</font>&nbsp;<font color = "black">1</font><font color = "silver">,</font>&nbsp;<font color = "black">0</font><font color = "maroon">)</font><font color = "maroon">)</font>&nbsp;<font color = "black">3</font><font color = "maroon">_stars</font><font color = "silver">,</font>
                              <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color = "maroon">sum</font><font color = "maroon">(</font><font color = "blue">IF</font><font color = "maroon">(</font><font color = "maroon">star_rating</font>&nbsp;<font color = "silver">=</font>&nbsp;<font color = "black">4</font><font color = "silver">,</font>&nbsp;<font color = "black">1</font><font color = "silver">,</font>&nbsp;<font color = "black">0</font><font color = "maroon">)</font><font color = "maroon">)</font>&nbsp;<font color = "black">4</font><font color = "maroon">_stars</font><font color = "silver">,</font>
                              <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color = "maroon">sum</font><font color = "maroon">(</font><font color = "blue">IF</font><font color = "maroon">(</font><font color = "maroon">star_rating</font>&nbsp;<font color = "silver">=</font>&nbsp;<font color = "black">5</font><font color = "silver">,</font>&nbsp;<font color = "black">1</font><font color = "silver">,</font>&nbsp;<font color = "black">0</font><font color = "maroon">)</font><font color = "maroon">)</font>&nbsp;<font color = "black">5</font><font color = "maroon">_stars</font>
                              <br/><font color = "blue">FROM</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color = "maroon">reviews</font>
                              <br/><font color = "blue">WHERE</font>&nbsp;&nbsp;&nbsp;&nbsp;<font color = "maroon">product_category</font>&nbsp;<font color = "silver">=</font>
                              <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color = "maroon">(</font>
                              <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color = "blue">SELECT</font>&nbsp;<font color = "maroon">product_category</font>
                              <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color = "blue">FROM</font>&nbsp;&nbsp;&nbsp;<font color = "maroon">reviews</font>
                              <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color = "blue">WHERE</font>&nbsp;&nbsp;<font color = "maroon">product_id</font>&nbsp;<font color = "silver">=</font>&nbsp;<font color = "red">'B00CXSISJW'</font>&nbsp;<font color = "maroon">limit</font>&nbsp;<font color = "black">1</font><font color = "maroon">)</font>
                              <br/><font color = "blue">GROUP</font>&nbsp;<font color = "blue">BY</font>&nbsp;<font color = "maroon">year</font><font color = "maroon">(</font><font color = "maroon">review_date</font><font color = "maroon">)</font><font color = "silver">,</font>
                              <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color = "maroon">month</font><font color = "maroon">(</font><font color = "maroon">review_date</font><font color = "maroon">)</font>
                              <br/><font color = "blue">ORDER</font>&nbsp;<font color = "blue">BY</font>&nbsp;<font color = "maroon">year</font><font color = "maroon">(</font><font color = "maroon">review_date</font><font color = "maroon">)</font><font color = "silver">,</font>
                              <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color = "maroon">month</font><font color = "maroon">(</font><font color = "maroon">review_date</font><font color = "maroon">)</font>
                              </font>
                           </td>
                        </tr>
                       
                     </tbody>
                  </table>
               </div>
               <div class="modal-footer">
                  <button type="button" onclick="closeModal()" class="btn btn-secondary" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
      </div>

</div>

</body>
</html>
