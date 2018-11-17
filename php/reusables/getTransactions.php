<?php
    //Initialize variables
    $id = '';
    $result = '';
    $sum = '';


    //NOT YET IMPLEMENTED. $_session id is set for demo for time being 
    //until a first-time user experience can be created
    //$_SESSION['id'] = 45;

    if(isset($_SESSION['id']) && !$_SESSION['id'] == '') {
        $id = $_SESSION['id'];
    }else{
        $id = $defaultDemoAccountId; //from config.php file. The demonstration account for new users.
    }
    //Determine if user has selected a Piggy else use default
    try{
        if (isset($_POST['changePiggyBank'])) {
            $query = "SELECT * FROM piggybanks WHERE piggyUser = :id AND piggyBankName = :piggyBankName";
            $statement = $db->prepare($query);
            $statement->execute(array(':id'=>$id, ':piggyBankName'=>$_POST['switchPiggyName']));
            
        }else{
            //NOT YET IMPLEMENTED if no default piggy found, check if any piggies.
            $query = "SELECT * FROM piggybanks WHERE piggyUser = :id AND isDefault = :isDefault";
            $statement = $db->prepare($query);
            $statement->execute(array(':id'=>$id, ':isDefault'=>TRUE));
        }           

        if ($statement->rowCount()>0) {
            $row=$statement->fetch();                                      
            $_SESSION['piggyBankId'] = $row['id'];
            $_SESSION['piggyBankName'] = $row['piggyBankName'];
            $_SESSION['piggyBankOwner'] = $row['piggyBankOwner'];                       
                            
        }else{
            $result="Piggy Bank not found";
        }
    }catch(PDOException $ex) {
        $result = "An error occurred.<br>Error message number: ".$ex->getCode();
    }
    
    $piggyBankId = $_SESSION['piggyBankId'];     
    $piggyBankName = $_SESSION['piggyBankName'];   
    $piggyBankOwner = $_SESSION['piggyBankOwner'];      
    
    //Run Transaction Query
    $query  = "SELECT * FROM transactions WHERE piggyBankId=:piggyBankId ORDER BY transactionDate DESC";
    $statement = $db->prepare($query);
    $statement->execute(array(':piggyBankId'=>$piggyBankId));
    $transactions = $statement->fetchAll(PDO::FETCH_ASSOC); 

    //create and run sum query for balance
    $query="SELECT SUM(transactionAmount) AS valueSum FROM transactions WHERE piggyBankId=:piggyBankId";
    $statement=$db->prepare($query);
    $statement->execute(array(':piggyBankId'=>$piggyBankId));
    $row=$statement->fetch(PDO::FETCH_ASSOC);
    $sum=$row['valueSum'];

    //Create and run Type Transaction Query
    $statement = $db->query("SELECT * FROM transactionType ORDER BY selectBoxOrder");
    $transactionTypes = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    // else{
        
    //     $piggyBankId = '';     
    //     $piggyBankName = '';   
    //     $piggyBankOwner = '';
    //     $transactions = '';
    //     $transactionTypes = '';  
    
?>