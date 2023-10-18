<?php

class password
{
    public static function hashPassword( $password )
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verificarPassword( $password, $hashPassword )
    {
        return password_verify($password, $hashPassword);
    }
}

?>