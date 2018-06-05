<?php
class Loginsystem
{
    private $username;

    public function __construct()
    {
        $this->username = isset($_SESSION["gebruikersnaam"]) ? $_SESSION["gebruikersnaam"] : null;
    }

    public function isLoggedIn()
    {
        return isset($this->username);
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function register($username, $password)
    {
        $errortable = $this->checkData($username, $password);
        if (empty($errortable))
        {
            $lesdb = Lottodb::getLottodbInstance();
            if (!$lesdb->doesUserExist($username))
            {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $lesdb->addUser($username, $hash);
            }
            else
            {
                $errortable[] = "De gebruikersnaam bestaat al";
            }
        }
        return $errortable;
    }

    public function login($username, $password)
    {
        $errortable = $this->checkData($username, $password);
        if (empty($errortable))
        {
            $lesdb = Lottodb::getLottodbInstance();
            if ($lesdb->userExists($username, $password))
            {
                $this->username = $username;
                $_SESSION["gebruikersnaam"] = $this->username;
            }
            else
            {
                $errortable[] = "Inloggegevens niet correct";
            }
        }
        return $errortable;
    }

    public function logout()
    {
        $this->username = null;
        foreach($_SESSION as $key => $value)
        {
            unset($_SESSION[$key]);
        }
    }

    private function checkData($username, $password)
    {
        $errortable = array();

        if(empty($username)||strlen($username)<4)
        {
            $errortable[] = "De gebruikersnaam moet minstens 4 tekens bevatten";
        }
        if(empty($password)||strlen($password)<4)
        {
            $errortable[] = "Het wachtwoord moet minstens 4 tekens bevatten";
        }

        return $errortable;
    }
}