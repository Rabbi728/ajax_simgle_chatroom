<?php

namespace Rabbi\Db;

use PDO;
class Dbh
{
    protected $dbh;

    public function __construct()
    {
        $hostname = "localhost";
        $dbname = "chatroom";
        $username = "root";
        $password = "iamRabbi";
        try{
            $this->dbh = new PDO("mysql:host=$hostname;dbname=$dbname",$username,$password);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        catch (\PDOException $e){
            echo $e->getMessage();
        }

    }
}