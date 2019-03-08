<?php session_start(); ?>
<?php include 'php/config/config.php'; ?>
<?php include 'php/classes/Database.php'; ?>
<?php include 'php/helpers/controllers.php'; ?>
<?php include 'php/helpers/formatting.php'; ?>
<?php 
    if (isset($_POST['emailSubmit'])) {
        $email = $_POST['email'];
        $id = $_SESSION['id'];
        $splQuery = "UPDATE users SET email = :email WHERE id = :id";
        $statement = $db->prepare($splQuery);
        $statement->execute(array(':id'=>$id, 'email'=>$email));
    }
?>
<?php 
    if (isset($_POST['passwordSubmit'])) {
        $id = $_SESSION['id'];
        $userInputPassword = $_POST['userInputPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];
        
        if ($newPassword === $confirmPassword) {
            //Get old hashed password from db
            $splQuery = "SELECT password FROM users WHERE id = :id";
            $statement = $db->prepare($splQuery);
            $statement->execute(array(':id'=>$id));

            if($row=$statement->fetch()){  
                $passwordFromDb = $row['password'];
                
                if (password_verify($userInputPassword, $passwordFromDb)) {
                    $result="password is good";
                    //hash the new password
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    //update db
                    $sqlUpdate = "UPDATE users SET password=:password WHERE id=:id";
                                $statement = $db->prepare($sqlUpdate);
                                $statement->execute(array(':password'=>$hashedPassword, ':id'=>$id));

                                if($statement->rowCount()===1){
                                    $result = "Password reset Successful.";
                                }else{
                                    $result = 'Password not updated.';
                                }
                } else {
                    $result="Current password is not correct.";
                }
            }

            

            // $splQuery = "UPDATE users SET email = :email WHERE id = :id";
            // $statement = $db->prepare($splQuery);
            // $statement->execute(array(':id'=>$id, 'email'=>$email));
        } else {
            $result = "New password and confirm password do not match.";
        }
    }
?>
<?php 
    if (isset($_POST['closeAccountSubmit'])) {
        $result = closeAccount($db, $_SESSION['id']);
        header('Location: index.php');
        exit();
        // $email = $_POST['email'];
        // $id = $_SESSION['id'];
        // $splQuery = "UPDATE users SET email = :email WHERE id = :id";
        // $statement = $db->prepare($splQuery);
        // $statement->execute(array(':id'=>$id, 'email'=>$email));
    }
?>
<?php
    $id = $_SESSION['id'];
    $splQuery = "SELECT * FROM users WHERE id = :id";
    $statement = $db->prepare($splQuery);
    $statement->execute(array(':id'=>$id));

    if($row=$statement->fetch()){  
        $email = $row['email'];
    }else{
        $result = 'User not found, please login again or signup for a new account.';
    }
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'php/reusables/head.php' ?>

<body>
    <?php include 'php/reusables/hero.php' ?>
        <div class="profile__line1">
            <h2>Profile<span>Page</span></h2>
        </div>        
        <?php if (isset($result)) : ?>
            <div class="signatureBox">
                <?php include 'php/reusables/messageBox.php'; ?>
            </div>
        <?php endif; ?>
        
        <div class="profile__container">
            <div class="profile__form profile__form--email" id="js--profileOriginalEmail">
                <?php 
                    if (isset($email)) {
                        echo $email;
                    } else {
                        echo "no email found";
                    }
                ?>
            </div>

            <div class="profile__container--bottom">
                <form action="profile.php" method="post">
                    <div id="js--emailInput" hidden>
                        <div style="display: flex">
                            <h3 name="NOT YET IMPLEMENTED" style="color: #D9AE5C"><span style="color: #e47587">Piggy Says: </span>This website is under construction and eventually a verification email will be sent when the account email is changed.</h3>
                        </div>
                        <input name="email" type="email" placeholder="enter new email">
                    </div>
                    <div class="profile_form profile__form--changeProfileButton">                             
                        <button name="emailSubmit" type="button" class="btn btn__secondary profile__form--changeProfileButton" onClick="startChangeEmail(this)" id="js--profileChangeSaveEmail">Change Email</button>
                        <button name="emailCancel" type="button" class="btn btn__primaryVeryDark profile__form--changeProfileButton" onClick="startChangeEmail(this)" id="js--profileCancelEmail" hidden>Cancel</button>                 
                    </div>
                </form> 
                <br>                                         
                                
                <div class="profile__form--changePassword">
                    <form action="profile.php" method="post">
                        <div id="js--profileChangePassword" hidden>
                            <input type="password" placeholder="enter current password" name="userInputPassword">
                            <input type="password" placeholder="enter new password" name="newPassword" id="js--profileNewPassword">
                            <input type="password" placeholder="confirm new password" name="confirmPassword">
                        </div>
                        <div class="profile__form profile__form--changePasswordButton">
                            <button name="passwordSubmit" type="button" class="btn btn__secondary profile__form--changeProfileButton" onClick="startChangePassword(this)" id='js--profileChangePasswordButton'>Change Password</button>
                            <button name="passwordCancel" type="button" class="btn btn__primaryVeryDark profile__form--changeProfileButton" onClick="startChangePassword(this)" id="js--profileCancelPasswordButton" hidden>Cancel</button>                 
                        </div>
                        
                        <div class="profile__form profile__form--password" id="js--profileOriginalPassword" hidden>
                            <?php 
                                if ($row['password']) {
                                    echo $row['password'];
                                }
                            ?>
                        </div>
                    </form>
                </div>
        
                <br>
                <form action="profile.php" method="post">
                    
                    <div class="profile_form profile__form--changeProfileButton">                             
                        <button name="closeAccountSubmit" type="button" class="btn btn__secondary profile__form--changeProfileButton" onClick="startCloseAccount(this, '<?php echo $row['email']; ?>')" id="js--profileCloseAccount">Close Account</button>
                    </div>
                </form>
                <br>
                <div class="profile_form">
                    <a class="btn btn__secondary profile__form--addEditPiggyBanks" href="addEditPiggyBanks.php">Add, Edit, or Delete Piggy Banks</a>                
                </div>
                <br>
            </div>
        </div>
       
    </div>
</body>
</html>