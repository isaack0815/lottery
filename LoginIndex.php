<?php
session_start();
require_once 'header.php';
require_once 'General.php';

Execute::showTitle("Lotto met inlogsysteem");
Execute::showRegisterLogin();

$loginsystem = new Loginsystem();

$action = isset($_GET["actie"])? $_GET["actie"] : "";

switch ($action)
{
    case "registreren":
        if (empty($_POST))
        {
            Execute::showRegister();
        }
        elseif (isset($_POST["registrerenknop"]))
        {
            $errortable = $loginsystem->register($_POST["gebruikersnaam"], $_POST["wachtwoord"]);
            if(empty($errortable))
            {
                Execute::showSubtitle("Succesvol geregistreerd");
            }
            else
            {
                Execute::showErrors($errortable);
            }
        }
        break;
    case "inloggen":
        if (empty($_POST))
        {
            Execute::showLogin();
        }
        elseif (isset($_POST["inloggenknop"]))
        {
            $errortable = $loginsystem->login($_POST["gebruikersnaam"], $_POST["wachtwoord"]);
            if(empty($errortable))
            {
                header("Location: Index.php");
            }
            else
            {
                Execute::showErrors($errortable);
            }
        }
        break;
}