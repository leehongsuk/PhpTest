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
                    {
                        key: "btns", label: "스코어입력", width: "100", align: "center", formatter: function ()
                        {
                            //trace(this.item);

                            // 지정한 날짜가 있는경우
                            if  ( (this.item.mapping_dt != null) && (this.item.unmapping_dt == null) )
                            {
                                var theater_code  = '<?=$_POST["theaterCode"]?>' ;
                                var showroom_seq  = <?=$_POST["showroomSeq"]?> ;
                                var film_code     = this.item.code ;
                                var playprint_seq = this.item.playprint_seq ;

                                return '<button class="AXButton" onclick="fnObj.playScore(\''+theater_code+'\','+showroom_seq+',\''+film_code+'\','+playprint_seq+');">스코어입력</button>'
                            }
                            else
                                return '미지정' ;
                        }
                    },
                    {key:"code", label:"영화코드", width:"70"},
                    {key:"film_nm", label:"대표영화명", width:"100"},
                    {key:"play_print_nm", label:"프린트", width:"100"},
                    {key:"distributor_nm", label:"배급사", width:"100"},
                    {key:"play_term", label:"상영기간", width:"160"},
                    {key:"replay_term", label:"재상영기간", width:"160"},
                    {key:"mapping_dt",    label:"지정일",    width:"80"},
                    {key:"unmapping_dt",  label:"해지일",    width:"80"}
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

            fnObj.searchFilm(); // 전체 상영관을 리스팅한다.

        }, // pageStart: function()

        // 검색버튼을 누를시..
        searchFilm: function()
        {
            var distributor_seq = jQuery("#AXSelect_Distributor").val();
            var film_nm         = jQuery("#AXText_FilmeNm").val();
            var mappinged       = (jQuery("#AXCheck_Mappinged").prop('checked')) ? "Y" : "N" ;

            gridFilm.setList({
                ajaxUrl : "<?=$path_AjaxJSON?>/wrk_film_playprint_page.php",  // <-----
                ajaxPars: { "theaterCode" : '<?=$_POST["theaterCode"]?>'
                           ,"showroomSeq" : <?=$_POST["showroomSeq"]?>
                           ,"distributor_seq" : distributor_seq
                           ,"film_nm"         : film_nm
                           ,"mappinged"       : mappinged
                },
                onLoad  : function(){
                    //gridFilm.setFocus(0);
                }
            });
        },

        // 상영스코어 입력화면으로 들어간다.
        playScore : function(theater_code, showroom_seq, film_code, playprint_seq)
        {
            trace(theater_code+' , '+ showroom_seq+' , '+ film_code+' , '+ playprint_seq);

            jQuery("form[name=frmMain]").attr({action: 'PlayDetail.php', target:'_parent', method:'post'});
            jQuery('<input>').attr({ type: 'hidden', name: 'theater_code', value: theater_code }).appendTo('form[name=frmMain]');
            jQuery('<input>').attr({ type: 'hidden', name: 'showroom_seq', value: showroom_seq }).appendTo('form[name=frmMain]');
            jQuery('<input>').attr({ type: 'hidden', name: 'film_code', value: film_code }).appendTo('form[name=frmMain]');
            jQuery('<input>').attr({ type: 'hidden', name: 'playprint_seq', value: playprint_seq }).appendTo('form[name=frmMain]');

            jQuery("form[name=frmMain]").submit();
        }

    }; // var fnObj = {

    $(document.body).ready(function() { setTimeout(fnObj.pageStart, 1); } );

    </script>

</head>
<body>
    <div class="bodyHeightDiv">

    	<form name="frmMain"></form>

        <div class="modalProgramTitle">
            상영영화선택 (<?=$_POST["theaterName"]?>,<?=$_POST["showroomName"]?>)
        </div>

        <div style="margin-top: 8px;margin-bottom: 5px;">

        	<label class="label">배급사 :</label><select name="Distributor" class="AXSelect" id="AXSelect_Distributor" style="width:150px;" tabindex="3"></select>
        	<label class="label">영화명 :</label><input type="text" name="FilmName" value="" id="AXText_FilmeNm" class="AXInput" />


            <label class="label"><input type="checkbox" name="Mappinged" value="true" id="AXCheck_Mappinged" checked="checked"/> 지정된</label>

            <button style="margin-left: 10px;" type="button" class="AXButton" id="button" tabindex="2" onclick="fnObj.searchFilm();"><i class="axi axi-search2"></i> 조회</button>
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
