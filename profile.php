<?php include 'php/config/config.php'; ?>
<?php include 'php/classes/Database.php'; ?>
<?php include 'php/helpers/controllers.php'; ?>
<?php include 'php/helpers/formatting.php'; ?>
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
        
        <form action="index.php" method="post"class="user__form">
            
            <div class="user_form user__form--username">
                <label for="username">Username: </label>
                <div><?php echo $row['username']; ?></div>
                <input name="username" type="text">                                           
            </div>                 
            <div class="user_form user__form--email">
                <label for="email">Email: </label>
                <div><?php echo $row['username']; ?></div>
                <input name="email" type="email">                                          
            </div>                 
            <div class="user_form user__form--password">
                <a href="changePassword.php">Change Password</a>
                <div hidden><?php echo $row['password']; ?></div>                
            </div>
            <div class="user_form user__form--password">
                <label for="owner">PiggyBank Owner: </label>
                <div><?php echo $row['piggyOwner']; ?></div>
                <input name="owner" type="text">
                <label for="owner">  "OwnerName's Piggy Bank" will appear on your main page.</label>                
            </div>
        
            <div class="user_form user__form--submit">
                <input type="submit" name="submit" class="btn" value="Submit"/>           
            </div>
        </form>
    </div>
</body>
</html>