<?php 
	if(isset($_POST['chosenForDel']) && $usersTable->select("COUNT(*) as count",10,"username = '{$_COOKIE['user']}'")['count'] == 1 ){
		foreach ($_POST['chosenForDel'] as $delItem) {
			if($products->select("image",10,"name = '{$delItem}'")['image'] != "empty")
			@unlink("assets/productsImage/".$products->select("image",10,"name = '{$delItem}'")['image'].".webp");
			$products->delete("name = '{$delItem}'");
			
		}
		return Yii::$app->response->redirect(['base/index', 'id' => ""]);
	}

	if(isset($_POST['newCount']) && isset($_POST['newCountS']) && $usersTable->select("COUNT(*) as count",10,"username = '{$_COOKIE['user']}'")['count'] == 1 ){
		$_COOKIE['offset'] = $_POST['newCount'];
		$options = array(
			'expires'=>strtotime("+1 week"),
			'path'=>'/',
			'httponly'=>true,
			'samesite' => 'Strict'
		);
		setcookie("offset",$_POST['newCount'],$options);
		return Yii::$app->response->redirect(['base/index', 'id' =>'']);
	}
	if(!isset($_COOKIE['user']) || empty($_COOKIE['user'])){
	?>

    <div id="loginEmerg">
    	Для просмотра и редактирования товаров необходимо войти!
    </div>
<?php }else{

	if($usersTable->select("COUNT(*) as count",10,"username = '{$_COOKIE['user']}'")['count'] == 1){
		if(isset($_GET['page'])){
			$page = $_GET['page'];
		}else{
			$page = 1;
		}

		if(isset($_COOKIE['offset'])){
			$offset1 = $_COOKIE['offset'];
		}else{
			$offset1 = 5;
		} 
	
		$allPages = ceil($products->select("COUNT(*) as count",10)['count'] / $offset1);
		if($page < 1){
			$page = $allPages;
		}elseif($page > $allPages){
			$page = 1;
		}

		if($products->select("COUNT(*) as count",10)['count']  == 0){?>
			<div id="addFirstG">Добавить первый товар</div>
			<div id="allproductsCont"></div>
			<input type="hidden" id="pageH" value="<?=$page?>">
		<?php }else{?>
			<div >
				<div style="display:none;" id="curDocPages"><?php print $allPages;?></div>
				<input type="hidden" id="pageH" value="<?=$page?>">
				<form action="" method="POST" name="updateGF" id="updateG" enctype="multipart/form-data" style="transform:translate(0px,0px);">
					<div id="UpdateError"></div>
					<div id="movelockUpdate" data-st="lock"><img src="assets\images\lock.webp"></div>
					<div id="closeupdateG"><img src="assets\images\close.webp"></div>
					<input type="text" placeholder="Название" name="title">
					<input type="hidden" name="oldtitle" id="oldtitle">
					<input type="text" placeholder="Тип" name="type">
					<input type="text" placeholder="Кол-Во" name="count">
					<input type="text" placeholder="SKU" name="SKU">
					<input type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
					<input type="file" id="ImgChange" name="preImgChange">
					<label for="ImgChange">Изображение</label>
					<input type="hidden" name="isChangeIMage" id="isChImg" value="false">
					<img src="" id="preImaChange">
					<button id="ChangeNewproduct" name="Change" value="1">Обновить</button>
				</form>
			</div>
			<?php 
				if(isset($_COOKIE['imageSize']) && !empty($_COOKIE['imageSize'])){
					$imageSize  = "style=\"width:".$_COOKIE['imageSize']."px;\"";
					$imageSizeN = "value=\"".$_COOKIE['imageSize']."\"";
				}else{
					$imageSize='';
					$imageSizeN = "value=\"30\"";
				}
				if(isset($_COOKIE['tableStatus']) && !empty($_COOKIE['tableStatus'])){
					$one='';
					$two='';
					$three='';
					$four='';
					$five='';

					if($_COOKIE['tableStatus'][0] == 1){
						$one = "checked";
					}
					if($_COOKIE['tableStatus'][1] == 1){
						$two = "checked";
					}
					if($_COOKIE['tableStatus'][2] == 1){
						$three = "checked";
					}
					if($_COOKIE['tableStatus'][3] == 1){
						$four = "checked";
					}
					if($_COOKIE['tableStatus'][4] == 1){
						$five = "checked";
					}
				}else{
					$one = "checked";
					$two = "checked";
					$three = "checked";
					$four = "checked";
					$five = "checked";
				}
			?>
			<div id="choseColumns">
				<div id="visimgL"><input type="checkbox" id="visimgLC" <?= $one?> ></div>
				<div id="visnamel"><input type="checkbox" id="visnamelC" <?= $two?> ></div>
				<div id="visSKUL"><input type="checkbox" id="visSKULC" <?= $three?> ></div>
				<div id="visTypel"><input type="checkbox" id="visTypelC" <?= $four?> ></div>
				<div id="viscountl"><input type="checkbox" id="viscountlC" <?= $five?> ></div>
			</div>

			<div id="GoddsHeaders">
				<div id="delCheck"><img src="assets\images\trash.webp"></div>
				<div id="imgL" class="topH" <?php print $imageSize?>>
					<img src="assets\images\image.webp" >
				</div>
				<div id="namel" class="topH">Наименование</div>
				<div id="SKUL" class="topH">SKU</div>
				<div id="Typel" class="topH">Тип</div>
				<div id="countl" class="topH">кол-во</div>
			</div>
			<div id="allproducts">
				<div id="settings" data-st="hid"><img src="assets\images\gear.webp" alt=""></div>
				<div id="search" data-st="hid"><img src="assets\images\glass.webp" alt=""></div>
				<form action="" id="ChoseCount" method="POST">
					<input type="text" placeholder="кол-во записей" name="newCount">
					<input type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
					<button type="submit" name="newCountS" value='1'>Задать</button>
				</form>
				<div id="SoSettings">
					<input type="range" id="imageSize"
        			 	min="30" max="70" <?php print $imageSizeN?>>
        			 <br>
  					<label for="volume">Размер изображений</label>
				</div>
				<div id="searchForm" style="transform:translate(0px,0px);">
					<div id="closeupdateGFind"><img src="assets\images\close.webp"></div>
					<div id="movelock" data-st="lock"><img src="assets\images\lock.webp"></div>
					<form action="" id="searchF">
						<input id="tokenC" type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
						<input type="text" name="searchQ" placeholder="SKU или Название">
						<button type="submit">Найти</button>
					</form>
					<form action="" method="POST">
						<input id="tokenC" type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
						<div id="finded">
							
						</div>
						<button type="submit" id="delFind">Удалить</button>
					</form>
				</div>
				<form action="" id="points" method="POST">
				<input type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
				<?php 
				if(isset($_COOKIE['offset'])){
				    $ofs = $_COOKIE['offset'];
				}else{
					$ofs = 5;
				}
			
				if($page == 1){
					$start = 0;
				}else{
					$start = ($page-1)*$ofs ;
				}?>
				<div id="allproductsCont">
				<?php foreach($products->select("*",1,false,"id LIMIT {$start},{$ofs}") as $Allproducts){?>
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
				</div>
			</form>
				<div id="pages">
					<div id="PrevPage">
					<?php if($page == 1){?>
						<span class="notActive">
							<<
						</span>	
					<?php }else{?>
						<a href="base?page=<?php print $page-1?>">
							<<
						</a>
					<?php }?>
					</div>
					<div id="pagesButtons">
					<?php
						for($i=1;$i<=$allPages;$i++){
							if($i == $page){?>
								<span class="CurrentPage">
									<?php print $i;?>
								</span>
							<?php }else{?>
								<a href="base?page=<?php print $i?>" class="pageButton">
									<?php print $i;?>
								</a>
							<?php }
						}
					?>
					</div>
					<div id="NextPage">
						<?php if($page == $allPages){?>
						<span class="notActive">
							>>
						</span>	
					<?php }else{?>
						<a href="base?page=<?php print $page+1?>">
							>>
						</a>
					<?php }?>
					</div>
				</div>
				<div id="chosePageA">
					<input type="text" id="InputPage" placeholder="Стр">
					<a href="base?page=1" id="InputPageSun">Перейти</a>
				</div>
				<div id="addNewproductButton">Добавить Товар</div>
			</div>
			<?php 
	
		}

	?>
	
	<form action="" method="POST" id="newproduct" name="newproduct" data-st="hid" enctype="multipart/form-data">
		<div id="addError"></div>
		<div id="annproduct">Новый товар</div>
		<input type="text" placeholder="Название" name="title">
		<input type="text" placeholder="Тип" name="type">
		<input type="text" placeholder="Кол-Во" name="count">
		<input type="text" placeholder="SKU" name="SKU">
		<input type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
		<input type="file" name="GImage" id="loadfile">
		<label for="loadfile">Изображение</label>
		<img src="" id="preImage">
		<button id="addNewproduct">Добавить</button>

	</form>
<?php }else{?>
	<div id="loginEmerg">
    	Для просмотра и редактирования товаров необходимо войти!
    </div>
<?php }
} ?>

	
