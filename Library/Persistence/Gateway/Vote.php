<?php
namespace Persistence\Gateway;

class Vote
{
    public function add($choiceId, $ipAddress)
    {
        $sql = "INSERT INTO votes (choice_id, ip_address) VALUES (" . $choiceId . ", '" . $ipAddress . "')";
        $pdo = new \PDO('mysql:dbname=polls;host=127.0.0.1;charset=utf8', 'root', NULL);
        $pdo->query($sql);
    }
}
