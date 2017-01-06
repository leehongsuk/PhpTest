<?php
require_once("./config/CONFIG.php");

if  ($_SESSION['user_seq'])  Header("Location:MainPages/"); // 이미 로그인 세션이 확보되어 있다면 MainPage쪽으로 간다.....
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Language" content="ko" />

    <!-- 공통요소 -->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axisj-1.1.11/ui/arongi/AXJ.css" />

    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXJ.js"></script>

    <!-- 추가하는 UI 요소 -->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axisj-1.1.11/ui/arongi/AXInput.css" />
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axisj-1.1.11/ui/arongi/AXSelect.css" />
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axisj-1.1.11/ui/arongi/AXGrid.css" />
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axisj-1.1.11/ui/arongi/AXJ.min.css" />

    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/dist/AXJ.min.js"></script>
    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXInput.js"></script>
    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXSelect.js"></script>
    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXGrid.js"></script>
    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXSearch.js"></script>

    <!-- 아이콘사용을 위해서..(http://axicon.axisj.com/) -->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axicon/axicon.min.css"/>

    <!-- css block -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/MainCss/Common.css" />

	<!-- bxslider -->
    <script src="<?=$path_Root?>/js/jquery.bxslider/jquery.bxslider.min.js"></script>
	<link href="<?=$path_Root?>/js/jquery.bxslider/jquery.bxslider.css" rel="stylesheet" />

    <script type="text/javascript">

    var myModal = new AXModal(); // 범용팝업

    var fnObj =
    {
        pageStart: function()
        {
        },

		// 로그인 버튼
        login: function()
        {
            var errMsg = "" ;
			var user_id = jQuery('input[name=user_id]').val() ;
			var user_pw = jQuery('input[name=user_pw]').val() ;

			if  (user_id=="") 	errMsg += "아이디가 없습니다 아이디를 입력하세요.<br>"
			else
			{
			    if  (user_id.length < 5) errMsg += "아이디는 5자 이상이여야 합니다.<br>"
			}

			if  (user_pw=="") 	errMsg += "암호가 없습니다 암호를 입력하세요.<br>"
			else
			{
			    if  (user_pw.length < 5) errMsg += "암호는 5자 이상이여야 합니다.<br>"
			}

			if  (errMsg == "")
			{
			    // 로그인을 한다.
	            jQuery.post( "./AjaxJSON/user_login.php",  { user_id : user_id , user_pw : user_pw })  // <-----
			          .done(function( data ) {

			            	var obj  = eval("("+data+")");

			            	if  (obj.count_id == 0) errMsg += "등록되어 있지 않는 아이디입니다.<br>"
			            	else
			            	{
				            	if  (obj.del_flag == 'Y') errMsg += obj.delete_dt+"에 이미 삭제된 아이디입니다.<br>"
				            	else
				            	{
    								if  (obj.count_idpw == 0) errMsg += "암호가 올바르지 않습니다.<br>"
    								else
    								{
    								    location.reload(); // 이미 세션이 확보되었으므로..
    								}
					            }
			            	}

			            	if  (errMsg != "")
			                {
			                	fnObj.modalOpen(500,-1,'확인',errMsg,null)
			                }

			          });
			}
			else
            {
            	fnObj.modalOpen(500,-1,'확인',errMsg,null)
            }
        },

        // 모달창을 띄운다.
        modalOpen: function (width,top,title,errorMsg,onFnClose)
        {
            myModal.setConfig({onclose: onFnClose, displayLoading: false});

            var pars = "title="+title+"&content="+errorMsg ;
            myModal.open({
                url: "./MainPages/AX_Modal.php",  // <-----
                pars: pars.queryToObject(),
                width: width,
                //top: 100,
                verticalAlign: true, // 씨발 안먹네..!!
                closeButton: true,
                closeByEscKey: true
            });
        }

    };

    jQuery(document).ready(fnObj.pageStart.delay(0.1));

    $(document).ready(function()
    {
        $('.bxslider').bxSlider(
        {
            speed: 6000,
            hideControlOnEnd:true,
            adaptiveHeight:true,
            randomStart:true,
            slideWidth: 900,
            minSlides: 1,
            maxSlides: 1,
            moveSlides: 0,
            pager: false,
            autoControls: false,
            auto: true
        });
    });



    </script>
</head>

<body>



	<div style="margin: 40px;"></div>

    <ul class="bxslider" style="width: 100%;">
        <?php
        $files = scandir("./bxslider_images");

        foreach ($files as $file)
        {
            if  (($file != ".") && ($file != "..") )
            {
            ?>
            <li><img height="600" src="<?=$path_Root?>/bxslider_images/<?=$file?>" /></li>
            <?php
            }
        }
        ?>
    </ul>


    <div style="margin: 30px;"></div>

    <div class="modalButtonBox" align="center"  style="">

     	아이디 : <input type="text" class="AXInput W90" placeholder="아이디" name="user_id"/>&nbsp;&nbsp;&nbsp;

     	암호 : <input type="password" class="AXInput W90" placeholder="암호" name="user_pw">&nbsp;&nbsp;&nbsp;

     	<button type="button" class="AXButton W500" id="btnSave" onclick="fnObj.login();"><i class="axi axi-save "></i> 로그인</button>
    </div>


</body>
</html>
