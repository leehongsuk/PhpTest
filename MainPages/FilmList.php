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
    <!-- link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet "-->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/MainCss/font-awesome.min.css" />


    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/MainCss/Common.css" />

    <script type="text/javascript">

    var filmCode ; // 선택된 영화코드..
    var filmName ; // 선택된 영화명..

    var gridFilm      = new AXGrid() ; // 영화 그리드
    var gridPlayprint = new AXGrid() ; // 상영프린트 그리드

    var myModal = new AXModal(); // 범용팝업

    var fnObj =
    {
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
                targetID : "AXGridFilm",
                theme : "AXGrid",
                autoChangeGridView: { // autoChangeGridView by browser width
                    mobile:[0,600], grid:[600]
                },
                fitToWidth: false, // 너비에 자동 맞춤
                colGroup : [
                    {
                        key: "btns", label: "삭제", width: "60", align: "center", formatter: function ()
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
                    {key:"code", label:"영화코드", width:"100"},
                    {key:"film_nm", label:"대표영화명", width:"100"},
                    {key:"grade_nm", label:"상영등급", width:"100"},
                    {key:"distributor_nm", label:"배급사", width:"100"},
                    {key:"distributor_cd", label:"배급사 영화코드", width:"100"},
                    {key:"first_play_dt", label:"최초상영일", width:"100"},
                    {key:"play_term", label:"상영기간", width:"180"},
                    {key:"replay_term", label:"재상영기간", width:"180"},
                    {key:"poster_yn", label:"포스터사용 유무", width:"100"},
                    {key:"korabd_gbn_nm", label:"방화외화", width:"100"},
                    {key:"cnt_playprint", label:"상영프린터수", width:"100"},
                    {key:"images_no", label:"이미지 첨부파일번호", width:"100"}
                ],
                body :
                {
                    height: 3,
                    onclick: function()
                    {
                        filmCode = this.item.code ;    // 선택된 영화코드..
                        filmName = this.item.film_nm ; // 선택된 영화명..

                        gridPlayprint.setList({
                            ajaxUrl : "<?=$path_AjaxJSON?>/wrk_playprint.php",  // <-----
                            ajaxPars:"code="+this.item.code,
                            onLoad  : function(){
                                //trace(this);

                                //gridFilm.setFocus(0);
                            }
                        });
                    }
                },
                page:{
                    paging:true,
                    pageNo:1,
                    pageSize:10
                }
            });


            gridFilm.setList({
                ajaxUrl : "<?=$path_AjaxJSON?>/wrk_film_page.php",  // <-----
                onLoad  : function(){
                    //trace(this);

                    gridFilm.setFocus(0);
                }
            });

			// 그리드(상영프린트)
            gridPlayprint.setConfig(
            {
                targetID : "AXGridPlayprint",
                theme : "AXGrid",
                autoChangeGridView: { // autoChangeGridView by browser width
                    mobile:[0,600], grid:[600]
                },
                fitToWidth: false, // 너비에 자동 맞춤
                colGroup : [
                    {key:"seq", label:"no", width:"100"},
                    {key:"playprint1_seq", label:" ", width:"1", formatter: function () { return '' ; }},
                    {key:"playprint1", label:"상영프린트1", width:"100"},
                    {key:"playprint2_seq", label:" ", width:"1", formatter: function () { return '' ; }},
                    {key:"playprint2", label:"상영프린트2", width:"100"},
                    {key:"memo", label:"메모", width:"100"},
                    {
                        key: "btns", label: "상영관지정", width: "100", align: "center", formatter: function ()
                        {
                            var playprintSeq  = this.item.seq
                            var playprintName = this.item.playprint1 + ' ' + this.item.playprint2 ;
                            return '<button class="AXButton" onclick="fnObj.mappingShowroom(\'' + filmCode + '\',\'' + filmName + '\',\'' + playprintSeq + '\',\'' + playprintName + '\');">상영관지정</button>';
                        }
                    },
                    {key:"cnt_theater", label:"극장수", width:"100"},
                    {key:"cnt_showroom", label:"상영관수", width:"100"}
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


        },

        // 검색버튼을 누를시..
        searchFilm: function()
        {
            var distributor_seq = jQuery("#AXSelect_Distributor").val();
            var film_Nm         = jQuery("#AXText_FilmeNm").val();

            gridFilm.setList({
                ajaxUrl : "<?=$path_AjaxJSON?>/wrk_film_page.php",  // <-----
                ajaxPars: {
                    "distributor_seq" : distributor_seq,
                    "film_Nm"         : film_Nm
                },
                onLoad  : function(){
                    //gridFilm.setFocus(0);
                }
            });

        },

		// 영화 삭제처리
        deleteItem: function (code)
        {
            if (confirm("정말로 삭제하시겠습니까?"))
            {
                jQuery.post( "<?=$path_AjaxJSON?>/wrk_film_delete.php", { code: code }) // <-----
                      .done(function( data )
                      {
                          gridFilm.setList({
                              ajaxUrl : "<?=$path_AjaxJSON?>/wrk_film_page.php",  // <-----
                              //                 ajaxPars: {
                              //                     "param1": "액시스제이",
                              //                     "param2": "AXU4J"
                              //                 },
                              onLoad  : function(){
                                  //trace(this);

                                  //gridFilm.setFocus(this.list.length - 1);
                              }
                          });
                      });
            }
        },

        // 영화 수정 또는 생성 버튼을 누를 시..
        editItem: function (code)
        {
            //console.log('editItem');
            //console.log(index);
            //toast.push('deleteItem1: ' + index);
            if (typeof code == "undefined") location.href = "./FilmEdit.php"
            else                            location.href = "./FilmEdit.php?code="+code ;
        },

        // 상영프린트에서 상영관지정 버튼을 누를 시...
        mappingShowroom: function (filmCode, filmName, playprintSeq, playprintName)
        {
            //alert(code);
            myModal.open({
				method: "post",
				url: "AXMdl_SchShowroom.php",  // <-----
				pars: {
					   filmCode : filmCode
					  ,filmName : filmName
					  ,playprintSeq  : playprintSeq
					  ,playprintName : playprintName
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

    <h1>영화정보</h1>

    <div style="height: 50px;">

        <label>배급사 :</label><select name="Distributor" class="AXSelect" id="AXSelect_Distributor" style="width:150px;" tabindex="3"></select>
        <label>영화명 :</label><input type="text" name="FilmName" value="" id="AXText_FilmeNm" class="AXInput" />

        <button type="button" class="AXButton" id="button" tabindex="2" onclick="fnObj.searchFilm();"><i class="axi axi-search2"></i> 조회</button>
        <button type="button" class="AXButton" id="button" tabindex="2" onclick="fnObj.editItem();"><i class="axi axi-ion-document-text"></i> 등록</button>

    </div>

    <div id="AXGridFilm"></div>
	<br>
	<h3>상영프린트</h3>
    <div id="AXGridPlayprint"></div>

</body>
</html>
