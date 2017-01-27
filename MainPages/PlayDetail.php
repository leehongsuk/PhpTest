<?php require_once("../config/CONFIG.php"); ?>
<?php require_once("../config/SESSION_OUT.php"); ?>
<?php
$post_theater_code  = $_POST["theater_code"] ;
$post_showroom_seq  = $_POST["showroom_seq"] ;
$post_film_code     = $_POST["film_code"] ;
$post_playprint_seq = $_POST["playprint_seq"] ;
?>
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
    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXUpload5.js"></script>

    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXModal.js"></script>

    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXToolBar.js"></script>
    <script type="text/javascript" src="<?=$path_Root?>/MainJavascript/AXToolBar.js"></script>

    <!-- 아이콘사용을 위해서..(http://axicon.axisj.com/) -->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axicon/axicon.min.css"/>


    <!-- css block -->
    <!-- link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet "-->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/MainCss/font-awesome.min.css" />

    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/MainCss/Common.css" />

    <script type="text/javascript" src="<?=$path_Root?>/MainJavascript/CommonLib.js"></script>

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

    var jsonInning ;  // 하부 지역리스트의 json
    var jsonPlayDetail ; // 스코어전체 json

    var myModal = new AXModal();
    var grid_PlayDetail = new AXGrid() ; // 스코어 그리드


    var fnObj =
    {
        pageStart: function()
        {
            // 툴바 생성
            fnToolbar.toolbar.init();

            myModal.setConfig({
                windowID: "myModalCT",
                width: 740,
                mediaQuery: {
                    mx: {min: 0, max: 767}, dx: {min: 767}
                },
                displayLoading: false,
                scrollLock: false,
                onclose: function ()
                {
                    //toast.push("모달 close");
                }
            });

            // 이걸하지않으면 디자인이 나오지 않는다.
            $('input[type=checkbox]').bindChecked();
            $('input[type=radio]').bindChecked();

            $("#AXInputDate").bindDate({
                align:"right",
                valign:"top",
                onChange:function(){
                    //toast.push(Object.toJSON(this));
                    //dialog.push({body:'<b>Caution</b> Application Call dialog push', type:'Caution', onConfirm:fnObj.btnOnConfirm, data:'onConfirmData'});
                }
                //minDate:"2013-05-10",
                //maxDate:"2013-05-20",
                //defaultDate:"2013-05-15"
            });

            // 스코어그리드
            grid_PlayDetail.setConfig(
            {
                targetID : "AXgrid_PlayDetail",
                height : 500,
                theme : "AXGrid",
                fitToWidth: false, // 너비에 자동 맞춤
                colGroup : [
                    {key:"title1", label:"극장정보", width:"100"},
                    {key:"unitprice", label:"요금", width:"100"},
                    {key:"sum", label:"합계", width:"100"}
                ],
                body : {
                    onclick: function(){
                        //toast.push(Object.toJSON({index:this.index, item:this.item}));
                        ///console.log(this.item);
                    }
                },
                page:{
                    paging:false
                }
            });

            jQuery("input[name=play_dt]").val( GetToday() ); // 디폴트로 오늘 ...

            // '조회' 버튼을 누른다..
            fnObj.search_play_detail();


        }, // end (pageStart: function())



        // 스코어값으로 text박스를 만든다.
        formatter : function()
        {
            if  ((this.item.price == "합계") || (this.item.price == "금액") || (this.item.price == "전일"))
            {
                return 	comma(this.value) ;
            }
            else
            {
//trace(this);
                var name = "pd_"+this.item.price_seq+"_"+this.key ;

                return   '<input type="text"                                    '
                       + '       name="'+name+'"                                '
                       + '       style="text-align: right; padding-right:5px;"  '
                       + '       class="AXInput W40 dot"                        '
                       + '       value="'+this.value +'"                        '
                       + '       maxlength="3"                                  ' // 3까지자리만..
                       + '       onkeyup="fnKeyup(this,event)"                  '
                       + '       onblur="fnBlur(this)"/>                        '
                        ;
            }
        },

        // '조회' 버튼을 누를때..
        search_play_detail: function()
        {
            jQuery.post( "<?=$path_AjaxJSON?>/lst_inning16.php", {})  // <----- 16회차리스트를 구한다.
                  .done(function( data )
                  {
      				    jsonInning = eval("("+data+")");  // 회차리스트의 json
                        //trace(jsonInning); ////////////

                        var colgrp = [];

                        var o={} ;
                        o['key'] = 'price';
                        o['label'] = '요금';
                        o['width'] = '100';
                        o['align'] = 'right';
                        colgrp.push(o);

                        var o={} ;
                        o['key'] = 'sum';
                        o['label'] = '합계';
                        o['width'] = '90';
                        o['align'] = 'right';
                        colgrp.push(o);

                        /** 회차 갯수 만큼 컬럼타이틀을 구성한다. **/
                        for (var i=0;i<jsonInning.options.length ;i++)
                        {
                            var o={} ;

                            for (var prop in jsonInning.options[i])
                            {
                                 if  (prop=="seq")  o['key']   = jsonInning.options[i][prop];
                                 if  (prop=="name") o['label'] = jsonInning.options[i][prop];
                            }
                            o['width'] = '70';
                            o['formatter'] = fnObj.formatter;// <input typw="text"> 태그를 단다...
                            o['align'] = 'right';

                            colgrp.push(o);
                        }

                        grid_PlayDetail.setConfig({colGroup : colgrp}); // 컬럼 그룹정보를 설정한다...


                        var result = '' ;
                        grid_PlayDetail.setList({
                              ajaxUrl : "<?=$path_AjaxJSON?>/wrk_play_detail_selected_sel.php",  // <----- 선택된 일자-상영관-영화의 스코어정보를 구한다.
                              ajaxPars: {
                                  "play_dt"       : jQuery("input[name=play_dt]").val() ,
                                  "theater_code"  : '<?=$post_theater_code?>' ,
                                  "showroom_seq"  : <?=$post_showroom_seq?> ,
                                  "film_code"     : '<?=$post_film_code?>' ,
                                  "playprint_seq" : <?=$post_playprint_seq?>
                              },
                              onLoad : function()
                              {
                                  jsonPlayDetail = this;

                                  //trace(jsonPlayDetail.play_mast);

                                  var play_mast = jsonPlayDetail.play_mast[0] ;

                                  jQuery("#play_mast").text(play_mast.theater_nm+' '+ play_mast.room_nm+'관 : '+play_mast.film_nm+' ('+play_mast.play_print_nm1+' '+play_mast.play_print_nm2+') ');

                                  var val = (play_mast.confirm == 'Y') ? "확인" : "미확인" ; // 확인/미확인

                                  jQuery("#confirm").val( val );

                                  jQuery("textarea[name=memo]").text(play_mast.memo);

                                  $(".AXInputSwitch").bindSwitch({ off:"미확인",on:"확인"});


                                  // 엔터키를 쳤을때 탭키를 친것과 같은 효과를 내도록 처리하는 jquery
                                  $('body').on('keydown', 'input, select, textarea', function(e)
                                  {
                                      var self = $(this);
                                      var form = self.parents('form:eq(0)');
                                      var focusable;
                                      var next;

                                      if (e.keyCode == 13)
                                      {
                                          focusable = form.find('input,a,select,button,textarea').filter(':visible');
                                          next = focusable.eq(focusable.index(this)+1);
                                          if (next.length) {
                                              next.focus();
                                              next.select(); // 전체가 선택되도록 한다.
                                          } else {
                                              form.submit();
                                          }
                                          return false;
                                      }
                                  });

                              }
                        });

                  });

        },


        // '저장' 버튼을 누를때
        save_play_detail: function()
        {
            //trace(jsonPlayDetail.list);

            var price_seqs = ""

            jsonPlayDetail.list.forEach(function(e)
            {
	           // trace(e.price_seq);
	            if (typeof e.price_seq != "undefined")
	            {
		            if (price_seqs != "") price_seqs += ",";

	                price_seqs += e.price_seq
	            }
            });

            jQuery('input:hidden[name=price_seqs]').val( price_seqs );

            // 저장할 값들을 취합한다.
            var formData = jQuery("form[name=frmPlayDetail]").serialize();

            jQuery.ajax({
                         type : "POST",
                         url : "<?=$path_AjaxJSON?>/wrk_play_detail_save.php",  // <-----
                         cache : false,
                         data : formData,
                         success : fnObj.onSuccessPreminumRate,
                         error : fnObj.onErrorPreminumRate
            });
        },

        onFnClose : function()
        {
        },

        // 스코어 저장이 성공적일때..
        onSuccessPreminumRate : function()
        {
            fnObj.modalOpen(500,-1,'확인','저장이 완료되었습니다.',fnObj.onFnClose) ;
        },

        // 부울 저장이 실패하면..
        onErrorPreminumRate : function(request,status,error)
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
                url: "AX_Modal.php",  // <-----
                pars: pars.queryToObject(),
                width: width,
                //top: 100,
                verticalAlign: true, // 씨발 안먹네..!!
                closeButton: true,
                closeByEscKey: true
            });
        }

    }; // var fnObj =

    jQuery(document).ready(fnObj.pageStart.delay(0.1));


    var parseInput = function(val)
    {
        if  (isNaN(parseFloat(val))) return '';

         var floatValue = parseFloat(val);

         if  (val == floatValue) return val
         else                    return isNaN(floatValue) ? '' : floatValue;
    }

    function fnKeyup(my,event)
    {
		//trace(event.keyCode);

        if (event.keyCode==46 ) return;
        if (event.keyCode==8 ) return;

        if (event.keyCode==13 ) return;
        if (event.keyCode==9 ) return;
        if (event.keyCode==16 ) return;

        if (event.keyCode== 37) return;
        if (event.keyCode== 38) return;
        if (event.keyCode== 39) return;
        if (event.keyCode== 40) return;

        var value = $(my).val()+'';

        if (value[value.length-1] !== '.')
        {
            $(my).val(parseInput(value));
        }
        else
        {
            if  (value.substring(1, value.length-1).indexOf(".") > -1)
                $(my).val(parseInput(value));
        }
    }

    function fnBlur(my)
    {
        var value = $(my).val();

        if  (parseInput(value)!='')
        {
            $(my).val(eval(value).toFixed(0)); // 소수입력시 반올림 정수
        }
        else
        {
            $(my).val('');
        }
    }

    </script>
</head>

<body>

	<div style="height: 70px;">
       <div class="toolBar" id="tool-bar" style="position: relative;border-bottom: 1px solid #d6d6d6;border: 1px solid #d6d6d6;"></div>
       <div style="text-align: right; margin-top: 5px;">
           <a href="./index.php"><b>HOME</b></a> > 스코어 관리 > 스코어 입력 &nbsp;&nbsp; [<b><?=$_SESSION["user_name"]?></b>] 님을 환영합니다...&nbsp;&nbsp;<a href="#" onclick="log_out('<?=$path_AjaxSESSION?>')"><b>로그아웃</b></a>&nbsp;
       </div>
    </div>

    <!-- h1>스코어 입력</h1 -->

    <form name="frmPlayDetail" onsubmit="return false;">

		<input type="hidden" name="price_seqs"  value="<?=$_POST["theater_code"]?>"> <!-- 가격대 -->

        <input type="hidden" name="theater_code"  value="<?=$_POST["theater_code"]?>">
        <input type="hidden" name="showroom_seq"  value="<?=$_POST["showroom_seq"]?>">
        <input type="hidden" name="film_code"     value="<?=$_POST["film_code"]?>">
        <input type="hidden" name="playprint_seq" value="<?=$_POST["playprint_seq"]?>">

        <label class="label"><input type="text" name="play_dt" id="AXInputDate" class="AXInput W100" /></label> <!-- 조회일 -->

        <button type="button" class="AXButton" id="btnSearch" tabindex="2" onclick="fnObj.search_play_detail();"><i class="axi axi-search2  W100"></i> 조회</button>

        <button type="button" class="AXButton" id="btnSave" tabindex="3" onclick="fnObj.save_play_detail();" ><i class="axi axi-save  W100"></i> 저장</button>
        <br>
        <br>


        <table cellpadding="0" cellspacing="0" class="AXFormTable">
            <colgroup>
                <col width="100" />
                <col />
            </colgroup>
            <tbody>
                <tr>
                    <th>
                        <div class="tdRel">상영정보</div>
                    </th>
                    <td class="last">
                    	<div id="play_mast" style="font-weight: bold;  font-size: x-large;"></div>
                    </td>
                </tr>
                <tr>
                    <td class="last" colspan="2">
                        <div style="padding-top: 10px;">
                            <div id="AXgrid_PlayDetail"></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">확인 / 비고</div>
                    </th>
                    <td class="last">

                        &nbsp;
                        &nbsp;
                    	<!-- 확인 / 미확인 -->
                    	<input type="text" name="confirm" id="confirm"  value="Y"  class="AXInputSwitch" style="width:60px;height:21px;border:0px none;" >
                        &nbsp;
                        &nbsp;

                    	<textarea name="memo" class="AXTextarea" style="width: 200px; height: 100px; resize:none;"></textarea>
                    </td>
                </tr>

            </tbody>
        </table>

    </form>

    <div style="display:none;">

		<div id="modalContent2">
			<div class="modalProgramTitle">
                입력오류
            </div>

            <div id="modalContent" style="padding:20px;"></div>

            <br/>
            <br/>
            <br/>

			<div class="modalButtonBox" align="center" style="height: 32px;background-color: silver;padding-top: 4px;">
            	<input type="button" value="확 인" class="AXButton W60" onclick="myModal.close('modalDiv02');"/>
            </div>
        </div>

    </div>


</body>
</html>
