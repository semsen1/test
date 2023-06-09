
let regForm = document.getElementById("regForm");
let userPass = document.getElementById("userPass");
let changePass = document.getElementById("changePass");
let passeye = document.getElementById("passeye");

let cookies = document.cookie.split(";");
let tableStatus
let imageSizeP
if(cookies){
	cookies.forEach((item)=>{
		if(item.indexOf("tableStatus") != -1){
			tableStatus = item.replace(/tableStatus=/gi,'');
		}else if(item.indexOf("imageSize") != -1){
			imageSizeP = item.indexOf("imageSize");
		}
	})
	
	
}else{
	tableStatus = 11111;
}
let searchRStatus = 0;
let searchMove = 0;
let changeMove = 0;
let newImage = 0;

window.addEventListener("mouseup",()=>{
	searchMove = 0;
	changeMove = 0;
})

let searchFormM = document.getElementById("searchForm"); 

let updateGM = document.getElementById("updateG");

let curMouseX = 0;
let curMouseY = 0;

let curMouseXD = 0;
let curMouseYD = 0;

let movelock = document.getElementById("movelock");
let movelockUpdate = document.getElementById("movelockUpdate")

window.addEventListener("mousemove",(e)=>{

	if(searchMove == 1 && movelock.getAttribute("data-st") == "open"){

		let curposSezarch = searchFormM.style.transform.replace(/(translate\()|(\))|(px)|(\s?)/gi,'').split(",");
		let topS = Number(curposSezarch[1]);
		let leftS = Number(curposSezarch[0]);
		
		if(curMouseX == 0){
			curMouseX = e.clientX;
		}
		let xOfs = (curMouseX-e.clientX);
		if(e.clientX > curMouseX){
			searchFormM.style.transform = "translate("+(leftS-(xOfs))+"px,"+topS+"px)";
		}
		else if(e.clientX < curMouseX){
			searchFormM.style.transform = "translate("+(leftS-(xOfs))+"px,"+topS+"px)";
		}

		

		if(curMouseY == 0){
			curMouseY = e.clientY;
		}

		let yOfs = (curMouseY-e.clientY);

		if(e.clientY > curMouseY){
			searchFormM.style.transform = "translate("+(leftS)+"px,"+(topS-(yOfs))+"px)";
		}
		else if(e.clientY < curMouseY){
			searchFormM.style.transform = "translate("+(leftS)+"px,"+(topS-(yOfs))+"px)";
		}
			curMouseY = e.clientY;
			curMouseX = e.clientX;

	}

	if(changeMove == 1 && movelockUpdate.getAttribute("data-st") == "open"){
		let curposSezarch = updateGM.style.transform.replace(/(translate\()|(\))|(px)|(\s?)/gi,'').split(",");
		let topS = Number(curposSezarch[1]);
		let leftS = Number(curposSezarch[0]);



		if(curMouseXD == 0){
			curMouseXD = e.clientX;
		}
		let xOfs = (curMouseXD-e.clientX);
		if(e.clientX > curMouseX){
			updateGM.style.transform = "translate("+(leftS-(xOfs))+"px,"+topS+"px)";
		}
		else if(e.clientX < curMouseXD){
			updateGM.style.transform = "translate("+(leftS-(xOfs))+"px,"+topS+"px)";
		}

		

		if(curMouseYD == 0){
			curMouseYD = e.clientY;
		}

		let yOfs = (curMouseYD-e.clientY);

		if(e.clientY > curMouseYD){
			updateGM.style.transform = "translate("+(leftS)+"px,"+(topS-(yOfs))+"px)";
		}
		else if(e.clientY < curMouseYD){
			updateGM.style.transform = "translate("+(leftS)+"px,"+(topS-(yOfs))+"px)";
		}
			curMouseYD = e.clientY;
			curMouseXD = e.clientX;


	}
})

if(changePass != null){
	changePass.addEventListener("click",()=>{
		if(changePass.getAttribute("data-st") == "hid" && userPass.getAttribute("data-st") == "hid"){
			changePass.setAttribute("data-st","vis");
			userPass.setAttribute("data-st","vis");
			userPass.setAttribute("type","text");
		}else{
			changePass.setAttribute("data-st","hid");
			userPass.setAttribute("data-st","hid");
			userPass.setAttribute("type","password");
		}
})
}

if(regForm != null){
	let signError = document.getElementById("signError");
	let signErrorText = document.getElementById("signErrorText");
	regForm.addEventListener("submit",(e)=>{
		e.preventDefault();
		let name = document.forms.regForm.elements.name.value;
		let password = document.forms.regForm.elements.password.value;
		if((name.length != 0 && name.length>5) &&  (password.length != 0 && password.length>5)){
			signError.style.display="none";
			regForm.submit();
		}else{
			signError.style.display="block";
			let errorMessageLogin = '';
			let errorMessagePassword = '';
			switch (6-Number(name.length)) {
				case 1:
					errorMessageLogin = "В логине необходим ещё "+(6-Number(name.length))+" символ";
				break;
				case 2: 
 				case 3:
 				case 4:
					errorMessageLogin = "В логине необходимо ещё "+(6-Number(name.length))+" символа";
				break;
				case 5:
				case 6:
					errorMessageLogin = "В логине необходимо ещё "+(6-Number(name.length))+" символов";
				break;
			}

			switch (6-Number(password.length)) {
				case 1:
					errorMessagePassword = "В пароле необходим ещё "+(6-Number(password.length))+" символ";
				break;
				case 2: 
 				case 3:
 				case 4:
					errorMessagePassword = "В пароле необходимо ещё "+(6-Number(password.length))+" символа";
				break;
				case 5:
				case 6:
					errorMessagePassword = "В пароле необходимо ещё "+(6-Number(password.length))+" символов";
				break;
			}
				
			if(name.length<=5){
				signErrorText.textContent = errorMessageLogin;
			}else if(password.length<=5){
				signErrorText.textContent = errorMessagePassword;
			}
			
		}
	})
}


let addFirstG = document.getElementById("addFirstG");
let newproduct = document.getElementById("newproduct");
let addError = document.getElementById("addError");
if(newproduct != null){
	let pagesButtons = document.getElementById("pagesButtons");
	newproduct.addEventListener("submit",(e)=>{
		e.preventDefault(); 
		let formd = new FormData(newproduct);
		if(isFirst == 0){
		    let pageH = document.getElementById("pageH");
	    	formd.append('page',pageH.value);
		    let curDocPages = document.getElementById("curDocPages");
	    	formd.append('Apages',curDocPages.textContent);
		}else{
		    formd.append('first','1');
		}
		if(newImage == 1){
			let imgCanv = document.createElement("canvas");
			let preImageLoad = imgCanv.getContext('2d');
	
			imgCanv.width = preImage.offsetWidth;
			imgCanv.height = preImage.offsetHeight
	
			preImageLoad.drawImage(preImage,0,0,preImage.offsetWidth,preImage.offsetHeight);
			preImage.src = imgCanv.toDataURL("image/webp",1);
			formd.append('image',preImage.src);
		}else{
			formd.append('image','');
		}
		
	
		let  xhr = new XMLHttpRequest();
	  	xhr.open('POST','addNewproduct.php', true);
	 	xhr.send(formd);
	 	xhr.addEventListener("load",(e)=>{
	 	    if(isFirst == 1){
	 	        window.location.reload();
	 	    }
	 	    if(xhr.responseText == "nameerror"){
	 	    	addError.style.display = "block";
	 	    	addError.textContent = "!Имя занято"
	 	    }else if(xhr.responseText == "error"){
	 	    	addError.style.display = "block";
	 	    	addError.textContent = "!Ошибка загрузки"
	 	    }else{
	 		let allproductsCont = document.getElementById("allproductsCont");
			allproductsCont.innerHTML = xhr.responseText;
			if(document.getElementById("newAllPage") != null){
				let newPagesC = document.getElementById("newAllPage").textContent;
				curDocPages.textContent = newPagesC;
				pagesButtons.innerHTML = '';
				for(let i = 1;i<=Number(newPagesC);i++){
					if(i == pageH.value){
						let CPage = document.createElement("span");
						CPage.textContent = i;
						CPage.setAttribute("class",'CurrentPage');
						pagesButtons.appendChild(CPage);
					}else{
						let aPage = document.createElement("a");
						aPage.setAttribute("href","base?page="+i);
						aPage.setAttribute("class","pageButton");
						aPage.textContent = i;
						pagesButtons.appendChild(aPage);

					}
				}
			}	
			}

		})
	})	
}
let isFirst = 0;
if(addFirstG != null){
	addFirstG.addEventListener("click",()=>{
	    isFirst = 1;
		if(newproduct.getAttribute("data-st") == 'hid'){
			newproduct.setAttribute("data-st",'vis');
			newproduct.style.display = 'flex';
			let addFirstGPos = addFirstG.getBoundingClientRect();

		}else{
			newproduct.setAttribute("data-st",'hid');
			newproduct.style.display = 'none';
		}
	})
}


let loadfile = document.getElementById("loadfile");

if(loadfile != null){
	let preImage = document.getElementById("preImage");
	loadfile.addEventListener("change",function(e){
		if(this.files[0]){
			let imageG = new FileReader();
			imageG.readAsDataURL(this.files[0]);
			imageG.addEventListener("load",()=>{
				preImage.setAttribute("src",imageG.result);
				preImage.style.display = "block";
				newImage = 1;
			})
		}
	})
}

let addNewproductButton = document.getElementById("addNewproductButton");
if(addNewproductButton != null){
	addNewproductButton.addEventListener("click",()=>{
		addError.style.display = "none";
		if(newproduct.getAttribute("data-st") == "hid"){
			newproduct.setAttribute("data-st",'vis');
			newproduct.style.display = 'flex';
		}else{
			newproduct.setAttribute("data-st",'hid');
			newproduct.style.display = 'none';
		}
		
	})
}



let signB = document.getElementById("signB");
if(signB != null){

	let regB = document.getElementById("regB");
	let fType = document.getElementById("fType");

	signB.addEventListener("click",()=>{
		fType.value = "sign";
	})

	regB.addEventListener("click",()=>{
		fType.value = "reg";
	})
}

let settings = document.getElementById("settings");
if(settings != null){

	let delCheck = document.getElementById("delCheck");
	let updateGFV = document.forms.updateGF;
	let preImaChange = document.getElementById("preImaChange");
	let ImgChange = document.getElementById('ImgChange');
	let isChImg = document.getElementById("isChImg");

	ImgChange.addEventListener('change',function(e){
		if(this.files[0]){
			let imageG = new FileReader();
			imageG.readAsDataURL(this.files[0]);
			imageG.addEventListener("load",()=>{
				preImaChange.setAttribute("src",imageG.result);
				preImaChange.style.display = "block";
				isChImg.value = "true";
			})
		}
	})


	

	let choseColumns = document.getElementById("choseColumns");

	let SoSettings = document.getElementById("SoSettings");

	let search = document.getElementById("search");
	settings.addEventListener("click",()=>{
		let point = document.getElementsByClassName("point");
		point = Array.from(point);

		let changeproduct = document.getElementsByClassName("changeproduct");
		changeproduct = Array.from(changeproduct);
		let ChoseCount = document.getElementById("ChoseCount");

		if(settings.getAttribute("data-st") == "hid"){
			settings.style.right ="-10px"
			delCheck.style.display = "block";
			settings.setAttribute("data-st",'vis');
			point.forEach((item)=>{item.style.display = "flex"});
			changeproduct.forEach((item)=>{item.style.display = "flex"});
			choseColumns.style.display = "flex";
			choseColumns.style.left = "20px";
			search.style.right = "-30px";
			ChoseCount.style.display = "block";
			SoSettings.style.display = "block";
			changeproduct.forEach((item)=>{
				item.addEventListener("click",()=>{
					UpdateError.style.display = "none";
					updateGF.style.display = 'flex';
					updateGFV.elements.oldtitle.value = item.parentNode.getElementsByClassName("productOnename")[0].textContent; 
					updateGFV.elements.title.value = item.parentNode.getElementsByClassName("productOnename")[0].textContent;
					updateGFV.elements.type.value = item.parentNode.getElementsByClassName("productOnetype")[0].textContent;
					updateGFV.elements.count.value = item.parentNode.getElementsByClassName("productOnecount")[0].textContent;
					updateGFV.elements.SKU.value = item.parentNode.getElementsByClassName("productOneSKU")[0].textContent;
					preImaChange.setAttribute("src",item.parentNode.getElementsByClassName("productOneimageImg")[0].getAttribute("src"));
					preImaChange.style.display = "block";
				})
			})
		}else{
			settings.style.right ="20px"
			delCheck.style.display = "none";
			settings.setAttribute("data-st",'hid');
			point.forEach((item)=>{item.style.display = "none"});
			changeproduct.forEach((item)=>{item.style.display = "none"});
			choseColumns.style.display = "none";
			search.style.right = "20px";
			ChoseCount.style.display = "none";
			SoSettings.style.display = "none";
		}
	})
	let firstCol = 2
	let secondCol = 2
	let thirdCol = 2
	let fourthCol = 2
	let fifthCol = 2
	let cookies = document.cookie.split(";");
	if(tableStatus){
		let tableVis = tableStatus.toString().split('');
		firstCol = tableVis[0];
		secondCol = tableVis[1];
		thirdCol = tableVis[2];
		fourthCol = tableVis[3];
		fifthCol = tableVis[4];
	}
	
	function newtableStatus(){
		tableStatus = firstCol.toString()+secondCol.toString()+thirdCol.toString()+fourthCol.toString()+fifthCol.toString();
		document.cookie = "tableStatus="+tableStatus;
		
	}

	let visimgLC = document.getElementById("visimgLC");

	if(tableStatus){
		let tableVis = tableStatus.replace(/\s?/gi,'').toString().split('');
		if(tableVis[0] == '2'){
			let productOneimage = document.getElementsByClassName("productOneimage");
    		productOneimage = Array.from(productOneimage);
			let imgL = document.getElementById("imgL");
			productOneimage.forEach((elem)=>{
				elem.style.display = "none";
				imgL.style.display = "none";
			})
		}

		if(tableVis[1] == '2'){
			let productOnename = document.getElementsByClassName("productOnename");
    		productOnename = Array.from(productOnename);
			let namel = document.getElementById("namel");
			productOnename.forEach((elem)=>{
				elem.style.display = "none";
				imgL.style.display = "none";
			})
		}

		if(tableVis[2] == '2'){
			let productOneSKU = document.getElementsByClassName("productOneSKU");
    		productOneSKU = Array.from(productOneSKU);
			let SKUL = document.getElementById("SKUL");
			productOneSKU.forEach((elem)=>{
				elem.style.display = "none";
				imgL.style.display = "none";
			})
		}

		if(tableVis[3] == '2'){
			let productOnetype = document.getElementsByClassName("productOnetype");
    		productOnetype = Array.from(productOnetype);
			let Typel = document.getElementById("Typel");
			productOnetype.forEach((elem)=>{
				elem.style.display = "none";
				imgL.style.display = "none";
			})
		}

		if(tableVis[4] == '2'){
			let productOnecount = document.getElementsByClassName("productOnecount");
    		productOnecount = Array.from(productOnecount);
			let countl = document.getElementById("countl");
			productOnecount.forEach((elem)=>{
				elem.style.display = "none";
				imgL.style.display = "none";
			})
		}


	}else{
		let tableStatus1 = 11111;
	}
	



	visimgLC.addEventListener("click",(e)=>{
		let productOneimage = document.getElementsByClassName("productOneimage");
    	productOneimage = Array.from(productOneimage);
		let imgL = document.getElementById("imgL");
		if(visimgLC.checked == false){
			productOneimage.forEach((elem)=>{
				elem.style.display = "none";
				imgL.style.display = "none";
				firstCol = 2;
				newtableStatus()
			})
		}else if(visimgLC.checked == true){
			productOneimage.forEach((elem)=>{
				elem.style.display = "block";
				imgL.style.display = "block";
				firstCol = 1;
				newtableStatus()
			})
		}
	})

	let visnamelC = document.getElementById("visnamelC");

	
	visnamelC.addEventListener("click",(e)=>{
		let productOnename = document.getElementsByClassName("productOnename");
    	productOnename = Array.from(productOnename);
		let namel = document.getElementById("namel");
		if(visnamelC.checked == false){
			productOnename.forEach((elem)=>{
				elem.style.display = "none";
				namel.style.display = "none";
				secondCol = 2;
				newtableStatus();
			})
		}else if(visnamelC.checked == true){
			productOnename.forEach((elem)=>{
				elem.style.display = "block";
				namel.style.display = "block";
				secondCol = 1;
				newtableStatus();
			})
		}
	})

	let visSKULC = document.getElementById("visSKULC");

	visSKULC.addEventListener("click",(e)=>{
		let productOneSKU = document.getElementsByClassName("productOneSKU");
    	productOneSKU = Array.from(productOneSKU);
		let SKUL = document.getElementById("SKUL");
		if(visSKULC.checked == false){
			productOneSKU.forEach((elem)=>{
				elem.style.display = "none";
				SKUL.style.display = "none";
				thirdCol = 2;
				newtableStatus();
			})
		}else if(visSKULC.checked == true){
			productOneSKU.forEach((elem)=>{
				elem.style.display = "block";
				SKUL.style.display = "block";
				thirdCol = 1;
				newtableStatus();
			})
		}
	})

	let visTypelC = document.getElementById("visTypelC");

	visTypelC.addEventListener("click",(e)=>{
		let productOnetype = document.getElementsByClassName("productOnetype");
    	productOnetype = Array.from(productOnetype);
		let Typel = document.getElementById("Typel");
		if(visTypelC.checked == false){
			productOnetype.forEach((elem)=>{
				elem.style.display = "none";
				Typel.style.display = "none";
				fourthCol = 2;
				newtableStatus();
			})
		}else if(visTypelC.checked == true){
			productOnetype.forEach((elem)=>{
				elem.style.display = "block";
				Typel.style.display = "block";
				fourthCol = 1;
				newtableStatus();
			})
		}
	})

	let viscountlC = document.getElementById("viscountlC");
	
	viscountlC.addEventListener("click",(e)=>{
		let productOnecount = document.getElementsByClassName("productOnecount");
    	productOnecount = Array.from(productOnecount);
		let countl = document.getElementById("countl");
		if(viscountlC.checked == false){
			productOnecount.forEach((elem)=>{
				elem.style.display = "none";
				countl.style.display = "none";
				fifthCol = 2;
				newtableStatus();
			})
		}else if(viscountlC.checked == true){
			productOnecount.forEach((elem)=>{
				elem.style.display = "block";
				countl.style.display = "block";
				fifthCol = 1;
				newtableStatus();
			})
		}
	})




	let points = document.getElementById("points");
	delCheck.addEventListener("click",()=>{
		points.submit();
	})

}
let closeupdateG = document.getElementById('closeupdateG');
if(closeupdateG != null){
	closeupdateG.addEventListener("click",()=>{
		updateG.style.display = "none";
	})
}


let UpdateError = document.getElementById("UpdateError");
let updateG = document.getElementById("updateG");

if(updateG != null){
	movelockUpdate.addEventListener("click",()=>{
		if(movelockUpdate.getAttribute("data-st") == "lock"){
			movelockUpdate.style.background = "green";
			movelockUpdate.setAttribute("data-st","open");
		}else{
			movelockUpdate.style.background = "none";
			movelockUpdate.setAttribute("data-st","lock");
		}
	})

	updateG.addEventListener("submit",(e)=>{
		e.preventDefault();
		let formd = new FormData(updateG);
		if(isChImg.value == 'true'){
			let imgCanv = document.createElement("canvas");
			let preImageLoad = imgCanv.getContext('2d');
			imgCanv.width = preImaChange.offsetWidth;
			imgCanv.height = preImaChange.offsetHeight
	
			preImageLoad.drawImage(preImaChange,0,0,preImaChange.offsetWidth,preImaChange.offsetHeight);
			preImaChange.src = imgCanv.toDataURL("image/webp",1);
			formd.append('image',preImaChange.src);
		}
		formd.append('page',pageH.value);
		let  xhr = new XMLHttpRequest();
	  	xhr.open('POST','updateproduct.php', true);
	 	xhr.send(formd);
	 	xhr.addEventListener("load",(e)=>{
	 		if(xhr.responseText != "error" && xhr.responseText != "titleError"){
	 			let allproductsCont = document.getElementById("allproductsCont");
				allproductsCont.innerHTML = xhr.responseText;
				if(searchRStatus == 1){
					searchF.submit();
					searchRStatus =0;
				}
				let changeproduct = document.getElementsByClassName("changeproduct");
				changeproduct = Array.from(changeproduct);
				let updateGFV = document.forms.updateGF;
				changeproduct.forEach((item)=>{
					item.addEventListener("click",()=>{
						updateGF.style.display = 'flex';
						updateGFV.elements.oldtitle.value = item.parentNode.getElementsByClassName("productOnename")[0].textContent; 
						updateGFV.elements.title.value = item.parentNode.getElementsByClassName("productOnename")[0].textContent;
						updateGFV.elements.type.value = item.parentNode.getElementsByClassName("productOnetype")[0].textContent;
						updateGFV.elements.count.value = item.parentNode.getElementsByClassName("productOnecount")[0].textContent;
						updateGFV.elements.SKU.value = item.parentNode.getElementsByClassName("productOneSKU")[0].textContent;
						preImaChange.setAttribute("src",item.parentNode.getElementsByClassName("productOneimageImg")[0].getAttribute("src"));
						preImaChange.style.display = "block";
					})
				})
				updateG.style.display = "none";
			}else{
				UpdateError.style.display = "block";
				if(xhr.responseText == "error"){
					UpdateError.textContent = "!Ошибка обновления"
				}else if(xhr.responseText == "titleError"){
					UpdateError.textContent = "!Имя занято"
				}
					
				
			}
		})

		

	})	

	updateG.addEventListener("mousedown",(e)=>{
		changeMove = 1;
	})

	updateG.addEventListener("mouseup",()=>{
		changeMove = 0; 
	})
}

let search = document.getElementById("search");

if(search != null){
	movelock.addEventListener("click",()=>{
		if(movelock.getAttribute("data-st") == "lock"){
			movelock.style.background = "green";
			movelock.setAttribute("data-st","open");
		}else{
			movelock.style.background = "none";
			movelock.setAttribute("data-st","lock");
		}
	})
	let searchForm = document.getElementById("searchForm");

	search.addEventListener("click",()=>{
		if(search.getAttribute("data-st") == "hid"){
			search.setAttribute("data-st","vis")
			searchForm.style.display = "flex"
		}else{
			search.setAttribute("data-st","hid")
			searchForm.style.display = "none"
		}
	})

	searchForm.addEventListener("mousedown",(e)=>{
		searchMove = 1;
	})

	searchForm.addEventListener("mouseup",()=>{
		searchMove = 0;
	})
}

let searchF = document.getElementById("searchF");
if(searchF != null){
	let delFind = document.getElementById('delFind')
	searchF.addEventListener("submit",(e)=>{

		e.preventDefault();
		searchRStatus = 1;

		let formd = new FormData(searchF);
		formd.append('page',pageH.value);
		let  xhr = new XMLHttpRequest();
	  	xhr.open('POST','search.php', true);
	 	xhr.send(formd);
	 	xhr.addEventListener("load",(e)=>{
	 		let finded = document.getElementById("finded");
	 		finded.innerHTML = '';
	 		finded.innerHTML = xhr.responseText;

	 		if(finded.getElementsByClassName("Oneproduct").length != 0){
	 			delFind.style.display = "block";
	 		}else{
	 			delFind.style.display = "none";
	 		}
	 		let delFindF = document.getElementsByClassName("delFindF");
	 		let ChangeFindF = document.getElementsByClassName("ChangeFindF");
	 		delFindF=Array.from(delFindF);
	 		ChangeFindF=Array.from(ChangeFindF);
	 		let tokenC = document.getElementById("tokenC");
	 		let tocN = tokenC.getAttribute("name");

	 		let tocA = tokenC.getAttribute("value");
	 		ChangeFindF.forEach((item)=>{
	 			let newToc = document.createElement("input");
	 			newToc.setAttribute("type","hidden");
	 			newToc.setAttribute("name",tocN);
	 			newToc.setAttribute("value",tocA);
	 			item.appendChild(newToc);

	 			item.addEventListener("click",(e)=>{
	 			 e.preventDefault();
	 			updateGF.style.display = 'flex';
	 			let parenT = item.parentNode.parentNode.parentNode;
	 			let updateGFV = document.forms.updateGF;
				updateGFV.elements.oldtitle.value = parenT.getElementsByClassName("productOnename")[0].textContent; 
				updateGFV.elements.title.value = parenT.getElementsByClassName("productOnename")[0].textContent;
				updateGFV.elements.type.value = parenT.getElementsByClassName("productOnetype")[0].textContent;
				updateGFV.elements.count.value = parenT.getElementsByClassName("productOnecount")[0].textContent;
				updateGFV.elements.SKU.value = parenT.getElementsByClassName("productOneSKU")[0].textContent;
				preImaChange.setAttribute("src",parenT.getElementsByClassName("productOneimageImg")[0].getAttribute("src"));
				preImaChange.style.display = "block";	
	 			})

	 			
	 		})

	 		delFindF.forEach((item)=>{
	 			let newToc = document.createElement("input");
	 			newToc.setAttribute("type","hidden");
	 			newToc.setAttribute("name",tocN);
	 			newToc.setAttribute("value",tocA);
	 			item.appendChild(newToc);

	 			item.addEventListener("submit",(e)=>{
	 			 	e.preventDefault();
	 			})
	 		})
	 		
		})
	})
}

let closeupdateGFind = document.getElementById("closeupdateGFind");
if(closeupdateGFind != null){
	closeupdateGFind.addEventListener("click",()=>{
		searchForm.style.display = "none";
		search.setAttribute("data-st","hid")
	})
}


let InputPage = document.getElementById("InputPage");
if(InputPage != null){
	let InputPageSun = document.getElementById("InputPageSun");
	InputPage.addEventListener("input",()=>{
		InputPageSun.setAttribute("href","base?page="+InputPage.value);
	})
}


let imageSize = document.getElementById("imageSize");
if(imageSize != null){
	imageSize.addEventListener("change",()=>{
		imgL.style.width = imageSize.value+"px";
		let productOneimageImg = document.getElementsByClassName("productOneimageImg");
		productOneimageImg = Array.from(productOneimageImg);
		productOneimageImg.forEach((item)=>{
			item.style.width = imageSize.value+"px";
		})
		document.cookie = "imageSize="+imageSize.value;
	})
}


console.log(document.cookie)