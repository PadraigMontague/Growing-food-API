<?php
Class DatabaseController{
    protected $configSettings;
    public $connection;
    private $username;
    private $password;

    public function __construct(array $configSettings){
        $this->configSettings = $configSettings;
        $this->createConnection();
    }

    public function __destruct() {
        $this->destroyConnection();
    }

    private function createConnection(){
        if($this->connection === null){
            $connectionDetails = 
            "" . $this->configSettings['driver'] .
            ":host=" . $this->configSettings['host'] . 
            ";dbname=" . $this->configSettings['dbname'];

            $this->username = $this->configSettings['username'];
            $this->password = $this->configSettings['password'];
            try {
                $this->connection = new PDO($connectionDetails, $this->username, $this->password);
            } catch (PDOException $e) {
                echo __LINE__ . $e->getMessage();
            }
        }
    }

    public function destroyConnection(){
        $this->connection = null;
        $this->configSettings = null;
    }

    public function execute($sqlQuery){
        try{
            $rowsEffected = $this->connection->exec($sqlQuery) or print_r($this->connection->errorInfo());
        } catch(PDOException $e){
            echo __LINE__ . $e->getMessage();
        }

        return $rowsEffected;
    }

    public function queryData($sqlQuery){
        $sqlStatement = $this->connection->prepare($sqlQuery);
        $sqlStatement->execute();
        $data = $sqlStatement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function queryClassData($sqlQuery, $className){
        $sqlStatement = $this->connection->query($sqlQuery);
        $sqlStatement->setFetchMode(PDO::FETCH_CLASS, $className);
        return $sqlStatement;
    }
}
?>