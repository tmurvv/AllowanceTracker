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
            <h3>Easy 
                <span> Signup</span>Page
            </h3>
        </div>
        
        <form action="index.php" method="post"class="user__form">
            
            <div class="user_form user__form--username">
                <label for="username">Username: </label>
                <input name="username" type="text">                                           
            </div>                 
            <div class="user_form user__form--email">
                <label for="email">Email: </label>
                <input name="email" type="email"> 
                <label for="email">  a confirmation email will be sent</label>                                          
            </div>                 
            <div class="user_form user__form--password">
                <label for="password">Password: </label>
                <input name="password" type="password">                
            </div>
            <div class="user_form user__form--password">
                <label for="confirmPassword">Confirm Password: </label>
                <input name="confirmPassword" type="password">                
            </div>
            <div class="user_form user__form--password">
                <label for="owner">PiggyBank Owner: </label>
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