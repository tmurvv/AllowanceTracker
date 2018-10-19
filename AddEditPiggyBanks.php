<?php session_start(); ?>
<?php include 'php/config/config.php'; ?>
<?php include 'php/classes/Database.php'; ?>
<?php include 'php/helpers/controllers.php'; ?>
<?php include 'php/helpers/formatting.php'; ?>
<?php 
  //Run PiggyBank Query
  $query  = "SELECT * FROM piggybanks WHERE piggyUser=:userId ORDER BY piggyBankName";
  $statement = $db->prepare($query);
  $statement->execute(array(':userId'=>$_SESSION['id']));
  $piggyBanks = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<?php if(isset($_POST['submit'])){
    //Get post variables
    $piggyBankName = $_POST['piggyBankName'];
    $piggyBankOwner = $_POST['piggyBankOwner'];
    if($_POST['default']=='on'){
        //NOT YET IMPLEMENTED UPDATE query to remove default
        $default = TRUE;
    } else {
        $default = FALSE;
    }
       
    $splQuery = "INSERT INTO piggybanks (piggyUser, piggyBankName, piggyBankOwner, isDefault)
    VALUES (:piggyUser, :piggyBankName, :piggyBankOwner, :isDefault);";
    $statement = $db->prepare($splQuery);
    $statement->execute(array(':piggyUser'=>$_SESSION['id'],':piggyBankName' => $piggyBankName, ':piggyBankOwner' => $piggyBankOwner,':isDefault'=>$default));
    header("Location: addEditPiggyBanks.php");
}
?>
<?php
    //Edit transaction
    if(isset($_POST['edit'])){      
        //Assign Vars   
        $piggyUser = $_SESSION['id'];
        $piggyBankName = $_POST['piggyBankName'];
        $piggyBankOwner = $_POST['piggyBankOwner'];
        $piggyBankId = $_POST['piggyBankId'];
        $isDefault='';
        if($_POST['default']=='on'){
            //NOT YET IMPLEMENTED UPDATE query to remove default
            $isDefault = TRUE;
        } else {
            $isDefault = FALSE;
        }

        //Update Data       
        $query = "UPDATE piggybanks SET piggyBankName = :piggyBankName, 
                                            piggyBankOwner = :piggyBankOwner, 
                                            isDefault = :isDefault WHERE id=:piggyBankId";      
        $statement = $db->prepare($query);
        $statement->execute(array(':piggyBankName'=>$piggyBankName,
                                    ':piggyBankOwner'=>$piggyBankOwner,
                                    ':isDefault'=>$isDefault,
                                    ':piggyBankId'=>$piggyBankId));
        header("Location: addEditPiggyBanks.php", true, 301);
    }
?>
<?php
  //Delete transaction
  if(isset($_POST['delete'])){
    $piggyBankId = $_POST['piggyBankId'];
    $query = "DELETE FROM piggybanks WHERE id = :piggyBankId";
    $statement = $db->prepare($query);
    $statement->execute(array(":piggyBankId"=>$piggyBankId));
    header("Location: addEditPiggyBanks.php", true, 301);
  }
?>
<!DOCTYPE html>

<html lang="en">

<?php include 'php/reusables/head.php' ?>

<body>
    <?php include 'php/reusables/hero.php' ?>
    <?php if (isset($result)) : ?>
        <div class="signatureBox">
            <?php include 'php/reusables/messageBox.php'; ?>
        </div>
    <?php endif; ?>
    <div class="login signatureBox">
        <div class="login__line1">
            <h3>Add/Edit
                <span> PiggyBanks</span> 
            </h3>
        </div>
        
        <form action="addEditPiggyBanks.php" method="post" class="addEditPiggy__form">
                                            
            <div class="addEditPiggy__form--name">
                <label for="email">PiggyBank Name: </label>
                <input name="piggyBankName" type="text" required>                                           
            </div>
                          
            <div class="addEditPiggy__form--piggyBankOwner">
                <label for="piggyBankOwner">Whose PiggyBank is it? </label>
                <input name="piggyBankOwner" type="text">
                <label for="piggyBankOwner">Name will appear above, "Your name here's Piggy Bank".</label>               
            </div>
            <div class="addEditPiggy__form--default">
                <label for="default">Set as default? </label>
                <input name="default" type="checkbox">             
            </div>
            <div class="addEditPiggy__form--submit">
                <input type="submit" name="submit" class="btn" value="Submit"/>           
            </div>
        </form>

        <?php if($piggyBanks) : ?>
        <?php foreach($piggyBanks as $piggy) : ?>
            <form method="post" name="edit" action="addEditPiggyBanks.php">
                
                <div style="display:flex; justify-content:space-between;" class="piggy__lineItem">
                    <div class="piggy__lineItem--piggyBankName">
                        <?php echo $piggy['piggyBankName']; ?>
                    </div>
                    <div class="piggy__lineItem--piggyBankName" hidden>
                        <input class="piggy__lineItem-piggBankName" name="piggyBankName" type="text" value="<?php echo $piggy['piggyBankName']; ?>"/>
                    </div>
                    <div class="piggy__lineItem---piggyBankOwner">
                        <?php echo $piggy['piggyBankOwner']; ?>
                    </div>
                    <div class="piggy__lineItem--piggyBankOwner" hidden>
                        <input class="piggy__lineItem--piggBankOwner" name="piggyBankOwner" type="text" value="<?php echo $piggy['piggyBankOwner']; ?>" />
                    </div>
                    <?php if($piggy['isDefault']==1) {$checked = 'checked';}else{$checked="";} ?>
                    <div class="piggy__lineItem--isDefault">
                        <label for="isDefault">Default?</label>
                        <input class="piggy__lineItem--isDefault" name="isDefault" type="checkbox" <?php echo $checked ?> disabled/>
                    </div>
                    <div class="piggy__lineItem--piggyBankId" hidden>
                        <input class="piggy__lineItem--piggBankId" name="piggyBankId" type="text" value="<?php echo $piggy['id']; ?>" hidden/>
                    </div>
                    <div class="piggy__lineItem--editDelete">                            
                        <button name="edit" type="button" class="btn btn__secondary" onClick="startEditPiggyBanks(this)">Edit</button>
                        <button name="delete" type="button" class="btn btn__primaryVeryDark" onClick="startEditPiggyBanks(this)">Delete</button>
                    </div>
                </div>
            </form>
        <?php endforeach; ?>
        <?php endif; ?>                 
    </div>
</body>
</html>