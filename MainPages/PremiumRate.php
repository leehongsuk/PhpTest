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

    <!-- 아이콘사용을 위해서..(http://axicon.axisj.com/) -->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axicon/axicon.min.css"/>


  	<!-- css block -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/MainCss/Common.css" />

    <script type="text/javascript">

    var jsonLocChldAll ; // 지역리스트의 json
    var jsonPremiumRate ; // 부율전체 json

    var myUpload         = new AXUpload5();
    var grid_PremiumRate = new AXGrid() ; // 부율 그리드


    var fnObj =
    {
        pageStart: function()
        {
            // 이걸하지않으면 디자인이 나오지 않는다.
            $('input[type=checkbox]').bindChecked();
            $('input[type=radio]').bindChecked();

         	// 방화/외화 구분 셀렉터
            jQuery("#AXSelect_KorabdGbn").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_korabd_gbn.php",
                onChange: function(){
                    console.log(this.value);
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
                   //+ '       onkeydown="fnKeydown(event)"                   '
                   + '       onkeyup="fnKeyup(this)"                        '
				   + '       onblur="fnBlur(this)"/>                        '
                    ;
		},

        // '조회'버튼을 누를때
        search_premium_rate: function()
        {
            jQuery.post( "<?=$path_AjaxJSON?>/bas_location_child_all.php", {})
	              .done(function( data ) {

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

						jsonLocChldAll = eval("("+data+")");  // 지역리스트의 json

						//trace(jsonLocChldAll); ////////////

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

	      				//var j = JSON.stringify(colgrp); // object를 json으로 변환한다.
	      				//console.log(j);

	      				grid_PremiumRate.setConfig({colGroup : colgrp});

	      				var result = '' ;
	                  	grid_PremiumRate.setList({
	                      	ajaxUrl : "<?=$path_AjaxJSON?>/bas_premium_rate_sel.php",
	                      	ajaxPars: {
	                          	"korabd_gbn": jQuery("#AXSelect_KorabdGbn").val()
	                      	},
	                      	onLoad : function()
	                      	{
								//trace(this);
								jsonPremiumRate = this;
	                      	  	jQuery("#btnSave").removeAttr("disabled");
	                      	}
	                  	});
	              });

        },

        // '저장' 버튼을 누를때
        save_premium_rate: function()
        {
            //trace(jsonPremiumRate.list);

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

					if  (premium_rate == '') alert('값이없습니다.'+title1+title2+location_nm)
					else
					{
					    if  (parseInput(premium_rate) >= 100.0)	alert('값이100보다 크면 안돼요'+title1+title2+location_nm)
					}

                    //trace(name+' , '+premium_rate);
                });
                /*
                jQuery(':input').each(function(index)
          		{
              			if  ($(this).attr('type')=='text')
              			{
       		                var result = "태그명 : " +  $(this).get(0).tagName
               		                    + ", type  : " + $(this).attr('type')
               		                    + ", title1  : " + $(this).attr('title1')
               		                    + ", title2  : " + $(this).attr('title2')
               		                    + ", location_nm  : " + $(this).attr('location_nm')
               		                    + ", value  : " + $(this).attr('value')
               		                    + '\n';

       						trace( result );
              			}
                });
                */
            }

            //jQuery("form[name=frmPremiumRate]").submit();

            var formData = jQuery("form[name=frmPremiumRate]").serialize();

            //trace(formData);

            jQuery.ajax({
	 					type : "POST",
	 					url : "<?=$path_AjaxJSON?>/bas_premium_rate_upt.php",
	 					cache : false,
	 					data : formData
	 					//,
	 					//success : onSuccess,
	 					//error : onError
			});

			// 다시 검색버튼을 누른다.
            fnObj.search_premium_rate();
		}

    };

	jQuery(document).ready(fnObj.pageStart.delay(0.1));


	var parseInput = function(val)
	{
		if  (isNaN(parseFloat(val))) return '';

         var floatValue = parseFloat(val);
         return isNaN(floatValue) ? '' : floatValue;
    }

    function fnKeydown(event)
    {
        trace(event.keyCode);

        if (event.keyCode == 13)
        {
            //trace($(this).attr(tabindex));
        }

        //this.value.replace(/[\a-zㄱ-ㅎㅏ-ㅣ가-힣]/g, '');
        //obj.value = obj.value.replace(/[\ㄱ-ㅎㅏ-ㅣ가-힣]/g, '');
    }


    function fnKeyup(my)
    {
        	trace(event.keyCode);
/*
        if (event.keyCode == 13)
        {
            trace($(this).attr(tabindex));
        	trace($(my).next());
        	trace($(my).index(this));
        	$( my ).blur();
            //$(my).next().focus();
        }
*/
        if (event.keyCode==13 ) return;
		if (event.keyCode==9 ) return;

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

    <form name="frmPremiumRate" action="<?=$path_AjaxJSON?>/bas_premium_rate_upt.php">

    <select name="KorabdGbn" class="AXSelectSmall W100" id="AXSelect_KorabdGbn" tabindex="1"></select>

    <button type="button" class="AXButtonSmall" id="btnSearch" tabindex="2" onclick="fnObj.search_premium_rate();"><i class="axi axi-search2  W100"></i> 조회</button>

    <button type="button" class="AXButtonSmall" id="btnSave" tabindex="3" onclick="fnObj.save_premium_rate();" disabled="disabled"><i class="axi axi-save  W100"></i> 저장</button>

    <br>


     	<div style="padding-top: 10px;">
     		<div id="AXgrid_PremiumRate"></div>
     	</div>

    </form>



</body>
</html>
