<?php session_start(); ?>
<?php include 'php/config/config.php'; ?>
<?php include 'php/classes/Database.php'; ?>
<?php include 'php/helpers/controllers.php'; ?>
<?php include 'php/helpers/formatting.php'; ?>
<?php
    $id = $_SESSION['id'];
    $splQuery = "SELECT * FROM users WHERE id = :id";
    $statement = $db->prepare($splQuery);
    $statement->execute(array(':id'=>$id));

    if($row=$statement->fetch()){  
        $email = $row['email'];
    }else{
        $result = 'User not found, please login again.';
    }

?>

<!DOCTYPE html>
<html lang="en">

<?php include 'php/reusables/head.php' ?>

<body>
    <?php include 'php/reusables/hero.php' ?>
    <div class="user">
        <div class="user__line1">
            <h3>Profile 
                <span> Page</span>
            </h3>
        </div>        
        <?php if (isset($result)) : ?>
            <div class="signatureBox">
                <?php include 'php/reusables/messageBox.php'; ?>
            </div>
        <?php endif; ?>
        <div class="signatureBox">
            <form action="index.php" method="post"class="user__form">
                <div class="user_form user__form--email">
                    <label for="email">Email: </label>
                    <?php echo $row['email']; ?>
                    <div class="transactions__lineItem--line1-editDelete">                             
                            <button name="edit" type="button" class="btn btn__secondary" onClick="startEditProfile(this)">Edit</button>
                            <button name="delete" type="button" class="btn btn__primaryVeryDark" onClick="startEditProfile(this)">Delete</button>
                        </div>
                    <div hidden>
                        <input name="email" type="email">
                    </div> 
                    <br>                                         
                </div>                 
                <div class="user_form user__form--password">
                    <a href="changePassword.php">Change Password</a>
                    <div hidden><input type="password" placeholder="enter current password" name="currentPassword"></div>                
                </div>
                <div class="user_form user__form--addEditPiggyBanks">
                    <a href="addEditPiggyBanks.php">Add, Edit, or Delete Piggy Banks</a>                
                </div>
                <br>
            </form>
        </div>
    </div>
</body>
</html>