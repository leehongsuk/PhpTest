<?php
    // 이미 로그인 세션이 확보되어 있다면 MainPages쪽으로 간다.....
    if  ($_SESSION['user_seq'])
    {
        if  ($PhpSelf == $path_Root."/index.php")                     Header("Location:MainPages/"); // 초기 로그인 페이지

        if  ($PhpSelf == $path_Root."/MainPages/UserJoin.php")       Header("Location:".$path_Root); // '회원가입' 페이지
        if  ($PhpSelf == $path_Root."/MainPages/UserFindIdPw.php")  Header("Location:".$path_Root); // '아이디/비밀번호 찾기' 페이지
    }
?>