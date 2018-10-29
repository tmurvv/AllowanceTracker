<?php                                     
session_start();
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
            <h3>Logout<span> Page</span> </h3>
        </div>       
        <form action="logout.php" method="post" class="login__form">                           
            <div>
                <?php  
                    if(isset($_POST['logout'])) {
                        unset($_SESSION['id']);
                        unset($_POST['logout']);
                        // NOT YET IMPLEMENTED if(isset($_COOKIE['rememberUserCookie'])){
                        //     uset($_COOKIE['rememberUserCookie']);
                        //     setcookie('rememberUserCookie', null, -1, '/');
                        // } 
                        // end NOT YET IMPLEMENTED
                        session_destroy();
                        session_regenerate_id(true);
                        //header("Location: index.php"); 
                    }            
                ?>
                <?php if(isset($_SESSION['id'])) : ?> 
                    Logout? Are you sure? 
                    <div class="login__form--submit">
                        <input type="submit" name="logout" class="btn" value="Logout"/>           
                    </div> 
                <?php else : ?>  
                    <?php header("Location: index.php"); ?> 
                <?php endif; ?>
            </div>                                   
        </form>
    </div>
</body>
</html>