<?php require_once("../config/CONFIG.php"); ?>
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

    <!-- 아이콘사용을 위해서..(http://axicon.axisj.com/) -->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axicon/axicon.min.css"/>


    <!-- css block -->
    <!-- link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet "-->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/MainCss/font-awesome.min.css" />

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
            background-color: #DBDDE6;
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

            jQuery("input[name=play_dt]").val('2017-01-15');

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


            jQuery.post( "<?=$path_AjaxJSON?>/lst_inning.php", {})  // <-----
                  .done(function( data )
                  {
      				    jsonInning = eval("("+data+")");  // 회차리스트의 json
                        //trace(jsonInning); ////////////

                        var colgrp = [];

                        var o={} ;
                        o['key'] = 'price';
                        o['label'] = '요금';
                        o['width'] = '100';
                        colgrp.push(o);

                        var o={} ;
                        o['key'] = 'sum';
                        o['label'] = '합계';
                        o['width'] = '90';
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

                            colgrp.push(o);
                        }

                        grid_PlayDetail.setConfig({colGroup : colgrp}); // 컬럼 그룹정보를 설정한다...


                        var result = '' ;
                        grid_PlayDetail.setList({
                              ajaxUrl : "<?=$path_AjaxJSON?>/wrk_play_detail_selected_sel.php",  // <-----
                              ajaxPars: {
                                  "play_dt"       : jQuery("input[name=play_dt]").val() ,
                                  "theater_code"  : '<?=$post_theater_code?>' ,
                                  "showroom_seq"  : <?=$post_showroom_seq?> ,
                                  "film_code"     : '<?=$post_film_code?>' ,
                                  "playprint_seq" : <?=$post_playprint_seq?>
                              },
                              onLoad : function()
                              {
                                  /*
      							jsonPremiumRate = this;

                                jQuery("#btnSave").removeAttr("disabled"); // 저장가능하도록 한다.

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
                                  */
                              }
                        });

                  });

        }, // end (pageStart: function())



        // 스코어값으로 text박스를 만든다.
        formatter : function()
        {
trace(this.value);
            //var name = "pr_"+this.key+"_"+this.item.a_seq+"_"+this.item.id_code+"_"+this.item.ua_seq ;

            return   '<input type="text"                                    '
                   + '       name="'+name+'"                                '
                   + '       style="text-align: right; padding-right:5px;"  '
                   + '       class="AXInput W40 dot"                        '
                   + '       value="'+this.value +'"                        '
                   + '       onkeyup="fnKeyup(this,event)"                        '
                   + '       onblur="fnBlur(this)"/>                        '
                    ;
        },


        // '저장' 버튼을 누를때
        save_premium_rate: function()
        {
            //trace(jsonPlayDetail.list);
            var errorMsg = '' ;

            for (var i=0; i<jsonPlayDetail.list.length;i++)
            {
                var keys = Object.keys(jsonPlayDetail.list[i]) ;
                var values = Object.values(jsonPlayDetail.list[i]) ;

                var nonLoc = [ 'a_seq'
                              ,'a_affiliate_nm'
                              ,'id_code'
                              ,'id_direct_nm'
                              ,'ua_seq'
                              ,'ua_affiliate_nm'
                              ,'title1'
                              ,'title2'
                             ] ;

                var locs = jQuery(keys).not(nonLoc).get() ; // 지역이 아닌건 차집합으로 빼고.. 순수지역만..

                jQuery.each(locs,function(idx,value){
                    var name = "pr_"+value+"_"
                              + values[ jQuery.inArray('a_seq',keys) ]+"_"
                              + values[ jQuery.inArray('id_code',keys) ]+"_"
                              + values[ jQuery.inArray('ua_seq',keys) ] ;

                    var premium_rate = jQuery('input[name='+name+']').val() ;
                    var title1       = jQuery('input[name='+name+']').attr('title1') ;
                    var title2       = jQuery('input[name='+name+']').attr('title2') ;
                    var location_nm  = jQuery('input[name='+name+']').attr('location_nm') ;

                    if  (premium_rate == '')
                    {
                        errorMsg += title1+title2+'의 '+location_nm+'에 값이없습니다.<br>';
                    }
                    else
                    {
                        if  (parseInput(premium_rate) >= 100.0)
                            errorMsg += title1+title2+'의 '+location_nm+'에 값이100보다 크면 안됍니다.<br>';
                    }
                });
            } // for (var i=0; i<jsonPlayDetail.list.length;i++)

            if (errorMsg == '')
            {
                // 저장할 값들을 취합한다.
                var formData = jQuery("form[name=frmPlayDetail]").serialize();

                jQuery.ajax({
                             type : "POST",
                             url : "<?=$path_AjaxJSON?>/bas_premium_rate_upt.php",  // <-----
                             cache : false,
                             data : formData,
                             success : fnObj.onSuccessPreminumRate,
                             error : fnObj.onErrorPreminumRate
                });
            }
            else
            {
                jQuery("#modalContent").html(errorMsg);

                fnObj.modalOpen(500,-1,'입력오류',errorMsg,null) ;
            }

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
            $(my).val(eval(value).toFixed(2));
        }
        else
        {
            $(my).val('');
        }
    }

    </script>
</head>

<body>

    <h1>스코어 입력</h1>

    <form name="frmPlayDetail" action="<?=$path_AjaxJSON?>/bas_premium_rate_upt.php" onsubmit="return false;">

        <input type="text" name="play_dt" id="AXInputDate" class="AXInput W100" /> <!-- 조회일 -->

        <button type="button" class="AXButton" id="btnSave" tabindex="3" onclick="fnObj.save_premium_rate();" ><i class="axi axi-save  W100"></i> 저장</button>
        <br>

         <div style="padding-top: 10px;">
             <div id="AXgrid_PlayDetail"></div>
         </div>

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
