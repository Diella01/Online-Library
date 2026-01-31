<?php
session_start();
require "config/Database.php";
require "classes/User.php";

$db = new Database();
$conn = $db->connect();
$userObj = new User($conn);

if($_POST){

    $user = $userObj->login($_POST['email'], $_POST['password']);

    if($user){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];

        if($user['role'] == 'admin'){
            header("Location: admin/dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        echo "Login failed";
    }
}
?>