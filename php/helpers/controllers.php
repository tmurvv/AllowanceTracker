<?php

function createQuery() {
    $query = "";
    $query = "SELECT * FROM transactions ORDER BY transactionDate DESC";
    return $query;
}

function sumQuery() {
    $query = "";
    $query = "SELECT SUM(transactionAmount) FROM transactions";
    return $query;
}

function validateEmail($data) {
    //check if the email field has a value
    if($data != null){

        //Remove all illegal characters from email
        filter_var($data, FILTER_SANITIZE_EMAIL);

        //Check if input is a valid email address
        if(filter_var($data, FILTER_VALIDATE_EMAIL) === false){
            return false;
        }
    } else {
        return false;
    }
     
    return true;
}

// NOT IN USE
// function prepLogin($id, $username, $remember){
//     $_SESSION['id'] = $id;
//     $_SESSION['username'] = $username;
    
//     //added security
//     $fingerprint = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
//     $_SESSION['last_active'] = time();
//     $_SESSION['fingerprint'] = $fingerprint;

//     //if remember me checked, set cookie
//     if($remember === "yes"){
//         rememberMe($id);
//     }
    
//     redirectTo('index');                          
// }

//Logout
function logout(){
    unset($_SESSION['piggyBankId']);
    unset($_SESSION['piggyBankOwner']);
    unset($_SESSION['piggyBankName']);
    unset($_SESSION['id']);

    // NOT YET IMPLEMENTED if(isset($_COOKIE['rememberUserCookie'])){
    //     uset($_COOKIE['rememberUserCookie']);
    //     setcookie('rememberUserCookie', null, -1, '/');
    // } 
    session_destroy();
    header('Location: index.php');
}
?>