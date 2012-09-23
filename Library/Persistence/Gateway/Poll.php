<?php
namespace Persistence\Gateway;

class Poll
{
    public function all()
    {
        $sql = 'SELECT DISTINCT polls.id, polls.question, polls.icon '
             . 'FROM polls '
             . 'INNER JOIN choices ON polls.id = choices.poll_id';
        $pdo = new \PDO('mysql:dbname=polls;host=127.0.0.1', 'root', NULL);
        $statement = $pdo->query($sql);
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function load($id)
    {
        $sql = 'SELECT DISTINCT polls.id, polls.question, polls.icon '
             . 'FROM polls '
             . 'INNER JOIN choices ON polls.id = choices.poll_id '
             . 'WHERE polls.id = ' . (int) $id;
        $pdo = new \PDO('mysql:dbname=polls;host=127.0.0.1', 'root', NULL);
        $statement = $pdo->query($sql);
        $poll = $statement->fetchObject('\Model\Poll');

        if ($poll) {
            $sql = 'SELECT choices.id, choices.choice, COUNT(votes.choice_id) AS votes '
                 . 'FROM choices CROSS JOIN polls '
                 . 'LEFT JOIN votes ON choices.id = votes.choice_id '
                 . 'WHERE polls.id = ' . (int) $id
                 . ' GROUP BY choices.id, choices.choice, polls.id';
            $statement = $pdo->query($sql);
            $poll->setChoices($statement->fetchAll(\PDO::FETCH_OBJ));

            return $poll;
        }
    }
}
