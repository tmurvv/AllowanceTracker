<?php include 'php/config/config.php'; ?>
<?php include 'php/classes/Database.php'; ?>
<?php include 'php/helpers/controllers.php'; ?>
<?php include 'php/helpers/formatting.php'; ?>
<?php 
    if (isset($_POST['signupBtn'])) {       
        //collect form data and store in variables       
        $email = $_POST['email'];
        $password = $_POST['password'];
        $piggyBankOwner = $_POST['piggyBankOwner'];
        $confirmPassword = $_POST['confirmPassword'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $piggyBankName = $_POST['piggyBankName'];
        $isDefault = TRUE;
        $piggyUserId = NULL;
      
        if ($password == $confirmPassword) {
            //check if email + name exists
               
            $sqlQuery = "SELECT * FROM users WHERE email= :email";
            $statement = $db->prepare($sqlQuery);
            $statement->execute(array(':email'=> $email));
            
            if (!$piggyUserRow = $statement->fetch()) {                   
                try {               
                    //insert user
                    $sqlInsert = "INSERT INTO users (email, password, join_date)
                    VALUES (:email, :password, now())";
                    $statement = $db->prepare($sqlInsert);
                    $statement->execute(array(':email' => $email, ':password' => $hashed_password));                  

                    if($statement->rowCount() == 1){
                        $piggyUserId = $db->lastInsertId();
                        $encodeUserId = base64_encode("encodeuserid{$piggyUserId}");
                    
                        try {               
                            //insert first piggy bank
                            $sqlInsert = "INSERT INTO piggybanks (piggyUser, piggyBankName, piggyBankOwner, isDefault)
                            VALUES (:piggyUser, :piggyBankName, :piggyBankOwner, :isDefault)";
                            $statement = $db->prepare($sqlInsert);
                            $statement->execute(array(':piggyUser' => $piggyUserId, ':piggyBankName' => $piggyBankName, ':piggyBankOwner' => $piggyBankOwner, ':isDefault' => $isDefault));
                            $result = "Registration Successful";
    
                        } catch (PDOException $ex) {
                            $result = "An error occurred entering your first piggy bank: ".$ex;
                        }

                        //prepare email body

                        $mail_body = '<html>
                            <body style="color:#C76978; font-family: Lato, Arial, Helvetica, sans-serif;
                                                line-height:1.8em;">
                            <h2>Message from Piggy<span style="color:#D9AE5C;">Bank</span></h2>
                            <p>Dear PiggyBank user,<br><br>Thank you for registering, please click on the link below to
                                confirm your email address</p>
                            <p style="text-decoration: underline; font-size: 24px;"><a style="color:#D9AE5C;" href='.$rootDirectory.'activate.php?id='.$encodeUserId.'"> Confirm Email</a></p>
                            <p><strong>&copy;2018 <a href="https://take2tech.ca" style="color:#D9AE5C;text-decoration: underline;">take2tech.ca</strong></p>
                            </body>
                            </html>';
                        
                        $subject = "Message from PiggyBank";
                        $headers = "From: PiggyBank.--User Signup" . "\r\n";
                        $headers .= "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        
                        //Error Handling for PHPMailer
                        if(!mail($email, $subject, $mail_body, $headers)){
                            $result = "Email send failed.";
                        }
                        else{
                            $result = "Registration Successful. Please check email for confirmation link.";
                        }
                    }

                } catch (PDOException $ex) {
                    $result = "An error occurred entering a new user: ".$ex;
                }
                
            }else{
                $result="Account email already exists. Please use another email.";
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
    <div class="signup signatureBox">
        <div class="signup__line1">
            <h3>Easy&nbsp;&nbsp;<span>Signup</span>Page
            </h3>
        </div>
        
        <form action="signup.php" method="post" class="signup__form">
                             
            <div class="signup__form--email">
                <label for="email">Email: </label>
                <input name="email" type="email" placeholder="A confirmation email will appear in your inbox." required> 
            </div>                 
            <div class="signup__form--password">
                <label for="password">Password: </label>
                <input name="password" type="password" required>                
            </div>
            <div class="signup__form--password">
                <label for="confirmPassword">Confirm Password: </label>
                <input name="confirmPassword" type="password" required>                
            </div>
            <div class="signup__form--piggyName">
                <label for="piggyBankName">PiggyBank Name: </label>
                <input name="piggyBankName" type="text" placeholder="For example 'allowance' or 'savings'" >
            </div>
            <div class="signup__form--piggyOwner">
                <label for="piggyBankOwner">PiggyBank Owner: </label>
                <input name="piggyBankOwner" type="text" placeholder="Who's PiggyBank is it?" >
            </div>
        
            <div class="signup__form--submit">
                <input type="submit" name="signupBtn" class="btn" value="Submit"/>           
            </div>
        </form>
    </div>
</body>
</html>