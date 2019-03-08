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
    //Add Transaction
    //Get post variables
    $piggyBankName = $_POST['piggyBankName'];
    $piggyBankOwner = $_POST['piggyBankOwner'];
    $isDefault='';
    if(isset($_POST['isDefault']) && $_POST['isDefault']=='on'){
        $isDefault = TRUE;
    } else {
        $isDefault = FALSE;
    }

    //in case user changing to a new default account
    
    if (isset($isDefault) && $isDefault == 1) {
        //remove default from all PiggyBanks, default will be added to the edited piggybank in the following query
        removeDefaultPiggy($db, $_SESSION['id']);
    }
    
    //insert new piggybank
    $splQuery = "INSERT INTO piggybanks (piggyUser, piggyBankName, piggyBankOwner, isDefault)
    VALUES (:piggyUser, :piggyBankName, :piggyBankOwner, :isDefault);";
    $statement = $db->prepare($splQuery);
    $statement->execute(array(':piggyUser'=>$_SESSION['id'],':piggyBankName' => $piggyBankName, ':piggyBankOwner' => $piggyBankOwner,':isDefault'=>$isDefault));
    header("Location: addEditPiggyBanks.php");
    exit();
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
        $isDefaultOld='';
        if(isset($_POST['isDefault']) && $_POST['isDefault']=='on'){
            //NOT YET IMPLEMENTED UPDATE query to remove default
            $isDefault = TRUE;
        } 
        
        if(!isset($_POST['isDefault'])) {
            $isDefault = 0;

        }
        if(isset($_POST['isDefaultOld']) && $_POST['isDefaultOld']=='on'){
            //NOT YET IMPLEMENTED UPDATE query to remove default
            $isDefaultOld = TRUE;
        }         
        if(!isset($_POST['isDefaultOld'])) {
            $isDefaultOld = 0;
        }
        
        //in case user changing to a new default account
        if ($isDefaultOld == 0 && $isDefault == 1) {
            removeDefaultPiggy($db, $_SESSION['id']);
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
        exit();
    }
?>
<?php
  //Delete Piggy
  if(isset($_POST['delete'])){
    $piggyBankId = $_POST['piggyBankId'];
    $query = "DELETE FROM piggybanks WHERE id = :piggyBankId";
    $statement = $db->prepare($query);
    $statement->execute(array(":piggyBankId"=>$piggyBankId));
    header("Location: addEditPiggyBanks.php", true, 301);
    exit();
  }
?>
<!DOCTYPE html>

<html lang="en">

<?php include 'php/reusables/head.php' ?>

<body>
    <?php include 'php/reusables/hero.php' ?>
    <!-- <div style="display: flex">
        <h3 style="color: #D9AE5C"><span style="color: #e47587">Piggy Says: </span>This website is under construction and this page still needs some formatting<br>to make it look prettier, but everything works!</h3>
    </div> -->
    <?php if (isset($result)) : ?>
        <div class="signatureBox">
            <?php include 'php/reusables/messageBox.php'; ?>
        </div>
    <?php endif; ?>
    <div>
        <div class="login__line1">
            <h3>Add/Edit
                <span> PiggyBanks</span> 
            </h3>
        </div>
        <div class="addEditPiggy__addArea signatureBox">
            <div class="addEditPiggy__addArea--title">
                    <h3>Add <span> PiggyBank</span> </h3>
            </div>
            <form action="addEditPiggyBanks.php" method="post">
                                            
                <div class="addEditPiggy__addArea--name">
                    <label for="email">PiggyBank Name: </label>
                    <input name="piggyBankName" type="text" required>                                           
                </div>
                            
                <div class="addEditPiggy__addArea--piggyBankOwner">
                    <label for="piggyBankOwner">Whose PiggyBank is it? </label>
                    <input name="piggyBankOwner" type="text">
                </div>
                <div class="addEditPiggy__addArea--default">
                    <label for="default">Set as default? </label>
                    <input name="isDefault" type="checkbox">             
                </div>
                <div class="addEditPiggy__addArea--submit">
                    <input type="submit" name="submit" class="btn" value="Submit"/>           
                </div>
            </form>
        </div>
        <?php if($piggyBanks) : ?>
            <div class="addEditPiggy__editArea signatureBox">
                <div class="addEditPiggy__editArea--title">
                        <h3>Edit <span> PiggyBank</span> </h3>
                </div>                
                <div class="addEditPiggy__piggy--lineItem addEditPiggy__piggy--lineItem-headings">
                    <div class="addEditPiggy__piggy--lineItem-piggyBankName">
                        PiggyBank Name
                    </div>
                    <div class="addEditPiggy__piggy--lineItem-piggyBankOwner">
                        Whose PiggyBank is it?
                    </div>
                    <div class="addEditPiggy__piggy--lineItem-isDefault">
                        Default?
                    </div>               
                    <div class="addEditPiggy__piggy--lineItem-editDelete">                            
                    </div>
                </div>
                <?php foreach($piggyBanks as $piggy) : ?>
                    <form method="post" name="edit" action="addEditPiggyBanks.php">
                        
                        <div class="addEditPiggy__piggy--lineItem">
                            <div class="addEditPiggy__piggy--lineItem-piggyBankName">
                                <?php echo $piggy['piggyBankName']; ?>
                            </div>
                            <div class="addEditPiggy__piggy--lineItem-piggyBankName" hidden>
                                <input class="addEditPiggy__piggy--lineItem-piggyBankName" name="piggyBankName" type="text" value="<?php echo $piggy['piggyBankName']; ?>"/>
                            </div>
                            <div class="addEditPiggy__piggy--lineItem-piggyBankOwner">
                                <?php echo $piggy['piggyBankOwner']; ?>
                            </div>
                            <div class="addEditPiggy__piggy--lineItem-piggyBankOwner" hidden>
                                <input class="addEditPiggy__piggy--lineItem-piggBankOwner" name="piggyBankOwner" type="text" value="<?php echo $piggy['piggyBankOwner']; ?>" />
                            </div>
                            <?php if($piggy['isDefault']==1) {$checked = 'checked';}else{$checked="";} ?>
                            <div class="addEditPiggy__piggy--lineItem-isDefault">
                                <label for="isDefault">Default?</label>
                                <input class="addEditPiggy__piggy--lineItem-isDefault" name="isDefaultOld" type="checkbox" <?php echo $checked ?> disabled/>
                            </div>
                            <div class="addEditPiggy__piggy--lineItem-isDefault" hidden>
                                <label for="isDefault">Default?</label>
                                <input class="addEditPiggy__piggy--lineItem-isDefault" name="isDefault" type="checkbox" <?php echo $checked ?> />
                            </div>
                            <div class="addEditPiggy__piggy--lineItem-piggyBankId" hidden>
                                <input class="piggy__lineItem-piggBankId" name="piggyBankId" type="text" value="<?php echo $piggy['id']; ?>" hidden/>
                            </div>
                            <div class="addEditPiggy__piggy--lineItem-editDelete">                            
                                <button name="edit" type="button" class="btn btn__secondary" onClick="startEditPiggyBanks(this)">Edit</button>
                                <button name="delete" type="button" class="btn btn__primaryVeryDark" onClick="startEditPiggyBanks(this)">Delete</button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <hr>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>                 
    </div>
</body>
</html>