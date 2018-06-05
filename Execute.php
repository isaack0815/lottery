<?php
class Execute
{
    public static function showTitle($title)
    {
        echo "<h1>$title</h1>";
    }

    public static function showSubtitle($title)
    {
        echo "<h3>$title</h3>";
    }

    public static function showLotteryForm()
    {
        self::showSubtitle("Lottogetallen ingeven");
        //Er wordt hier gewerkt met GET om didactische reden
        echo "<form action=LottoIndex.php method=get>";
        echo "<input type=hidden name=actie value=ingeven>";
        for($i=1; $i<=7; $i++)
        {
            echo "<div>";
            echo "<label for=lottogetal$i>Lottogetal $i </label>";
            echo "<select name=lottogetal[$i] id=lottogetal$i>";
            //merk op: name=lottogetal[$i]
            //dit betekent dat de lottogetallen arrayelementen zijn!
                for($j=1; $j<=42; $j++)
                {
                    echo "<option value=$j>".$j."</option>";
                }
            echo "</select>";
            echo "</div>";
        }
        echo "<div>";
        echo "<input type=submit name=jaknop value=Ingeven>";
        echo "</div>";
        echo "</form>";
    }

    public static function showLotteryTable($table)
    {
        if(!empty($table))
        {
            echo "<table>";
            echo "<colgroup span=\"7\" class=\"kolbreedte\" ></colgroup>";
            foreach ($table as $week)
            {
                echo "<tr>";
                foreach ($week as $lotterynumber)
                {
                    echo "<td>" . Helper::cleanData($lotterynumber) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }
        else
        {
            echo "<div>----</div>";
        }
    }

    public static function showOccurences($occurences)
    {
        //Toon tabel met lottogetal en aantal voorkomens
        echo "<table>";
        echo "<colgroup span=\"2\" class=\"kolbreedte\" />";
        echo "<tr>";
        echo "<td>Lottogetal</td>";
        echo "<td>Voorkomens</td>";
        echo "</tr>";
        foreach ($occurences as $number => $amount)
        {
            echo "<tr>";
            echo "<td>$number</td>";
            echo "<td>$amount</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    public static function showRegisterLogin()
    {
        ?>
        <ul>
            <li><a href="LoginIndex.php?actie=registreren">Registreren</a></li>
            <li><a href="LoginIndex.php?actie=inloggen">Inloggen (voor gebruikers die reeds geregistreerd zijn)</a></li>
        </ul>
        <hr />
        <?php
    }

    public static function showLogout($username)
    {
        ?>
        <ul>
            <li><a href="LottoIndex.php?actie=uitloggen">Uitloggen (gebruikersnaam <?php echo Helper::cleanData($username) ?>)</a></li>
        </ul>
        <hr />
        <?php
    }

    public static function showRegister()
    {
        ?>
        <form action="LoginIndex.php?actie=registreren" method=post>
            <h1>Registreren</h1>
            <div>
                <label for=gebruikersnaam>Gebruikersnaam</label>
                <input type=text name=gebruikersnaam id=gebruikersnaam>
            </div>
            <div>
                <label for=wachtwoord>Wachtwoord</label>
                <input type=password name=wachtwoord id=wachtwoord>
            </div>
            <div>
                <input type=submit name=registrerenknop value=Registreren>
                <input type=submit name=annulerenknop value=Annuleren>
            </div>
        </form>
        <hr />
        <?php
    }

    public static function showLogin()
    {
        ?>
        <form action="LoginIndex.php?actie=inloggen" method=post>
            <h1>Inloggen</h1>
            <div>
                <label for=gebruikersnaam>Gebruikersnaam</label>
                <input type=text name=gebruikersnaam id=gebruikersnaam>
            </div>
            <div>
                <label for=wachtwoord>Wachtwoord</label>
                <input type=password name=wachtwoord id=wachtwoord>
            </div>
            <div>
                <input type=submit name=inloggenknop value=Inloggen>
                <input type=submit name=annulerenknop value=Annuleren>
            </div>
        </form>
        <hr />
        <?php
    }

    public static function showErrors($errortable)
    {
        $resstring = "Error: ";
        foreach($errortable as $error)
        {
            $resstring .= $error."; ";
        }
        $resstring .= "<hr />";
        echo $resstring;
    }
}
