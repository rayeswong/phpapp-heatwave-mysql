<!doctype html>
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
        <!-- <script src="https://mysql.withoracle.cloud/demos/hw/rc/scripts.js"></script> -->
        <link rel="stylesheet" href="./src/style.css">

        <!-- Chart.js -->
        <script src="./src/Chart.bundle.min.js"></script>

        <!-- highlight -->
        <link rel="stylesheet" href="./src/default.min.css">
        <script src="./src/highlight.min.js"></script>

        <!-- https://github.com/alrusdi/jquery-plugin-query-object -->
        <script src="./src/jquery.query-object.js"></script>

        <title>MySQL Heatwave Demo</title>
 </head>

<body>
        <div class="container-fluid">
                <div class="row mt-4">
                        <div class="row offset-md-10"></div>
                        <div class="row col-md-2"><button type="button" class="btn btn-success btn-lg" id="productPage">Open Product Page</button></div>
                </div>
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
                MySQL Database Service (MDS) & Heatwave demo
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
</body>
</html>
