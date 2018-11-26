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

//Removes the default piggy for the session user in case a new default has been selected or added
function removeDefaultPiggy($db, $userId) {
   
    //remove default from all PiggyBanks, default=true will be added to the edited piggybank in the following query
    $query = "UPDATE piggybanks SET isDefault = :isDefault WHERE piggyUser = :piggyUser AND isDefault=1";      
    $statement = $db->prepare($query);
    $statement->execute(array(':isDefault'=>0, ':piggyUser'=>$userId));
    
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
    // NOT YET IMPLEMENTED if(isset($_COOKIE['rememberUserCookie'])){
    //     uset($_COOKIE['rememberUserCookie']);
    //     setcookie('rememberUserCookie', null, -1, '/');
    // }
    if (isset($_SESSION)) {
        unset($_SESSION['piggyBankId']);
        unset($_SESSION['piggyBankOwner']);
        unset($_SESSION['piggyBankName']);
        unset($_SESSION['id']);   
        session_destroy();
    }
    header('Location: index.php');
}

//Close Account
function closeAccount($db, $closeAccountEmail) {
    $result = '';

    //find PiggyBanks associated with user    
    try {
        $splQuery = "Select * FROM piggybanks WHERE piggyUser = :id";
        $statement = $db->prepare($splQuery);
        $statement->execute(array(':id'=>$_SESSION['id']));
    }catch (PDOexception $ex) {
        $result = "An error occurred. Try logging out and logging in again.";
    }
    
    //delete transactions, piggybanks and user    
    if($piggyBanks=$statement->fetchAll()){
        foreach ($piggyBanks as $piggyBank) {
           
            //delete tranactions assoc with piggy bank
            try {
                $statement = $db->prepare( "DELETE FROM transactions WHERE piggyBankId =:id" );
                $statement->execute(array(':id'=>$piggyBank['id']));

            }catch (PDOexception $ex) {
                $result = "An error occurred. Try logging out and logging in again.";
            }

            //delete PiggyBank
            try {
                $statement = $db->prepare("DELETE FROM piggybanks WHERE id = :id");
                $statement->execute(array(':id'=>$piggyBank['id']));

                if (!$statement->rowCount()) {
                    $result = "No piggybank deleted: ".$piggyBank['piggyBankName'];               
                } 
            }catch (PDOexception $ex) {
                $result = "An error occurred. Try logging out and logging in again.";
            }        
        }

        //delete User
        try{
            $statement = $db->prepare("DELETE FROM users WHERE id = :id");
            $statement->execute(array(':id'=>$_SESSION['id']));

            if (!$statement->rowCount()) {
               $result = "Close account not successful for user Id#: ".$piggyBank['piggyUser']; 

               //clean up environment
               logout();             
            }
        }catch (PDOexception $ex) {
            $result = "An error occurred. Try logging out and logging in again.";
        }            
        return $result;
    }else{
        return "User or PiggyBanks not found. Please login again.";
    }
}
?>