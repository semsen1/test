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

if(isset($_POST['searchQ'])){

	foreach($products->select("*",1,"name = '{$_POST['searchQ']}' OR SKU = '{$_POST['searchQ']}'") as $find){?>
		<div class="Oneproduct">
			<div class="point" style="display:flex;"><input type="checkbox" value="<?=$find['name']?>" name="chosenForDel[]"></div>
			<div class="productOneimage"><img class="productOneimageImg" src="assets/productsImage/<?= $find['image']?>.webp"></div>
			<div class="productOnename"><?= $find['name']?></div>
			<div class="productOneSKU"><?= $find['SKU']?></div>
			<div class="productOnetype"><?= $find['type']?></div>
			<div class="productOnecount"><?= $find['count']?></div>

			<div id="controlFind">
				<div id="ChangeFind">
					<div type="submit" class="ChangeFindF">Редактировать</div>
				</div>

			</div>
		</div>
	<?}

}