<?php
class Lottodb
{
	private static $lottodbInstance = null;

	private $db;

	private function __construct()
	{
		try
		{
            $config = Config::getConfigInstance();
            $server = $config->getServer();
            $database = $config->getDatabase();
            $username = $config->getUsername();
            $password = $config->getPassword();

            $this->db = new PDO("mysql:host=$server; dbname=$database; charset=utf8mb4",
                $username,
                $password,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
		catch (PDOException $e)
		{
			die($e->getMessage());
		}
	}

	public static function getLottodbInstance()
	{
		if(is_null(self::$lottodbInstance))
		{
			self::$lottodbInstance = new Lottodb();
		}
		return self::$lottodbInstance;
	}

	public function closeDB()
	{
		self::$lottodbInstance = null;
	}

	private function getUser($username)
    {
        try
        {
            $sql = "SELECT * FROM gebruikers
					WHERE gebruikersnaam = :gebruikersnaam";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":gebruikersnaam", $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }

        return $user;
    }

    public function doesUserExist($username)
    {
        $user = $this->getUser($username);
        return (!empty($user) ? true : false);
    }

    public function userExists($username, $password)
    {
        $user = $this->getUser($username);
        return (!empty($user) && password_verify($password, $user->wachtwoord) ? true : false);
    }

    public function addUser($username, $password)
    {
        try
        {
            $sql = "INSERT INTO gebruikers(gebruikersnaam, wachtwoord)
						VALUES(:gebruikersnaam, :wachtwoord)";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":gebruikersnaam", $username);
            $stmt->bindParam(":wachtwoord", $password);

            $stmt->execute();
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
    }
}
