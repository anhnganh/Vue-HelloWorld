<?php
 include "./db.php";
 if (isset($_SERVER['HTTP_ORIGIN'])) {
	// Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
	// you want to allow, and if so:
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 1000');
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
			// may also be using PUT, PATCH, HEAD etc
			header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
	}

	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
			header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");
	}
	exit(0);
}

// $res = array('error' => false);
$action='';
if (isset($_GET['action'])) {
	$action=$_GET['action'];
}

if($action=='list'){
    // $name = $_POST['name'];
    // $score =$_POST['score'];
    $sql = "SELECT   * FROM `user` ORDER BY score desc limit 10";
    $result = $conn->query($sql);
    $num = mysqli_num_rows($result);
    $userData = array();
    if($num>0){
        while($row=$result->fetch_assoc()){
            array_push($userData, $row);
        }
        // $res['error'] = false;
        $res['user']=$userData;
    }else{
		$res['error']=false;
        $res['message']="No Data Found!";
    }
    echo json_encode([$res]);
    }else if($action=="insert"){

    $name = $conn->real_escape_string($_REQUEST['name']);
    $score= $conn->real_escape_string($_REQUEST['score']);
    $sql = "INSERT INTO `user`(`name`,`score`) VALUES ('$name','$score')";
    $result=$conn->query($sql);
    if($result===true){
		$res['error']=false;
        $res['message']="User Added Successfully";
	}else{
		$res['error']=true;
        $res['message']="Somthing Went Wrong";
    }
    echo json_encode($res);
}
    $conn->close();
    header("Content-type: application/json");
    die();
?>