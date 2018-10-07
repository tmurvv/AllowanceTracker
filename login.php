<?php session_start(); ?>
<?php include 'php/config/config.php'; ?>
<?php include 'php/classes/Database.php'; ?>
<?php include 'php/helpers/controllers.php'; ?>
<?php include 'php/helpers/formatting.php'; ?>
<?php if(isset($_POST['submit'])){
    $inputOwner = $_POST['owner'];
    $inputPassword = $_POST['password'];
    $inputEmail = $_POST['email'];
    
    if(!$nullField) {
        $splQuery = "SELECT * FROM users WHERE email = :email";
        $statement = $db->prepare($splQuery);
        $statement->execute(array(':email'=>$inputEmail));

        if($row=$statement->fetch()){
            $id = $row['id'];
            $hashed_password = $row['password'];
            $password = $row['password'];
            $owner = $row['piggybank_owner'];
            //NOT YET IMPLEMENTED $activated = $row['activated'];
        
            if(password_verify($inputPassword, $hashed_password)){
                //prepLogin($id, $username, $remember);
                $_SESSION['id'] = $id;
                //$_SESSION['id'] = $row['id'];
                $result = $owner." logged in user id = ".$_SESSION['id'];
            }else{           
                $result = "Invalid password.<br>Please try again.";
            }
                
        }else{
            $result = "Email not found.<br>Please try again.";
        }
    }else{
        $result = "Invalid Email. Please try again.";
    }

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
            <h3>Login
                <span> Page</span> 
            </h3>
            <h4 class="login__line1--signup"><a href="signup.php">Easy Sign-up</a>
                
            </h4>
        </div>
        
        <form action="login.php" method="post" class="login__form">
                           
            <div class="login__form--owner">
                <label for="owner">Piggybank Owner: </label>
                <input name="owner" type="text">                                           
            </div>                 
            <div class="login__form--email">
                <label for="email">Email: </label>
                <input name="email" type="email" required>                                           
            </div>                 
            <div class="login__form--password">
                <label for="password">Password: </label>
                <input name="password" type="password" placeholder="password" required>                
            </div>
        
            <div class="login__form--submit">
                <input type="submit" name="submit" class="btn" value="Submit"/>           
                <h4 class="login__line1--signup"><a href="signup.php">Easy Sign-up<a></h4>
            </div>
        </form>
    </div>
</body>
</html>