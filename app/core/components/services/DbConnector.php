<?php
namespace app\core\components\services;
/**
 * Class DbConnector
 * @package app\core\components\services
 */
class DbConnector

{

    protected $connection = null;
    protected $dsn = null;
    protected $user = null;
    protected $password = null;
    protected $host = null;
    protected $dbName = null;
    protected $charset = null;
    protected $opt = [];

    function __construct($user, $password, $host, $dbName, $charset = '', $opt = [])
    {
        //Инициализия свойств и параметров
        if ($charset != '') {
            $this->charset = $charset;
        } else {
            $this->charset = 'utf8';
        }
        if ($opt != []) {
            $this->opt = $opt;
        } else {
            $this->opt = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
        }
        $this->user = $user;
        $this->password = $password;
        $this->host = $host;
        $this->dbName = $dbName;
    }

    public function getConnection()
    {
        if ($this->connection == null) {
            $this->dsn = "mysql:host={$this->host};dbname={$this->dbName};charset={$this->charset}";
            $this->connection = new \PDO($this->dsn, $this->user, $this->password, $this->opt); //создание pdo объекта
        }
        return $this->connection;
    }

    public function select()
    {

    }
}