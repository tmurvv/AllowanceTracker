<?php include 'php/config/config.php'; ?>
<?php include 'php/classes/Database.php'; ?>
<?php include 'php/helpers/controllers.php'; ?>
<?php include 'php/helpers/formatting.php'; ?>
<?php include 'php/reusables/head.php' ?>
<?php
    if(isset($_GET['id'])) {
        $encoded_id = $_GET['id'];
        $decode_id = base64_decode($encoded_id);
        $user_id_array = explode("encodeuserid", $decode_id);
        $piggyUserId = $user_id_array[1];
        
        try {
            $sql = "UPDATE users SET active =:active WHERE id=:piggyUserId AND active='0'";       
            $statement = $db->prepare($sql);
            $statement->execute(array(':active' => "1", ':piggyUserId' => $piggyUserId));
           
            if ($statement->rowCount() == 1) {
                $result = '<h2>Email Confirmed </h2>
                <p>Your email address has been verified, you can now <a class="activate" href="login.php">login</a> with your email and password.</p>';
            } else {
                $result = "<p class='lead'>No changes made please contact site admin,
                if you have not confirmed your email before</p>";
            }
        } catch(PDOException $ex) {
            $result = "An error occurred. ".$ex;
        }
    }else{
        $result="An error occurred, be sure to click on the link in the activation email to activate your account.";
    }

?>
<body>
    <?php include 'php/reusables/hero.php' ?>
    
    <div class="profile__line1">
        <h2>Activation <span>Page</span></h2>       
    </div>        
    <?php if (isset($result)) : ?>
        <div class="signatureBox">
            <?php include 'php/reusables/messageBox.php'; ?>
        </div>
    <?php endif; ?>
    <br>
    <br>
    <?php include_once "php/reusables/footer.php"; ?>
</body>
</html>