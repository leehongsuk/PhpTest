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
    </style>

    <script type="text/javascript">

    var mySearch = new AXSearch();
    var myGrid = new AXGrid();

    var fnObj = {

        pageStart: function()
        {
            fnObj.search.init();
            fnObj.grid.init();
        },
        search: {
            init: function(){

                mySearch.setConfig({
                    targetID:"AXSearchTarget",
                    theme : "AXSearch",
                    onsubmit: function(){
                        fnObj.searchAddr();
                    },
                    rows:[
                        {display:true, addClass:"", style:"", list:[
                            {label:"", labelWidth:"", type:"inputText", width:"150", key:"srchwrd", addClass:"secondItem", valueBoxStyle:"padding-left:10px;", placeholder:"검색어를 입력하세요", value:""},
                            {label:"", labelWidth:"", type:"button", width:"60", key:"button", valueBoxStyle:"padding-left:0px;padding-right:5px;", value:"검색",
                                onclick: function(){
                                    //AXUtil.alert(this);
                                    fnObj.searchAddr();
                                }
                            }
                        ]}

                    ]
                });

                parent.myModal.resize(); // 모달창이 동적으로 사이즈가 재 조정 될 때 모달창의 크기를 재 조정 해줍니다.
            }
        },
        grid: {
            init: function(){
                myGrid.setConfig({
                    targetID : "AXGridTarget",
                    colGroup : [
                        {key:"code", label:"우편번호", width:"100", align:"center"},
                        {key:"address_nm", label:"주소", width:"370", align:"center"}
                    ],
                    body : {
                        onclick: function()
                        {
                            parent.fnObj.addr.set({zip:this.item.code, addr:this.item.address_nm});
                            parent.myModal.close();
                        }
                    },
                    page:
                    {
                        paging:true,
                        pageNo:1,
                        pageSize:10
                    }
                });
            }
        },
        searchAddr: function(){

            myGrid.setList({
                           ajaxUrl : "<?=$path_AjaxJSON?>/bas_postzip_page.php",
                           ajaxPars: {
                               "dongNm": jQuery('input[name=srchwrd]').val()
                           },
                           onLoad  : function(){}
            });
        }
    };

    $(document.body).ready(function(){
        setTimeout(fnObj.pageStart, 1);
    });

    </script>

</head>
<body>
    <div class="bodyHeightDiv">
        <div class="modalProgramTitle">
            주소찾기
        </div>

        <div class="masterModalBody" id="masterModalBody">
            <div id="AXSearchTarget" style=""></div>

            <div style="padding:5px;">
                <div id="AXGridTarget" style="height:390px;"></div>
            </div>
        </div>

        <div class="modalButtonBox" align="center">
            <button class="AXButton W60" onclick="parent.myModal.close();">취소</button>
        </div>
    </div>
</body>
</html>
