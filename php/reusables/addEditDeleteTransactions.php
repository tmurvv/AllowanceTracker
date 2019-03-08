<?php
    //Add new transaction
    if(isset($_SESSION['id'])) {       
        if(isset($_POST['submit'])){
            //Assign Vars
            $transactionNote = $_POST['note'];  
            $transactionDate = $_POST['date'];     
            $transactionTime = $_POST['time'];
            $transactionDateTime = $transactionDate." ".$transactionTime;
            $transactionAmount = $_POST['amount'];
            if (isset($_POST['type'])) {
                $transactionType = $_POST['type'];
            }else {
                $transactionType = '';
            }
                       
            if ($transactionType == '' || $transactionType == null) {
                $transactionType = 'Select your option';
            }

            //Create and run transaction
            $query = "INSERT INTO transactions
                        (transactionType, transactionAmount, transactionDate, transactionNote, piggyBankId)
                        VALUES(?,?,?,?,?)";
            $statement = $db->prepare($query);             
            $statement->execute([$transactionType, $transactionAmount, $transactionDateTime, $transactionNote, $_SESSION['piggyBankId']]);         
            
            header("Location: index.php", true, 301);
            exit();       
        }
    }else{
        $result = "User not found, please login again.";
    }

    //Edit transaction
    if(isset($_POST['edit'])){
        //Assign Vars   
        $transactionNote = $_POST['transactionNote'];
        $transactionAmount = $_POST['transactionAmount'];
        $transactionDate = $_POST['transactionDate'];
        $transactionTime = $_POST['transactionTime'];
        $transactionDateTime = $transactionDate." ".$transactionTime;
        $transactionType = $_POST['transactionType'];
        $transactionId = $_POST['transactionId'];
          
        //Update Data       
        $query = "UPDATE transactions SET transactionNote = :transactionNote, 
                                            transactionAmount = :transactionAmount, 
                                            transactionDate = :transactionDateTime, 
                                            transactionType = :transactionType WHERE id=:id";      
        $statement = $db->prepare($query);
        $statement->execute(array(':transactionNote'=>$transactionNote,
                                    ':transactionAmount'=>$transactionAmount,
                                    ':transactionDateTime'=>$transactionDateTime,
                                    ':transactionType'=>$transactionType,
                                    ':id'=>$transactionId));
        header("Location: index.php", true, 301);
        exit();
    }

    //Delete transaction
    if(isset($_POST['delete'])){
        $id = $_GET['id'];
        $query = "DELETE FROM transactions WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->execute(array(":id"=>$id));
        header("Location: index.php", true, 301);
        exit();
    }
?>