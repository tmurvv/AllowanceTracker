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

//Close Account
function closeAccount($db, $closeAccountEmail) {
    echo "in the close account function<br>".$_SESSION['id'];
    $result = '';

    //find PiggyBanks ass with user
    
    $splQuery = "Select * FROM piggybanks WHERE piggyUser = :id";
    $statement = $db->prepare($splQuery);
    $statement->execute(array(':id'=>$_SESSION['id']));

    //delete tranactions assoc with piggy banks
    
    if($piggyBanks=$statement->fetchAll()){
        foreach ($piggyBanks as $piggyBank) {
            echo $piggyBank['piggyBankName'].'<br>';
            
            $deleteTransactionsId = $piggyBank['id'];
            echo "<br>".$deleteTransactionsId."<br>";
            //$deleteTransactionsId = '15';
            $statement = $db->prepare( "DELETE FROM transactions WHERE piggyBankId =:id" );
            $statement->execute(array(':id'=>$deleteTransactionsId));

            //NOT YET IMPLEMENTED--delete for production
            if (!$statement->rowCount()) {
                $result = "No transactions deleted: ".$piggyBank['piggyBankName'];               
            }

            //delete PiggyBanks
            $statement = $db->prepare("DELETE FROM piggybanks WHERE id = :id");
            $statement->execute(array(':id'=>$piggyBank['id']));

             //NOT YET IMPLEMENTED--delete for production
            if (!$statement->rowCount()) {
                $result = "No piggybank deleted: ".$piggyBank['piggyBankName'];               
            }             
        }
        //delete User
        $statement = $db->prepare("DELETE FROM users WHERE id = :id");
        $statement->execute(array(':id'=>$_SESSION['id']));

         //NOT YET IMPLEMENTED--delete for production
        if (!$statement->rowCount()) {
            $result = "Close account not successful for user ID#: ".$piggyBank['piggyUser'];               
        }       
        
        return true;
    }else{
        return false;
    }

    
   
        

}
?>