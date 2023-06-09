<?php
if(isset($_GET['exit']) && $_GET['exit'] == "true"){
    $_COOKIE['user'] = '';
    $options = array(
        'expires'=>time()-100000,
        'path'=>'/',
        'httponly'=>true,
        'samesite' => 'Strict'
    );
    setcookie("user",'',$options);
    Yii::$app->response->redirect(['/base']);
}

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use app\models\db;
use app\models\table;

AppAsset::register($this);

if (class_exists('yii\debug\Module')) {
    $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
}

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

    $db = new db("products","127.0.0.1","root",'');

    $usersTable = new table($db->getDb(),"usersTable");
    $usersTable->columns("id int(11) AUTO_INCREMENT PRIMARY KEY");
    $usersTable->columns("username varchar(255) not null");
    $usersTable->columns("password varchar(255)");
    $usersTable->create();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="style.css">
    <meta id="param" name="csrf-param" content="_csrf">
    <meta id="token" name="csrf-token" content="OTDOwBtYk-tsjYLIgTAXrqhKwU-WgneMk_TpFcbE6DwPCIu3XRPJhj202Jn0Z3TP4">
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => "Товары",
        'brandUrl' => "/web/base",
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    if(!isset($_COOKIE['user'])){
      echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            Yii::$app->user->isGuest
                ? ['label' => 'Вход/Регистрация', 'url' => ['/base/signup']]
                : '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'nav-link btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
        ]
     ]);  
    }
    
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <?php 
        if(isset($_COOKIE['user']) && !empty($_COOKIE['user']) && $usersTable->select("COUNT(*) as count",10,"username = '{$_COOKIE['user']}'")['count'] == 1){?>
            <div id="userInf">
                <div id="userName">
                    <?= $_COOKIE['user']?>
                </div>
                <a id="exitUser" href="?exit=true">Выход</a>
            </div>
       <?php }elseif(isset($_COOKIE['user']) && $usersTable->select("COUNT(*) as count",10,"username = '{$_COOKIE['user']}'")['count'] != 1){
                $_COOKIE['user'] = '';
                $options = array(
                    'expires'=>time()-100000,
                    'path'=>'/',
                    'httponly'=>true,
                    'samesite' => 'Strict'
                );
                setcookie("user",'',$options);
                Yii::$app->response->redirect(['/base']);
             }
    ?>
    
    <div class="container">
        <?= $content ?>
    </div>
</main>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
