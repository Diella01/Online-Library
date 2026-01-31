<?php
class User {

    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function register($name, $email, $pass){

        $hash = password_hash($pass, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name,email,password,role)
                VALUES (?,?,?, 'user')";

        $params = [$name,$email,$hash];

        return sqlsrv_query($this->conn, $sql, $params);
    }

    public function login($email,$pass){

        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = sqlsrv_query($this->conn,$sql,[$email]);

        $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        if($user && password_verify($pass,$user['password'])){
            return $user;
        }

        return false;
    }
}
?>