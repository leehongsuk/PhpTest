<?php require_once("../config/CONFIG.php"); ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1.0, minimum-scale=1" />
    <title>AXUpload5 - AXISJ</title>

    <link rel="shortcut icon" href="<?=$path_Root?>/js/axisj-1.1.11/ui/axisj.ico" type="image/x-icon" />
    <link rel="icon" href="<?=$path_Root?>/js/axisj-1.1.11/ui/axisj.ico" type="image/x-icon" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?=$path_Root?>/js/axisj-1.1.11/ui/AXJ.png" />
    <link rel="apple-touch-icon-precomposed" href="<?=$path_Root?>/js/axisj-1.1.11/ui/AXJ.png" />
    <meta property="og:image" content="/samples/_img/axisj_sns.png" />
    <meta property="og:site_name" content="Axis of Javascript - axisj.com" />
    <meta property="og:description" id="meta_description" content="Javascript UI Library based on JQuery" />

    <!-- css block -->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axisj-1.1.11/ui/arongi/page.css">
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axisj-1.1.11/ui/arongi/AXJ.min.css">

    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/dist/AXJ.min.js"></script>
	<script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXUpload5.js"></script>

    <script type="text/javascript" src="pageTab.js"></script>
    <!-- js block -->

	<script>
	/**
	 * Require Files for AXISJ UI Component...
	 * Based		: jQuery
	 * Javascript 	: AXJ.js, AXUpload5.js
	 * CSS			: AXJ.css, AXButton.css, AXUpload5.css
	 */
	var myUpload = new AXUpload5();

	var fnObj = {
		pageStart: function(){

			fnObj.upload.init();
		},
		upload: {
			init: function(){
				myUpload.setConfig({
					targetID:"AXUpload5",
					//targetButtonClass:"Green",
					uploadFileName:"fileData",

                    fileSelectAutoUpload:false,
                    buttonTxt: "전송 할 파일 찾기...",

					//file_types:"*.*",  //audio/*|video/*|image/*|MIME_type (accept)
					file_types:"image/*",
					dropBoxID:"uploadQueueBox",
					queueBoxID:"uploadQueueBox", // upload queue targetID
					// html 5를 지원하지 않는 브라우저를 위한 swf upload 설정 원치 않는 경우엔 선언 하지 않아도 됩니다. ------- s
					flash_url : "<?=$path_Root?>/js/axisj-1.1.11/lib/swfupload.swf",
					flash9_url : "<?=$path_Root?>/js/axisj-1.1.11/lib/swfupload_fp9.swf",
					// --------- e
					onClickUploadedItem: function(){ // 업로드된 목록을 클릭했을 때.
						//trace(this);
						window.open(this.uploadedPath.dec() + this.saveName.dec(), "_blank", "width=500,height=500");
					},

					uploadMaxFileSize:(10*1024*1024), // 업로드될 개별 파일 사이즈 (클라이언트에서 제한하는 사이즈 이지 서버에서 설정되는 값이 아닙니다.)
					uploadMaxFileCount:1, // 업로드될 파일갯수 제한 0 은 무제한
					uploadUrl:"<?=$path_AjaxJSON?>/AXU5_fileUpload.php",  // <-----
					uploadPars:{userID:'tom', userName:'액시스'},
					deleteUrl:"<?=$path_AjaxJSON?>/AXU5_fileDelete.php",  // <-----
					deletePars:{userID:'tom', userName:'액시스'},

					fileKeys:{ // 서버에서 리턴하는 json key 정의 (id는 예약어 사용할 수 없음)
						name:"name",
						type:"type",
						saveName:"saveName",
						fileSize:"fileSize",
						uploadedPath:"uploadedPath",
						thumbPath:"thumbUrl" // 서버에서 키값을 다르게 설정 할 수 있다는 것을 확인 하기 위해 이름을 다르게 처리한 예제 입니다.
					},

					formatter: function(f){
						var po = [];
						po.push("<div id='"+this.id+"_AXUploadLabel_mainImageFile' class='AXUploadMainImage' >mainImage</div>");

						return po.join('');
					},

					onUpload: function(){
						//trace(this);
						//trace("onUpload");
					},
					onComplete: function(){
						//trace(this);
						//trace("onComplete");
						$("#uploadCancelBtn").get(0).disabled = true; // 전송중지 버튼 제어
					},
					onStart: function(){
						//trace(this);
						//trace("onStart");
						$("#uploadCancelBtn").get(0).disabled = false; // 전송중지 버튼 제어
					},
					onDelete: function(){
						//trace(this);
						//trace("onDelete");
					},
					onError: function(errorType, extData){
						if(errorType == "html5Support"){
							//dialog.push('The File APIs are not fully supported in this browser.');
						}else if(errorType == "fileSize"){
							trace(extData);
							alert("파일사이즈가 초과된 파일을 업로드 할 수 없습니다. 업로드 목록에서 제외 합니다.\n("+extData.name+" : "+extData.size.byte()+")");
						}else if(errorType == "fileCount"){
							alert("업로드 갯수 초과 초과된 아이템은 업로드 되지 않습니다.");
						}
					}
				});
				// changeConfig

				// 서버에 저장된 파일 목록을 불러와 업로드된 목록에 추가 합니다. ----------------------------- s
				var url = "<?=$path_AjaxJSON?>/AXU5_fileListLoad.php";  // <-----
				var pars = "dummy="+AXUtil.timekey();
				new AXReq(url, {pars:pars, onsucc:function(res){
                    if(!res.error){
                        myUpload.setUploadedList(res);
                    }else{
                        alert(res.msg.dec());
                    }
				}});
				// 서버에 저장된 파일 목록을 불러와 업로드된 목록에 추가 합니다. ----------------------------- e

			},
			printMethodReturn: function(method, type){
				var list = myUpload[method](type);
				//trace(list);
				trace(myUpload.getUploadedList());
				toast.push(Object.toJSON(list));
			},
			changeOption: function(){

				// 업로드 갯수 등 업로드 관련 옵션을 동적으로 변경 할 수 있습니다.
				myUpload.changeConfig({
					/*
					uploadUrl:"uploadFile.asp",
					uploadPars:{userID:'tom', userName:'액시스'},
					deleteUrl:"deleteFile.asp",
					deletePars:{userID:'tom', userName:'액시스'},
					*/
					uploadMaxFileCount:10
				});
			}
		}
	};
	jQuery(document.body).ready(function(){fnObj.pageStart()});
	</script>

	<style type="text/css">

	</style>
</head>

<body style="margin: 0px;">

<div id="AXPage">

	<!-- s.AXPageBody -->
	<div id="AXPageBody" class="SampleAXSelect">
        <div id="demoPageTabTarget" class="AXdemoPageTabTarget"></div>
        <div class="AXdemoPageContent">
			<div class="title"><h1>AXUpload5 (Manual Upload)</h1></div>



            <div class="H10"></div>

            <div id="uploadQueueBox" class="AXUpload5QueueBox" style="height:188px;width:140px;"></div>

            <div class="AXUpload5" id="AXUpload5"></div>

            <div class="H10"></div>

            <div>

                <input type="button" value="업로드" class="AXButton" onclick="myUpload.uploadQueue(true);" />

                <input type="button" value="전송중지" class="AXButton" id="uploadCancelBtn" disabled="disabled" onclick="myUpload.cancelUpload();" />
                <input type="button" value="선택삭제" class="AXButton" onclick="myUpload.deleteSelect();" />
                <input type="button" value="모두삭제" class="AXButton" onclick="myUpload.deleteSelect('all');" />

                <input type="button" value="Get Object" class="AXButton" onclick="fnObj.upload.printMethodReturn('getUploadedList','object');" />
                <input type="button" value="Get Param" class="AXButton" onclick="fnObj.upload.printMethodReturn('getUploadedList','param');" />

                <input type="button" value="Get Select Object" class="AXButton" onclick="fnObj.upload.printMethodReturn('getSelectUploadedList','object')" />
                <input type="button" value="Get Select Param" class="AXButton" onclick="fnObj.upload.printMethodReturn('getSelectUploadedList','param')" />
            </div>

            <div class="H20"></div>

		</div>
	</div>
	<!-- e.AXPageBody -->

</div>

</body>
</html>
