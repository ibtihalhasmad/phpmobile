<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}
    include_once("dbconnect.php");
    if(isset($_POST['email']) ||  isset($_POST['name']) || isset($_POST['phone'])  || isset($_POST['homeaddress']) || isset($_POST['password']) || isset($_POST['gender'])  ){
    $email         =  $_POST['email'];
    $password      =  sha1($_POST['password']);
    $name          = $_POST['name'];
    $phone         = $_POST['phone'];
    $homeaddress   = $_POST['homeaddress'];
    $base64Image   = $_POST['image'];
    $gender        = $_POST['gender'];

    $sqlinsert ="INSERT INTO `mytutormobile`(`user_email`,`user_password`, `user_name`, `user_phone`, `user_homeaddress`, `user_gender`)
 VALUES ('$email','$password','$name','$phone','$homeaddress','$gender')";
    if ($conn->query($sqlinsert) === TRUE) {
        $response = array('status' =>'status','data' =>null);
        $filename = mysqli_insert_id($conn);
        $decoded_string = base64_decode($base64Image);
        $path = '../assets/users/' . $filename . '.jpg';
        $is_written = file_put_contents($path, $decoded_string);
        sendJsonResponse($response);
    } else {
        $response = array('status' => 'failed', 'data' => null);
        sendJsonResponse($response);
    }
    $result      = $conn->query($sqllogin);
    $numrow      = $result->num_rows;
    if ($numrow > 0) {

        while ($row = $result->fetch_assoc()) {
            $user['id'] = $row['user_id'];
            $user['email'] = $row['user_email'];
            $user['name'] = $row['user_name'];
            $user['phone'] = $row['user_phone'];
            $user['address'] = $row['user_homeaddress'];
            $user['image'] = $row['user_image'];
            $user['gender'] = $row['user_gender'];
            $user['BOD'] = $row['user_BOD'];
        }
        $response = array('state'=>'success', 'data'=>$user);
        sendJasonResponse($response);
    }
    function sendJasonResponse($sendArray){
        header('Content-Type: application/json');
        echo json_encode($sendArray);
    }
            

    }
?>
