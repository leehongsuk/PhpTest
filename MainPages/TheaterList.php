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

    <!-- 아이콘사용을 위해서..(http://axicon.axisj.com/) -->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axicon/axicon.min.css"/>

    <!-- css block -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/MainCss/Common.css" />


    <script type="text/javascript">

    var gridTheater = new AXGrid() ; // instance


    var fnObj =
    {
        pageStart: function()
        {
            // 이걸하지않으면 디자인이 나오지 않는다.
            $('input[type=checkbox]').bindChecked();
            $('input[type=radio]').bindChecked();



            // 지역1 초기화
            jQuery("#AXSelect_Location1").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_location1.php",
                ajaxPars: "",
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                    //console.log(this.value);
                    jQuery("#AXSelect_Location2").bindSelect({
                            ajaxUrl: "<?=$path_AjaxJSON?>/bas_location2.php",
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
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_affiliate.php",
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                   // console.log(this.value);
                }
            });

            gridTheater.setConfig(
            {
                targetID : "AXGrid_Theater",
                theme : "AXGrid",
                autoChangeGridView: { // autoChangeGridView by browser width
                    mobile:[0,600], grid:[600]
                },
                fitToWidth: false, // 너비에 자동 맞춤
                colGroup : [
                    {
                        key: "btns", label: "폐관", width: "60", align: "center", formatter: function ()
                        {
                          return '<button class="AXButton" onclick="fnObj.deleteItem(\'' + this.item.code + '\');"><i class="axi axi-trash2"></i></button>';
                        }
                    },
                    {
                        key: "btns", label: "수정", width: "60", align: "center", formatter: function ()
                        {
                            return '<button class="AXButton" onclick="fnObj.editItem(\'' + this.item.code + '\');"><i class="axi axi-pencil"></i></button>';
                        }
                    },

                    {key:"code", label:"극장코드", width:"70", align: "center"},
                    {key:"theater_nm", label:"극장명", width:"120"},
                    {key:"affiliate_nm", label:"계열사", width:"70", align: "center"},
                    {key:"direct_nm", label:"직위", width:"50", align: "center"},
                    {key:"unaffiliate_nm", label:"비계열", width:"90", align: "center"},
                    {key:"user_group_nm", label:"사용자그룹", width:"70", align: "center"},

                    {key:"open_dt", label:"개관일", width:"100", align: "center"},
                    {key:"operation", label:"운영여부", width:"30", align: "center"},
                    {key:"location", label:"지역", width:"100"},
                    {key:"address", label:"주소", width:"120"},
                    /*
                    {key:"score_tel", label:"스코어 전화", width:"100"},
                    {key:"score_fax", label:"스코어 팩스", width:"100"},
                    {key:"score_mail", label:"스코어 메일", width:"100"},
                    {key:"score_sms", label:"스코어 문자", width:"100"},
                    {key:"premium_tel", label:"부금 전화", width:"100"},
                    {key:"premium_fax", label:"부금 팩스", width:"100"},
                    {key:"premium_mail", label:"부금 메일", width:"100"},
                    {key:"premium_sms", label:"부금 문자", width:"100"},
                    */
                    {key:"meno", label:"비고(극장특징)", width:"100"},
                    {key:"fund_free", label:"기금면제여부", width:"100"},
                    {key:"gubun_code", label:"구분코드?", width:"100"},
                    {key:"saup_no", label:"사업자등록번호", width:"100"},
                    {key:"owner", label:"대표자명", width:"100"},
                    {key:"sangho", label:"상호", width:"100"},
                    {key:"homepage", label:"홈페이지", width:"100"},
                    {key:"images_no", label:"이미지번호", width:"100"},
                    {key:"cnt_showroom", label:"관수", width:"50", align: "right"}
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

            gridTheater.setList({
                ajaxUrl : "<?=$path_AjaxJSON?>/wrk_theater_page.php",
                onLoad  : function(){
                    gridTheater.goPageMove(1); // 상대적인 페이지 이동..
                    gridTheater.setFocus(3);  // 페이지별 row의 위치 .. 0 부터..
                }
            });

        },

        // 검색버튼을 누를시..
        searchTheater: function()
        {
            var location1 = jQuery("#AXSelect_Location1").val();
            var location2 = jQuery("#AXSelect_Location2").val();
            var affiliate = jQuery("#AXSelect_Affiliate").val();
            var theaterNm = jQuery("#AXText_TheaterNm").val();
            var operation = (jQuery("#AXCheck_Operation").prop('checked')) ? "Y" : "N" ;
            var fundFree  = (jQuery("#AXCheck_FundFree").prop('checked')) ? "Y" : "N" ;

            gridTheater.setList({
                ajaxUrl : "<?=$path_AjaxJSON?>/wrk_theater_page.php",
                ajaxPars: {
                    "location1": location1,
                    "location2": location2,
                    "affiliate": affiliate,
                    "theaterNm": theaterNm,
                    "operation": operation,
                    "fundFree": fundFree
                },
                onLoad  : function(){
                    gridTheater.setFocus(0);
                }
            });

        },

		//극장폐관처리..
        deleteItem: function (code)
        {
            if (confirm("정말로 폐관하시겠습니까?"))
            {
                jQuery.post( "<?=$path_AjaxJSON?>/wrk_theater_delete.php", { code: code })
                      .done(function( data ) {
                          alert( "극장이 폐관되었습니다. " + data );
                          gridTheater.setList({
                              ajaxUrl : "<?=$path_AjaxJSON?>/wrk_theater_page.php",
                              onLoad  : function(){
                                  //console.trace(this);
                                  //gridTheater.setFocus(this.list.length - 1);
                              }
                          });
                      });
            }
        },

		// 극장 수정 또는 생성 버튼을 누를 시..
        editItem: function (code)
        {
            if (typeof code == "undefined") location.href = "./TheaterEdit.php"
            else                            location.href = "./TheaterEdit.php?code="+code ;
            //toast.push('deleteItem: ' + index);
        }
    };

    jQuery(document).ready(fnObj.pageStart.delay(0.1));


    </script>
</head>

<body>

    <h1>극장정보</h1>
    <div style="height: 50px;">

        <label>지역1 :</label><select name="Location1" class="AXSelect" id="AXSelect_Location1" style="width:100px;" tabindex="1"></select>
        <label>지역2 :</label><select name="Location2" class="AXSelect" id="AXSelect_Location2" style="width:100px;" tabindex="2"></select>
        <label>계열사 :</label><select name="Affiliate" class="AXSelect" id="AXSelect_Affiliate" style="width:100px;" tabindex="3"></select>

        <label>극장명 :</label><input type="text" name="input" value="" class="AXInput W150" id="AXText_TheaterNm"/>

        <label><input type="checkbox" name="Operation" value="true" id="AXCheck_Operation" /> 폐관제외</label>
        <label><input type="checkbox" name="FundFree" value="true" id="AXCheck_FundFree" /> 영진위기금면제</label>

        <button type="button" class="AXButton" id="button" tabindex="2" onclick="fnObj.searchTheater();"><i class="axi axi-search2"></i> 조회</button>
        <button type="button" class="AXButton" id="button" tabindex="2" onclick="fnObj.editItem();"><i class="axi axi-ion-document-text"></i> 등록</button>
    </div>

    <div id="AXGrid_Theater"></div>

</body>
</html>
