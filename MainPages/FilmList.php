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

    var myGrid1 = new AXGrid() ; // instance
    var myGrid2 = new AXGrid() ; // instance


    var fnObj =
    {
        pageStart: function()
        {
            // 이걸하지않으면 디자인이 나오지 않는다.
            $('input[type=checkbox]').bindChecked();
            $('input[type=radio]').bindChecked();



            // 계열사 초기화
            jQuery("#AXSelect_Affiliate").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_distributor.php",  // <-----
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                    console.log(this.value);
                }
            });

            myGrid1.setConfig(
            {
                targetID : "AXGridTarget1",
                theme : "AXGrid",
                autoChangeGridView: { // autoChangeGridView by browser width
                    mobile:[0,600], grid:[600]
                },
                fitToWidth: false, // 너비에 자동 맞춤
                colGroup : [
                    {
                        key: "btns", label: "삭제", width: "60", align: "center", formatter: function ()
                        {
                          return '<button class="AXButton" onclick="fnObj.deleteItem1(\'' + this.item.code + '\');"><i class="axi axi-trash2"></i></button>';
                        }
                    },
                    {
                        key: "btns", label: "수정", width: "60", align: "center", formatter: function ()
                        {
                            return '<button class="AXButton" onclick="fnObj.editItem1(\'' + this.item.code + '\');"><i class="axi axi-pencil"></i></button>';
                        }
                    },

                    {key:"code", label:"영화코드", width:"100"},
                    {key:"distributor", label:"배급사 영화코드", width:"100"},
                    {key:"film_nm", label:"대표영화명", width:"100"},
                    {key:"grade", label:"상영등급", width:"100"},
                    {key:"first_play_dt", label:"최초상영일", width:"100"},
                    {key:"open_dt", label:"개봉일", width:"100"},
                    {key:"close_dt", label:"종영일", width:"100"},
                    {key:"reopem_dt", label:"재개봉일", width:"100"},
                    {key:"reclose_dt", label:"재종영일", width:"100"},
                    {key:"poster_yn", label:"포스터사용 유무", width:"100"},
                    {key:"images_no", label:"이미지 첨부파일번호", width:"100"}
                ],
                body :
                {
                    height: 3,
                    onclick: function()
                    {
                        console.log(this.item.code);

                        myGrid2.setList(
                        {
                            ajaxUrl : "<?=$path_AjaxJSON?>/wrk_playprint_page.php",  // <-----
                            ajaxPars: {
                            	"film_code": this.item.code,
                            },
                            onLoad  : function(){
                                //trace(this);

                                myGrid1.setFocus(0);
                            }
                        });
                    }
                },
                //              page:{
                //                  paging:false
                //              }
                page:{
                    paging:true,
                    pageNo:1,
                    pageSize:10
                }
            });


            myGrid1.setList({
                ajaxUrl : "<?=$path_AjaxJSON?>/wrk_film_page.php",  // <-----
                onLoad  : function(){
                    //trace(this);

                    myGrid1.setFocus(0);
                }
            });




            myGrid2.setConfig(
            {
                targetID : "AXGridTarget2",
                theme : "AXGrid",
                autoChangeGridView: { // autoChangeGridView by browser width
                    mobile:[0,600], grid:[600]
                },
                fitToWidth: false, // 너비에 자동 맞춤
                colGroup : [
                    {
                        key: "btns", label: "삭제", width: "60", align: "center", formatter: function ()
                        {
                          return '<button class="AXButton" onclick="fnObj.deleteItem1(\'' + this.item.code + '\');"><i class="axi axi-trash2"></i></button>';
                        }
                    },
                    {
                        key: "btns", label: "수정", width: "60", align: "center", formatter: function ()
                        {
                            return '<button class="AXButton" onclick="fnObj.editItem1(\'' + this.item.code + '\');"><i class="axi axi-pencil"></i></button>';
                        }
                    },

                    {key:"playprint1", label:"프린트1", width:"100"},
                    {key:"playprint2", label:"프린트2", width:"100"},
                    {key:"memo", label:"메모", width:"200"}
                ],
                body :
                {
                    onclick: function()
                    {
                        alert();
                        //toast.push(Object.toJSON({index:this.index, item:this.item}));
                        /*

                        */
                    }
                },
                //              page:{
                //                  paging:false
                //              }
                page:{
                    paging:true,
                    pageNo:1,
                    pageSize:10
                }
            });




        },

        deleteItem1: function (code)
        {
            if (confirm("정말로 삭제하시겠습니까?"))
            {
                jQuery.post( "<?=$path_AjaxJSON?>/wrk_film_delete.php",  { code: code }) // <-----
                      .done(function( data ) {
                          //alert( "자료가 삭제되었습니다. " + data );
                          myGrid1.setList({
                              ajaxUrl : "<?=$path_AjaxJSON?>/wrk_film_page.php",  // <-----
                              //                 ajaxPars: {
                              //                     "param1": "액시스제이",
                              //                     "param2": "AXU4J"
                              //                 },
                              onLoad  : function(){
                                  //trace(this);

                                  //myGrid1.setFocus(this.list.length - 1);
                              }
                          });
                      });
            }
        },

        editItem1: function (code)
        {
            //console.log('editItem1');
            //console.log(index);
            //toast.push('deleteItem1: ' + index);
            location.href = "./FilmEdit.php?code="+code ;
        }

    };

    jQuery(document).ready(fnObj.pageStart.delay(0.1));


    </script>
</head>

<body>

    <h1>영화정보</h1>
    <div style="height: 50px;">

        <label>배급사 :</label><select name="Affiliate" class="AXSelectSmall" id="AXSelect_Affiliate" style="width:100px;" tabindex="3"></select>

        <label>영화명 :</label><input type="text" name="input" value="" class="AXInput" />

        <button type="button" class="AXButton" id="button" tabindex="2" onclick="alert();"><i class="axi axi-search2"></i> 조회</button>
        <button type="button" class="AXButton" id="button" tabindex="2" onclick="alert();"><i class="axi axi-ion-document-text"></i> 등록</button>
    </div>

    <div id="AXGridTarget1"></div>
    <br>
    <div id="AXGridTarget2"></div>

</body>
</html>
