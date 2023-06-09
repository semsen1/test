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


if(isset($_POST['title']) && isset($_POST['type']) && isset($_POST['count']) && isset($_POST['SKU'])
&& $usersTable->select("COUNT(*) as count",10,"username = '{$_COOKIE['user']}'")['count'] == 1){
	if($products->select("COUNT(*) as count",10,"name='{$_POST['title']}'")['count'] == 0){
		try{
			$newName = time()+mt_rand(0,100);
			if(isset($_POST['image']) && !empty($_POST['image'])){
				$encodedData = explode(",",$_POST['image']);
				$encodedData = str_replace(' ', '+', $encodedData[1]);
				$decocedData = base64_decode($encodedData);
				file_put_contents("assets/productsImage/".$newName.".webp",$decocedData);
				$products->insert("image,SKU,name,count,type",$newName,$_POST['SKU'],$_POST['title'],$_POST['count'],$_POST['type']);
			}else{
				$products->insert("image,SKU,name,count,type","empty",$_POST['SKU'],$_POST['title'],$_POST['count'],$_POST['type']);
			}
		}catch(PDOexception $e){
			print "error";
		}
	}elseif($products->select("COUNT(*) as count",10,"name='{$_POST['title']}'")['count'] != 0){
		print "nameerror";
		exit();
	}else{
		print "error";
	}	
}

if(isset($_POST['first'])){
    exit();
}

if(isset($_COOKIE['offset'])){
	$offset1 = $_COOKIE['offset'];
}else{
	$offset1 = 5;
} 
$allPages = ceil($products->select("COUNT(*) as count",10)['count'] / $offset1);

if(isset($_COOKIE['offset'])){
    $ofs = $_COOKIE['offset'];
}else{$ofs = 5;}

$page = $_POST['page'];
if($page == 1){
	$start = 0;
}else{
	$start = ($page-1)*$ofs;
}
if(isset($_COOKIE['imageSize']) && !empty($_COOKIE['imageSize'])){
	$imageSize  = "style=\"width:".$_COOKIE['imageSize']."px;\"";
	$imageSizeN = "value=\"".$_COOKIE['imageSize']."\"";
}else{
	$imageSize='';
	$imageSizeN = "value=\"30\"";
}

if($allPages > $_POST['Apages']){?>
	<div style="display:none;" id="newAllPage"><?php print $allPages;?></div>
<?php }
foreach($products->select("*",1,false,"id LIMIT {$start},{$ofs}") as $Allproducts){?>
	<div class="Oneproduct">
		<div class="point"><input type="checkbox" value="<?=$Allproducts['name']?>" name="chosenForDel[]"></div>
		<div class="productOneimage">
			<img <?php print $imageSize?> class="productOneimageImg" src="assets/productsImage/<?= $Allproducts['image']?>.webp">
		</div>
		<div class="productOnename"><?= $Allproducts['name']?></div>
		<div class="productOneSKU"><?= $Allproducts['SKU']?></div>
		<div class="productOnetype"><?= $Allproducts['type']?></div>
		<div class="productOnecount"><?= $Allproducts['count']?></div>
		<div class="changeproduct"><img src="assets\images\wrench.webp"></div>
	</div>
<?php }?>
