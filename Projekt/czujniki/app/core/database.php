<?php
class Database
{
    protected $connection;
    protected $show_errors = TRUE;

    public function __construct($dbhost, $dbuser, $dbpass, $dbname, $charset = 'utf8')
    {
        $this->connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if ($this->connection->connect_error) {
            $this->error('Nie udało się połączyć z MySQL - ' . $this->connection->connect_error);
        }
        $this->connection->set_charset($charset);
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function runQuery($query)
    {
        return $this->connection->query($query);
    }

    public function close()
    {
        return $this->connection->close();
    }

    public function error($error)
    {
        if ($this->show_errors) {
            exit($error);
        }
    }
}
