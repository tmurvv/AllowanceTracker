<?php session_start(); ?>
<?php include 'php/config/config.php'; ?>
<?php include 'php/classes/Database.php'; ?>
<?php include 'php/helpers/controllers.php'; ?>
<?php include 'php/helpers/formatting.php'; ?>
<?php if(isset($_POST['submit'])){    
    $inputPassword = $_POST['password'];
    $inputEmail = $_POST['email'];
       
    try {
        $splQuery = "SELECT * FROM users WHERE email = :email";
        $statement = $db->prepare($splQuery);
        $statement->execute(array(':email'=>$inputEmail));

        if($row=$statement->fetch()){
            $id = $row['id'];
            $hashed_password = $row['password'];
            $password = $row['password'];
            $activated = $row['active'];
  
            if(password_verify($inputPassword, $hashed_password)){
                
                if ($activated) {
                    //clear old session
                    if (isset($_SESSION['id'])) {
                        unset($_SESSION['piggyBankId']);
                        unset($_SESSION['piggyBankOwner']);
                        unset($_SESSION['piggyBankName']);
                        unset($_SESSION['id']);

                        // NOT YET IMPLEMENTED if(isset($_COOKIE['rememberUserCookie'])){
                        //     uset($_COOKIE['rememberUserCookie']);
                        //     setcookie('rememberUserCookie', null, -1, '/');
                        // } 
                    }
                    $_SESSION['id'] = $id;                         
                    header("Location: index.php");
                    exit();
                }else{
                    $result="Account not activated. Please check your email inbox for a verification email.";
                }
            }else{           
                $result = "Invalid password.<br>Please try again.";
            }
                
        }else{
            $result = "Email not found.<br>Please try again.";
        }

    } catch (PDOException $ex) {
        $result = "An error occurred.<br>Error message number: ".$ex->getCode();
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
            <h3>Login<span> Page</span> </h3>
            <h4 class="login__line1--signup"><a href="signup.php">Easy Sign-up</a></h4>
        </div>
        
        <form action="login.php" method="post" class="login__form">
                                            
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