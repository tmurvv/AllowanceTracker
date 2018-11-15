<?php
    //get a list of all user piggybanks
    if (isset($_SESSION['id'])) {
        try {
            $query = "SELECT * FROM piggybanks WHERE piggyUser = :id";
            $statement = $db->prepare($query);
            $statement->execute(array(":id"=>$_SESSION['id']));
            $piggies = $statement->fetchAll();
        }catch (PDOException $ex) {
            $result = "Error finding your PiggyBanks.";
        }
    }else{
        $result = "User not found. Please log in again.";
    }
?>