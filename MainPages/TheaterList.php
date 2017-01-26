<?php require_once("../config/CONFIG.php"); ?>
<?php require_once("../config/SESSION_OUT.php"); ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Language" content="ko" />

    <!-- 공통요소 -->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axisj-1.1.11/ui/arongi/page.css" />
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

    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXToolBar.js"></script>
    <script type="text/javascript" src="<?=$path_Root?>/MainJavascript/AXToolBar.js"></script>

    <!-- 아이콘사용을 위해서..(http://axicon.axisj.com/) -->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axicon/axicon.min.css"/>

    <!-- css block -->
    <!-- link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet "-->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/MainCss/font-awesome.min.css" />

    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/MainCss/Common.css" />
	<script type="text/javascript" src="<?=$path_Root?>/MainJavascript/CommonLib.js"></script>

    <script type="text/javascript">

    var theaterCode ; // 선택된 극장코드..
    var theaterName ; // 선택된 극장명..

    var gridTheater = new AXGrid() ;  // 극장 그리드
    var gridShowroom = new AXGrid() ; // 상영관 그리드

    var myModal = new AXModal(); // 범용팝업


    var fnObj =
    {
        pageStart: function()
        {
            // 툴바 생성
            fnToolbar.toolbar.init();

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

            // 직.위 초기화
            jQuery("#AXSelect_Isdirect").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_isdirect.php",  // <-----
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                   // console.log(this.value);
                }
            });

            // 비계열 초기화
            jQuery("#AXSelect_Unaffiliate").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_unaffiliate.php",  // <-----
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                   // console.log(this.value);
                }
            });

            // 사용자그룹 초기화
            jQuery("#AXSelect_Usergroup").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_user_group.php",  // <-----
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                   // console.log(this.value);
                }
            });



			// 그리드(극장)
            gridTheater.setConfig(
            {
                targetID : "AXGridTheater",
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
                    {key:"del_dt", label:"폐관일", width:"100", align: "center"},
                    {key:"location", label:"지역", width:"100"},
                    {key:"address", label:"주소", width:"120"},
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
                    onclick: function()
                    {
                        theaterCode = this.item.code ;       // 선택된 극장코드..
                        theaterName = this.item.theater_nm ; // 선택된 극장명..

                        gridShowroom.setList({
                            ajaxUrl : "<?=$path_AjaxJSON?>/wrk_showroom.php",  // <-----
                            ajaxPars:"code="+this.item.code,
                            onLoad  : function(){}
                        });
                    }
                },
                page:{
                    paging:true,
                    pageNo:1,
                    pageSize:10
                }
            });

            gridTheater.setList({
                ajaxUrl : "<?=$path_AjaxJSON?>/wrk_theater_page.php",  // <-----
                onLoad  : function(){
                    //gridTheater.goPageMove(1); // 상대적인 페이지 이동..
                    //gridTheater.setFocus(3);  // 페이지별 row의 위치 .. 0 부터..
                }
            });

            // 그리드(상영관)
            gridShowroom.setConfig(
            {
                targetID : "AXGridShowroom",
                theme : "AXGrid",
                autoChangeGridView: { // autoChangeGridView by browser width
                    mobile:[0,600], grid:[600]
                },
                fitToWidth: false, // 너비에 자동 맞춤
                colGroup : [
                    {key:"seq", label:"no", width:"100"},
                    {key:"room_nm", label:"상영관명", width:"100"},
                    {key:"room_alias", label:"상영관별칭", width:"100"},
                    {
                        key: "btns", label: "스코어입력", width: "100", align: "center", formatter: function ()
                        {
                            //trace(this.item);

                            var showroomSeq  = this.item.seq
                            var showroomName = this.item.room_nm + ' ' + this.item.room_alias ;
                            return '<button class="AXButton" onclick="fnObj.mappingFilm(\'' + theaterCode + '\',\'' + theaterName + '\',\'' + showroomSeq + '\',\'' + showroomName + '\');">스코어입력</button>';

                        }
                    },
                    {key:"cnt_film", label:"상영영화수", width:"100"}
                ],
                body :
                {
                    height: 3,
                    onclick: function()
                    {
                        //console.log(this.item.code);
                    }
                },
                page:{
                    paging:false
                }
            });

        }, // pageStart: function()

        // 검색버튼을 누를시..
        searchTheater: function()
        {
            var location1   = jQuery("#AXSelect_Location1").val();
            var location2   = jQuery("#AXSelect_Location2").val();
            var affiliate   = jQuery("#AXSelect_Affiliate").val();
            var isdirect    = jQuery("#AXSelect_Isdirect").val();
            var unaffiliate = jQuery("#AXSelect_Unaffiliate").val();
            var usergroup   = jQuery("#AXSelect_Usergroup").val();
            var theaterNm   = jQuery("#AXText_TheaterNm").val();
            var onlylive    = (jQuery("#AXCheck_OnlyLive").prop('checked')) ? "Y" : "N" ;
            var fundFree    = (jQuery("#AXCheck_FundFree").prop('checked')) ? "Y" : "N" ;

            gridTheater.setList({
                ajaxUrl : "<?=$path_AjaxJSON?>/wrk_theater_page.php",  // <-----
                ajaxPars: {
                    "location1": location1,
                    "location2": location2,
                    "affiliate": affiliate,
                    "isdirect": isdirect,
                    "unaffiliate": unaffiliate,
                    "usergroup": usergroup,
                    "theaterNm": theaterNm,
                    "onlylive": onlylive,
                    "fundFree": fundFree
                },
                onLoad  : function(){
                    //gridTheater.setFocus(0);
                    gridShowroom.setList({
                        ajaxUrl : "<?=$path_AjaxJSON?>/wrk_showroom.php",  // <-----
                        ajaxPars:"code=",
                        onLoad  : function(){}
                    });
                }
            });

        },

		// 극장폐관처리..
        deleteItem: function (code)
        {
            if (confirm("정말로 폐관하시겠습니까?"))
            {
                jQuery.post( "<?=$path_AjaxJSON?>/wrk_theater_delete.php", { code: code }) // <-----
                      .done(function( data )
                      {
                          dialog.push('<b>알림</b>\n'+ "극장이 폐관되었습니다. " + data );

                          gridTheater.setList({
                              ajaxUrl : "<?=$path_AjaxJSON?>/wrk_theater_page.php",  // <-----
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
        },

        // 상영관에서 스코어입력 버튼을 누를 시...
        mappingFilm: function (theaterCode, theaterName, showroomSeq, showroomName)
        {
            //alert(code);
            myModal.open({
				method: "post",
				url: "AXMdl_SchFilm.php",  // <-----
				pars: {
					   theaterCode : theaterCode
					  ,theaterName : theaterName
					  ,showroomSeq  : showroomSeq
					  ,showroomName : showroomName
					  },
				closeByEscKey: true,
				top: 100,
				width: 900
			});
        }

    }; // var fnObj =

    jQuery(document).ready(fnObj.pageStart.delay(0.1));


    </script>
</head>

<body>

    <div style="height: 70px;">
       <div class="toolBar" id="tool-bar" style="position: relative;border-bottom: 1px solid #d6d6d6;border: 1px solid #d6d6d6;"></div>
       <div style="text-align: right; margin-top: 5px;">
           <a href="./index.php"><b>HOME</b></a> > 극장관리 > 극장정보 &nbsp;&nbsp; [<b><?=$_SESSION["user_name"]?></b>] 님을 환영합니다...&nbsp;&nbsp;<a href="#" onclick="log_out('<?=$path_AjaxSESSION?>')"><b>로그아웃</b></a>&nbsp;
       </div>
    </div>

    <!-- h1>극장정보</h1 -->
    <div>

		<div class="bodyHeightDiv"  style="height: 40px;">
			<label>극장명 :</label><input type="text" name="input" value="" class="AXInput W150" id="AXText_TheaterNm"/>

            <label><input type="checkbox" name="OnlyLive" value="true" id="AXCheck_OnlyLive" /> 폐관제외</label>
            <label><input type="checkbox" name="FundFree" value="true" id="AXCheck_FundFree" /> 영진위기금면제</label>

            <button type="button" class="AXButton" id="button" tabindex="2" onclick="fnObj.searchTheater();"><i class="axi axi-search2"></i> 조회</button>
            <button type="button" class="AXButton" id="button" tabindex="2" onclick="fnObj.editItem();"><i class="axi axi-ion-document-text"></i> 등록</button>
		</div>
        <div class="bodyHeightDiv"  style="height: 40px;">
            <label>지역1 :</label><select name="Location1" class="AXSelect" id="AXSelect_Location1" style="width:100px;" tabindex="1"></select>
            <label>지역2 :</label><select name="Location2" class="AXSelect" id="AXSelect_Location2" style="width:100px;" tabindex="2"></select>
            <label>계열사 :</label><select name="Affiliate" class="AXSelect" id="AXSelect_Affiliate" style="width:100px;" tabindex="3"></select>

            <label>직.위 :</label><select name="Isdirect" class="AXSelect" id="AXSelect_Isdirect" style="width:100px;" tabindex="4"></select>
            <label>비계열 :</label><select name="Unaffiliate" class="AXSelect" id="AXSelect_Unaffiliate" style="width:100px;" tabindex="5"></select>
            <label>사용자그룹 :</label><select name="Usergroup" class="AXSelect" id="AXSelect_Usergroup" style="width:100px;" tabindex="6"></select>

		</div>
    </div>

    <div id="AXGridTheater"></div>
    <br>
	<h3>상영관</h3>
    <div id="AXGridShowroom"></div>

</body>
</html>
