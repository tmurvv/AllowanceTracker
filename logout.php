<?php session_start(); ?>
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
            <h3>Logout
                <span> Page</span> 
            </h3>
            <h4 class="login__line1--signup"><a href="signup.php">Easy Sign-up</a>
                
            </h4>
        </div>
        
        <form action="logout.php" method="post" class="login__form">
                            
            <div class="signatureBox">
                <?php if(isset($_POST['logout'])) : ?>
                    "Logout functionality not yet implemented."                  
                <?php endif;?>
                <?php if(isset($_SESSION['id'])) : ?> 
                    Logout? Are you sure? 
                    <div class="login__form--submit">
                        <input type="submit" name="logout" class="btn" value="Logout"/>           
                    </div> 
                <?php else : ?>  
                    Not logged in.
                    <h4 class="login__line1--signup"><a href="login.php">Login</a>&nbsp;&nbsp;&nbsp;&vert;&nbsp<a href="signup.php">Easy Sign-up</a></h4> 
                <?php endif; ?>
            </div>                
                    
        </form>
    </div>
</body>
</html>