<html>
	<head>
		
		<title>JISQL - DBMS Simple</title>
		<link rel="icon" type="image/x-icon" href="/jisql/assets/img/favicon.png">
		<!--  -->
		<link rel="stylesheet" href="/jisql/assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="/jisql/assets/css/style.css">
		<!--  -->
		<link rel="stylesheet" href="/jisql/assets/libs/fontawesome/css/all.min.css">
		<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500&display=swap" rel="stylesheet"> 
	</head>
	<body>

		<div id="app">
			<div class="row mt-3" style="margin:0">
				<div class="col-lg-8">
					<div class="card shadow border-0">
						<div class="card-body">

							<div class="form-group">
								<label for="host" class="font-weight-bold">HOST</label>
								<input type="text" class="form-control" name="host" id="host">
							</div>
							<div class="form-group row">
								<div class="col-lg-6">
									<label for="username" class="font-weight-bold">USERNAME</label>
									<input type="text" class="form-control" name="username" id="username">
								</div>
								<div class="col-lg-6">
									<label for="password" class="font-weight-bold">PASSWORD</label>
									<input type="text" class="form-control" name="password" id="password">	
								</div>
							</div>
							<div class="form-group">
								<label for="dbname" class="font-weight-bold">DB NAME</label>
								<input type="text" class="form-control" name="dbname" id="dbname">
							</div>

						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="card shadow border-0">
						<div class="card-body">
							<div class="form-group">
								<button class="btn btn-primary btn-block btn-test"><i class="fas fa-play"></i> Cek Hubungkan</button>
							</div>
							<div class="form-group">
								<button class="btn btn-success btn-block btn-execute"><i class="fas fa-paper-plane"></i> Execute</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row mt-4" style="margin:0">
				<div class="col-lg-12">
					<div class="card shadow border-0">
						<div class="card-body">
							<textarea name="query" id="query" cols="30" rows="10" class="form-control"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row mt-4 mb-5" style="margin:0">
				<div class="col-lg-12">
					<div class="card shadow border-0">
						<div class="card-body" id="result">
							
						</div>
					</div>
				</div>
			</div>
		</div>


		<!--  -->
		<script src="/jisql/assets/js/jquery-3.5.0.min.js"></script>
		<script src="/jisql/assets/js/bootstrap.min.js"></script>
		
		<script src="/jisql/assets/js/moment.min.js"></script>
		<script src="/jisql/assets/js/popper.min.js"></script>
		<!--  -->
		<script src="/jisql/assets/js/custom.js"></script>
		<script src="/jisql/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
		<script>
			$(document).ready(function(){
				// Execute
				$(".btn-execute").click((e)=>{
					e.preventDefault();
					var host = $("#host").val();
					var username = $("#username").val();
					var password = $("#password").val();
					var dbname = $("#dbname").val();
					var query = $("#query").val();
					$.ajax({
						url : "/jisql/ajax.php",
						type : "POST",
						dataType : "JSON",
						data : {
							request : 'execute',
							host : host,
							username : username,
							password : password,
							dbname : dbname,
							query : query
						},
						beforeSend : ()=>{
							$(".btn-execute").html("<i class='fas fa-spinner fa-spin'></i> Loading...").prop('disabled', true);
						},
						error : ()=>{
							$(".btn-execute").html("Error, Coba Lagi").prop('disabled', false);
						},
						success : (res)=>{
							$(".btn-execute").html("<i class='fas fa-paper-plane'></i> Execute").prop('disabled', false);
							
							var html = `

							<table class='table table-bordered'>
							 	<thead>

							`;
							var data = res.data;
							// $.each(data, function(index, value){
							// 	const unique = arr => [...new Set(arr)];
							// 	var keys = Object.keys(value);
							// 	var key  = unique(keys);


							// });
							for(var i = 0;i < data.length; i++){
								var keys = Object.keys(data[i]);
									if(keys){
										limitOne = keys;
										break;
									}
							}
							// var bagiProperty = limitOne.split(',');
							html 		+=
							`<tr>`;
							$.each(limitOne, function(index, value){
								html += `

								<th>${value}</th>

								`;
							});
							html 		+=
							`</tr></thead><tbody>`;
							var no = 0;
							for(var a = 0; a < data.length; a++){
								html 	+=
								`
								<tr>`;
								$.each(limitOne, function(index, value){
									html += `

									<td>${data[a][value]}</td>

									`;
								});
								html += `</tr>

								`;
							}
							html 		+=	`</tbody></table>`;

							console.log(limitOne);
							$("#result").html(html);
						}
					})


				});

				// Test
				$(".btn-test").click((e)=>{
					e.preventDefault();
					var host = $("#host").val();
					var username = $("#username").val();
					var password = $("#password").val();
					var dbname = $("#dbname").val();
					$.ajax({
						url : "/jisql/ajax.php",
						type : "POST",
						data : { 
							request : 'cek_connection',
							host : host,
							username : username,
							password : password,
							dbname : dbname
							},
						dataType : "JSON",
						beforeSend : ()=>{
							$(".btn-test").html('<i class="fas fa-spin fa-spinner"></i> Loading..').prop('disabled', true);
						},
						error : ()=>{
							$(".btn-test").html('Error, Coba Lagi').prop('disabled', false);
						},
						success : (res)=>{
							$(".btn-test").html('<i class="fas fa-play"></i> Cek Hubungkan').prop('disabled', false);
							if(res.status == true){
								Swal.fire(
								  res.message,
								  res.data,
								  'success'
								);
							}else{
								Swal.fire(
								  res.message,
								  res.data,
								  'error'
								);
							}
						}
					})
				})
			});
		</script>
	</body>
</html>