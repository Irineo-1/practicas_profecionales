<?php


class DBConecction
{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "practicas_profesionales";

    public function getConnection()
    {
        return mysqli_connect( $this->host, $this->user, $this->password, $this->database );
    }

}

?>