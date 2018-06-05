<?php
session_start();
require_once 'header.php';
require_once 'General.php';

$loginsystem = new Loginsystem();

if(!$loginsystem->isLoggedIn())
{
    //NOG NIET ingelogd
    header("Location: LoginIndex.php");
}
else
{
    //WEL ingelogd
    header("Location: LottoIndex.php");
}

require_once 'footer.php';