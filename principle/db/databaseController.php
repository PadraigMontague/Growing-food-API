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

    public function execQuery($statement){
        try{
            $query = $this->connection->prepare($statement);
            $query->execute();
            $changesMade = $query->rowCount();

            if($changesMade > 0){
                 $result = 'success';
            } else{
                 $result = 'unsuccessful';
            }
        } catch(PDOException $e){
            echo __LINE__ . $e->getMessage();
        }
        return $result;
    }

    public function queryData($sqlQuery){
        $sqlStatement = $this->connection->prepare($sqlQuery);
        $sqlStatement->execute();
        $data = $sqlStatement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
?>