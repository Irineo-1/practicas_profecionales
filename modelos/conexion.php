<?php


class DBConecction
{
    private static $host = "localhost";
    private static $user = "root";
    private static $password = "";
    private static $database = "practicas_profesionales";

    public static function getConnection()
    {
        return mysqli_connect( self::$host, self::$user, self::$password, self::$database );
    }

}

?>