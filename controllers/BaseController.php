<?php

namespace app\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\base\Model;
use app\models\signupForm;
use app\models\db;
use app\models\table;


class BaseController extends Controller
{
	public function actionIndex(){
		$db = new db("products","127.0.0.1","root",'');

		$products = new table($db->getDb(),"products");
		$products->columns("id int(11) AUTO_INCREMENT PRIMARY KEY");
  		$products->columns("image text not null");
		$products->columns("SKU varchar(255) not null");
		$products->columns("name varchar(255) not null");
		$products->columns("count int(11)");
		$products->columns("type varchar(255) not null");
		$products->keys("name");
		$products->keys("SKU");
		$products->create();

		$usersTable = new table($db->getDb(),"usersTable");
    	$usersTable->columns("id int(11) AUTO_INCREMENT PRIMARY KEY");
    	$usersTable->columns("username varchar(255) not null");
    	$usersTable->columns("password varchar(255)");
    	$usersTable->create();

		return $this->render("index",compact('products','usersTable'));
	}

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }


    public function actionLogout()
    {
        Yii::$app->user->logout();
    }

    public function actionSignup()
    {
    	if(!Yii::$app->user->isGuest) {
    		return $this->goHome();
    	}

    	$this->enableCsrfValidation = false;


    	$db = new db("products","127.0.0.1","root",'');
    	$usersTable = new table($db->getDb(),"usersTable");
    	$usersTable->columns("id int(11) AUTO_INCREMENT PRIMARY KEY");
    	$usersTable->columns("username varchar(255) not null");
    	$usersTable->columns("password varchar(255)");
    	$usersTable->create();

    	return $this->render("signup",compact('db','usersTable'));
    }


}