<?php

namespace splitbrain\TheBankster;

class DataBase
{

    protected $pdo;

    protected $dbfile = __DIR__ . '/../data.sqlite3';

    /**
     * DataBase constructor.
     */
    public function __construct()
    {
        $this->pdo = new \PDO('sqlite:' . $this->dbfile);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    }

    /**
     * @return \PDO
     */
    public function getPDO()
    {
        return $this->pdo;
    }

    /**
     * @param string $sql
     * @param array $parameters
     * @return array
     */
    public function queryAll($sql, $parameters = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($parameters);
        return $stmt->fetchAll();
    }

    /**
     * Query for exactly one single value
     *
     * @param string $sql
     * @param array $parameters
     * @return mixed
     */
    public function querySingleValue($sql, $parameters = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($parameters);
        $row = $stmt->fetch();

        if (is_array($row) && count($row)) return array_values($row)[0];
        return null;
    }
}