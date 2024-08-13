
<?php
// GET URL
function get_path(){
	$path = array();
	if(isset($_SERVER['REQUEST_URI'])){
		$request_path = explode('?', $_SERVER['REQUEST_URI']);
		
		$path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
		$path['call_utf8'] = substr(urldecode($request_path[0]), strlen($path['base']) + 1);
		$path['call'] = utf8_decode($path['call_utf8']);
		if($path['call'] == basename($_SERVER['PHP_SELF'])){
			$path['call'] = '';
		}
		$path['call_parts'] = explode('/', $path['call']);
		
		$path['query_utf8'] = urldecode($request_path[0]);
		$path['query'] = utf8_decode(urldecode($request_path[0]));
		$vars = explode('&', $path['query']);
		foreach ($vars as $var) {
			$t = explode('=', $var);
			$path['query_vars'][$t[0]] = $t[0];
		}
	}
	return $path;
}
function redirect($page, $method = true){
	if($method){
		return header("Location:".$page);
	}else{
		echo '<script>window.location.href="'.$page.'";</script>';
	}
} 

// ENCRYPT OR DECRYPT CLASS

function create_payment_invoice($receive_url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $receive_url);
	$ccc = curl_exec($ch);
	$json = json_decode($ccc, true);
	//on error the address in not sent back
	if(!isset($json['address'])){
		//failed reponse from CURL has [message] ,[description]
		return array('status' => FALSE,'response' => $json['message']." - ".$json['description']);
	}else{
		//valid reponse from CURL has [address], [index],[callback]
		return array('status' => TRUE,'response' => $json['address']);
	}
} 
// HOURS 
function differenceInHours($startdate,$enddate){
	$starttimestamp = strtotime($startdate);
	$endtimestamp = strtotime($enddate);
	$difference = abs($endtimestamp - $starttimestamp)/3600;
	return $difference;
}
// CLEAN INPUT DATA

function clean($dirty){
	$dirty = trim($dirty);
	$dirty = stripcslashes($dirty);
	$dirty = strip_tags($dirty);
	return $dirty;
}

// ENCRYPT OR DECRYPT CLASS

class SA_Encryption{
 
    const OPEN_SSL_METHOD = 'aes-256-cbc';
    // Generate a 256-bit encryption key
    const BASE64_ENCRYPTION_KEY = 'G1fM0aXhguJ5tVaqVMJOVHB+Jk6QFd99FgkfAcEgwjI';//base64_encode(openssl_random_pseudo_bytes(32));
    const BASE64_IV = 'xIkaHuquZFjtP4SI4mIyOg';//base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length(AES_256_CBC)));
 
    static private function base64_url_encode($input) {
        return strtr(base64_encode($input), '+/=', '-_,');
    }
 
    static private function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_,', '+/='));
    }
 
 
    static function encrypt_to_url_param($message){
        $encrypted = openssl_encrypt($message, self::OPEN_SSL_METHOD, base64_decode(self::BASE64_ENCRYPTION_KEY), 0, base64_decode(self::BASE64_IV));
        $base64_encrypted = self::base64_url_encode($encrypted);
        return $base64_encrypted;
    }
 
    static function decrypt_from_url_param($base64_encrypted){
        $encrypted = self::base64_url_decode($base64_encrypted);
        $decrypted = openssl_decrypt($encrypted, self::OPEN_SSL_METHOD, base64_decode(self::BASE64_ENCRYPTION_KEY), 0, base64_decode(self::BASE64_IV));
        return $decrypted;
    }
}
// side column
function get_column($side){
	if($side == 'L'){
		return 'LEFT_SIDE';
	}
	elseif($side == 'R'){
		return 'RIGHT_SIDE';
	}
}
function user_status($status){
	if($status == 0){
		return 'CV APPLIED';
	}
	elseif($status == 1){
		return 'NO TEST';
	}
	elseif($status == 2){
		return 'TEST QUALIFIED';
	}
	elseif($status == 3){
		return 'TEST TAKEN';
	}
	elseif($status == 4){
		return 'FAILED TEST';
	}
	elseif($status == 5){
		return 'JOB QUALIFIED';
	}
}
function user_job($conex, $job){
	$sql = $conex->query("SELECT * FROM jobs WHERE CODE = '$job'");
	$data = $sql->fetch_assoc();
	return $data['TITLE'];
}
function job_status($status){
	if($status == 0){
		return 'Inactive';
	}elseif ($status == 1) {
		return 'Active';
	}
}
// get_binary_users
function get_binary_users($conex, $user_code){
	$sql = $conex->query("SELECT * FROM user_tree WHERE USER_CODE = '$user_code'");
	$user_data = $sql->fetch_assoc();
	$data['LEFTY'] = $user_data['LEFT_SIDE']; 
	$data['RIGHTY'] = $user_data['RIGHT_SIDE']; 
	return $data;
}
// single_user_data
function single_user_data($conex, $user_code){
	$sql = $conex->query("SELECT * FROM users WHERE CODE = '$user_code'");
	$user_data = $sql->fetch_assoc();
	return $user_data;
}
//$message = 'tehseeniqbal9090@gmail.com';
//$param = SA_Encryption::encrypt_to_url_param($message);
 
 //echo $param.'<br>';
//==== for receiving param ====
 
//$message = SA_Encryption::decrypt_from_url_param($param);
//echo $message.'<br>';exit;
// FILE IS A IMAGE
// encrypt
function base64_url_encode($input){
	return rtrim(strtr(base64_encode($input), '+/=', '-_,'),',');
}
// decrypt
function base64_url_decode($input){
	return base64_decode(strtr($input.',', '-_,', '+/='));
}
// check image file
function is_image($path){
    $a = getimagesize($path);
    $image_type = $a[2];
     
    if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
    {
        return true;
    }
    return false;
}
// binary position
function get_pos($pos){
	if($pos == 'R'){
		return 'RIGHT';
	}
	elseif($pos == 'L'){
		return 'LEFT';
	}
}
// user status
function get_status($status){
	if($status == 0){
		return 'UNVERIFIED';
	}
	elseif($status == 1){
		return 'Active';
	}
	elseif($status == 2){
		return 'Blocked';
	}
	elseif($status == 3){
		return 'Suspend';
	}
	elseif($status == 4){
		return 'Precious';
	}
}
// transaction status
function get_txn_type($status){
	if($status == 1){
		return 'PLAN';
	}
	elseif($status == 2){
		return 'REFFERAL';
	}
	elseif($status == 3){
		return 'BINARY';
	}
	elseif($status == 4){
		return 'ROI';
	}
	elseif($status == 5){
		return 'RANK';
	}
	elseif($status == 6){
		return 'WITHDRAW';
	}
}
function get_q_list($conex, $user_code){
	$q = '';
	$query = $conex->query("SELECT * FROM result WHERE USER_CODE = '$user_code'");
	while($data = $query->fetch_assoc()){
		$q .= $data['QUEST_CODE'].',';
	}
	$q_list = substr($q, 0, -1);
	return $q_list;
}
?>