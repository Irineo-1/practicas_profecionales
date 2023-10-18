<?php

class password
{
    public function hashPassword( $password )
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verificarPassword( $password, $hashPassword )
    {
        return password_verify($password, $hashPassword);
    }
}

?>