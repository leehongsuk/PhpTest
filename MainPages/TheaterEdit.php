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
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">


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
    var grid_Contact     = new AXGrid() ; // 연락처 그리드
    var grid_ChangeHist  = new AXGrid() ; // 변경내역 그리드
    var grid_ShowRoom    = new AXGrid() ; // 상영관 그리드
    var grid_Distributor = new AXGrid() ; // 배급사 그리드

    var myModal = new AXModal(); // 우편번호검색을 위한 팝업창과 범용팝업

    var fnObj =
    {
        pageStart: function()
        {
            // 이걸하지않으면 디자인이 나오지 않는다.
            $('input[type=checkbox]').bindChecked();
            $('input[type=radio]').bindChecked();

            myModal.setConfig({windowID:"myModalCT",
                displayLoading: false,
                scrollLock: false
               });  // 우편번호검색을 위한 팝업창


             // 담당자 종류를 가지고 온다.
            jQuery.post( "<?=$path_AjaxJSON?>/bas_contact.php")
                  .done(function( data ) {
                        //console.log(data);
                        var obj = eval("("+data+")");

                        $("#AXTabs_Contact").closeTab();
                        $("#AXTabs_Contact").addTabs(obj.options);

                        if  (obj.options.length > 0)
                        {
                            $("#AXTabs_Contact").setValueTab(obj.options[0].optionValue);
                        }
                  });

            // 연락처 탭을 구성한다.
            $("#AXTabs_Contact").bindTab({
                theme : "AXTabs",
                //value:"S", // 첫번째가 바로 선택되도록..
                overflow:"scroll", /* "visible" */
                /*
                options:[
                    {optionValue:"S", optionText:"스코어담당"},
                    {optionValue:"P", optionText:"부율담당"},
                    {optionValue:"T", optionText:"극장관리"}
                ],
                */
                onchange: function(selectedObject, value){
                    //toast.push(Object.toJSON(this));
                    //toast.push(Object.toJSON(selectedObject));
                    //toast.push("onchange: "+Object.toJSON(value));

                    if (typeof theater_json != "undefined")
                    {
                        jQuery.each(theater_json.contacts,function()
                        {
                            if (this.code == value) grid_Contact.setList(this.contacts);
                        })
                    }
                },
                onclose: function(selectedObject, value){
                    //toast.push(Object.toJSON(this));
                    //toast.push(Object.toJSON(selectedObject));
                    //toast.push("onclose: "+Object.toJSON(value));
                }
            });

            // 지역1 초기화
            jQuery("#AXSelect_Loccation1").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_location1.php",
                ajaxPars: "",
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                    //console.log(this.value);
                    jQuery("#AXSelect_Loccation2").bindSelect({
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
            jQuery("#AXSelect_Loccation2").bindSelect({
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
                    //console.log(this.value);
                }
            });

            // 직영위탁 초기화
            jQuery("#AXSelect_IsDirect").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_isdirect.php",
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                    //console.log(this.value);
                }
            });

            // 비계열 초기화
            jQuery("#AXSelect_Unaffiliate").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_unaffiliate.php",
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                    //console.log(this.value);
                }
            });

            // 사용자그룹 초기화
            jQuery("#AXSelect_UserGroup").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_user_group.php",
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                    //console.log(this.value);
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
                            //trace(this.index);
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
                    {key:"seq", label:"no", width:"30"},
                    {key:"name", label:"이름", width:"100"},
                    {key:"tel", label:"대표번호", width:"110"},
                    {key:"hp", label:"무선전화", width:"110"},
                    {key:"fax", label:"팩스", width:"110"},
                    {key:"mail", label:"이메일", width:"250"}
                ],
                body : {
                    ondblclick: function()
                    {
                        //toast.push(Object.toJSON({index:this.index, item:this.item}));
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
                                {colSeq:2, align:"center", valign:"middle", form:{type:"hidden", value:"itemValue"}},
                                {colSeq:3, align:"left", valign:"top", form:{type:"text", value:"itemValue"}},
                                {colSeq:4, align:"left", valign:"top", form:{type:"text", value:"itemValue"}},
                                {colSeq:5, align:"left", valign:"top", form:{type:"text", value:"itemValue"}},
                                {colSeq:6, align:"left", valign:"top", form:{type:"text", value:"itemValue"}},
                                {colSeq:7, align:"left", valign:"top", form:{type:"text", value:"itemValue"}}
                            ]
                    ],
                    response: function()
                    {
                        if(this.index == null) // 추가
                        {
                            var pushItem = this.res.item;

                            if(this.res.item.title == ""){
                                alert("제목이 비어 추가 할 수 없습니다.");
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

            // 변경정보 그리드 초기화
            grid_ChangeHist.setConfig(
            {
                targetID : "AXGrid_ChangeHist",
                height : 250,
                theme : "AXGrid",
                fitToWidth: false, // 너비에 자동 맞춤
                colGroup : [
                    {key:"seq", label:"변경일련번호", width:"50", align:"right"},
                    /*
                    {key:"gubun", label:"추가/갱신", width:"100"},
                    {key:"theater_code", label:"극장코드(TH0001)", width:"100"},
                    */
                    {key:"change_datetime", label:"변경시간", width:"140"},
                    {key:"location", label:"지역", width:"100"},
                    {key:"affiliate_seq", label:"계열사코드", width:"100"},
                    {key:"dir_mng", label:"직영여부", width:"100"},
                    {key:"unaffiliate", label:"비계열코드", width:"100"},
                    {key:"user_group", label:"사용자그룹코드", width:"100"},
                    {key:"operation", label:"운영여부", width:"40"},
                    {key:"theater_nnm", label:"극장명", width:"150"},
                    {key:"fund_free", label:"기금면제여부", width:"40"},
                    {key:"gubun_code", label:"구분코드??", width:"100"},
                    {key:"saup_no", label:"사업자등록번호", width:"100"},
                    {key:"owner", label:"대표자명", width:"100"},
                    {key:"sangho", label:"상호", width:"150"},
                    {key:"homepage", label:"홈페이지", width:"100"},
                    {key:"images_no", label:"이미지 첨부파일번호", width:"100"}
                ],
                body : {
                    onclick: function(){
                        //toast.push(Object.toJSON({index:this.index, item:this.item}));
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
                    {key:"room_nm", label:"상영관명", width:"100"},
                    {key:"room_alias", label:"상영관별칭", width:"100"},
                    {key:"art_room", label:"예술관여부", width:"100"},
                    {key:"seat", label:"좌석수", width:"100"}
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
                                {colSeq:4, align:"left", valign:"top", form:{type:"text", value:"itemValue"}},
                                {colSeq:5, align:"left", valign:"top", form:{type:"text", value:"itemValue"}}
                            ]
                    ],
                    response: function()
                    {
                        if(this.index == null) // 추가
                        {
                            var pushItem = this.res.item;

                            if(this.res.item.title == ""){
                                alert("제목이 비어 추가 할 수 없습니다.");
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
                    {key:"distributor_seq", label:"배급사일련번호", width:"100"},
                    {key:"theater_knm", label:"극장명(한글)", width:"200"},
                    {key:"theater_enm", label:"극장명(영문)", width:"200"},
                    {key:"theater_dcode", label:"배급사 극장코드", width:"100"}
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
                                {colSeq:2, align:"left", valign:"top", form:{type:"text", value:"itemValue"}},
                                {colSeq:3, align:"left", valign:"top", form:{type:"text", value:"itemValue"}},
                                {colSeq:4, align:"left", valign:"top", form:{type:"text", value:"itemValue"}},
                                {colSeq:5, align:"left", valign:"top", form:{type:"text", value:"itemValue"}}
                            ]
                    ],
                    response: function()
                    {
                        if(this.index == null) // 추가
                        {
                            var pushItem = this.res.item;

                            if(this.res.item.title == ""){
                                alert("제목이 비어 추가 할 수 없습니다.");
                                return;
                            }

                            grid_Distributor.pushList(pushItem, this.insertIndex);
                        }
                        else // 수정
                        {
                            fnObj.gridDistributor.restoreList(this.index); // 삭제된걸 다시 복구한다.

                           	trace(this.index);
                           	trace(this.list);
                           	trace(this.res.item);

							AXUtil.overwriteObject(this.list[this.index], this.res.item, true); // this.list[this.index] object 에 this.res.item 값 덮어쓰기
							grid_Distributor.updateList(this.index, this.list[this.index]);
                        }
                    }
                }
            });

            $("#AXInputDate").bindDate({
                align:"right",
                valign:"top",
                onChange:function(){
                    //toast.push(Object.toJSON(this));
                }
            });

            // 해당극장의 요금을 가지고 온다.
            jQuery.post( "<?=$path_AjaxJSON?>/wrk_theater_unitprice.php", { code: '<?=$_GET['code']?>' })
		          .done(function( data ) {

		            	var obj  = eval("("+data+")");
     				    var tag1 = '<div class="unitprice_item"><label>';
     				    var tag2 = '</label></div>';

						for (var i=0 ; i<obj.options.length ; i++)
						{
						    var checked = (obj.options[i].unit_price_seq != null) ? 'checked=checked' : '' ;

						    $("#divUnitPrice").before(tag1 + '<input type="checkbox" name="unitPrices[]" value="'+obj.options[i].seq+'" '+checked+'/> ' + obj.options[i].unit_price + tag2);
						}
						$('input[type=checkbox]').bindChecked();
		          });

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


        gridShowroom: {

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



        gridDistributor: {

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


		// 지역2를 다시 구한다.
        setLoc2: function(loc2)
        {
            jQuery("select[name=loc2]").setValueSelect(loc2);
        },

        // 하나의 극장정보를 읽어 온다.
        readTheaterOne: function()
        {
            jQuery.post( "<?=$path_AjaxJSON?>/wrk_theater_one.php", { code: '<?=$_GET['code']?>' })
                  .done(function( data )
                  {
						//console.log(data);

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

                        $('input[type=checkbox]').bindChecked();

                        jQuery("select[name=loc1]").setValueSelect(theater_json.loc1);
                        jQuery("select[name=loc2]").bindSelect({
                            ajaxUrl: "<?=$path_AjaxJSON?>/bas_location2.php",
                            ajaxPars: {"parent_seq":theater_json.loc1 },
                            isspace: true,
                            isspaceTitle: "전체",
                            onChange: function(){
                                //console.log(this.value);

                            }
                        });
                        fnObj.setLoc2.delay(1,theater_json.loc2);

                        jQuery("select[name=affiliate_seq]").setValueSelect(theater_json.affiliate_seq);
                        jQuery("select[name=isdirect]").setValueSelect(theater_json.isdirect);
                        jQuery("select[name=unaffiliate_seq]").setValueSelect(theater_json.unaffiliate_seq);
                        jQuery("select[name=user_group_seq]").setValueSelect(theater_json.user_group_seq);

						if  (typeof theater_json.contacts != "undefined")
						{
                            if  (theater_json.contacts.length > 0)
                            {
                                grid_Contact.setList(theater_json.contacts[0].contacts);
                            }
						}

						if  (typeof theater_json.showroom != "undefined")
						{
                        	grid_ShowRoom.setList(theater_json.showroom);
						}
                        if  (typeof theater_json.distributor != "undefined")
						{
                        	grid_Distributor.setList(theater_json.distributor);
						}

                        grid_ChangeHist.setList({
                            ajaxUrl : "<?=$path_AjaxJSON?>/wrk_theater_chghist_page.php",
                            ajaxPars: {
                                "theater_code": theater_json.code
                            },
                            onLoad  : function(){
                                //trace(this);
                            }
                        });

            });
        },

        // 우편번호를 모달로 검색하거나 선택한다.
        addr:
        {
			search: function()
			{
				myModal.open({
					method:"get",
					url:"AXMdl_AddrFinder.php",
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

		    if (errorMsg == '')
            {
                // 저장할 값들을 취합한다.
                var formData = jQuery("form[name=frmThearter]").serialize();

                //trace(formData);

                jQuery.ajax({
                             type : "POST",
                             url : "<?=$path_AjaxJSON?>/wrk_theater_save.php",
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

			/*
		    var a = AXUtil.clientHeight();
		    var b = AXUtil.scrollHeight();
		    var c = AXUtil.clientWidth();
		    var d = AXUtil.scrollWidth();
		    trace({a:a,b:b,c:c,d:d});
		    */
		},

		onFnClose : function()
        {
		    //location.href = "./TheaterList.php"; // 히스토리에 저장이 된다.
		    location.replace("./TheaterList.php") ; // 히스토리에 저장이 되지않는다.
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
            /*
            myModal.openDiv({
                modalID: "modalDiv02",
                targetID: "modalContent2",
                width: width,
                top: top,
                verticalAlign: true,
                closeByEscKey: true,
                closeButton: true
            });
            */
            myModal.setConfig({onclose: onFnClose});

            var pars = "title="+title+"&content="+errorMsg ;
            myModal.open({
                url: "AX_Modal.php",
                pars: pars.queryToObject(),
                width: width,
                //top: 100,
                verticalAlign: true, // 씨발 안먹네..!!
                closeButton: true,
                closeByEscKey: true
            });
        }

    };

    jQuery(document).ready([ fnObj.pageStart.delay(0.1)
                             <?php if ($MODE=="EDIT") { ?>,fnObj.readTheaterOne.delay(1)<?php } ?>
                             ]);





    function test()
    {
        //jQuery("#AXSelect_Affiliate").setValueSelect("1");
    }

    </script>
</head>


<body>

    <button onclick="test();">test</button>
    <?php
    if ($MODE=="APPEND")  { ?><h1>극장 등록</h1><?php     }
    if ($MODE=="EDIT")    { ?><h1>극장 편집</h1><?php     }
    ?>

    <form name="frmThearter" onsubmit="return false;">

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
                                    : <input type="text" name="open_dt" id="AXInputDate" placeholder="개관일" class="AXInput W100" />
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
