<?php require_once("../config/CONFIG.php"); ?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<!-- 공통요소 -->
	<link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axisj-1.1.11/ui/arongi/AXJ.css" />
	<script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXJ.js"></script>
	
	<!-- 추가하는 UI 요소 -->
	<link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axisj-1.1.11/ui/arongi/AXInput.css" />
	<link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axisj-1.1.11/ui/arongi/AXSelect.css" />
	<link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axisj-1.1.11/ui/arongi/AXGrid.css" />
	
	<script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXInput.js"></script>
	<script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXSelect.js"></script>
	<script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXGrid.js"></script>
	
	<style type="text/css">
	
	body {
	font-family: "굴림";
	font-size:13px;
	}
	
	</style>
	
	<script type="text/javascript">
	
	var myGrid = new AXGrid(); // instance
	
	var fnObj = 
	{	
		pageStart: function()
		{	
			myGrid.setConfig(
			{
				targetID : "AXGridTarget",
				theme : "AXGrid",
				autoChangeGridView: { // autoChangeGridView by browser width
					mobile:[0,600], grid:[600]
				},
				colGroup : [
						{key:"zip_code", label:"우편번호", width:"100"},
						{key:"si_do", label:"시도", width:"100"},
						{key:"kun_ku", label:"시군구", width:"100"},
						{key:"ub_myun_dong", label:"읍면동", width:"100"},
						{key:"lee", label:"리", width:"100"},
						{key:"doseo", label:"도서", width:"100"},
						{key:"s_bunji1", label:"시작주번지", width:"100"},
						{key:"s_bunji2", label:"시작부번지", width:"100"},
						{key:"e_bunji1", label:"끝주번지", width:"100"},
						{key:"e_bunji2", label:"끝부번지", width:"100"},
						{key:"location", label:"다량배달처", width:"100"},
						{key:"s_dong", label:"시작동", width:"100"},
						{key:"e_dong", label:"끝동", width:"100"}
				],
				body : {
					onclick: function(){
						//toast.push(Object.toJSON({index:this.index, item:this.item}));
						console.log(this.item);
					}
				},
// 				page:{
// 					paging:false
// 				}
				 page:{
	                    paging:true,
	                    pageNo:1,
	                    pageSize:10
	                }
			});


			myGrid.setList({
			    ajaxUrl : "<?=$path_AjaxJSON?>/bas_zip.php",
//                 ajaxPars: {
//                     "param1": "액시스제이",
//                     "param2": "AXU4J"
//                 },
                onLoad  : function(){
                    //trace(this);
 
		            //myGrid.setFocus(this.list.length - 1);
                }
			});
		}
	};
	
	jQuery(document).ready(fnObj.pageStart.delay(0.1));	
	
	
	</script>
</head>

<body>
	<h1>우편번호</h1>
	<div id="AXGridTarget"></div>
	
	한글 English;
</body>
</html>
