<?php 
require_once("db.php");
require_once("table.php");

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

//print_r($_POST);
if($usersTable->select("COUNT(*) as count",10,"username = '{$_COOKIE['user']}'")['count'] == 1){
		if($_POST['title'] != $_POST['oldtitle'] && $products->select("COUNT(*) as count",10,"name='{$_POST['title']}'")['count'] != 0){
			print "titleError";
			exit();
		}
		if($_POST['isChangeIMage'] == "false"){
		    try{
		        $products->update(
			     "name,type,count,SKU","'{$_POST['title']}'".","."'{$_POST['type']}'".",".$_POST['count'].","."'{$_POST['SKU']}'","name = '{$_POST['oldtitle']}'"); 
		    }catch(PDOexception $e){
		        
		    }
			

		}elseif($_POST['isChangeIMage'] == "true"){
			$newName = time()+mt_rand(0,100);
			try{
				$encodedData = explode(",",$_POST['image']);
				$encodedData = str_replace(' ', '+', $encodedData[1]);
				$decocedData = base64_decode($encodedData);
				file_put_contents("assets/productsImage/".$newName.".webp",$decocedData);
					$products->update(
				"name,type,count,SKU,image","'{$_POST['title']}'".","."'{$_POST['type']}'".",".$_POST['count'].","."'{$_POST['SKU']}'".","."'{$newName}'","name = '{$_POST[	'oldtitle']}'");
			}catch(PDOexception $e){
			 print "error";   
			 exit();
			}
		}	
	}
	if(isset($_COOKIE['offset'])){
	    $ofs = $_COOKIE['offset'];
	}else{ $ofs = 5;};

$page = $_POST['page'];
if($page == 1){
	$start = 0;
}else{
	$start = ($page-1)*$ofs;
}
foreach($products->select("*",1,false,"id LIMIT {$start},{$ofs}") as $Allproducts){?>
	<div class="Oneproduct">
		<div class="point" style="display: flex;" ><input type="checkbox" value="<?=$Allproducts['name']?>" name="chosenForDel[]"></div>
		<div class="productOneimage"><img class="productOneimageImg" src="assets/productsImage/<?= $Allproducts['image']?>.webp"></div>
		<div class="productOnename"><?= $Allproducts['name']?></div>
		<div class="productOneSKU"><?= $Allproducts['SKU']?></div>
		<div class="productOnetype"><?= $Allproducts['type']?></div>
		<div class="productOnecount"><?= $Allproducts['count']?></div>
		<div class="changeproduct" style="display: flex;"><img src="\assets\images\wrench.webp"></div>
	</div>
<?php }?>
