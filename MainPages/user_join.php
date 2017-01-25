<?php require_once("../config/CONFIG.php"); ?>
<?php require_once("../config/SESSION_IN.php"); ?>
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

    <script type="text/javascript" src="<?=$path_Root?>/js/axisj-1.1.11/lib/AXToolBar.js"></script>
    <script type="text/javascript" src="<?=$path_Root?>/MainJavascript/AXToolBar.js"></script>

    <!-- 아이콘사용을 위해서..(http://axicon.axisj.com/) -->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/js/axicon/axicon.min.css"/>

    <!-- css block -->
    <!-- link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet "-->
    <link rel="stylesheet" type="text/css" href="<?=$path_Root?>/MainCss/font-awesome.min.css" />

	<script type="text/javascript" src="<?=$path_Root?>/MainJavascript/CommonLib.js"></script>
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


    var myModal = new AXModal(); // 범용팝업


    var fnObj =
    {
        pageStart: function()
        {
            // 이걸하지않으면 디자인이 나오지 않는다.
            $('input[type=checkbox]').bindChecked();
            $('input[type=radio]').bindChecked();


        }, // pageStart: function()


        duplicate_check: function()
        {
            var errMsg = "" ;
            var user_id = jQuery("input[name=user_id]").val().trim() ;

            if  (user_id.length == 0)
            {
                errMsg += "아이디가 없습니다.\n" ;
            }
            else
            {
                if  (user_id.length < 5) errMsg += "아이디는 반드시 5자 이상이어야 합니다.\n"
                else
                {
                    jQuery.ajax({
                                 type : "POST",
                                 url : "<?=$path_AjaxJSON?>/usr_id_duplicate_check.php",  // <-----
                                 cache : false,
                                 data : {user_id : user_id},
                                 success : fnObj.onSuccessTheater,
                                 error : fnObj.onErrorTheater
                    });
                }
            }

            if  (errMsg != "")
            {
                dialog.push({title:'오류', body:'<b>경고</b>\n'+errMsg, type:'Caution'}); //
            }
        },

        // 아이디 중복체트가 성공적일때..
        onSuccessTheater : function(data)
        {
            var obj = eval("("+data+")");

            if  (obj.count_id == 1) dialog.push({title:'오류', body:'<b>경고</b>\n아이디가 중복됩니다. 다른아이디를 입력하세요', type:'Caution'})
            else                    jQuery("input:hidden[name=duplicate_check]").val("true");
        },

        // 아이디 중복체트가 실패하면..
        onErrorTheater : function(request,status,error)
        {
            alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        },

        // "가입" 버튼을 누를때 ..
        join_user : function()
        {
            var errMsg = "" ;

            var user_id  = jQuery("input[name=user_id]").val().trim() ;
            var user_pw1 = jQuery("input[name=user_pw1]").val().trim() ;
            var user_pw2 = jQuery("input[name=user_pw2]").val().trim() ;
            var user_nm  = jQuery("input[name=user_nm]").val().trim() ;
            var hp       = jQuery("input[name=hp]").val().trim() ;
            var email    = jQuery("input[name=email]").val().trim() ;

            if  (user_id.length == 0)
            {
                errMsg += "아이디가 없습니다.\n" ;
            }
            else
            {
                if  (user_id.length < 5) errMsg += "아이디는 반드시 5자 이상이어야 합니다.\n"
                else
                {
                    if (jQuery("input:hidden[name=duplicate_check]").val() == "false") errMsg += "아이디 중복 체크가 안되어있습니다.\n"
                }
            }

            if  (user_pw1.length == 0)
            {
                errMsg += "비밀번호가 없습니다.\n" ;
            }
            else
            {
                if  (user_pw1.length < 5) errMsg += "비밀번호는 반드시 5자 이상이어야 합니다.\n"
                else
                {
                    if  (user_pw2.length == 0)
                    {
                        errMsg += "비밀번호확인이 없습니다.\n" ;
                    }
                    else
                    {
                    	if (user_pw1 != user_pw2) errMsg += "비밀번호와 비밀번호확인이 서로 다릅니다.\n"
                    }
                }
            }
            if  (user_nm.length == 0)
            {
                errMsg += "사용자이름이 없습니다.\n" ;
            }
            if  (hp.length == 0)
            {
                errMsg += "휴대폰번호가 없습니다.\n" ;
            }
            if  (email.length == 0)
            {
                errMsg += "이메일이 없습니다.\n" ;
            }


            if  (errMsg != "")
            {
                dialog.push({title:'오류', body:'<b>경고</b>\n'+errMsg, type:'Caution'}); //
            }
            else
            {
                jQuery("input:hidden[name=duplicate_check]").val("false");
                jQuery("input[name=user_pw1]").val('') ;
                jQuery("input[name=user_pw2]").val('') ;

                jQuery("input:hidden[name=user_pw]").val( String2Hex(user_pw1) ) ; // 비밀번호 암호화....

             	// 저장할 값들을 취합한다.
                var formData = jQuery("form[name=frmUser]").serialize();

                jQuery.ajax({
                             type : "POST",
                             url : "<?=$path_AjaxJSON?>/usr_user_save.php",  // <-----
                             cache : false,
                             data : formData,
                             success : fnObj.onSuccessFilm,
                             error : fnObj.onErrorFilm
                });
            }

        }


    }; // var fnObj =

    jQuery(document).ready(fnObj.pageStart.delay(0.1));


    </script>
</head>

<body>

    <h1>회원가입</h1>

    <form name="frmUser" onsubmit="return false;">

    	<input type="hidden" name="duplicate_check" value="false">
    	<input type="hidden" name="user_pw" value="">


        <table cellpadding="0" cellspacing="0" class="AXFormTable">
            <colgroup>
                <col width="100" />
                <col />
            </colgroup>
            <tbody>
                <tr>
                    <th>
                        <div class="tdRel">아이디</div>
                    </th>
                    <td class="last">
                        <div class="tdRel">
                            <input type="text" name="user_id" placeholder="아이디" value="" class="AXInput W70 av-bizno"/>
                            <button type="button" class="AXButtonSmall W500" id="btnSave" onclick="fnObj.duplicate_check();"><i class="axi axi-save "></i> 중복확인</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">비밀번호</div>
                    </th>
                    <td class="last">
                        <div class="tdRel">
                            <input type="password" name="user_pw1" placeholder="비밀번호" value="" class="AXInput W100 av-bizno" />
                            <input type="password" name="user_pw2" placeholder="비밀번호확인" value="" class="AXInput W100 av-bizno" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">이름</div>
                    </th>
                    <td class="last">
                        <div class="tdRel">
                            <input type="text" name="user_nm" placeholder="사용자이름" value="" class="AXInput W90 av-bizno" />
                        </div>
                    </td>
                </tr>

                <tr>
                    <th>
                        <div class="tdRel">전화번호</div>
                    </th>
                    <td class="last">
                        <div class="tdRel">
                            <input type="text" name="tel" placeholder="전화번호" value="" class="AXInput W120 av-bizno" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">휴대폰번호</div>
                    </th>
                    <td class="last">
                        <div class="tdRel">
                            <input type="text" name="hp" placeholder="휴대폰번호" value="" class="AXInput W120 av-bizno" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">팩스번호</div>
                    </th>
                    <td class="last">
                        <div class="tdRel">
                            <input type="text" name="fax" placeholder="팩스번호" value="" class="AXInput W120 av-bizno" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <div class="tdRel">이메일</div>
                    </th>
                    <td class="last">
                        <div class="tdRel">
                            <input type="text" name="email" placeholder="이메일" value="" class="AXInput W150 av-bizno" />
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>

    </form>

    <div class="modalButtonBox" align="center">
        <button type="button" class="AXButtonLarge W500" id="btnSave" onclick="fnObj.join_user();"><i class="axi axi-save "></i> 가입</button>
    </div>

</body>
</html>
