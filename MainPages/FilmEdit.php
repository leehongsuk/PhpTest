<?php require_once("../config/CONFIG.php"); ?>
<?php
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
    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXUpload5.js"></script>

    <!-- 아이콘사용을 위해서..(http://axicon.axisj.com/) -->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axicon/axicon.min.css"/>


  	<!-- css block -->
    <!-- link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet "-->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/MainCss/font-awesome.min.css" />

    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axisj-1.1.11/ui/arongi/AXJ.min.css" />

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

    var film_json ;

    var myUpload       = new AXUpload5(); // 이미지 파일업로드
    var grid_PlayPrint = new AXGrid() ;   // 연락처 그리드

    var myModal = new AXModal(); // 우편번호검색을 위한 팝업창과 범용팝업

	// 하나의 영화정보를 읽어 온다.
    function readFilmOne(mode)
    {
        jQuery.post( "<?=$path_AjaxJSON?>/wrk_film_one_sel.php", { mode: mode, code: '<?=$_GET['code']?>' })  // <-----
              .done(function( data )
              {
                  	film_json = eval('('+data+')');

                    jQuery("input[name=code]").val(film_json.code);
                    jQuery("input[name=distributor_cd]").val(film_json.distributor_cd);
                    jQuery("input[name=film_nm]").val(film_json.film_nm);
                    jQuery("input[name=first_play_dt]").val(film_json.first_play_dt);
                    jQuery("input[name=open_dt]").val(film_json.open_dt);
                    jQuery("input[name=close_dt]").val(film_json.close_dt);
                    jQuery("input[name=reopem_dt]").val(film_json.reopem_dt);
                    jQuery("input[name=reclose_dt]").val(film_json.reclose_dt);
                    jQuery("input:hidden[name=images_no]").val(film_json.images_no);

                    jQuery("input[name=poster_yn").prop('checked',(film_json.poster_yn=="Y"));

                    $('input[type=radio]').bindChecked();
                    $('input[type=checkbox]').bindChecked();

                    fnObj.pageStart.delay(0.1) ; ///////////////////////// pageStart
              });
    }




    var fnObj =
    {
        readFilmOne_callbak: function()
        {
            // 배급사 (radio)
    		jQuery("input:radio[name='distributor_seq']:radio[value="+film_json.distributor_seq+"]").attr("checked",true);
    		$('input[type=radio]').bindChecked();

    		// 방화/외화 구분, 등급(seelct)
    		jQuery("select[name=korabd_cd]").setValueSelect( film_json.korabd_cd );
    		jQuery("select[name=grade_seq]").setValueSelect( film_json.grade_seq );

    		// 상영프린트(grid)
    		grid_PlayPrint.setList(film_json.playprints);
        },

        pageStart: function()
        {
            // 이걸하지않으면 디자인이 나오지 않는다.
            $('input[type=checkbox]').bindChecked();
            $('input[type=radio]').bindChecked();


            // 배급사를 가지고 온다.
			var obj = film_json.distributors ;

			for (var i=0 ;i<obj.options.length;i++)
			{
			    $('<label><input type="radio" name="distributor_seq" value="'+obj.options[i].optionValue+'" id="AXCheck_Distributor'+obj.options[i].optionValue+'" /> '+obj.options[i].optionText+'</label>').appendTo("#tdDistributor");
			}
			$('input[type=radio]').bindChecked();

            // 장르를 가지고 온다.
			var obj = film_json.genres ;

			for (var i=0 ;i<obj.options.length;i++)
			{
			    var checked = (obj.options[i].genre_seq != null) ? 'checked=checked' : '' ;

			    $('<label><input type="checkbox" name="genres[]" value="'+obj.options[i].seq+'" id="AXCheck_Genre'+obj.options[i].seq+'" '+checked+'/> '+obj.options[i].genre_nm+'</label>').appendTo("#tdGenre");
			}
			$('input[type=checkbox]').bindChecked();


            $("#AXInputDate1").bindDate({
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
            $("#AXInputDate2").bindDate({
                align:"right",
                valign:"top",
                onChange:function(){
                    //toast.push(Object.toJSON(this));
                    /*
                    dialog.push({
                        title: "제목",
                        body:'<b>주의</b> 메롱Application Call dialog push', top:200, type:'Caution', buttons:[
                            {buttonValue:'button1', buttonClass:'Red W100', onClick:fnObj.btnClick, data:'data1'},
                            {buttonValue:'button2', buttonClass:'Blue', onClick:fnObj.btnClick, data:'data2'},
                            {buttonValue:'button3', buttonClass:'Green', onClick:fnObj.btnClick, data:'data3'}
                        ]
                     });
                    */
                }
                //minDate:"2013-05-10",
                //maxDate:"2013-05-20",
                //defaultDate:"2013-05-15"
            });
            $("#AXInputDate3").bindDate({
                align:"right",
                valign:"top",
                onChange:function(){
                    //toast.push(Object.toJSON(this));
                }
                //minDate:"2013-05-10",
                //maxDate:"2013-05-20",
                //defaultDate:"2013-05-15"
            });
            $("#AXInputDate4").bindDate({
                align:"right",
                valign:"top",
                onChange:function(){
                    //toast.push(Object.toJSON(this));
                }
                //minDate:"2013-05-10",
                //maxDate:"2013-05-20",
                //defaultDate:"2013-05-15"
            });
            $("#AXInputDate5").bindDate({
                align:"right",
                valign:"top",
                onChange:function(){
                    //toast.push(Object.toJSON(this));
                }
                //minDate:"2013-05-10",
                //maxDate:"2013-05-20",
                //defaultDate:"2013-05-15"
            });


			// 방화/외화 구분
            jQuery("#AXSelect_KorabdGbn").bindSelect({
                reserveKeys: {
                    optionValue: "optionValue",
                    optionText: "optionText"
                },
                options: film_json.korabdgbns.options,
                isspace: true,
                isspaceTitle: "없음",
                onChange: function(){
                    //console.log(this.value);
                }
            });


            // 관람등급 초기화
            jQuery("#AXSelect_Grade").bindSelect({
                reserveKeys: {
                    optionValue: "optionValue",
                    optionText: "optionText"
                },
                options: film_json.grade.options,
                isspace: true,
                isspaceTitle: "없음",
                onChange: function(){
                    //console.log(this.value);
                }
            });


            grid_PlayPrint.setConfig(
            {
                targetID : "AXgrid_PlayPrint",
                height : 250,
                theme : "AXGrid",
                fitToWidth: false, // 너비에 자동 맞춤
                passiveMode:true,
                passiveRemoveHide:false,
                colGroup : [
                    {
                        key: "btns", label: "삭제", width: "60", align: "center", formatter: function ()
                        {
                          	return '<button class="AXButton" onclick="fnObj.gridPlayPrint.deleteItem(\'' + this.index + '\');"><i class="axi axi-trash2"></i></button>';
                        }
                    },
                    {key:"status", label:"상태", width:"50", align:"center", formatter:function()
                        {
	                        if(this.item._CUD == "C"){ return "신규"; }
	                        else if(this.item._CUD == "D"){ return "삭제"; }
	                        else if(this.item._CUD == "U"){ return "수정"; }
	                    }
                    },
                    {key:"playprint1_seq", label:" ",           width:"1", formatter: function () { return '' ; }},
                    {key:"playprint1_nm",  label:"상영프린트1", width:"100"},
                    {key:"playprint2_seq", label:" ",           width:"1", formatter: function () { return '' ; }},
                    {key:"playprint2_nm",  label:"상영프린트2", width:"100"},
                    {key:"memo",           label:"메모",        width:"300"}
                ],
                body : {
                    ondblclick: function()
                    {
                        //toast.push(Object.toJSON({index:this.index, item:this.item}));
                        grid_PlayPrint.setEditor(this.item, this.index);
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
                                {colSeq:3, align:"left", valign:"top", form:{type:"text", value:"itemValue"}
                                         ,AXBind:{
                                                  type:"selector",
                                                  config:{
                                                          appendable:true,
                                                          ajaxUrl:"<?=$path_AjaxJSON?>/bas_playprint1.php",  // <-----
                                                          ajaxPars:"",
                                                          onChange:function(){
                                                              if(this.selectedOption){

                                                              grid_PlayPrint.setEditorForm({
                                                                  key:"playprint1_seq",
                                                                  position:[0,2], // editor rows 적용할 대상의 배열 포지션 (다르면 적용되지 않습니다.)
                                                                  value:this.selectedOption.optionValue
                                                              });
                                                              grid_PlayPrint.setEditorForm({
                                                                  key:"playprint1_nm",
                                                                  position:[0,3], // editor rows 적용할 대상의 배열 포지션 (다르면 적용되지 않습니다.)
                                                                  value:this.selectedOption.optionText
                                                              });
                                                              }
                                                          }
                                                         }
                                         		 }

                                },
                                {colSeq:4, align:"left", valign:"top", form:{type:"text", value:"itemValue"}},
                                {colSeq:5, align:"left", valign:"top", form:{type:"text", value:"itemValue"}
                                         ,AXBind:{
                                                  type:"selector",
                                                  config:{
                                                          appendable:true,
                                                          ajaxUrl:"<?=$path_AjaxJSON?>/bas_playprint2.php",  // <-----
                                                          ajaxPars:"",
                                                          onChange:function(){
                                                              if(this.selectedOption){

                                                              grid_PlayPrint.setEditorForm({
                                                                  key:"playprint2_seq",
                                                                  position:[0,4], // editor rows 적용할 대상의 배열 포지션 (다르면 적용되지 않습니다.)
                                                                  value:this.selectedOption.optionValue
                                                              });
                                                              grid_PlayPrint.setEditorForm({
                                                                  key:"playprint2_nm",
                                                                  position:[0,5], // editor rows 적용할 대상의 배열 포지션 (다르면 적용되지 않습니다.)
                                                                  value:this.selectedOption.optionText
                                                              });
                                                              }
                                                          }
                                                         }
                                         		 }

                                },
                                {colSeq:6, align:"left", valign:"top", form:{type:"text", value:"itemValue"}}
                            ]
                    ],
                    response: function()
                    {
                        if(this.index == null) // 추가
                        {
                            var pushItem = this.res.item;

                            var errorMsg = '' ;

                            if (this.res.item.playprint1_nm == "")  { errorMsg += '상영프린트1이 비어 추가 할 수 없습니다.\n'; }
                            if (this.res.item.playprint2_nm == "")  { errorMsg += '상영프린트2이 비어 추가 할 수 없습니다.\n'; }

                            if  (errorMsg != '')
                            {
                                dialog.push('<b>알림</b>\n'+errorMsg);
                                return;
                            }

                            grid_PlayPrint.pushList(pushItem, this.insertIndex);
                        }
                        else // 수정
                        {
                            fnObj.gridPlayPrint.restoreList(this.index); // 삭제된걸 다시 복구한다.

                           	//trace(this.index);
                           	//trace(this.list);
                           	//trace(this.res.item);

							AXUtil.overwriteObject(this.list[this.index], this.res.item, true); // this.list[this.index] object 에 this.res.item 값 덮어쓰기
							grid_PlayPrint.updateList(this.index, this.list[this.index]);
                        }
                    }
                }

            });

			fnObj.upload.init();


			fnObj.readFilmOne_callbak.delay(0.1) ;
        }, // end (pageStart: function())

        //상영프린트 그리드 관련 이벤트 함수 그룹..
        gridPlayPrint:
        {

            // 상영프린트 추가 버튼을 누를 때..
            appendGrid: function(index)
            {
                var item = {};
                if(index){
                    grid_PlayPrint.appendList(item, index);
                }else{
                    grid_PlayPrint.appendList(item);
                }
            },

            // 상영프린트에서 삭제버튼을 누를 때..
            deleteItem: function (index)
            {
                if (confirm("정말로 삭제하시겠습니까?"))
                {
                    var collect = [];

                    for (var item, itemIndex = 0, __arr = grid_PlayPrint.list; (itemIndex < __arr.length && (item = __arr[itemIndex])); itemIndex++)
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

                    grid_PlayPrint.removeListIndex(collect);
                }
            },

            // 상영프린트에서 더블클릭으로 수정할 때..
            restoreList: function(index)
            {
                var collect = [];

                for (var item, itemIndex = 0, __arr = grid_PlayPrint.list; (itemIndex < __arr.length && (item = __arr[itemIndex])); itemIndex++)
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
                grid_PlayPrint.restoreList(removeList);
            }
        },

        upload: {
			init: function(){
				myUpload.setConfig({
					targetID:"AXUpload5",
					//targetButtonClass:"Green",
					uploadFileName:"fileData",

                    fileSelectAutoUpload:false,
                    buttonTxt: "전송 할 파일 찾기...",

					//file_types:"*.*",  //audio/*|video/*|image/*|MIME_type (accept)
					file_types:"image/*",
					dropBoxID:"uploadQueueBox",
					queueBoxID:"uploadQueueBox", // upload queue targetID
					// html 5를 지원하지 않는 브라우저를 위한 swf upload 설정 원치 않는 경우엔 선언 하지 않아도 됩니다. ------- s
					flash_url : "<?=$path_Root?>/js/axisj-1.1.11/lib/swfupload.swf",
					flash9_url : "<?=$path_Root?>/js/axisj-1.1.11/lib/swfupload_fp9.swf",
					// --------- e
					onClickUploadedItem: function(){ // 업로드된 목록을 클릭했을 때.
						//trace(this);
						window.open(this.uploadedPath.dec() + this.saveName.dec(), "_blank", "width=500,height=500");
					},

					uploadMaxFileSize:(10*1024*1024), // 업로드될 개별 파일 사이즈 (클라이언트에서 제한하는 사이즈 이지 서버에서 설정되는 값이 아닙니다.)
					uploadMaxFileCount:1, // 업로드될 파일갯수 제한 0 은 무제한
					uploadUrl:"<?=$path_AjaxJSON?>/AXU5_fileUpload.php",  // <-----
					uploadPars:{userID:'tom', userName:'액시스'},

					deleteUrl:"<?=$path_AjaxJSON?>/AXU5_fileDelete.php",  // <-----
					deletePars:{userID:'tom', userName:'액시스'},

					fileKeys:{ // 서버에서 리턴하는 json key 정의 (id는 예약어 사용할 수 없음)
						name:"name",
						type:"type",
						saveName:"saveName",
						fileSize:"fileSize",
						uploadedPath:"uploadedPath",
						thumbPath:"thumbUrl" // 서버에서 키값을 다르게 설정 할 수 있다는 것을 확인 하기 위해 이름을 다르게 처리한 예제 입니다.
					},

					formatter: function(f){
						var po = [];
						po.push("<div id='"+this.id+"_AXUploadLabel_mainImageFile' class='AXUploadMainImage' >mainImage</div>");

						return po.join('');
					},

					onUpload: function() // 이미지 업로드가 완료되면..
					{
					    var list = myUpload.getUploadedList();

					    jQuery("input:hidden[name=images_no]").val( list[0].result ) ; // <input type="hidden" name="images_no"> 값을 설정한다.

					    //trace(list[0].result);
					},
					onComplete: function() {},
					onStart: function() {},
					onDelete: function() {},

					onError: function(errorType, extData)
					{
						if(errorType == "html5Support"){
							//dialog.push('The File APIs are not fully supported in this browser.');
						}else if(errorType == "fileSize"){
							trace(extData);
							alert("파일사이즈가 초과된 파일을 업로드 할 수 없습니다. 업로드 목록에서 제외 합니다.\n("+extData.name+" : "+extData.size.byte()+")");
						}else if(errorType == "fileCount"){
							alert("업로드 갯수 초과 초과된 아이템은 업로드 되지 않습니다.");
						}
					}
				});
				// changeConfig

				// 서버에 저장된 파일 목록을 불러와 업로드된 목록에 추가 합니다. ----------------------------- s
				var url = "<?=$path_AjaxJSON?>/AXU5_fileListLoad.php?gubun=film&code=<?=$_GET['code']?>";  // <-----
				var pars = "dummy="+AXUtil.timekey();
				new AXReq(url, {pars:pars, onsucc:function(res){
                    if(!res.error){
                        myUpload.setUploadedList(res);
                    }else{
                        alert(res.msg.dec());
                    }
				}});
				// 서버에 저장된 파일 목록을 불러와 업로드된 목록에 추가 합니다. ----------------------------- e

			},
			printMethodReturn: function(method, type){
				var list = myUpload[method](type);
				//trace(list);
				trace(myUpload.getUploadedList());
				toast.push(Object.toJSON(list));
			},
			changeOption: function(){

				// 업로드 갯수 등 업로드 관련 옵션을 동적으로 변경 할 수 있습니다.
				myUpload.changeConfig({
					/*
					uploadUrl:"uploadFile.asp",
					uploadPars:{userID:'tom', userName:'액시스'},
					deleteUrl:"deleteFile.asp",
					deletePars:{userID:'tom', userName:'액시스'},
					*/
					uploadMaxFileCount:10
				});
			}
		},

		// 하나의 영화을 저장한다.
		save_film : function()
		{
		    var errorMsg = '' ;

		    var distributor_cd  = jQuery('input[name=distributor_cd]').val().trim() ;
		    var distributor_seq = jQuery('input:radio[name=distributor_seq]').is(':checked') ;
		    var film_nm         = jQuery('input[name=film_nm]').val().trim() ;
		    var korabd_cd       = jQuery("select[name=korabd_cd]").val() ;
		    var genres_num      = jQuery("input[name='genres[]']:checked").length ;
		    var grade_seq       = jQuery("select[name=grade_seq]").val() ;


		    if  (distributor_cd == '') errorMsg += '배급사 영화코드가 없습니다.<br>' ;
		    if  (!distributor_seq)     errorMsg += '배급사가 선택되지 않았습니다.<br>' ;
		    if  (film_nm == '')        errorMsg += '대표영화명이 없습니다.<br>' ;
		    if  (korabd_cd == '')      errorMsg += '방화/외화 구분이 없습니다.<br>';
		    if  (genres_num == 0)      errorMsg += '장르가 선택되지 않았습니다.<br>' ;
		    if  (grade_seq == '')      errorMsg += '영화등급이 없습니다.<br>';

			// 상영프린터 개수 체크....
		    var count = 0 ;
		    grid_PlayPrint.list.forEach(function(e)
            {
	            if (typeof e._CUD != "undefined")
	            {
	                if (e._CUD != 'D') count++ ;
	            }
	            else
	            {
	                count++ ;
	            }
            });

            var skip = false ;

            if  (count == 0)
            {
                errorMsg += '상영프린터가 하나이상 존재해야 됩니다.<br>';
            }
            else
            {
                if  (count > 1)
                {
					var duplicate = false ; // 중복자료가 발견되면  true

                    for(var i=0 ; i<grid_PlayPrint.list.length ; i++)
                    {
                        var skip_i = false ;

                        if (typeof grid_PlayPrint.list[i]._CUD != "undefined")
        	            {
                        	if  (grid_PlayPrint.list[i]._CUD == 'D') skip_i = true;
        	            }

        	            if  (!skip_i)
        	            {
                            var playprint1_seq_i = grid_PlayPrint.list[i].playprint1_seq ;
                            var playprint2_seq_i = grid_PlayPrint.list[i].playprint2_seq ;

							for(var j=0 ; j<grid_PlayPrint.list.length ; j++)
                            {
                               	var skip_j = false ;

								if (typeof grid_PlayPrint.list[j]._CUD != "undefined")
               	            	{
                               		if  (grid_PlayPrint.list[j]._CUD == 'D') skip_j = true;
               	            	}

                	            if  (!skip_j)
                	            {
                	                var playprint1_seq_j = grid_PlayPrint.list[j].playprint1_seq ;
                                    var playprint2_seq_j = grid_PlayPrint.list[j].playprint2_seq ;

                                    if  ((i != j) && (playprint1_seq_i == playprint1_seq_j) && (playprint2_seq_i == playprint2_seq_j) )
                                    {
                                        duplicate = true; // 중복확인...!!
                                    }
                	            }
         	            	} // for(var j=0 ; j<grid_PlayPrint.list.length ; j++)
        	            }
                    } // for(var i=0 ; i<grid_PlayPrint.list.length ; i++)

                    if  (duplicate == true) errorMsg += '상영프린터1,2가 중복됩니다.<br>';

                } // if  (count > 1)
            }


		    if (errorMsg == '')
            {
		        jQuery("input:hidden[name=playprints]").val( JSON.stringify( grid_PlayPrint.list ) ) ;

                // 저장할 값들을 취합한다.
                var formData = jQuery("form[name=frmFilm]").serialize();

                jQuery.ajax({
                             type : "POST",
                             url : "<?=$path_AjaxJSON?>/wrk_film_save.php",  // <-----
                             cache : false,
                             data : formData,
                             success : fnObj.onSuccessFilm,
                             error : fnObj.onErrorFilm
                });
            }
            else
            {
                fnObj.modalOpen(500,-1,'입력오류',errorMsg,null) ;
            }
		},

		onFnClose : function()
        {
		    location.replace("./FilmList.php") ; // 히스토리에 저장이 되지않는다.   // <-----
        },

		// 영화 저장이 성공적일때..
        onSuccessFilm : function(data)
        {
            var obj = eval("("+data+")");
            //trace(obj);

            if  (obj=='-1') fnObj.modalOpen(500,-1,'확인','저장이 실패되었습니다.',null)
            else            fnObj.modalOpen(500,-1,'확인','저장이 완료되었습니다.',fnObj.onFnClose) ;
        },

        // 영화 저장이 실패하면..
        onErrorFilm : function(request,status,error)
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
            myModal.setConfig({onclose: onFnClose, displayLoading: false});

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
    };


    jQuery(document).ready(readFilmOne('<?=$MODE?>'));



    function test()
    {
    	jQuery("#AXSelect_Grade").setValueSelect("1");
    	$('input[type=checkbox]').bindChecked();
    }
    </script>
</head>


<body>

    <!-- button onclick="test();">test</button -->
    <?php
    if ($MODE=="APPEND")  { ?><h1>영화 등록</h1><?php     }
    if ($MODE=="EDIT")    { ?><h1>영화 편집</h1><?php     }
    ?>

    <form name="frmFilm" onsubmit="return false;">

    	<input type="hidden" name="playprints">
    	<input type="hidden" name="images_no">

    	<table cellpadding="0" cellspacing="0" class="AXFormTable">
    		<colgroup>
    			<col width="120" />
    			<col />
    		</colgroup>
    		<tbody>
    			<tr>
    				<th>
    					<div class="tdRel">영화코드</div>
    				</th>
    				<td class="last">
    					<div class="tdRel">
    						<input type="text" name="code" placeholder="영화코드" value="" class="AXInput W90 av-bizno" readonly="readonly"/>
    					</div>
    				</td>
    			</tr>
    			<tr>
    				<th>
    					<div class="tdRel">배급사 영화코드</div>
    				</th>
    				<td class="last">
    					<div class="tdRel">
    						<input type="text" name="distributor_cd" placeholder="배급사영화코드" value="" class="AXInput W200 av-bizno" />
    					</div>
    				</td>
    			</tr>
    			<tr>
    				<th>
    					<div class="tdRel">배급사</div>
    				</th>
    				<td class="last" id="tdDistributor">
    				</td>
    			</tr>
    			<tr>
    				<th>
    					<div class="tdRel">대표영화명</div>
    				</th>
    				<td class="last">
    					<div class="tdRel">
    						<input type="text" name="film_nm" placeholder="대표영화명" value="" class="AXInput W200 av-bizno" />

    						<!-- 방화/외화 -->
    						<select name="korabd_cd" class="AXSelectSmall" id="AXSelect_KorabdGbn" style="width:120px;" tabindex="1"></select>
    					</div>
    				</td>
    			</tr>
    			<tr>
    				<th>
    					<div class="tdRel">장르</div>
    				</th>
    				<td class="last" id="tdGenre">
    				</td>
    			</tr>
    			<tr>
    				<th>
    					<div class="tdRel">영화 등급</div>
    				</th>
    				<td class="last">
    					<select name="grade_seq" class="AXSelectSmall" id="AXSelect_Grade" style="width:120px;" tabindex="1"></select>
    				</td>
    			</tr>
    			<tr>
    				<th>
    					<div class="tdRel">개봉일 - 종영일</div>
    				</th>
    				<td class="last">
    					<table>
    						<tr>
    							<td class="white_board"><label>1. 최초상영일</label></td>
    							<td class="white_board">
    								: <input type="text" name="first_play_dt" id="AXInputDate1" class="AXInput W100" />
    							</td>
    						</tr>
    						<tr>
    							<td class="white_board"><label>2. 개봉일</label></td>
    							<td class="white_board">
    								: <input type="text" name="open_dt" id="AXInputDate2" class="AXInput W100" />
    							</td>
    						</tr>
    						<tr>
    							<td class="white_board"><label>3. 종영일</label></td>
    							<td class="white_board">
    								: <input type="text" name="close_dt" id="AXInputDate3" class="AXInput W100" />
    							</td>
    						</tr>
    						<tr>
    							<td class="white_board"><label>4. 재개봉일</label></td>
    							<td class="white_board">
    								: <input type="text" name="reopem_dt" id="AXInputDate4" class="AXInput W100" />
    							</td>
    						</tr>
    						<tr>
    							<td class="white_board"><label>5. 재종영일</label></td>
    							<td class="white_board">
    								: <input type="text" name="reclose_dt" id="AXInputDate5" class="AXInput W100" />
    							</td>
    						</tr>
    						</table>
    				</td>
    			</tr>
    			<tr>
    				<th>
    					<div class="tdRel">포스터</div>
    				</th>
    				<td class="last">

    					<label><input type="checkbox" name="poster_yn" value="Y" id="AXCheck_Operation0" /> 포스트사용 유무</label>

    					<div style="height: 10px;"></div>
    					<input type="button" value="업로드" class="AXButton" onclick="myUpload.uploadQueue(true);" />
    					<input type="button" value="삭제" class="AXButton" onclick="myUpload.deleteSelect('all');" />
    					<div style="height: 5px;"></div>

    		            <div id="uploadQueueBox" class="AXUpload5QueueBox" style="height:188px;width:140px;"></div>
						<div style="height: 5px;"></div>
                        <div class="AXUpload5" id="AXUpload5"></div>


    				</td>
    			</tr>
    			<tr>
    				<th>
    					<div class="tdRel">프린터</div>
    				</th>
    				<td class="last">

    					<div style="padding: 5px;">
                            <div id="AXgrid_PlayPrint"></div>
                        </div>

    					<button type="button" class="AXButton" onclick="fnObj.gridPlayPrint.appendGrid();"><i class="axi axi-ion-document-text"></i> 추가하기</button>
    				</td>
    			</tr>
    		</tbody>
    	</table>

	</form>

    <div class="modalButtonBox" align="center">
        <button type="button" class="AXButtonLarge W500" id="btnSave" onclick="fnObj.save_film();"><i class="axi axi-save "></i> 저장</button>
    </div>


</body>
</html>
