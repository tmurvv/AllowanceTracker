<!DOCTYPE html>

<html lang="en">

<?php include 'php/reusables/head.php' ?>

<body>
    <?php include 'php/reusables/hero.php' ?>
    <div class="user">
        <div class="user__line1">
            <h3>Login
                <span> Page</span> 
            </h3>
            <h4 class="user__line1--signup"><a href="#">Easy Sign-up</a>
                
            </h4>
        </div>
        
        <form action="index.php" method="post"class="user__form">
            
            <div class="user__form--username">
                <label for="username">Username: </label>
                <input name="username" type="text">                                           
            </div>                 
            <div class="user__form--email">
                <label for="email">Email: </label>
                <input name="email" type="email">                                           
            </div>                 
            <div class="user__form--password">
                <label for="password">Password: </label>
                <input name="password" type="password" placeholder="password">                
            </div>
        
            <div class="user__form--submit">
                <input type="submit" name="submit" class="btn" value="Submit"/>           
                <h4 class="user__line1--signup"><a href="#">Easy Sign-up<a></h4>
            </div>
        </form>
    </div>
</body>
</html>