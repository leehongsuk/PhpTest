<?php require_once("../config/CONFIG.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1.0, minimum-scale=1" />
    <title>AXToolBar - AXISJ</title>

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
        });
    </script>
</head>

<body>

    <div style="position: relative; z-index: 2;height: 50px;text-align: right;padding-top: 20px;padding-right: 10px;">
        ....님을 환영합니다.....
    </div>
    <div style="position: relative;top:-60px;z-index: 3;">
	    <div class="toolBar" id="tool-bar" style="position: relative;border-bottom: 1px solid #d6d6d6;border: 1px solid #d6d6d6;"></div>
    </div>


</body>

</html>
