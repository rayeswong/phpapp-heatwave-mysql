
<!doctype html>
<html>
 <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

	<link rel="icon" type="image/png" href="./img/mysqlIcon.png" />

	<!-- JQuery js and css -->
	<script src="./src/jquery-3.5.1.min.js"></script>

	<!-- Bootstrap 4.0 js and css -->
	<link rel="stylesheet" href="./src/bootstrap.min.css">
	<script src="./src/bootstrap.min.js"></script>
	<script src="./src/popper.js"></script>

	<!-- Our js and styles (if any) -->
	<script src="./src/scripts.js?v=87506"></script>
	<link rel="stylesheet" href="./src/style.css?v=42218">

	<!-- Chart.js -->
	<script src="./src/Chart.bundle.min.js"></script>

	<!-- highlight -->
	<link rel="stylesheet" href="./src/highlight/default.min.css">
	<script src="./src/highlight/highlight.min.js"></script>

	<!-- https://github.com/alrusdi/jquery-plugin-query-object -->
	<script src="./src/jquery.query-object.js"></script>

	<title>MySQL Heatwave Demo</title>
 </head>

<body>
	<div class="container-fluid">
		<div class="row mt-4">
			<div class="col-md-10 productPageTitleClass blurText" id="productPageTitle">
			</div>
			<div class="col-md-2">
										<button type="button" class="btn btn-danger btn-lg" id="HW" value="0">HW Disabled</button>
							</div>
		</div>

		<div class="row mt-4">
			<div class="col-md-6">
				<div class="card">
					<div class="card-body" id="cardGraph1">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="footer">
		MySQL Database Service (MDS) & Heatwave demo by Ronen Baram 2022
	</div>

	<!-- Modal -->
	<div class="modal" tabindex="-1" role="dialog" id="modal">
		<div class="modal-dialog" role="document" style="max-width: 90%">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Query information</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="modalBody">
                    
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</body>

<script type="text/javascript">
	$.ajax({
		type: "POST",
		url: "./src/ajax.php?productPageTitleInit",
		data: {
			productID: "31b2dbaf-"
		},
		success: function(result) {
			$("#productPageTitle").html(result.html);
			// $('#queryStatsTable tr:last').after(result.queryStats);
			$.ajax({
				type: "POST",
				url: "./src/ajax.php?productPageTitle",
				data: {
					productID: "31b2dbaf-"
				},
				success: function(result) {
					$("#productPageTitle").html(result.html).removeClass("blurText");
					// $('#queryStatsTable tr:last').after(result.queryStats);
				}
			})
		}
	});

	var graph = [];
	var graphsComplete = 0;
	drawGraphAjax(1, '31b2dbaf-', $("#HW").attr("value"));

	$("#HW").on('click', function(){
		if ($("#HW").attr("value") == 0) {
			window.location.search = jQuery.query.set("HW", 1);
		} else {
			window.location.search = jQuery.query.set("HW", 0);
		}
	});
</script>