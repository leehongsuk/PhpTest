<?php require_once("../config/CONFIG.php"); ?>
<?php
      // 리스트에서 넘어올때 리스트의 페이지 정보가 필요..
      $MODE = ($_SERVER["QUERY_STRING"] == null) ? "APPEND" : "EDIT";
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

    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXModal.js"></script>

    <!-- 아이콘사용을 위해서..(http://axicon.axisj.com/) -->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axicon/axicon.min.css"/>

    <!-- css block -->
    <!-- link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet "-->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/MainCss/font-awesome.min.css" />



	<script type="text/javascript" src="<?=$path_Root?>/MainJavascript/CommonLib.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/MainCss/Common.css" />


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
        padding:10px;
        border-top:1px solid #ccc;
    }

    .unitprice_box {
        display: table-cell;

    }
    .unitprice_item {
        display:inline-block;
        width:90px;
        line-height: 36px;
        margin-left:1px;
    }
    </style>

    <script type="text/javascript">

    var theater_json ;

    var myUpload         = new AXUpload5(); // 이미지 파일업로드

    var grid_Contact     = new AXGrid() ; // 연락처 그리드
    var grid_ChangeHist  = new AXGrid() ; // 변경내역 그리드
    var grid_ShowRoom    = new AXGrid() ; // 상영관 그리드
    var grid_Distributor = new AXGrid() ; // 배급사 그리드

    var myModal = new AXModal(); // 우편번호검색을 위한 팝업창과 범용팝업


    // 하나의 극장정보를 읽어 온다.
    function readTheaterOne(mode)
    {
        jQuery.post( "<?=$path_AjaxJSON?>/wrk_theater_one_sel.php", { mode: mode,  code: '<?=$_GET['code']?>' })  // <-----
              .done(function( data )
              {
                  	theater_json = eval('('+data+')');

                    jQuery("input[name=code]").val(theater_json.code);
                    jQuery("input[name=theater_nm]").val(theater_json.theater_nm);
                    jQuery("input[name=zip]").val(theater_json.zip);
                    jQuery("input[name=addr1]").val(theater_json.addr1);
                    jQuery("input[name=addr2]").val(theater_json.addr2);
                    jQuery("textarea[name=memo]").text(theater_json.memo);
                    jQuery("input[name=open_dt]").val(theater_json.open_dt);
                    jQuery("input[name=gubun_code]").val(theater_json.gubun_code);
                    jQuery("input[name=saup_no]").val(theater_json.saup_no);
                    jQuery("input[name=owner]").val(theater_json.owner);
                    jQuery("input[name=sangho]").val(theater_json.sangho);
                    jQuery("input[name=homepage]").val(theater_json.homepage);

                    jQuery("input[name=fund_free").prop('checked',(theater_json.fund_free=="Y"));

                    jQuery("input[name=score_tel").prop('checked',(theater_json.score_tel=="Y"));
                    jQuery("input[name=score_fax").prop('checked',(theater_json.score_fax=="Y"));
                    jQuery("input[name=score_mail").prop('checked',(theater_json.score_mail=="Y"));
                    jQuery("input[name=score_sms").prop('checked',(theater_json.score_sms=="Y"));

                    jQuery("input[name=premium_tel").prop('checked',(theater_json.premium_tel=="Y"));
                    jQuery("input[name=premium_fax").prop('checked',(theater_json.premium_fax=="Y"));
                    jQuery("input[name=premium_mail").prop('checked',(theater_json.premium_mail=="Y"));
                    jQuery("input[name=premium_sms").prop('checked',(theater_json.premium_sms=="Y"));

                    jQuery("input:hidden[name=images_no]").val(theater_json.images_no);

                    $('input[type=checkbox]').bindChecked();


                    jQuery("select[name=affiliate_seq]").setValueSelect(theater_json.affiliate_seq);
                    jQuery("select[name=isdirect]").setValueSelect(theater_json.isdirect);
                    jQuery("select[name=unaffiliate_seq]").setValueSelect(theater_json.unaffiliate_seq);
                    jQuery("select[name=user_group_seq]").setValueSelect(theater_json.user_group_seq);

                    grid_ChangeHist.setList({
                        ajaxUrl : "<?=$path_AjaxJSON?>/wrk_theater_chghist_page.php",  // <-----
                        ajaxPars: {
                            "theater_code": theater_json.code
                        },
                        onLoad  : function(){
                            //trace(this);
                        }
                    });

                    fnObj.pageStart.delay(0.1) ; ///////////////////////// pageStart

        });
    }

    var fnObj =
    {
        readTheaterOne_callbak: function()
        {
            // 지역1,2 (seelct)
            jQuery("select[name=loc2]").setValueSelect(theater_json.loc2);
            jQuery("select[name=loc1]").setValueSelect(theater_json.loc1);

            jQuery("#AXSelect_Loccation1").bindSelect({
                onChange: function(){
                    //console.log(this.value);
                    jQuery("#AXSelect_Loccation2").bindSelect({
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

            // 계열사,직위,비계열,사용자그룹 (seelct)
            jQuery("select[name=affiliate_seq]").setValueSelect(theater_json.affiliate_seq) ;
            jQuery("select[name=isdirect]").setValueSelect(theater_json.isdirect) ;
            jQuery("select[name=unaffiliate_seq]").setValueSelect(theater_json.unaffiliate_seq) ;
            jQuery("select[name=user_group_seq]").setValueSelect(theater_json.user_group_seq) ;

            // 상영관(grid)
            grid_ShowRoom.setList(theater_json.showrooms);

            // 배급사(grid)
            grid_Distributor.setList(theater_json.distributors);
        },
        pageStart: function()
        {
            // 이걸하지않으면 디자인이 나오지 않는다.
            $('input[type=checkbox]').bindChecked();
            $('input[type=radio]').bindChecked();

            myModal.setConfig({windowID:"myModalCT",
                displayLoading: false,
                scrollLock: false
               });  // 우편번호검색을 위한 팝업창

			// 개관일 초기화
            $("#AXInputDate_Open").bindDate({
                align:"right",
                valign:"top",
                onChange:function(){
                    //toast.push(Object.toJSON(this));
                }
            });

            // 연락처 그리드 초기화
            grid_Contact.setConfig(
            {
                targetID : "AXgrid_Contact",
                height : 250,
                theme : "AXGrid",
                fitToWidth: false, // 너비에 자동 맞춤
                passiveMode:true,
                passiveRemoveHide:false,
                colGroup : [
                    {key: "btns", label: "삭제", width: "60", align: "center", formatter: function ()
                        {
                          return '<button class="AXButton" onclick="fnObj.gridContact.deleteItem(\'' + this.index + '\');"><i class="axi axi-trash2"></i></button>';
                        }
                    },
                    {key:"status", label:"상태", width:"50", align:"center", formatter:function()
                        {
	                        if(this.item._CUD == "C"){ return "신규"; }
	                        else if(this.item._CUD == "D"){ return "삭제"; }
	                        else if(this.item._CUD == "U"){ return "수정"; }
	                    }
                    },
                    {key:"name", label:"이름",     width:"100"},
                    {key:"tel",  label:"대표번호", width:"110"},
                    {key:"hp",   label:"무선전화", width:"110"},
                    {key:"fax",  label:"팩스",     width:"110"},
                    {key:"mail", label:"이메일",   width:"250"}
                ],
                body : {
                    ondblclick: function()
                    {
                        grid_Contact.setEditor(this.item, this.index);
                    }
                },
                page:{
                    paging:false
                },
                editor: {
                    rows: [
                            [
                                {key:"status", align:"center", valign:"middle", form:{type:"hidden", value:"itemValue"}},
                                {colSeq:1, align:"center", valign:"middle", form:{type:"hidden", value:"itemValue"}},
                                {colSeq:2, align:"left", valign:"top", form:{type:"text", value:"itemValue"}},
                                {colSeq:3, align:"left", valign:"top", form:{type:"text", value:"itemValue"}},
                                {colSeq:4, align:"left", valign:"top", form:{type:"text", value:"itemValue"}},
                                {colSeq:5, align:"left", valign:"top", form:{type:"text", value:"itemValue"}},
                                {colSeq:6, align:"left", valign:"top", form:{type:"text", value:"itemValue"}}
                            ]
                    ],
                    response: function()
                    {
                        if(this.index == null) // 추가
                        {
                            var pushItem = this.res.item;

                            if(this.res.item.name == ""){
                                dialog.push('<b>알림</b>\n 이름이 비어 추가 할 수 없습니다.');
                                return;
                            }

                            grid_Contact.pushList(pushItem, this.insertIndex);
                        }
                        else // 수정
                        {
                            fnObj.gridContact.restoreList(this.index); // 삭제된걸 다시 복구한다.

                           	trace(this.index);
                           	trace(this.list);
                           	trace(this.res.item);

							AXUtil.overwriteObject(this.list[this.index], this.res.item, true); // this.list[this.index] object 에 this.res.item 값 덮어쓰기
                            grid_Contact.updateList(this.index, this.list[this.index]);
                        }
                    }
                }
            });


            // 연락처 탭을 구성한다.
            $("#AXTabs_Contact").bindTab({
                theme : "AXTabs",
                //value:"S", // 첫번째가 바로 선택되도록..
                overflow:"scroll", // "visible"

                onchange: function(selectedObject, value){
                    //toast.push(Object.toJSON(this));
                    //toast.push(Object.toJSON(selectedObject));
                    //toast.push("onchange: "+Object.toJSON(value));

                    jQuery.each(theater_json.contacts,function()
                    {
                        if (this.code == value)
                        {
                            grid_Contact.setList(this.contacts); // theater_json.contacts[?].contacts 를 각 탭이 변경될때마다 적용한다.
                        }
                    })
                },
                onclose: function(selectedObject, value){
                    //toast.push(Object.toJSON(this));
                    //toast.push(Object.toJSON(selectedObject));
                    //toast.push("onclose: "+Object.toJSON(value));
                }
            });

            $("#AXTabs_Contact").closeTab();
            $("#AXTabs_Contact").addTabs(theater_json.contact_option.options);

            if  (theater_json.contact_option.options.length > 0) // 하나라도 있다면...
            {
                $("#AXTabs_Contact").setValueTab(theater_json.contact_option.options[0].optionValue); // 첫번째를 먼저 선택한다.
            }

            // 지역1 초기화
            jQuery("#AXSelect_Loccation1").bindSelect({
                reserveKeys: {
                    optionValue: "optionValue",
                    optionText: "optionText"
                },
                options: theater_json.loc1_option.options,
                isspace: true,
                isspaceTitle: "없음"
            });

            // 지역2 초기화
            jQuery("#AXSelect_Loccation2").bindSelect({
                reserveKeys: {
                    optionValue: "optionValue",
                    optionText: "optionText"
                },
                options: theater_json.loc2_option.options,
                isspace: true,
                isspaceTitle: "없음"
            });

            // 계열사 초기화
            jQuery("#AXSelect_Affiliate").bindSelect({
                reserveKeys: {
                    optionValue: "optionValue",
                    optionText: "optionText"
                },
                options: theater_json.affiliate_option.options,
                isspace: true,
                isspaceTitle: "없음",
                onChange: function(){
                    //console.log(this.value);
                }
            });
            // 직영위탁 초기화
            jQuery("#AXSelect_IsDirect").bindSelect({
                reserveKeys: {
                    optionValue: "optionValue",
                    optionText: "optionText"
                },
                options: theater_json.isdirect_option.options,
                isspace: true,
                isspaceTitle: "없음",
                onChange: function(){
                    //console.log(this.value);
                }
            });


            // 비계열 초기화
            jQuery("#AXSelect_Unaffiliate").bindSelect({
                reserveKeys: {
                    optionValue: "optionValue",
                    optionText: "optionText"
                },
                options: theater_json.unaffiliate_option.options,
                isspace: true,
                isspaceTitle: "없음",
                onChange: function(){
                    //console.log(this.value);
                }
            });

            // 사용자그룹 초기화
            jQuery("#AXSelect_UserGroup").bindSelect({
                reserveKeys: {
                    optionValue: "optionValue",
                    optionText: "optionText"
                },
                options: theater_json.usergroup_option.options,
                isspace: true,
                isspaceTitle: "없음",
                onChange: function(){
                    //console.log(this.value);
                }
            });


            // 변경정보 그리드 초기화
            grid_ChangeHist.setConfig(
            {
                targetID : "AXGrid_ChangeHist",
                height : 250,
                theme : "AXGrid",
                fitToWidth: false, // 너비에 자동 맞춤
                colGroup : [
                    {key:"seq",             label:"변경일련번호",        width: "50", align:"right"},
                    {key:"change_datetime", label:"변경시간",            width:"140"},
                    {key:"location",        label:"지역",                width:"100"},
                    {key:"affiliate_seq",   label:"계열사코드",          width:"100"},
                    {key:"dir_mng",         label:"직영여부",            width:"100"},
                    {key:"unaffiliate",     label:"비계열코드",          width:"100"},
                    {key:"user_group",      label:"사용자그룹코드",      width:"100"},
                    {key:"operation",       label:"운영여부",            width: "40"},
                    {key:"theater_nnm",     label:"극장명",              width:"150"},
                    {key:"fund_free",       label:"기금면제여부",        width: "40"},
                    {key:"gubun_code",      label:"구분코드??",          width:"100"},
                    {key:"saup_no",         label:"사업자등록번호",      width:"100"},
                    {key:"owner",           label:"대표자명",            width:"100"},
                    {key:"sangho",          label:"상호",                width:"150"},
                    {key:"homepage",        label:"홈페이지",            width:"100"},
                    {key:"images_no",       label:"이미지 첨부파일번호", width:"100"}                ],
                body : {
                    onclick: function(){
                        ///console.log(this.item);
                    }
                },
                page:{
                    paging:true,
                    pageNo:1,
                    pageSize:10
                }
            });

			// 상영관 그리드 초기화
            grid_ShowRoom.setConfig(
            {
                targetID : "AXGrid_ShowRoom",
                height : 250,
                theme : "AXGrid",
                fitToWidth: false, // 너비에 자동 맞춤
                passiveMode:true,
                passiveRemoveHide:false,
                colGroup : [
                    {key: "btns", label: "삭제", width: "60", align: "center", formatter: function ()
                        {
                            //trace(this.index);
                          return '<button class="AXButton" onclick="fnObj.gridShowroom.deleteItem(\'' + this.index + '\');"><i class="axi axi-trash2"></i></button>';
                        }
                    },
                    {key:"status", label:"상태", width:"50", align:"center", formatter:function()
                        {
	                        if(this.item._CUD == "C"){ return "신규"; }
	                        else if(this.item._CUD == "D"){ return "삭제"; }
	                        else if(this.item._CUD == "U"){ return "수정"; }
	                    }
                    },
                    {key:"room_nm",    label:"상영관명",   width:"100"},
                    {key:"room_alias", label:"상영관별칭", width:"100"},
                    {key:"art_room",   label:"예술관",     width:"70"},
                    {key:"seat",       label:"좌석수",     width:"100"}
                ],
                body : {
                    ondblclick: function()
                    {
                        //toast.push(Object.toJSON({index:this.index, item:this.item}));
                        grid_ShowRoom.setEditor(this.item, this.index);
                    }
                },
                page:{
                    paging:false
                },
                editor: {
                    rows: [
                            [
                                {key:"status", align:"center", valign:"middle", form:{type:"hidden", value:"itemValue"}},
                                {colSeq:1, align:"center", valign:"middle", form:{type:"hidden", value:"itemValue"}},
                                {colSeq:2, align:"left", valign:"top", form:{type:"text", value:"itemValue"}},
                                {colSeq:3, align:"left", valign:"top", form:{type:"text", value:"itemValue"}},
                                {colSeq:4, align:"center", valign:"middle", form:{type:"checkbox", value:"itemValue", options:[ {value:'Y', text:''} ] }},
                                {colSeq:5, align:"left", valign:"top", form:{type:"text", value:"itemValue"}, AXBind:{type:"number", config:{min:1, max:500}}} // 1석에서 500석까지..
                            ]
                    ],
                    response: function()
                    {
                        if(this.index == null) // 추가
                        {
                            var pushItem = this.res.item;

                            var errorMsg = '' ;

                            if (this.res.item.room_nm == "") { errorMsg += '상영관명이 비어 추가 할 수 없습니다.\n'; }
                            if (this.res.item.seat == "")    { errorMsg += '좌석수가 비어 추가 할 수 없습니다.\n'; }

                            if  (errorMsg != '')
                            {
                                dialog.push('<b>알림</b>\n'+errorMsg);
                                return;
                            }

                            grid_ShowRoom.pushList(pushItem, this.insertIndex);
                        }
                        else // 수정
                        {
                            fnObj.gridShowroom.restoreList(this.index); // 삭제된걸 다시 복구한다.

                           	trace(this.index);
                           	trace(this.list);
                           	trace(this.res.item);

							AXUtil.overwriteObject(this.list[this.index], this.res.item, true); // this.list[this.index] object 에 this.res.item 값 덮어쓰기
							grid_ShowRoom.updateList(this.index, this.list[this.index]);
                        }
                    }
                }
            });

			// 배급사 그리드 초기화
            grid_Distributor.setConfig(
            {
                targetID : "AXGrid_Distributor",
                height : 250,
                theme : "AXGrid",
                fitToWidth: false, // 너비에 자동 맞춤
                passiveMode:true,
                passiveRemoveHide:false,
                colGroup : [
                    {key: "btns", label: "삭제", width: "60", align: "center", formatter: function ()
                        {
                            //trace(this.index);
                          	return '<button class="AXButton" onclick="fnObj.gridDistributor.deleteItem(\'' + this.index + '\');"><i class="axi axi-trash2"></i></button>';
                        }
                    },
                    {key:"status", label:"상태", width:"50", align:"center", formatter:function()
                        {
	                        if(this.item._CUD == "C"){ return "신규"; }
	                        else if(this.item._CUD == "D"){ return "삭제"; }
	                        else if(this.item._CUD == "U"){ return "수정"; }
	                    }
                    },
                    {key:"distributor_seq",label:" ",               width:"1", formatter: function () { return '' ; }},
                    {key:"distributor_nm", label:"배급사",          width:"200"},
                    {key:"theater_knm",    label:"극장명(한글)",    width:"200"},
                    {key:"theater_enm",    label:"극장명(영문)",    width:"200"},
                    {key:"theater_dcode",  label:"배급사 극장코드", width:"100"}
                ],
                body : {
                    ondblclick: function()
                    {
                        //toast.push(Object.toJSON({index:this.index, item:this.item}));
                        grid_Distributor.setEditor(this.item, this.index);
                    }
                },
                page:{
                    paging:false
                },
                editor: {
                    rows: [
                            [
                                {key:"status", align:"center", valign:"middle", form:{type:"hidden", value:"itemValue"}},
                                {colSeq:1, align:"center", valign:"middle", form:{type:"hidden", value:"itemValue"}},
                                {colSeq:2, align:"center", valign:"middle", form:{type:"hidden", value:"itemValue"}},
                                {colSeq:3, align:"left", valign:"top", form:{type:"text", value:"itemValue"}
                                         ,AXBind:{
                                                  type:"selector",
                                                  config:{
                                                          appendable:true,
                                                          ajaxUrl:"<?=$path_AjaxJSON?>/bas_distributor.php",  // <-----
                                                          ajaxPars:"",
                                                          onChange:function(){
                                                              if(this.selectedOption){

                                                              grid_Distributor.setEditorForm({
                                                                  key:"distributor_seq",
                                                                  position:[0,2], // editor rows 적용할 대상의 배열 포지션 (다르면 적용되지 않습니다.)
                                                                  value:this.selectedOption.optionValue
                                                              });
                                                              grid_Distributor.setEditorForm({
                                                                  key:"distributor_nm",
                                                                  position:[0,3], // editor rows 적용할 대상의 배열 포지션 (다르면 적용되지 않습니다.)
                                                                  value:this.selectedOption.optionText
                                                              });
                                                              }
                                                          }
                                                         }
                                         		 }

                                },
                                {colSeq:4, align:"left", valign:"top", form:{type:"text", value:"itemValue"}},
                                {colSeq:5, align:"left", valign:"top", form:{type:"text", value:"itemValue"}},
                                {colSeq:6, align:"left", valign:"top", form:{type:"text", value:"itemValue"}}
                            ]
                    ],
                    response: function()
                    {
                        if(this.index == null) // 추가
                        {
                            var pushItem = this.res.item;

                            var errorMsg = '' ;

                            if (this.res.item.distributor_nm == "")  { errorMsg += '배급사가 비어 추가 할 수 없습니다.\n'; }
                            if (this.res.item.theater_knm == "")     { errorMsg += '극장명(한글)이 비어 추가 할 수 없습니다.\n'; }
                            if (this.res.item.theater_enm == "")     { errorMsg += '극장명(영문)이 비어 추가 할 수 없습니다.\n'; }
                            if (this.res.item.theater_dcode == "")   { errorMsg += '배급사 극장코드가 비어 추가 할 수 없습니다.\n'; }

                            if  (errorMsg != '')
                            {
                                dialog.push('<b>알림</b>\n'+errorMsg);
                                return;
                            }

                            grid_Distributor.pushList(pushItem, this.insertIndex);
                        }
                        else // 수정
                        {
                            fnObj.gridDistributor.restoreList(this.index); // 삭제된걸 다시 복구한다.

                           	//trace(this.index);
                           	//trace(this.list);
                           	//trace(this.res.item);

							AXUtil.overwriteObject(this.list[this.index], this.res.item, true); // this.list[this.index] object 에 this.res.item 값 덮어쓰기
							grid_Distributor.updateList(this.index, this.list[this.index]);
                        }
                    }
                }
            });

            var obj  = theater_json.unitprices;
			var tag1 = '<div class="unitprice_item"><label>';
			var tag2 = '</label></div>';

			for (var i=0 ; i<obj.options.length ; i++)
			{
			    var checked = (obj.options[i].unit_price_seq != null) ? 'checked=checked' : '' ;

			    $("#divUnitPrice").before(tag1 + '<input type="checkbox" name="unitPrices[]" value="'+obj.options[i].seq+'" '+checked+'/> ' + obj.options[i].unit_price + tag2);
			}
			$('input[type=checkbox]').bindChecked();


			fnObj.upload.init();

            fnObj.readTheaterOne_callbak.delay(0.1) ;

        }, // end (pageStart: function())


        // 연락처 그리드 관련 이벤트 함수 그룹..
        gridContact:
        {

            // 연락처 추가 버튼을 누를 때..
            appendGrid: function(index)
            {
                var item = {};
                if(index){
                    grid_Contact.appendList(item, index);
                }else{
                    grid_Contact.appendList(item);
                }
            },

            // 연락처에서 삭제버튼을 누를 때..
            deleteItem: function (index)
            {
                if (confirm("정말로 삭제하시겠습니까?"))
                {
                    var collect = [];

                    for (var item, itemIndex = 0, __arr = grid_Contact.list; (itemIndex < __arr.length && (item = __arr[itemIndex])); itemIndex++)
                    {
                        if (!item.___disabled) item.___disabled = {};
                        if (!item.___checked) item.___checked = {};

                        if  (itemIndex == index)
                        {
                            item.___disabled[0] = false;
                            item.___checked[0] = true;

    						collect.push({index: itemIndex, item: item});
                        }
                    }

                    grid_Contact.removeListIndex(collect);
                }
            },

            // 연락처에서 더블클릭으로 수정할 때..
            restoreList: function(index)
            {
                var collect = [];

                for (var item, itemIndex = 0, __arr = grid_Contact.list; (itemIndex < __arr.length && (item = __arr[itemIndex])); itemIndex++)
                {
                    if (!item.___disabled) item.___disabled = {};
                    if (!item.___checked) item.___checked = {};

                    if  (itemIndex == index)
                    {
                        item.___disabled[0] = false;
                        item.___checked[0] = true;

    					collect.push({index: itemIndex, item: item});
                    }
                }

                var removeList = [];
                $.each(collect, function()
                {
                    removeList.push({seq:this.item.seq});
                });
                grid_Contact.restoreList(removeList);
            }
        },

        // 상영관 그리드 관련 이벤트 함수 그룹..
        gridShowroom:
        {

            // 상영관 추가 버튼을 누를 때..
            appendGrid: function(index)
            {
                var item = {};
                if(index){
                    grid_ShowRoom.appendList(item, index);
                }else{
                    grid_ShowRoom.appendList(item);
                }
            },

            // 상영관에서 삭제버튼을 누를 때..
            deleteItem: function (index)
            {
                if (confirm("정말로 삭제하시겠습니까?"))
                {
                    var collect = [];

                    for (var item, itemIndex = 0, __arr = grid_ShowRoom.list; (itemIndex < __arr.length && (item = __arr[itemIndex])); itemIndex++)
                    {
                        if (!item.___disabled) item.___disabled = {};
                        if (!item.___checked) item.___checked = {};

                        if  (itemIndex == index)
                        {
                            item.___disabled[0] = false;
                            item.___checked[0] = true;

    						collect.push({index: itemIndex, item: item});
                        }
                    }

                    grid_ShowRoom.removeListIndex(collect);
                }
            },

            // 상영관에서 더블클릭으로 수정할 때..
            restoreList: function(index)
            {
                var collect = [];

                for (var item, itemIndex = 0, __arr = grid_ShowRoom.list; (itemIndex < __arr.length && (item = __arr[itemIndex])); itemIndex++)
                {
                    if (!item.___disabled) item.___disabled = {};
                    if (!item.___checked) item.___checked = {};

                    if  (itemIndex == index)
                    {
                        item.___disabled[0] = false;
                        item.___checked[0] = true;

    					collect.push({index: itemIndex, item: item});
                    }
                }

                var removeList = [];
                $.each(collect, function()
                {
                    removeList.push({seq:this.item.seq});
                });
                grid_ShowRoom.restoreList(removeList);
            }
        },


		// 배급사 그리드 관련 이벤트 함수 그룹..
        gridDistributor:
        {

            // 배급사 추가 버튼을 누를 때..
            appendGrid: function(index)
            {
                var item = {};
                if(index){
                    grid_Distributor.appendList(item, index);
                }else{
                    grid_Distributor.appendList(item);
                }
            },

            // 배급사에서 삭제버튼을 누를 때..
            deleteItem: function (index)
            {
                if (confirm("정말로 삭제하시겠습니까?"))
                {
                    var collect = [];

                    for (var item, itemIndex = 0, __arr = grid_Distributor.list; (itemIndex < __arr.length && (item = __arr[itemIndex])); itemIndex++)
                    {
                        if (!item.___disabled) item.___disabled = {};
                        if (!item.___checked) item.___checked = {};

                        if  (itemIndex == index)
                        {
                            item.___disabled[0] = false;
                            item.___checked[0] = true;

    						collect.push({index: itemIndex, item: item});
                        }
                    }

                    grid_Distributor.removeListIndex(collect);
                }
            },

            // 배급사에서 더블클릭으로 수정할 때..
            restoreList: function(index)
            {
                var collect = [];

                for (var item, itemIndex = 0, __arr = grid_Distributor.list; (itemIndex < __arr.length && (item = __arr[itemIndex])); itemIndex++)
                {
                    if (!item.___disabled) item.___disabled = {};
                    if (!item.___checked) item.___checked = {};

                    if  (itemIndex == index)
                    {
                        item.___disabled[0] = false;
                        item.___checked[0] = true;

    					collect.push({index: itemIndex, item: item});
                    }
                }

                var removeList = [];
                $.each(collect, function()
                {
                    removeList.push({seq:this.item.seq});
                });
                grid_Distributor.restoreList(removeList);
            }
        },


        upload: {
			init: function(){
				myUpload.setConfig({
					targetID:"AXUpload5",
					//targetButtonClass:"Green",
					uploadFileName:"fileData",

                    fileSelectAutoUpload:false,
                    buttonTxt: "전송 할 파일 찾기...",

					//file_types:"*.*",  //audio/*|video/*|image/*|MIME_type (accept)
					file_types:"image/*",
					dropBoxID:"uploadQueueBox",
					queueBoxID:"uploadQueueBox", // upload queue targetID
					// html 5를 지원하지 않는 브라우저를 위한 swf upload 설정 원치 않는 경우엔 선언 하지 않아도 됩니다. ------- s
					flash_url : "<?=$path_Root?>/js/axisj-1.1.11/lib/swfupload.swf",
					flash9_url : "<?=$path_Root?>/js/axisj-1.1.11/lib/swfupload_fp9.swf",
					// --------- e
					onClickUploadedItem: function(){ // 업로드된 목록을 클릭했을 때.
						//trace(this);
						window.open(this.uploadedPath.dec() + this.saveName.dec(), "_blank", "width=500,height=500");
					},

					uploadMaxFileSize:(10*1024*1024), // 업로드될 개별 파일 사이즈 (클라이언트에서 제한하는 사이즈 이지 서버에서 설정되는 값이 아닙니다.)
					uploadMaxFileCount:1, // 업로드될 파일갯수 제한 0 은 무제한
					uploadUrl:"<?=$path_AjaxJSON?>/AXU5_fileUpload.php",  // <-----
					uploadPars:{userID:'tom', userName:'액시스'},

					deleteUrl:"<?=$path_AjaxJSON?>/AXU5_fileDelete.php",  // <-----
					deletePars:{userID:'tom', userName:'액시스'},

					fileKeys:{ // 서버에서 리턴하는 json key 정의 (id는 예약어 사용할 수 없음)
						name:"name",
						type:"type",
						saveName:"saveName",
						fileSize:"fileSize",
						uploadedPath:"uploadedPath",
						thumbPath:"thumbUrl" // 서버에서 키값을 다르게 설정 할 수 있다는 것을 확인 하기 위해 이름을 다르게 처리한 예제 입니다.
					},

					formatter: function(f){
						var po = [];
						po.push("<div id='"+this.id+"_AXUploadLabel_mainImageFile' class='AXUploadMainImage' >mainImage</div>");

						return po.join('');
					},

					onUpload: function() // 이미지 업로드가 완료되면..
					{
					    var list = myUpload.getUploadedList();

					    jQuery("input:hidden[name=images_no]").val( list[0].result ) ; // <input type="hidden" name="images_no"> 값을 설정한다.

					    //trace(list[0].result);
					},
					onComplete: function() {},
					onStart: function() {},
					onDelete: function() {},

					onError: function(errorType, extData)
					{
						if(errorType == "html5Support"){
							//dialog.push('The File APIs are not fully supported in this browser.');
						}else if(errorType == "fileSize"){
							trace(extData);
							alert("파일사이즈가 초과된 파일을 업로드 할 수 없습니다. 업로드 목록에서 제외 합니다.\n("+extData.name+" : "+extData.size.byte()+")");
						}else if(errorType == "fileCount"){
							alert("업로드 갯수 초과 초과된 아이템은 업로드 되지 않습니다.");
						}
					}
				});
				// changeConfig

				// 서버에 저장된 파일 목록을 불러와 업로드된 목록에 추가 합니다. ----------------------------- s
				var url = "<?=$path_AjaxJSON?>/AXU5_fileListLoad.php?gubun=theater&code=<?=$_GET['code']?>";  // <-----
				var pars = "dummy="+AXUtil.timekey();
				new AXReq(url, {pars:pars, onsucc:function(res){
                    if(!res.error){
                        myUpload.setUploadedList(res);
                    }else{
                        alert(res.msg.dec());
                    }
				}});
				// 서버에 저장된 파일 목록을 불러와 업로드된 목록에 추가 합니다. ----------------------------- e

			},
			printMethodReturn: function(method, type){
				var list = myUpload[method](type);
				//trace(list);
				trace(myUpload.getUploadedList());
				toast.push(Object.toJSON(list));
			},
			changeOption: function(){

				// 업로드 갯수 등 업로드 관련 옵션을 동적으로 변경 할 수 있습니다.
				myUpload.changeConfig({

					uploadMaxFileCount:10
				});
			}
		},

        // 우편번호를 모달로 검색하거나 선택한다.
        addr:
        {
			search: function()
			{
				myModal.open({
					method:"get",
					url:"AXMdl_AddrFinder.php",  // <-----
					pars:"",
					closeByEscKey: true,
					top:100,
					width:500
				});
			},
			set: function(obj)
			{
				var frm = document.frmThearter;
				frm.zip.value = obj.zip;
				frm.addr1.value = obj.addr;
				frm.addr2.focus();
			}
		},

		// 하나의 극장을 저장한다.
		save_theater : function()
		{
		    var errorMsg = '' ;

		    var theater_nm      = jQuery("input[name=theater_nm]").val().trim() ;
		    var open_dt         = jQuery("input[name=open_dt]").val().trim() ;
		    var saup_no         = jQuery("input[name=saup_no]").val().trim() ;
            var owner           = jQuery("input[name=owner]").val().trim() ;
            var sangho          = jQuery("input[name=sangho]").val().trim() ;
            var homepage        = jQuery("input[name=homepage]").val().trim() ;
            var loc1            = jQuery("select[name=loc1]").val() ;
            var loc2            = jQuery("select[name=loc2]").val() ;
            var zip             = jQuery("input[name=zip]").val().trim() ;
            var addr2           = jQuery("input[name=addr2]").val().trim() ;
            var affiliate_seq   = jQuery("select[name=affiliate_seq]").val() ;
            var isdirect        = jQuery("select[name=isdirect]").val() ;
            var unaffiliate_seq = jQuery("select[name=unaffiliate_seq]").val() ;
            var user_group_seq  = jQuery("select[name=user_group_seq]").val() ;

		    if  (theater_nm == '') errorMsg += '극장명이 없습니다.<br>' ;
		    if  (open_dt == '')    errorMsg += '개관일이 없습니다.<br>';
		    if  (saup_no == '')    errorMsg += '사업자번호가 없습니다.<br>';
		    if  (owner == '')      errorMsg += '대표자명이 없습니다.<br>';
		    if  (sangho == '')     errorMsg += '상호가 없습니다.<br>';
	        if  (loc1 == '')       errorMsg += '지역1이 없습니다.<br>';
	        if  (loc2 == '')       errorMsg += '지역2가 없습니다.<br>';
	        if  (zip == '')        errorMsg += '우편번호가 없습니다.<br>';
	        if  (addr2 == '')      errorMsg += '상세주소가 없습니다.<br>';

	        if  ((affiliate_seq == '') && (unaffiliate_seq == ''))  errorMsg += '계열사와 비계열중 하나는 선택되어야 합니다.<br>'
	        else
	        {
    	        if  ((affiliate_seq != '') && (unaffiliate_seq != ''))   errorMsg += '계열사와 비계열은 같이 지정할 수 없습니다.<br>'
    	        else
    	        {
    	            if  ((affiliate_seq != '') && (isdirect ==''))   errorMsg += '계열사가 있으면 직영/위탁여부도 같이 지정해야 합니다.<br>'
    	        }
	        }

			// 상영관리스트 갯수 체크
	        var count = 0 ;
	        theater_json.showrooms.forEach(function(e)
            {
	            if (typeof e._CUD != "undefined")
	            {
	                if (e._CUD != 'D') count++ ;
	            }
	            else
	            {
	                count++ ;
	            }
            });

            if  (count == 0)
            {
                errorMsg += '상영관이 하나이상 존재해야 됩니다.<br>';
            }


            // 배급사리스트 갯수 체크
            var count = 0 ;
		    grid_Distributor.list.forEach(function(e)
            {
	            if (typeof e._CUD != "undefined")
	            {
	                if (e._CUD != 'D') count++ ;
	            }
	            else
	            {
	                count++ ;
	            }
            });

            var skip = false ;

            if  (count == 0)
            {
                errorMsg += '배급사가 하나이상 존재해야 됩니다.<br>';
            }
            else
            {
                if  (count > 1)
                {
					var duplicate = false ; // 중복자료가 발견되면  true

                    for(var i=0 ; i<grid_Distributor.list.length ; i++)
                    {
                        var skip_i = false ;

                        if (typeof grid_Distributor.list[i]._CUD != "undefined")
        	            {
                        	if  (grid_Distributor.list[i]._CUD == 'D') skip_i = true;
        	            }

        	            if  (!skip_i)
        	            {
                            var distributor_seq_i = grid_Distributor.list[i].distributor_seq ;

							for(var j=0 ; j<grid_Distributor.list.length ; j++)
                            {
                               	var skip_j = false ;

								if (typeof grid_Distributor.list[j]._CUD != "undefined")
               	            	{
                               		if  (grid_Distributor.list[j]._CUD == 'D') skip_j = true;
               	            	}

                	            if  (!skip_j)
                	            {
                	                var distributor_seq_j = grid_Distributor.list[j].distributor_seq ;

                                    if  ((i != j) && (distributor_seq_i == distributor_seq_j))
                                    {
                                        duplicate = true; // 중복확인...!!
                                    }
                	            }
         	            	} // for(var j=0 ; j<grid_Distributor.list.length ; j++)
        	            }
                    } // for(var i=0 ; i<grid_Distributor.list.length ; i++)

                    if  (duplicate == true) errorMsg += '배급사가 중복됩니다.<br>';

                } // if  (count > 1)
            }


		    if (errorMsg == '')
            {
		        jQuery("input:hidden[name=contacts]").val( JSON.stringify( theater_json.contacts ) ) ;
		        jQuery("input:hidden[name=showrooms]").val( JSON.stringify( theater_json.showrooms ) ) ;
		        jQuery("input:hidden[name=distributors]").val( JSON.stringify( theater_json.distributors ) ) ;

                // 저장할 값들을 취합한다.
                var formData = jQuery("form[name=frmThearter]").serialize();

                jQuery.ajax({
                             type : "POST",
                             url : "<?=$path_AjaxJSON?>/wrk_theater_save.php",  // <-----
                             cache : false,
                             data : formData,
                             success : fnObj.onSuccessTheater,
                             error : fnObj.onErrorTheater
                });
            }
            else
            {
                //jQuery("#content").html(errorMsg);

                fnObj.modalOpen(500,-1,'입력오류',errorMsg,null) ;
            }
		},

		onFnClose : function()
        {
		    //location.href = "./TheaterList.php"; // 히스토리에 저장이 된다.
		    location.replace("./TheaterList.php") ; // 히스토리에 저장이 되지않는다.   // <-----
        },

		// 극장 저장이 성공적일때..
        onSuccessTheater : function(data)
        {
            var obj = eval("("+data+")");
            //trace(obj);

            if  (obj=='-1') fnObj.modalOpen(500,-1,'확인','저장이 실패되었습니다.',null)
            else            fnObj.modalOpen(500,-1,'확인','저장이 완료되었습니다.',fnObj.onFnClose) ;
        },

        // 극장 저장이 실패하면..
        onErrorTheater : function(request,status,error)
        {
            alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        },

        // 모달창을 띄운다.
        modalOpen: function (width,top,title,errorMsg,onFnClose)
        {
            myModal.setConfig({onclose: onFnClose, displayLoading: false});

            var pars = "title="+title+"&content="+errorMsg ;
            myModal.open({
                url: "AX_Modal.php",  // <-----
                pars: pars.queryToObject(),
                width: width,
                //top: 100,
                verticalAlign: true, // 씨발 안먹네..!!
                closeButton: true,
                closeByEscKey: true
            });
        }

    };

    jQuery(document).ready(readTheaterOne('<?=$MODE?>'));




    function test()
    {
        //jQuery("#AXSelect_Affiliate").setValueSelect("1");
        jQuery("select[name=isdirect]").setValueSelect(theater_json.isdirect);
    }

    </script>
</head>


<body>

    <!-- button onclick="test();">test</button-->
    <?php
    if ($MODE=="APPEND")  { ?><h1>극장 등록</h1><?php     }
    if ($MODE=="EDIT")    { ?><h1>극장 편집</h1><?php     }
    ?>

    <form name="frmThearter" onsubmit="return false;">

    	<input type="hidden" name="contacts">
    	<input type="hidden" name="showrooms">
    	<input type="hidden" name="distributors">
    	<input type="hidden" name="images_no">


        <table cellpadding="0" cellspacing="0" class="AXFormTable">
            <colgroup>
                <col width="100" />
                <col />
            </colgroup>
            <tbody>
                <tr>
                    <th>
                        <div class="tdRel">극장코드</div>
                    </th>
                    <td class="last">
                        <div class="tdRel">
                            <input type="text" name="code" placeholder="극장코드" value="" class="AXInput W70 av-bizno" readonly="readonly"/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">극장명</div>
                    </th>
                    <td class="last">
                        <div class="tdRel">
                            <input type="text" name="theater_nm" placeholder="극장명" value="" class="AXInput W250 av-bizno" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">구분코드</div>
                    </th>
                    <td class="last">
                        <div class="tdRel">
                            <input type="text" name="gubun_code" placeholder="구분코드" value="" class="AXInput W200 av-bizno" />
                            <label><input type="checkbox" name="fund_free" value="Y" id="AXCheck_Operation0" /> 기금면제여부</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">사업자</div>
                    </th>
                    <td class="last">
                        <div class="tdRel">
                            <table>
                            <tr>
                                <td class="white_board"><label>개관일</label></td>
                                <td class="white_board">
                                    : <input type="text" name="open_dt" id="AXInputDate_Open" placeholder="개관일" class="AXInput W100" />
                                </td>
                                <td class="white_board" rowspan="7">

                					<input type="button" value="업로드" class="AXButton" onclick="myUpload.uploadQueue(true);" />
                					<input type="button" value="삭제" class="AXButton" onclick="myUpload.deleteSelect('all');" />
                					<div style="height: 5px;"></div>

                		            <div id="uploadQueueBox" class="AXUpload5QueueBox" style="height:188px;width:140px;"></div>
            						<div style="height: 5px;"></div>
                                    <div class="AXUpload5" id="AXUpload5"></div>

                                </td>
                            </tr>
                            <tr>
                                <td class="white_board"><label>사업자등록번호</label></td>
                                <td class="white_board">
                                    : <input type="text" name="saup_no" value="" placeholder="사업자등록번호" class="AXInput W100" />
                                </td>
                            </tr>
                            <tr>
                                <td class="white_board"><label>대표자</label></td>
                                <td class="white_board">
                                    : <input type="text" name="owner" value="" placeholder="대표자" class="AXInput W80" />
                                </td>
                            </tr>
                            <tr>
                                <td class="white_board"><label>상호</label></td>
                                <td class="white_board">
                                    : <input type="text" name="sangho" value="" placeholder="상호" class="AXInput W200" />
                                </td>
                            </tr>
                            <tr>
                                <td class="white_board"><label>홈페이지</label></td>
                                <td class="white_board">
                                    : <input type="text" name="homepage" value="" placeholder="홈페이지" class="AXInput W250" />
                                </td>
                            </tr>
                            <tr>
                                <td class="white_board" calspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="white_board" calspan="2">&nbsp;</td>
                            </tr>
                            </table>

                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">지역</div>
                    </th>
                    <td class="last">
                        <label>지역1 :</label><select name="loc1" class="AXSelectSmall" id="AXSelect_Loccation1" style="width:100px;" tabindex="1"></select>
                        <label>지역2 :</label><select name="loc2" class="AXSelectSmall" id="AXSelect_Loccation2" style="width:100px;" tabindex="2"></select>
                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">주소</div>
                    </th>
                    <td class="last">
                        <label>우편번호 :</label><input type="text" name="zip" value="" placeholder="우편번호" class="AXInput W50" />
                        <button type="button" class="AXButtonSmall" id="button" tabindex="2" onclick="fnObj.addr.search();"><i class="axi axi-search2"></i> 조회</button>
                        <label>주소 :</label>
                        <input type="text" name="addr1" value="" placeholder="주소1" class="AXInput W200" readonly="readonly" />
                        <input type="text" name="addr2" value="" placeholder="주소2" class="AXInput W200" />
                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">계열사</div>
                    </th>
                    <td class="last">
                        <label>계열사 :</label><select name="affiliate_seq" class="AXSelectSmall" id="AXSelect_Affiliate" style="width:100px;" tabindex="1"></select>
                        <label>직·위 :</label><select name="isdirect" class="AXSelectSmall" id="AXSelect_IsDirect" style="width:100px;" tabindex="1"></select>
                        <label>비계열 :</label><select name="unaffiliate_seq" class="AXSelectSmall" id="AXSelect_Unaffiliate" style="width:100px;" tabindex="1"></select>
                        <label>사용자 그룹 :</label><select name="user_group_seq" class="AXSelectSmall" id="AXSelect_UserGroup" style="width:100px;" tabindex="1"></select>
                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">연락처</div>
                    </th>
                    <td class="last">

                        <!-- 관리자 연락처 탭 -->
                        <div id="AXTabs_Contact"></div>

                        <div style="padding: 5px;">
                            <div id="AXgrid_Contact"></div>
                        </div>

                        <button type="button" class="AXButton" onclick="fnObj.gridContact.appendGrid();"><i class="axi axi-ion-document-text"></i> 추가하기</button>

                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">극장수신<br>연락처</div>
                    </th>
                    <td class="last">
                        <table>
                            <tr>
                                <td class="white_board">스코어</td>
                                <td class="white_board">
                                    :
                                    <label><input type="checkbox" name="score_tel" value="Y" id="AXCheck_Operation1" /> 전화</label>
                                    <label><input type="checkbox" name="score_fax" value="Y" id="AXCheck_Operation2" /> FAX</label>
                                    <label><input type="checkbox" name="score_mail" value="Y" id="AXCheck_Operation3" /> 메일</label>
                                    <label><input type="checkbox" name="score_sms" value="Y" id="AXCheck_Operation4" /> SMS</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="white_board">부금</td>
                                <td class="white_board">
                                    :
                                    <label><input type="checkbox" name="premium_tel" value="Y" id="AXCheck_Operation5" /> 전화</label>
                                    <label><input type="checkbox" name="premium_fax" value="Y" id="AXCheck_Operation6" /> FAX</label>
                                    <label><input type="checkbox" name="premium_mail" value="Y" id="AXCheck_Operation7" /> 메일</label>
                                    <label><input type="checkbox" name="premium_sms" value="Y" id="AXCheck_Operation8" /> SMS</label>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">극장특징</div>
                    </th>
                    <td class="last">
                        <textarea name="memo" class="AXTextarea" style="width: 99%; height: 100px; resize:none;"></textarea>
                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">변경정보</div>
                    </th>
                    <td class="last">

                            <div style="padding: 5px;">
                                <div id="AXGrid_ChangeHist"></div>
                            </div>

                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">상영관<br>상세</div>
                    </th>
                    <td class="last">

                            <div style="padding: 5px;">
                                <div id="AXGrid_ShowRoom"></div>
                            </div>

                            <button type="button" class="AXButton" onclick="fnObj.gridShowroom.appendGrid();"><i class="axi axi-ion-document-text"></i> 추가하기</button>

                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">배급사</div>
                    </th>
                    <td class="last">

                            <div style="padding: 5px;">
                                <div id="AXGrid_Distributor"></div>
                            </div>

                            <button type="button" class="AXButton" onclick="fnObj.gridDistributor.appendGrid();"><i class="axi axi-ion-document-text"></i> 추가하기</button>

                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">업로드<br>극장명</div>
                    </th>
                    <td class="last">
                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">요금체계</div>
                    </th>
                    <td class="last">

                    	<div class="unitprice_box">
                        	<div id="divUnitPrice" class="unitprice_item">
                                  <button type="button" class="AXButtonSmall" id="btnUnitprice" onclick="fnObj.setUnitprice();"><i class="axi"></i>요금단가설정</button>
                        	</div>
                    	</div>

                    </td>
                </tr>
            </tbody>
        </table>

    </form>

    <div class="modalButtonBox" align="center">
        <button type="button" class="AXButtonLarge W500" id="btnSave" onclick="fnObj.save_theater();"><i class="axi axi-save "></i> 저장</button>
    </div>

</body>
</html>
