<?php require_once("../config/CONFIG.php"); ?>
<?php
$title   = $_POST["title"];
$content = $_POST["content"];
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1.0, minimum-scale=1" />
	<title>modal</title>

    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axisj-1.1.11/ui/arongi/page.css">
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axisj-1.1.11/ui/arongi/AXJ.min.css">

    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXJ.js"></script>
    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXModal.js"></script>

    <style type="text/css">
        .modalProgramTitle{
            height:38px;
            line-height:40px;
            color:#282828;
            font-size:14px;
            font-weight:bold;
            padding-left:15px;
            border-bottom:1px solid #a6a6a6;
        }
        .modalButtonBox{
            padding:10px;border-top:1px solid #ccc;
        }
    </style>

    <script>

        var fnObj = {
            pageStart: function()
            {
            },
            close: function()
            {
                if(opener){
                    window.close();
                }
                else
                if(parent){
                    if(parent.myModal) parent.myModal.close();
                }
                else
                {
                    window.close();
                }
            }
        };

        jQuery(document).ready(fnObj.pageStart);
    </script>

</head>

<body>

    <div class="bodyHeightDiv">

        <div class="modalProgramTitle"><?=$title?></div>

        <div class="masterModalBody" id="masterModalBody">
            <div id="AXSearchTarget" style=""></div>
            <div style="padding:15px;">
                <div id="AXGridTarget"><?=$content?></div>
            </div>
        </div>
        <div class="modalButtonBox" align="center">
            <button class="AXButton W60" onclick="fnObj.close();">확 인</button>
        </div>
    </div>

</body>

</html>

