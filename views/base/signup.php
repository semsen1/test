<?php 
if(isset($_POST['name']) && isset($_POST['password']) && !empty($_POST['name']) && !empty($_POST['password']) ){
	if($usersTable->select("COUNT(*) as count",10,"`username` = '{$_POST['name']}'")['count'] == 0 && $_POST['fType'] == "reg"){
		$usersTable->insert("username,password",$_POST['name'],password_hash($_POST['password'], PASSWORD_DEFAULT));
		$COOKIE['user'] = $_POST['name'];
		$options = array(
			'expires'=>strtotime("+1 week"),
			'path'=>'/',
			'httponly'=>true,
			'samesite' => 'Strict'
		);
		setcookie("user",$_POST['name'],$options);
		Yii::$app->response->redirect(['/base']);
	}elseif($usersTable->select("COUNT(*) as count",10,"`username` = '{$_POST['name']}'")['count'] == 1 && $_POST['fType'] == "sign"){
		if(password_verify($_POST['password'],$usersTable->select("password",10,"`username` = '{$_POST['name']}'")['password']) == 1){
			print "sfwafwqfwq";
			$COOKIE['user'] = $_POST['name'];
			$options = array(
				'expires'=>strtotime("+1 week"),
				'path'=>'/',
				'httponly'=>true,
				'samesite' => 'Strict'
			);
			setcookie("user",$_POST['name'],$options);
			Yii::$app->response->redirect(['/base']);
		}
	}else{
		$error = "Имя занято";
		print $error;
	} 
}else{
	$error = "Присутствуют пустые поля";
	print $error;
}
if(isset($_COOKIE['user'])){
	Yii::$app->response->redirect(['/base']);
}
?>
<meta name="csrf-param" content="_csrf">
<meta name="csrf-token" content="OTDOwBtYk-tsjYLIgTAXrqhKwU-WgneMk_TpFcbE6DwPCIu3XRPJhj202Jn0Z3TP4">
<?php 
use yii\bootstrap5\Html;
$this->title = 'signUp';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h2>Регистрация</h2>
    <form action="" method="POST" id="regForm" name="regForm">
    	<input type="text" placeholder="name" name="name">
    	<input type="password" data-st="hid" placeholder="пароль" name="password" id="userPass">
    	<span id="changePass" data-st="hid"><img id="passeye" src="/assets/images/openEYE.webp" alt=""></span>
    	<input type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
    	<input type="hidden" name="fType" id="fType">
    	<button type="submit" name="sig" value="sig" id="signB">Вход</button>
    	<button type="submit" name="reg" value="reg" id="regB">Регистрация</button>
    </form>
    <div id="signError"><span id="signErrorMark">!</span><span id="signErrorText"></span></div>
</div>
