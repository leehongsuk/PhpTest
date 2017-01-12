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
        }
    </style>


    <script type="text/javascript">

    var jsonLocChldAll ;  // 지역리스트의 json
    var jsonPremiumRate ; // 부율전체 json

    var grid_PremiumRate = new AXGrid() ; // 부율 그리드
    var myModal = new AXModal();


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

             // 방화/외화 구분 셀렉터
            jQuery("#AXSelect_KorabdGbn").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_korabd_gbn.php",  // <-----
                onChange: function(){
                    //console.log(this.value);
                }
            });

            // 부율그리드
            grid_PremiumRate.setConfig(
            {
                targetID : "AXgrid_PremiumRate",
                height : 500,
                theme : "AXGrid",
                fitToWidth: false, // 너비에 자동 맞춤
                colGroup : [
                    {key:"title1", label:" ", width:"100"},
                    {key:"title2", label:" ", width:"100"}
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

        }, // end (pageStart: function())

        // 부율값으로 text박스를 만든다.
        formatter : function()
        {
            var location_nm = "";

            // 지역리스트 json에서 지역코드로 지역명을 구한다.
            for (var i = 0; i < jsonLocChldAll.options.length; i++)
            {
                if (jsonLocChldAll.options[i].seq == this.key)
                {
                    location_nm = jsonLocChldAll.options[i].location_nm ;
                }
            }

            var name = "pr_"+this.key+"_"+this.item.a_seq+"_"+this.item.id_code+"_"+this.item.ua_seq ;

            return   '<input type="text"                                    '
                   + '       name="'+name+'"                                '
                   + '       style="text-align: right; padding-right:5px;"  '
                   + '       loc="'+this.key+'"                             '
                   + '       location_nm="'+location_nm+'"                  '
                   + '       a_seq="'+this.item.a_seq+'"                    '
                   + '       id_code="'+this.item.id_code+'"                '
                   + '       ua_seq="'+this.item.ua_seq+'"                  '
                   + '       title1="'+this.item.title1+'"                  '
                   + '       title2="'+this.item.title2+'"                  '
                   + '       class="AXInput W40 dot"                        '
                   + '       value="'+this.value +'"                        '
                   + '       onkeyup="fnKeyup(this,event)"                        '
                   + '       onblur="fnBlur(this)"/>                        '
                    ;
        },

        // '조회'버튼을 누를때
        search_premium_rate: function()
        {
            jQuery.post( "<?=$path_AjaxJSON?>/bas_location_child_all.php", {})  // <-----
                  .done(function( data )
                  {
						jsonLocChldAll = eval("("+data+")");  // 지역리스트의 json
                        //trace(jsonLocChldAll); ////////////

                        var colgrp = [];

                        var o={} ;
                        o['key'] = 'title1';
                        o['label'] = ' ';
                        o['width'] = '100';
                        colgrp.push(o);

                        var o={} ;
                        o['key'] = 'title2';
                        o['label'] = ' ';
                        o['width'] = '100';
                        colgrp.push(o);


                        /***/
                        for (var i=0;i<jsonLocChldAll.options.length ;i++)
                        {
                            var o={} ;

                            for (var prop in jsonLocChldAll.options[i])
                            {
                                 if  (prop=="seq")         o['key']   = jsonLocChldAll.options[i][prop];
                                 if  (prop=="location_nm") o['label'] = jsonLocChldAll.options[i][prop];
                            }
                            o['width'] = '70';
                            o['formatter'] = fnObj.formatter;// <input typw="text"> 태그를 단다...

                            colgrp.push(o);
                        }

                        grid_PremiumRate.setConfig({colGroup : colgrp}); // 컬럼 그룹정보를 설정한다...

                        var result = '' ;
                        grid_PremiumRate.setList({
                              ajaxUrl : "<?=$path_AjaxJSON?>/bas_premium_rate_sel.php",  // <-----
                              ajaxPars: {
                                  "korabd_gbn": jQuery("#AXSelect_KorabdGbn").val()
                              },
                              onLoad : function()
                              {
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
                              }
                        });
                  });
        },

        // '저장' 버튼을 누를때
        save_premium_rate: function()
        {
            //trace(jsonPremiumRate.list);
            var errorMsg = '' ;

            for (var i=0; i<jsonPremiumRate.list.length;i++)
            {
                var keys = Object.keys(jsonPremiumRate.list[i]) ;
                var values = Object.values(jsonPremiumRate.list[i]) ;

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
            } // for (var i=0; i<jsonPremiumRate.list.length;i++)

            if (errorMsg == '')
            {
                // 저장할 값들을 취합한다.
                var formData = jQuery("form[name=frmPremiumRate]").serialize();

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
            //toast.push("다시 검색버튼을 누른다.");
            // 다시 검색버튼을 누른다.
            fnObj.search_premium_rate();
        },

        // 부율 저장이 성공적일때..
        onSuccessPreminumRate : function()
        {
             // 다시 검색버튼을 누른다.
            //fnObj.search_premium_rate();

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

    <h1>기본부율</h1>

    <form name="frmPremiumRate" action="<?=$path_AjaxJSON?>/bas_premium_rate_upt.php" onsubmit="return false;">

        <select name="KorabdGbn" class="AXSelectSmall W100" id="AXSelect_KorabdGbn" tabindex="1"></select>

        <button type="button" class="AXButtonSmall" id="btnSearch" tabindex="2" onclick="fnObj.search_premium_rate();"><i class="axi axi-search2  W100"></i> 조회</button>

        <button type="button" class="AXButtonSmall" id="btnSave" tabindex="3" onclick="fnObj.save_premium_rate();" disabled="disabled"><i class="axi axi-save  W100"></i> 저장</button>

        <br>

         <div style="padding-top: 10px;">
             <div id="AXgrid_PremiumRate"></div>
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
