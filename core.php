<?php
session_start();
require "config/config.php";

function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = '0201AE88A3F3BE576B08D0D294933057';
    $secret_iv = '365125E4FEF96C98AF33EF8867632DB0';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}

function utilisateurConnecte(){
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: inbox.php");
        exit;
    }
}

  function getUserId($database,$username){
    $sql = "SELECT id FROM `users` WHERE `username` = '$username'";
    if($result = mysqli_query($database, $sql)){
        return $result;
    }
}

function getAllUsers($database){
    $sql = "SELECT username FROM `users`";
    if($result = mysqli_query($database, $sql)){
        return $result;
    }
}

function getUsername($database,$id){
    $sql = "SELECT username FROM `users` WHERE `id` = '$id'";
    if($result = mysqli_query($database, $sql)){
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                return $row['username'];
            }
        }
    }
}

function getMessages($bdd, $id){
    $query = "SELECT * FROM messages WHERE recipient= '$id'";
    if($result = mysqli_query($bdd, $query)){
        return $result;
    }
 }

 function getMessageId($bdd, $id){
    $query = "SELECT * FROM messages WHERE id= '$id'";
    if($result = mysqli_query($bdd, $query)){
        return $result;
    }
 } 

 function countMessages($bdd, $id){
    $query = "SELECT COUNT(ID) FROM messages WHERE recipient= '$id'";
    if($result = mysqli_query($bdd, $query)){
        return $result;
    }
 }

