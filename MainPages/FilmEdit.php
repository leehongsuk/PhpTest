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

    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axisj-1.1.11/ui/arongi/AXJ.min.css" />

    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/MainCss/Common.css" />

    <script type="text/javascript">

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
            jQuery.post( "<?=$path_AjaxJSON?>/bas_distributor.php")
		          .done(function( data ) {
		            	//console.log(data);
		            	var obj = eval("("+data+")");

		            	$("#AXTabs_Contact").closeTab();
		            	$("#AXTabs_Contact").addTabs(obj.options);

		            	console.log("options:"+obj.options);

						for (var i=0 ;i<obj.options.length;i++)
						{
						    //console.log("option:"+obj.options[i].optionValue);
						    //console.log("option:"+obj.options[i].optionText);

						    $('<label><input type="checkbox" name="Operation5" value="T1" id="AXCheck_Distributor'+obj.options[i].optionValue+'" /> '+obj.options[i].optionText+'</label>').appendTo("#tdDistributor");

						    /*
						    $('<div/>', {
						    	"id"   : "foo",
						    	"class": "box",
						    	"title": "박스",
						        css:{
						    		"background": "blue",
						    		"width"     : "200px",
						    		"height"    : "200px",
						        },
						        click:function(){
						            $(this).css("background","red");
						        }
						    }).appendTo("#tdDistributor");
						    */
						}
						$('input[type=checkbox]').bindChecked();
		          });


            // 장르를 가지고 온다.
            jQuery.post( "<?=$path_AjaxJSON?>/bas_genre.php")
		          .done(function( data ) {
		            	//console.log(data);
		            	var obj = eval("("+data+")");

		            	$("#AXTabs_Contact").closeTab();
		            	$("#AXTabs_Contact").addTabs(obj.options);

		            	console.log("options:"+obj.options);

						for (var i=0 ;i<obj.options.length;i++)
						{
						    //console.log("option:"+obj.options[i].optionValue);
						    //console.log("option:"+obj.options[i].optionText);

						    $('<label><input type="checkbox" name="Operation5" value="T1" id="AXCheck_Genre'+obj.options[i].optionValue+'" /> '+obj.options[i].optionText+'</label>').appendTo("#tdGenre");
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
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_korabd_gbn.php",
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                    console.log(this.value);
                }
            });


            // 관람등급 초기화
            jQuery("#AXSelect_Grade").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_grade.php",
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                    console.log(this.value);
                }
            });

            /*
            // 상영프린트1 초기화
            jQuery("#AXSelect_Grade").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_playprint1.php",
                isspace: true,
                isspaceTitle: "전체",
                onChange: function(){
                    console.log(this.value);
                }
            });

            // 상영프린트2 초기화
            jQuery("#AXSelect_Grade").bindSelect({
                ajaxUrl: "<?=$path_AjaxJSON?>/bas_playprint2.php",
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
                    {key:"playprint1", label:"상영프린트1", width:"100"},
                    {key:"playprint2", label:"상영프린트2", width:"100"}
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

            grid_PlayPrint.setList({
                ajaxUrl : "<?=$path_AjaxJSON?>/wrk_playprint.php",
                ajaxPars: {
                    "film_code": "M0000001"
                },
                onLoad  : function(){
                    //trace(this);
                }
            });


            fnObj.upload.init();
        }, // end (pageStart: function())

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
					uploadUrl:"fileUpload.php",
					uploadPars:{userID:'tom', userName:'액시스'},
					deleteUrl:"fileDelete.php",
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
					/*
					uploadUrl:"uploadFile.asp",
					uploadPars:{userID:'tom', userName:'액시스'},
					deleteUrl:"deleteFile.asp",
					deletePars:{userID:'tom', userName:'액시스'},
					*/
					uploadMaxFileCount:10
				});
			}
		}
    };

    jQuery(document).ready(fnObj.pageStart.delay(0.1));


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
	if ($_SERVER["QUERY_STRING"] == null)
	{
	?><h1>영화 등록</h1><?
	}
	else
	{
    ?><h1>영화 편집</h1><?
	}
    ?>

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
						<input type="text" name="bizno" placeholder="bizno" value="" class="AXInput W200 av-bizno" />
					</div>
				</td>
			</tr>
			<tr>
				<th>
					<div class="tdRel">배급사 영화코드</div>
				</th>
				<td class="last">
					<div class="tdRel">
						<input type="text" name="bizno" placeholder="bizno" value="" class="AXInput W200 av-bizno" />
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
						<input type="text" name="bizno" placeholder="bizno" value="" class="AXInput W200 av-bizno" />
						<select name="Loccation1" class="AXSelectSmall" id="AXSelect_KorabdGbn" style="width:120px;" tabindex="1"></select>
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
					<select name="Loccation1" class="AXSelectSmall" id="AXSelect_Grade" style="width:120px;" tabindex="1"></select>
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
								: <input type="text" name="" id="AXInputDate1" class="AXInput W100" />
							</td>
						</tr>
						<tr>
							<td class="white_board"><label>2. 개봉일</label></td>
							<td class="white_board">
								: <input type="text" name="" id="AXInputDate2" class="AXInput W100" />
							</td>
						</tr>
						<tr>
							<td class="white_board"><label>3. 종영일</label></td>
							<td class="white_board">
								: <input type="text" name="" id="AXInputDate3" class="AXInput W100" />
							</td>
						</tr>
						<tr>
							<td class="white_board"><label>4. 재개봉일</label></td>
							<td class="white_board">
								: <input type="text" name="" id="AXInputDate4" class="AXInput W100" />
							</td>
						</tr>
						<tr>
							<td class="white_board"><label>5. 재종영일</label></td>
							<td class="white_board">
								: <input type="text" name="" id="AXInputDate5" class="AXInput W100" />
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



</body>
</html>
