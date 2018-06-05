<?php
session_start();
require_once 'header.php';
require_once 'General.php';

$loginsystem = new Loginsystem();

if($loginsystem->isLoggedIn())
{
    //WEL ingelogd
    $action = isset($_GET["actie"]) ? $_GET["actie"] : "";

    if ($action === "uitloggen")
    {
        $loginsystem->logout();
        header('Location:Index.php');
    }

    Execute::showTitle("Lotto met inlogsysteem");
    Execute::showLogout($loginsystem->getUsername());

    Execute::showTitle("Lotto");
    Execute::showLotteryForm();

    $lottery = new Lottery();

    switch ($action)
    {
        case "ingeven":
            if (isset($_GET["jaknop"]))
            {
                //var_dump($_GET["lottogetal"]);
                //$_GET["lottogetal"] is een tabel: zie toonFormulierLotto()
                $weektable = $_GET["lottogetal"];

                $errortable = $lottery->addWeekTable($weektable);

                if (!empty($errortable))
                {
                    Execute::showErrors($errortable);
                }
            }
            break;
    }

    Execute::showSubtitle("De ingegeven lottogetallen");
    Execute::showLotteryTable($lottery->getLotteryTable());

    $occurences = $lottery->countOccurences();

    Execute::showSubtitle("Het aantal voorkomens van de lottogetallen");
    Execute::showOccurences($occurences);

    $mostOccuring = $lottery->mostOccuring($occurences);

    Execute::showSubtitle("De lottogetallen met het meest aantal voorkomens");
    Execute::showOccurences($mostOccuring);
}
else
{
    //NIET ingelogd
    header("Location: Index.php");
}

require_once 'footer.php';
