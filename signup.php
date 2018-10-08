<?php include 'php/config/config.php'; ?>
<?php include 'php/classes/Database.php'; ?>
<?php include 'php/helpers/controllers.php'; ?>
<?php include 'php/helpers/formatting.php'; ?>

<?php 
    if (isset($_POST['signupBtn'])) {
       
        //collect form data and store in variables
        $email = $_POST['email'];
        $owner = $_POST['owner'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        if ($password == $confirmPassword) {
                //insert record
            try {               
                //create SQL insert statement
                $sqlInsert = "INSERT INTO users (piggybank_owner, email, password, join_date)
                VALUES (:piggybank_owner, :email, :password, now())";

                //use PDO prepared to sanitize data
                $statement = $db->prepare($sqlInsert);

                //add the data into the database
                $statement->execute(array(':piggybank_owner' => $owner, ':email' => $email, ':password' => $hashed_password));

                $result = "Registration Successful";

            } catch (PDOException $ex) {
                $result = "An error occurred: ".$ex;
            }   
        } else {
            $result = "Passwords do not match. Please try again.";
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
    <div class="user signatureBox">
        <div class="user__line1">
            <h3>Easy 
                <span> Signup</span>Page
            </h3>
        </div>
        
        <form action="signup.php" method="post"class="user__form">
                             
            <div class="user_form user__form--email">
                <label for="email">Email: </label>
                <input name="email" type="email" required> 
                <label for="email">  a confirmation email will be sent</label>                                          
            </div>                 
            <div class="user_form user__form--password">
                <label for="password">Password: </label>
                <input name="password" type="password" required>                
            </div>
            <div class="user_form user__form--password">
                <label for="confirmPassword">Confirm Password: </label>
                <input name="confirmPassword" type="password" required>                
            </div>
            <div class="user_form user__form--password">
                <label for="owner">Who's PiggyBank is it? </label>
                <input name="owner" type="text">
                <label for="owner">  "Your Piggy Bank" will appear on your main page.</label>                
            </div>
        
            <div class="user_form user__form--submit">
                <input type="submit" name="signupBtn" class="btn" value="Submit"/>           
            </div>
        </form>
    </div>
</body>
</html>