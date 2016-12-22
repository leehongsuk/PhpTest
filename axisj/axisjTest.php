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
    
    <script type="text/javascript">

	var myGrid = new AXGrid() ; // instance
	var fnObj = {
	    	
	    pageStart: function(){
	
		    jQuery("#AXSelect_Parent").bindSelect({
		        ajaxUrl: "<?=$path_AjaxJSON?>/bas_location_parent.php",
		        ajaxPars: "",
		        isspace: true,
		        isspaceTitle: "전체",
		        onChange: function(){
					//console.log(this.value);
		            jQuery("#AXSelect_Child").bindSelect({
					        ajaxUrl: "<?=$path_AjaxJSON?>/bas_location_child.php",
					        ajaxPars: {
			                    "parent_seq":this.value
			                },
					        isspace: true,
					        isspaceTitle: "전체",
					        onChange: function(){
								//console.log(this.value);
						    }
					    });					
			    }
		    });
	    
	        myGrid.setConfig({
	            targetID : "AXGridTarget",
	            theme : "AXGrid",
	            autoChangeGridView: { // autoChangeGridView by browser width
	                mobile:[0,600], grid:[600]
	            },
	            colGroup : [
	                {key:"no", label:"No.", width:"40", align:"center", formatter:"money"},
	                {key:"title", label:"Title", width:"200"},
	                {key:"writer", label:"Writer", width:"100", align:"center"},
	                {key:"date", label:"Date.", width:"100", align:"center"},
	                {key:"desc", label:"Etc.", width:"*"}
	            ],
	            body : {
	                onclick: function(){
	                    //toast.push(Object.toJSON({index:this.index, item:this.item}));
	                    console.log(this.item); 
	                }
	            },
	            page:{
	                paging:false
	            }
	        });
	
	        var list = [
	            {
	                no:1, title:"AXGrid 첫번째 줄 입니다.AXGrid 첫번째 줄 입니다.", writer:"장기영", img:"img/1.jpg", desc:"많은 글을 담고 있는 내용 입니다. 자연스럽게 줄이 넘어가고 표현되는 것이 관건 입니다.", category:"액시스제이", date:"2014-04-05"
	            },
	            {
	                no:2, title:"AXGrid 두번째 줄 입니다.AXGrid 첫번째 줄 입니다.", writer:"장기영", img:"img/2.jpg", desc:"많은 글을 담고 있는 내용 입니다.", category:"액시스제이", date:"2014-04-07"
	            },
	            {
	                no:3, title:"AXGrid 세번째 줄 입니다.AXGrid 첫번째 줄 입니다.", writer:"장기영", img:"img/3.jpg", desc:"많은 글을 담고 있는 내용 입니다. 자연스럽게...", category:"액시스제이", date:"2014-04-09"
	            }
	        ];
	
	        //setList
	        myGrid.setList(list);
	        /* ajax way
	        myGrid.setList({
	            ajaxUrl:"...",
	            ajaxPars:"",
	            onLoad:function(){},
	            onError:function(){}
	        });
	        */
	    }
	};
	
	jQuery(document).ready(fnObj.pageStart.delay(0.1));
	
	</script>
	
</head>

<body>
    <h1>AXGrid RWD</h1>
    <div id="AXGridTarget"></div>
    
    <select name="" class="AXSelectSmall" id="AXSelect_Parent" style="width:100px;" tabindex="5"></select>
    <select name="" class="AXSelectSmall" id="AXSelect_Child" style="width:100px;" tabindex="6"></select>
</body>
</html>