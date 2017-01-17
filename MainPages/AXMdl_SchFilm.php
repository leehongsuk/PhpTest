<?php require_once("../config/CONFIG.php"); ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1.0, minimum-scale=1" />
    <title>AXAddress</title>

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
    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXSelect.js"></script>

    <!-- css block -->
    <!-- link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet "-->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/MainCss/font-awesome.min.css" />

    <style type="text/css">
    .modalProgramTitle{
        height:38px;
        line-height:40px;
        color:#282828;
        font-size:14px;
        font-weight:bold;
        padding-left:15px;
        border-bottom:1px solid #a6a6a6;
        background-color: #DBDDE6;
    }
    .modalButtonBox{
        padding:10px;
        border-top:1px solid #ccc;
    }
    .label{
        margin-left: 7px;
        margin-right: 3px;
    }
    </style>

    <script type="text/javascript">

    var gridFilm = new AXGrid() ; // 영화 그리드

    var fnObj = {

        pageStart: function()
        {
            // 이걸하지않으면 디자인이 나오지 않는다.
            $('input[type=checkbox]').bindChecked();
            $('input[type=radio]').bindChecked();


            // 배급사 초기화
            jQuery("#AXSelect_Distributor").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_distributor.php",  // <-----
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                    console.log(this.value);
                }
            });



            // 그리드(영화)
            gridFilm.setConfig(
            {
                targetID : "AXGrid_Film",
                theme : "AXGrid",
                autoChangeGridView: { // autoChangeGridView by browser width
                    mobile:[0,600], grid:[600]
                },
                fitToWidth: false, // 너비에 자동 맞춤
                colGroup : [
                    {key:"code", label:"영화코드", width:"70"},
                    {key:"film_nm", label:"대표영화명", width:"100"},
                    {key:"play_print_nm", label:"프린트", width:"100"},
                    {key:"distributor_nm", label:"배급사", width:"100"},
                    {key:"play_term", label:"상영기간", width:"160"},
                    {key:"replay_term", label:"재상영기간", width:"160"}
                ],
                body :
                {
                    height: 3,
                    onclick: function()
                    {
                    }
                },
                page:{
                    paging:true,
                    pageNo:1,
                    pageSize:10
                }
            });

            fnObj.searchTheater(); // 전체 상영관을 리스팅한다.

        }, // pageStart: function()

        // 검색버튼을 누를시..
        searchTheater: function()
        {
            var distributor_seq = jQuery("#AXSelect_Distributor").val();
            var film_nm         = jQuery("#AXText_FilmeNm").val();

            gridFilm.setList({
                ajaxUrl : "<?=$path_AjaxJSON?>/wrk_film_playprint_page.php",  // <-----
                ajaxPars: {
                    "theaterCode" : '<?=$_POST["theaterCode"]?>',
                    "showroomSeq" :<?=$_POST["showroomSeq"]?>,
                    "distributor_seq" : distributor_seq,
                    "film_nm"         : film_nm
                },
                onLoad  : function(){
                    //gridFilm.setFocus(0);
                }
            });
        }

    }; // var fnObj = {

    $(document.body).ready(function() { setTimeout(fnObj.pageStart, 1); } );

    </script>

</head>
<body>
    <div class="bodyHeightDiv">
        <div class="modalProgramTitle">
            상영영화선택 (<?=$_POST["theaterName"]?>,<?=$_POST["showroomName"]?>)
        </div>

        <div style="margin-top: 8px;margin-bottom: 5px;">

        	<label class="label">배급사 :</label><select name="Distributor" class="AXSelect" id="AXSelect_Distributor" style="width:150px;" tabindex="3"></select>
        	<label class="label">영화명 :</label><input type="text" name="FilmName" value="" id="AXText_FilmeNm" class="AXInput" />


            <label class="label"><input type="checkbox" name="Mappinged" value="true" id="AXCheck_All" /> 전체</label>

            <button style="margin-left: 10px;" type="button" class="AXButton" id="button" tabindex="2" onclick="fnObj.searchTheater();"><i class="axi axi-search2"></i> 조회</button>
        </div>

        <div class="masterModalBody" id="masterModalBody">
            <div id="AXSearchTarget" style=""></div>

            <div style="padding:5px;">
        		<div id="AXGrid_Film" style="height:390px;"></div>
            </div>
        </div>

        <div class="modalButtonBox" align="center">
            <button class="AXButton W60" onclick="parent.myModal.close();">닫기</button>
        </div>

    </div>
</body>
</html>
