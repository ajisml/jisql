<?php 

// Connect



if(isset($_POST['request'])){
	$request 				=	$_POST['request'];
	$host 					=	$_POST['host'];
	$username 				=	$_POST['username'];
	$password 				=	$_POST['password'];
	$dbname 				=	$_POST['dbname'];
	if($request == "cek_connection"){
		if(!empty($host) || !empty($username)){

			
			if(!empty($dbname)){
				$conn 				=	mysqli_connect($host,$username,$password,$dbname);
			}else{
				$conn 				=	mysqli_connect($host,$username,$password);
			}
			if(mysqli_connect_errno()){
				$json 				=
				[
					'status' 		=> false,
					'message' 		=> 'Failed',
					'data' 			=> 'Gagal, Silahkan Cek Host,Username/Password'
				];
			}else{
				$json 				=
				[
					'status' 		=> true,
					'message' 		=> 'Successfully',
					'data' 			=> 'Berhasil Terhubung Ke Database'
				];
			}
			echo json_encode($json);
		}
	}elseif($request == "execute"){


		if(!empty($host) || !empty($username)){


			if(!empty($dbname)){
				$conn 				=	mysqli_connect($host,$username,$password,$dbname);
			}else{
				$conn 				=	mysqli_connect($host,$username,$password);
			}

			if(mysqli_connect_errno()){
				$json 				=
				[
					'status' 		=> false,
					'message' 		=> 'Failed',
					'data' 			=> 'Gagal, Silahkan Cek Host,Username/Password'
				];
			}else{
				
				$query 				=	$_POST['query'];
				if(!empty($query)){

					$command 		=	mysqli_query($conn, $query);
						while ($data = mysqli_fetch_assoc($command)) {
				            $array[] = $data;
				        }
						if(!empty($array)){
							$json 				=
							[
								'status' 		=> true,
								'message' 		=> 'Successfully',
								'data' 			=> $array
							];
						}else{
							$json 				=
							[
								'status' 		=> false,
								'message' 		=> 'Failed',
								'data' 			=> 'Query SQL Salah/Tidak ditemukan'
							];
						}

				}else{
					$json 				=
					[
						'status' 		=> false,
						'message' 		=> 'Failed',
						'data' 			=> 'Form query wajib diisi'
					];	
				}

			}
		}else{
			$json 				=
			[
				'status' 		=> false,
				'message' 		=> 'Failed',
				'data' 			=> 'Host & Username wajib diisi'
			];
		}
		echo json_encode($json);


	}else{

	}
}

