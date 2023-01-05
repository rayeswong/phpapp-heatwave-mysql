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
      
   </head>
   <body>
      <div class="container-fluid">
         <div class="row mt-4">
            <div class="col-md-10 productPageTitleClass" id="productPageTitle">
               <h2>rds_mysql_source_db</h2>
               <h5>Dataset: ecommerce product ratings</h5>
               <h5>Size: 2,218,487 rows</h5>
            </div>
            <div class="col-md-10" id="debugInfo">
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

 }

         // $.ajax({
         // 	type: "GET",
         // 	url: "getHeaderInfo.php",
         // 	success: function(result) {
         // 		$("#productPageTitle").html(result);
         //            $("#productPageTitle").html(result.html).removeClass("blurText");
         // 	}
         // });

         // $.ajax({
         // 	type: "GET",
         // 	url: "getHeatwaveStatus.php",
         // 	success: function(result) {
         // 		$("#productPageTitle").html(result);
         //            $("#productPageTitle").html(result.html).removeClass("blurText");
         // 	}
         // });
         
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
         MySQL Database Service (MDS) & Heatwave demo
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
                             <p> <span id='queryDuration'>'queryDuration'</span> seconds</p>
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
                              <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color = "blue">WHERE</font>&nbsp;&nbsp;<font color = "maroon">product_id</font>&nbsp;<font color = "silver">=</font>&nbsp;<font color = "red">'B0008G2WAW'</font>&nbsp;<font color = "maroon">limit</font>&nbsp;<font color = "black">1</font><font color = "maroon">)</font>
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
   </body>
</html>