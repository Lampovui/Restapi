<?php
class User{
    // Connection
    private $conn;
    // Table
    private $db_table = "user";
    private $db_table1 = "city";
    // Columns
    public $id;
    public $username;
    public $name;
    public $city_id;
//    public $designation;
    // Db connection
    public function __construct($db){
        $this->conn = $db;
    }
    // GET ALL
    public function getUser(){

        $sqlQuery = "SELECT $this->db_table.id, username, $this->db_table.name as nameUser, $this->db_table1.name as nameCity FROM " . $this->db_table." 
        LEFT JOIN ". $this->db_table1." ON $this->db_table.city_id=$this->db_table1.id ";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    // CREATE
    public function createUser(){
        $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                     SET
                        name = :name, 
                        username = :username,
                        city_id = :city_id";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->city_id=htmlspecialchars(strip_tags($this->city_id));


        // bind data
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":city_id", $this->city_id);


        if($stmt->execute()){
            return true;
        }
        return false;
    }
    // READ single
    public function getSingleUser(){
        $sqlQuery = "SELECT
                        id, 
                        name, 
                        username,
                        city_id
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $dataRow['name'];
        $this->username = $dataRow['username'];

    }
    // UPDATE
    public function updateUser(){
        $sqlQuery = "UPDATE ". $this->db_table ."
                    SET
                        name = :name, 
                        username = :username
                        
                    WHERE 
                        id = :id ";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->id=htmlspecialchars(strip_tags($this->id));

        // bind data
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
    // DELETE
    function deleteUser(){
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
