<?php
require_once("../config/CONFIG.php");

    if (isset($_SESSION["user_seq"]) || isset($_SESSION["user_name"]) )
    {
        session_destroy();
    }

?>