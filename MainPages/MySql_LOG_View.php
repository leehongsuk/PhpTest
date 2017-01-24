<?php require_once("../config/CONFIG.php"); ?>
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
    <!-- link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet "-->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/MainCss/font-awesome.min.css" />

    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/MainCss/Common.css" />

    <script type="text/javascript">

    var rowCount =0 ;

    var gridMySqlLOG = new AXGrid() ; // instance

    var fnObj =
    {
        pageStart: function()
        {
            gridMySqlLOG.setConfig(
                    {
                        targetID : "AXGrid_MySqlLOG",
                        theme : "AXGrid",
                        height : 800,
                        autoChangeGridView: { // autoChangeGridView by browser width
                            mobile:[0,600], grid:[600]
                        },
                        fitToWidth: false, // 너비에 자동 맞춤
                        colGroup : [
                            {key:"event_time", label:"시간",     width:"100", align: "center"},
                            {key:"argument",    label:"실행쿼리", width:"1500"}
                        ],
                        body : {
                            ondblclick: function(){
                                location.reload();
                            }
                        },
                        page:{
                            paging:true,
                            pageNo:1,
                            pageSize:100
                        }
                    });

            gridMySqlLOG.setList({
                        ajaxUrl : "<?=$path_AjaxJSON?>/log_mysql_page.php",  // <-----
                        onLoad  : function(){
                            //gridTheater.goPageMove(1); // 상대적인 페이지 이동..
                            //gridTheater.setFocus(3);  // 페이지별 row의 위치 .. 0 부터..
                            setTimeout(fnObj.reflash, 2000);
                        }
                    });
        },

        clear : function()
        {
            jQuery.ajax({
                type : "POST",
                url : "<?=$path_AjaxJSON?>/log_mysql_clear.php",  // <-----
                cache : false,
                success :  fnObj.reflash
   			});
        },


    	reflash :  function()
    	{
			jQuery.ajax({
                         type : "POST",
                         url : "<?=$path_AjaxJSON?>/log_mysql_count.php",  // <-----
                         cache : false,
                         //data : formData,
                         success : fnObj.onSuccess
            });

			setTimeout(fnObj.reflash, 2000);
        },

        onSuccess : function(data)
        {
            var obj = eval("("+data+")");

            if  ((rowCount>0) && (rowCount != obj['count'])) location.reload();

            //trace(rowCount);
            //trace(obj['count']);
            rowCount = obj['count'];
        }


    }; // var fnObj =

    jQuery(document).ready(fnObj.pageStart.delay(0.1));

    </script>
</head>

<body>


    <div class="modalButtonBox" align="center">
        <button type="button" class="AXButtonLarge W500" id="btnSave" onclick="fnObj.clear();"><i class="axi axi-save "></i> 비우기</button>
    </div>
	<br>
    <div id="AXGrid_MySqlLOG"></div>


</body>
</html>
