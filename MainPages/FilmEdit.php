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
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

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

    var myUpload       = new AXUpload5();
    var grid_PlayPrint = new AXGrid() ; // 연락처 그리드


    var fnObj =
    {
        pageStart: function()
        {
            // 이걸하지않으면 디자인이 나오지 않는다.
            $('input[type=checkbox]').bindChecked();
            $('input[type=radio]').bindChecked();

            // 배급사를 가지고 온다.
            jQuery.post( "<?=$path_AjaxJSON?>/bas_distributor.php")  // <-----
		          .done(function( data )
				  {
		            	var obj = eval("("+data+")");

						for (var i=0 ;i<obj.options.length;i++)
						{
						    $('<label><input type="radio" name="distributor_seq" value="'+obj.options[i].optionValue+'" id="AXCheck_Distributor'+obj.options[i].optionValue+'" /> '+obj.options[i].optionText+'</label>').appendTo("#tdDistributor");
						}
						$('input[type=radio]').bindChecked();
		          });


            // 장르를 가지고 온다.
            jQuery.post( "<?=$path_AjaxJSON?>/wrk_film_genre.php", { code: '<?=$_GET['code']?>' })  // <-----
		          .done(function( data )
				  {
		            	var obj = eval("("+data+")");

						for (var i=0 ;i<obj.options.length;i++)
						{
						    var checked = (obj.options[i].genre_seq != null) ? 'checked=checked' : '' ;

						    $('<label><input type="checkbox" name="genre'+obj.options[i].seq+'" value="Y" id="AXCheck_Genre'+obj.options[i].seq+'" '+checked+'/> '+obj.options[i].genre_nm+'</label>').appendTo("#tdGenre");
						}
						$('input[type=checkbox]').bindChecked();
		          });



            $("#AXInputDate1").bindDate({
                align:"right",
                valign:"top",
                onChange:function(){
                    toast.push(Object.toJSON(this));
                }
                //minDate:"2013-05-10",
                //maxDate:"2013-05-20",
                //defaultDate:"2013-05-15"
            });
            $("#AXInputDate2").bindDate({
                align:"right",
                valign:"top",
                onChange:function(){
                    toast.push(Object.toJSON(this));
                }
                //minDate:"2013-05-10",
                //maxDate:"2013-05-20",
                //defaultDate:"2013-05-15"
            });
            $("#AXInputDate3").bindDate({
                align:"right",
                valign:"top",
                onChange:function(){
                    toast.push(Object.toJSON(this));
                }
                //minDate:"2013-05-10",
                //maxDate:"2013-05-20",
                //defaultDate:"2013-05-15"
            });
            $("#AXInputDate4").bindDate({
                align:"right",
                valign:"top",
                onChange:function(){
                    toast.push(Object.toJSON(this));
                }
                //minDate:"2013-05-10",
                //maxDate:"2013-05-20",
                //defaultDate:"2013-05-15"
            });
            $("#AXInputDate5").bindDate({
                align:"right",
                valign:"top",
                onChange:function(){
                    toast.push(Object.toJSON(this));
                }
                //minDate:"2013-05-10",
                //maxDate:"2013-05-20",
                //defaultDate:"2013-05-15"
            });


			// 방화/외화 구분
            jQuery("#AXSelect_KorabdGbn").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_korabd_gbn.php",  // <-----
                isspace: true,
                isspaceTitle: "없음",
                onChange: function(){
                    //console.log(this.value);
                }
            });


            // 관람등급 초기화
            jQuery("#AXSelect_Grade").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_grade.php",  // <-----
                isspace: true,
                isspaceTitle: "없음",
                onChange: function(){
                    //console.log(this.value);
                }
            });

            /*
            // 상영프린트1 초기화
            jQuery("#AXSelect_Grade").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_playprint1.php",  // <-----
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                    console.log(this.value);
                }
            });

            // 상영프린트2 초기화
            jQuery("#AXSelect_Grade").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_playprint2.php",  // <-----
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                    console.log(this.value);
                }
            });
            */



            grid_PlayPrint.setConfig(
            {
                targetID : "AXgrid_PlayPrint",
                height : 250,
                theme : "AXGrid",
                fitToWidth: false, // 너비에 자동 맞춤
                colGroup : [
                    {
                        key: "btns", label: "삭제", width: "60", align: "center", formatter: function ()
                        {
                          return '<button class="AXButton" onclick="fnObj.deleteItem(\'' + this.item.code + '\');"><i class="axi axi-trash2"></i></button>';
                        }
                    },
                    {key:"seq", label:"일련번호", width:"100"},
                    {key:"film_code", label:"영화코드(M000001)", width:"100"},
                    {key:"playprint1_seq", label:"", width:"10"},
                    {key:"playprint1", label:"상영프린트1", width:"100"},
                    {key:"playprint2_seq", label:"", width:"10"},
                    {key:"playprint2", label:"상영프린트2", width:"100"},
                    {key:"memo", label:"메모", width:"100"}
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

            //fnObj.upload.init();
        }, // end (pageStart: function())

        // 하나의 영화정보를 읽어 온다.
        readFilmOne: function()
        {
            jQuery.post( "<?=$path_AjaxJSON?>/wrk_film_one.php", { code: '<?=$_GET['code']?>' })  // <-----
                  .done(function( data )
                  {
                      	film_json = eval('('+data+')');

                        jQuery("input[name=code]").val(film_json.code);
                        jQuery("input[name=distributor_cd]").val(film_json.distributor_cd);
                        jQuery("input:radio[name='distributor_seq']:radio[value="+film_json.distributor_seq+"]").attr("checked",true);
                        jQuery("input[name=film_nm]").val(film_json.film_nm);
                        jQuery("input[name=first_play_dt]").val(film_json.first_play_dt);
                        jQuery("input[name=open_dt]").val(film_json.open_dt);
                        jQuery("input[name=close_dt]").val(film_json.close_dt);
                        jQuery("input[name=reopem_dt]").val(film_json.reopem_dt);
                        jQuery("input[name=reclose_dt]").val(film_json.reclose_dt);

                        jQuery("select[name=korabd]").setValueSelect(film_json.korabd);
                        jQuery("select[name=grade]").setValueSelect(film_json.grade);

                        if  (typeof film_json.playprints != "undefined") // 상영 프린터가 존재 할 경우
						{
                            grid_PlayPrint.setList(film_json.playprints);
						}

                        $('input[type=radio]').bindChecked();
                  });
        },

		/*
        upload: {
			init: function(){
				myUpload.setConfig({
					targetID:"AXUpload5",
					//targetButtonClass:"Green",
					uploadFileName:"fileData",
					buttonTxt: "파일업로드",

                    fileSelectAutoUpload:false,

					file_types:"*.*",  //audio/*|video/*|image/*|MIME_type (accept)
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
					uploadMaxFileCount:5, // 업로드될 파일갯수 제한 0 은 무제한
					uploadUrl:"fileUpload.php",  // <-----
					uploadPars:{userID:'tom', userName:'액시스'},
					deleteUrl:"fileDelete.php",  // <-----
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

					onUpload: function(){
						//trace(this);
						//trace("onUpload");
					},
					onComplete: function(){
						//trace(this);
						//trace("onComplete");
						$("#uploadCancelBtn").get(0).disabled = true; // 전송중지 버튼 제어
					},
					onStart: function(){
						//trace(this);
						//trace("onStart");
						$("#uploadCancelBtn").get(0).disabled = false; // 전송중지 버튼 제어
					},
					onDelete: function(){
						//trace(this);
						//trace("onDelete");
					},
					onError: function(errorType, extData){
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
				var url = "fileListLoad.php";
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
				trace(list);
				toast.push(Object.toJSON(list));
			},
			changeOption: function(){

				// 업로드 갯수 등 업로드 관련 옵션을 동적으로 변경 할 수 있습니다.
				myUpload.changeConfig({

					//uploadUrl:"uploadFile.asp",
					//uploadPars:{userID:'tom', userName:'액시스'},
					//deleteUrl:"deleteFile.asp",
					//deletePars:{userID:'tom', userName:'액시스'},

					uploadMaxFileCount:10
				});
			}
		},
		*/

		// 하나의 영화을 저장한다.
		save_film : function()
		{
		    var errorMsg = '' ;

		    if (errorMsg == '')
            {
		        jQuery("input:hidden[name=playprints]").val( JSON.stringify( film_json.playprints ) ) ;

		        //trace( film_json.distributor );


                // 저장할 값들을 취합한다.
                var formData = jQuery("form[name=frmFilm]").serialize();

                //trace(formData);

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

    jQuery(document).ready(fnObj.pageStart.delay(0.1)
                          <?php if ($MODE=="EDIT") { ?>,fnObj.readFilmOne.delay(1)<?php } ?>
                          );


    function test()
    {
    	jQuery("#AXSelect_Grade").setValueSelect("1");
    	$('input[type=checkbox]').bindChecked();
    }


    </script>
</head>


<body>

    <button onclick="test();">test</button>
    <?php
    if ($MODE=="APPEND")  { ?><h1>영화 등록</h1><?php     }
    if ($MODE=="EDIT")    { ?><h1>영화 편집</h1><?php     }
    ?>

    <form name="frmFilm" onsubmit="return false;">

    	<input type="hidden" name="playprints">

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
    						<select name="korabd" class="AXSelectSmall" id="AXSelect_KorabdGbn" style="width:120px;" tabindex="1"></select>
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
    					<select name="grade" class="AXSelectSmall" id="AXSelect_Grade" style="width:120px;" tabindex="1"></select>
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

    		            <div id="uploadQueueBox" class="AXUpload5QueueBox" style="height:188px;width:200px;"></div>

    					<div class="AXUpload5" id="AXUpload5" style="padding-top: 5px;;"></div>

    				</td>
    			</tr>
    			<tr>
    				<th>
    					<div class="tdRel">프린터</div>
    				</th>
    				<td class="last">
    					<div id="AXgrid_PlayPrint"></div>
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
