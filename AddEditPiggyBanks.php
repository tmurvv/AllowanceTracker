<?php session_start(); ?>
<?php include 'php/config/config.php'; ?>
<?php include 'php/classes/Database.php'; ?>
<?php include 'php/helpers/controllers.php'; ?>
<?php include 'php/helpers/formatting.php'; ?>
<?php if(isset($_POST['submit'])){
    //Get post variables
    $piggyBankName = $_POST['piggyBankName'];
    $piggyBankOwner = $_POST['owner'];
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
        
        <form action="AddEditPiggyBanks.php" method="post" class="addEditPiggy__form">
                                            
            <div class="addEditPiggy__form--name">
                <label for="email">PiggyBank Name: </label>
                <input name="piggyBankName" type="text" required>                                           
            </div>
                          
            <div class="addEditPiggy__form--owner">
                <label for="owner">Owner: </label>
                <input name="owner" type="text">
                <label for="owner">  Whose PiggyBank is it? </label>               
            </div>
            <div class="addEditPiggy__form--default">
                <label for="default">Set as default? </label>
                <input name="default" type="checkbox">             
            </div>
            <div class="addEditPiggy__form--submit">
                <input type="submit" name="submit" class="btn" value="Submit"/>           
            </div>
        </form>
    </div>
</body>
</html>