<?php require_once("../config/CONFIG.php"); ?>
<?php require_once("../config/SESSION_OUT.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="ko" />


    <title>초기 화면</title>

    <link rel="shortcut icon" href="<?=$path_Root?>/js/axisj-1.1.11/ui/axisj.ico" type="image/x-icon" />
    <link rel="icon" href="<?=$path_Root?>/js/axisj-1.1.11/ui/axisj.ico" type="image/x-icon" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?=$path_Root?>/js/axisj-1.1.11/ui/AXJ.png" />
    <link rel="apple-touch-icon-precomposed" href="<?=$path_Root?>/js/axisj-1.1.11/ui/AXJ.png" />
    <meta property="og:image" content="/samples/_img/axisj_sns.png" />
    <meta property="og:site_name" content="Axis of Javascript - axisj.com" />
    <meta property="og:description" id="meta_description" content="Javascript UI Library based on JQuery" />

    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axisj-1.1.11/ui/arongi/page.css" />
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axisj-1.1.11/ui/arongi/AXJ.min.css" />

    <link rel="stylesheet" type="text/css" href="http://cdno.axisj.com/axicon/axicon.min.css" />

    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/dist/AXJ.min.js"></script>

    <script src="http://newdoc.axisj.com/scripts/prettify/prettify.js"></script>
    <script src="http://newdoc.axisj.com/scripts/prettify/lang-css.js"></script>

    <link type="text/css" rel="stylesheet"  href="http://newdoc.axisj.com/styles/prettify-jsdoc.css">

    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXToolBar.js"></script>
    <script type="text/javascript" src="<?=$path_Root?>/MainJavascript/AXToolBar.js"></script>

    <!-- bxslider -->
    <script src="<?=$path_Root?>/js/jquery.bxslider/jquery.bxslider.min.js"></script>
	<link href="<?=$path_Root?>/js/jquery.bxslider/jquery.bxslider.css" rel="stylesheet" />

	<script type="text/javascript" src="<?=$path_Root?>/MainJavascript/CommonLib.js"></script>

    <style type="text/css">
    .title{
        position: relative;
        color: whitesmoke;
        font-family: Courier New;
        font-size: 100px;
        font-weight: 900;
        height: 1px;
        text-shadow: 0.1em 0.1em 0.08em #333;
        left: 5px;
        top:-400px;
        text-align: center;
    }
    </style>

    <script type="text/javascript">

        var fnObj =
        {
            pageStart: function()
            {
                fnToolbar.toolbar.init();
            }
        };

        $(document.body).ready(function() {

            fnObj.pageStart();

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

    <div style="height: 70px;">
       <div class="toolBar" id="tool-bar" style="position: relative;border-bottom: 1px solid #d6d6d6;border: 1px solid #d6d6d6;"></div>
       <div style="text-align: right; margin-top: 5px;">
           <a href="./index.php"><b>HOME</b></a> > &nbsp;&nbsp; [<b><?=$_SESSION["user_name"]?></b>] 님을 환영합니다...&nbsp;&nbsp;<a href="#" onclick="log_out('<?=$path_AjaxSESSION?>')"><b>로그아웃</b></a>&nbsp;
       </div>
    </div>

	<div style="margin: 10px;"></div>

    <div style="position: relative;">
        <ul class="bxslider" style="width: 100%;">
            <?php
            $files = scandir("../bxslider_images");

            foreach ($files as $file)
            {
                if  (($file != ".") && ($file != "..") )
                {
                ?>
                <li><img height="600" src="../bxslider_images/<?=$file?>" /></li>
                <?php
                }
            }
            ?>
        </ul>
    </div>

    <div class="title">www.cineon.kr</div>

    <div style="margin: 30px;"></div>

</body>

</html>
