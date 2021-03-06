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

    var gridTheater = new AXGrid() ; // 극장 그리드

    var fnObj = {

        pageStart: function()
        {
            // 이걸하지않으면 디자인이 나오지 않는다.
            $('input[type=checkbox]').bindChecked();
            $('input[type=radio]').bindChecked();


            // 지역1 초기화
            jQuery("#AXSelect_Location1").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_location1.php",  // <-----
                ajaxPars: "",
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                    //console.log(this.value);
                    jQuery("#AXSelect_Location2").bindSelect({
                            ajaxUrl: "<?=$path_AjaxJSON?>/bas_location2.php",  // <-----
                            ajaxPars: {"parent_seq":this.value },
                            isspace: true,
                            isspaceTitle: "전체",
                            onChange: function(){
                                //console.log(this.value);
                            }
                        });
                }
            });

            // 지역2 초기화
            jQuery("#AXSelect_Location2").bindSelect({
                options:[
                    {optionValue:'', optionText:"전체"}
                ]
            });

            // 계열사 초기화
            jQuery("#AXSelect_Affiliate").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_affiliate.php",  // <-----
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                   // console.log(this.value);
                }
            });

            // 비계열사 초기화
            jQuery("#AXSelect_Unaffiliate").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_unaffiliate.php",  // <-----
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                   // console.log(this.value);
                }
            });


            // 그리드(극장)
            gridTheater.setConfig(
            {
                targetID : "AXGrid_Theater",
                theme : "AXGrid",
                autoChangeGridView: { // autoChangeGridView by browser width
                    mobile:[0,600], grid:[600]
                },
                fitToWidth: false, // 너비에 자동 맞춤
                colGroup : [

                    {key:"code",          label:"극장코드",    width:"60", align: "center"},
                    {key:"location",      label:"지역",        width:"90"},
                    {key:"affiliate_nm",  label:"계열사",      width:"90"},
                    {key:"direct_nm",     label:"직영여부",    width:"90"},
                    {key:"unaffiliate_nm",label:"비계열",      width:"90"},
                    {key:"user_group_nm", label:"사용자그룹",  width:"90"},
                    {key:"theater_nm",    label:"극장명",      width:"110"},
                    {key:"showroom_nm",   label:"상영관명",    width:"110"},
                    {
                        key: "btns", label: "지정/해지", width: "90", align: "center", formatter: function ()
                        {
                            var id  = this.item.code + '_' + this.item.room_seq + '_<?=$_POST["filmCode"]?>_<?=$_POST["playprintSeq"]?>' ;
                            var val = ((this.item.mapping_dt != null)&&(this.item.unmapping_dt == null)) // 지정일자만 있고 해지일자가 없을경우..
                                      ? "지정"
                                      : "해지"
                                      ;

                            return '<input type="text"                                       '
                                  +'        name=""                                          '
                                  +'        id="' + id + '"                                  '
                                  +'        value="' + val + '"                              '
                                  +'        class="AXInputSwitch"                            '
                                  +'        style="width:60px;height:21px;border:0px none;" >';
                        }
                    },
                    {key:"mapping_dt",    label:"지정일",    width:"110"},
                    {key:"unmapping_dt",  label:"해지일",    width:"110"}
                ],
                body : {
                    onclick: function(){
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
            var location1   = jQuery("#AXSelect_Location1").val();
            var location2   = jQuery("#AXSelect_Location2").val();
            var affiliate   = jQuery("#AXSelect_Affiliate").val();
            var unaffiliate = jQuery("#AXSelect_Unaffiliate").val();
            var theaterNm   = jQuery("#AXText_TheaterNm").val();
            var onlylive    = "Y" ; // 폐관제외 (살아있는건만)...
            var fundFree    = '' ;
            var mappinged   = (jQuery("#AXCheck_Mappinged").prop('checked')) ? "Y" : "N" ;

            gridTheater.setList({
                ajaxUrl : "<?=$path_AjaxJSON?>/wrk_theater_showroom_page.php",  // <-----
                ajaxPars: { "filmCode" : '<?=$_POST["filmCode"]?>'
                           ,"playprintSeq" : <?=$_POST["playprintSeq"]?>
                           ,"location1": location1
                           ,"location2": location2
                           ,"affiliate": affiliate
                           ,"unaffiliate": unaffiliate
                           ,"theaterNm": theaterNm
                           ,"onlylive": onlylive
                           ,"fundFree": fundFree
                           ,"mappinged": mappinged
                },
                onLoad  : function(){
                    //gridTheater.setFocus(0);

                    $(".AXInputSwitch").bindSwitch({ off:"해지"
                                                    ,on:"지정"
                                                    ,onChange:function(){

                                          				trace(this);

                                          				var id = this.targetID.split("_");
                                          				var theater_code  = id[0] ;
                                          				var showroom_seq  = id[1] ;
                                          				var film_code     = id[2] ;
                                          				var playprint_seq = id[3] ;

                                          				jQuery.post( "<?=$path_AjaxJSON?>/wrk_play_mast_save.php", // <-----
                                                  				       {
                                          				                  theater_code  : theater_code
                                          				                 ,showroom_seq  : showroom_seq
                                          				                 ,film_code     : film_code
                                          				                 ,playprint_seq : playprint_seq
                                          				                 ,change_value  : (this.value=='지정') ? 'Y' : 'N'
                                         				               }
                            				                       )
                                                		      .done(function( data )
                                                			  {
                                                		          var obj = eval("("+data+")");
                                                		          //trace(obj);
																  /*
                                                		          if  (obj.result == 'ok') fnObj.modalOpen(500,-1,'확인',obj.msg,null) ;
                                                		          else                     fnObj.modalOpen(500,-1,'오류',obj.msg,null) ;
																  */
                                                		      });
                                          			 }
        			                               });
                }
            });

        }

    }; // var fnObj = {

    $(document.body).ready(function() { setTimeout(fnObj.pageStart, 1); } );

    </script>

</head>
<body style="margin: 0px;">
    <div class="bodyHeightDiv">
        <div class="modalProgramTitle">
            상영관찾기 (<?=$_POST["filmName"]?>,<?=$_POST["playprintName"]?>)
        </div>

        <div style="margin-top: 8px;margin-bottom: 5px;">
            <label class="label">지역1 :</label><select name="Location1" class="AXSelect" id="AXSelect_Location1" style="width:70px;" tabindex="1"></select>
            <label class="label">지역2 :</label><select name="Location2" class="AXSelect" id="AXSelect_Location2" style="width:70px;" tabindex="2"></select>
            <label class="label">계열사 :</label><select name="Affiliate" class="AXSelect" id="AXSelect_Affiliate" style="width:80px;" tabindex="3"></select>
            <label class="label">비계열사 :</label><select name="Unaffiliate" class="AXSelect" id="AXSelect_Unaffiliate" style="width:80px;" tabindex="3"></select>

            <label class="label">극장명 :</label><input type="text" name="input" value="" class="AXInput W140" id="AXText_TheaterNm"/>

            <label class="label"><input type="checkbox" name="Mappinged" value="true" id="AXCheck_Mappinged" /> 지정된</label>

            <button style="margin-left: 10px;" type="button" class="AXButton" id="button" tabindex="2" onclick="fnObj.searchTheater();"><i class="axi axi-search2"></i> 조회</button>
        </div>

        <div class="masterModalBody" id="masterModalBody">
            <div id="AXSearchTarget" style=""></div>

            <div style="padding:5px;">
        		<div id="AXGrid_Theater" style="height:390px;"></div>
            </div>
        </div>

        <div class="modalButtonBox" align="center">
            <button class="AXButton W60" onclick="parent.myModal.close();">닫기</button>
        </div>

    </div>
</body>
</html>
