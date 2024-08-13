<?php
include("config/int.php");
include("config/conex.php");
include("helpers/func.php");
include("helpers/binary_func.php");
include("config/check_cookie.php");
$lang_ar = array("cn","pt", "es","fr");
$path_urls = get_path();
$path = $path_urls['call_parts'][0];
$pages_array = array('dashboard', 'statistics', 'plans', 'withdraw', 'transfer', 'refferal-commission', 'binary-commission', 'admin-withdraw', 'manage', 'buy-plan', 'binary-tree', 'user-detail', 'user-list', 'kyc-application', 'ico-distribution', 'transactions', 'profile');
if(isset($path_urls['call_parts'][1])){
	header("Location:error");
	exit;
}
if($path == '' || in_array($path, $lang_ar)){
	$url = 'home.php';
}
elseif($path == 'error'){
	$url = 'error.php';
}
elseif($path == 'contact'){
	$url = 'contact.php';
}
elseif($path == 'about'){
	$url = 'about.php';
}
elseif($path == 'apply'){
	$url = 'apply.php';
}
elseif($path == 'test'){
	$url = 'test.php';
}
elseif($path == 'dashboard'){
	$url = 'dashboard.php';
}
elseif($path == 'taken'){
	$url = 'taken.php';
}
elseif($path == 'applied'){
	$url = 'applied.php';
}
elseif($path == 'admin'){
	$url = 'admin.php';
}
elseif($path == 'qualified'){
	$url = 'qualified.php';
}
elseif($path == 'failed'){
	$url = 'failed.php';
}
elseif($path == 'all'){
	$url = 'all.php';
}
elseif($path == 'no-test'){
	$url = 'no_test.php';
}
elseif($path == 'test-wait'){
	$url = 'test_wait.php';
}
elseif($path == 'user-dashboard'){
	$url = 'user_dashboard.php';
}
elseif($path == 'jobs'){
	$url = 'jobs.php';
}
elseif($path == 'quest'){
	$url = 'quest.php';
}
elseif($path == 'log-in' || $path == 'sign-up' || $path == 'reset-password'){
	if(isset($_SESSION['boss_user']) && isset($_SESSION['boss_type'])){
		header("Location:dashboard");
		exit;
	}
	$url = 'login.php';
}
elseif($path == 'send-confirm-email'){
	$url = 'send_register_email.php';
}
elseif($path == 'confirm-email'){
	$url = 'confirm_email.php';
}
elseif($path == 'logout'){
	$url = 'logout.php';
}
elseif(in_array($path, $pages_array)){
	include("config/check.php");
	if($path == 'dashboard'){
		$url = 'dashboard.php';
		$title = 'DASHBOARD';
	}
	elseif($path == 'statistics'){
		$url = 'statistics.php';
		$title = 'STATISTICS';
	}
	elseif($path == 'plans'){
		$url = 'plans.php';
		$title = 'PLANS';
	}
	elseif($path == 'transactions'){
		$url = 'transactions.php';
		$title = 'TRANSACTIONS';
	}
	elseif($path == 'profile'){
		$url = 'profile.php';
		$title = 'PROFILE';
	}
	elseif($path == 'transfer'){
		$url = 'transfer.php';
		$title = 'TRANSFER';
	}
	elseif($path == 'refferal-commission'){
		$url = 'commission.php';
		$title = 'COMMISSION';
	}
	elseif($path == 'binary-commission'){
		$url = 'binary_commission.php';
		$title = 'BINARY COMMISSION';
	}
	elseif($path == 'admin-withdraw'){
		$url = 'admin_withdraw.php';
		$title = 'ADMIN WITHDRAW';
	}
	elseif($path == 'user-list'){
		$url = 'user_list.php';
		$title = 'USER LIST';
	}
	elseif($path == 'manage'){
		$url = 'manage.php';
		$title = 'MANAGE';
	}
	elseif($path == 'buy-plan'){
		$url = 'buy_plan.php';
		$title = 'BUY PLAN';
	}
	elseif($path == 'binary-tree'){
		$url = 'binary_tree.php';
		$title = 'BINARY TREE';
	}
	elseif($path == 'kyc-thank-you'){
		$url = 'kyc_thank_you.php';
	}
	elseif($path == 'user-withdraws'){
		$url = 'admin_withdrawals.php';
	}
	elseif($path == 'withdraw'){
		$url = 'withdraw.php';
		$title = 'WITHDRAW';
	}
	elseif($path == 'manage'){
		$url = 'manage.php';
	}
}
else{
	header("Location:error");
	exit;
}
?>