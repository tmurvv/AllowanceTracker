<?php
    // $thisURL = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    // $myMessage = $_GET['msg'];
    
    // if ($myMessage == "Record Added") {
    //     header("Location: admin.php?msg=added");  
    // } 
    // if ($myMessage == "Record Deleted") {
    //     header("Location: admin.php?msg=deleted");  
    // } 
    // if ($myMessage == "Record Updated") {
    //     header("Location: admin.php?msg=updated");  
    // }
?>
<?php include 'php/config/config.php'; ?>
<?php include 'php/classes/Database.php'; ?>
<?php include 'php/helpers/controllers.php'; ?>
<?php include 'php/helpers/formatting.php'; ?>
<?php
  $id = $_GET['id'];

  //Create DB Object
  $db = new Database();
  
  //Create Query
  $query = createQuery();  
  //Run Query
  $transactions = $db->select($query);

  //create and run sum query for balance
  $result=$db->select('SELECT SUM(transactionAmount) AS valueSum FROM transactions');
  $row=$result->fetch_assoc();
  $sum=$row['valueSum'];

  //Create and run Type Selector Query
  $query = "SELECT * FROM transactionType";
  $transactionTypes = $db->select($query);
?>
<?php
    //Create DB Object
    $db = new Database();

    if(isset($_POST['submit'])){
    //Assign Vars
    $transactionNote = mysqli_real_escape_string($db->link, $_POST['note']);  
    $transactionDate = mysqli_real_escape_string($db->link, $_POST['date']); 
    $transactionAmount = mysqli_real_escape_string($db->link, $_POST['amount']);
    $transactionType = mysqli_real_escape_string($db->link, $_POST['type']);
    $piggyUser = "tmurv";
      
    //Simple validation
    //if($title == '' || $body == '' || $category == '' || $author == ''){

    $query = "INSERT INTO transactions
                (transactionType, transactionAmount, transactionDate, transactionNote, piggyUser)
                VALUES('$transactionType', '$transactionAmount', '$transactionDate', '$transactionNote', '$piggyUser')";
    $insert_row = $db->insert($query);           
    
    //header("Location: admin.php", true, 301);
    
    }
?>
<?php
    if(isset($_POST['edit'])){
        //Assign Vars   
        $transactionNote = mysqli_real_escape_string($db->link, $_POST['transactionNote']);
        $transactionAmount = mysqli_real_escape_string($db->link, $_POST['transactionAmount']);
        $transactionDate = mysqli_real_escape_string($db->link, $_POST['transactionDate']);
        $transactionType = mysqli_real_escape_string($db->link, $_POST['transactionType']);

        //Update Data       
        $query = "UPDATE transactions SET transactionNote = '$transactionNote', transactionAmount = '$transactionAmount', transactionDate = '$transactionDate', transactionType = '$transactionType' WHERE id=".$id;      
        $update = $db->update($query);
    }
?>
<?php
  if(isset($_POST['delete'])){
    $id = $_GET['id'];
    $query = "DELETE FROM transactions WHERE id = ".$id;
    $delete_row = $db->delete($query);
  }
?>
<!DOCTYPE html>

<html lang="en">

<?php include 'php/reusables/head.php' ?>

<body>
    <?php include 'php/reusables/hero.php' ?>

    <div class="mainBoard" id="lineItems">
        <h1>
            Allowance
            <span>Tracker</span>
        </h1>
        <div class="mainBoard__bankImage">
            <img src="img/piggyBankSmall.jpg" alt="PiggyBank Image">
            <p>$
                <?php echo $sum ?>
                <p>
        </div>
        <div class="addTransaction">
            <h3>Add
                <span>Transaction</span>
            </h3>
            
                <form action="index.php" method="post"class="addTransaction__form">
                    
                    <div class="addTransaction__form--type">
                        <label for="type">Type: </label>
                        <select name="type" id="">
                            <option value="" disabled selected>Select your option</option>
                            <?php 
                                //Create and run Type Selector Query
                                $query = "SELECT * FROM transactionType ORDER BY transactionType";
                                $transactionTypes = $db->select($query);
                            ?>
                            <?php while($typeRow = $transactionTypes->fetch_assoc()) : ?>
                            
                            <option value="<?php echo $typeRow['transactionType']; ?>">
                                <?php echo $typeRow['transactionType']; ?>
                            </option>
                            <?php endwhile; ?>                     
                        </select>
                    </div>
                    
                    <div class="addTransaction__form--date">
                        <label for="date">Date: </label>
                        <input name="date" type="date">                      
                    </div>                 
                    <div class="addTransaction__form--note">
                        <label for="note">Note: </label>
                        <input name="note" type="text" placeholder="  enter note">                
                    </div>
                    <div class="addTransaction__form--amount">
                    	<label for="amount">Amount: </label>
                    	<input name="amount" type="text" placeholder="  enter amount">                   	
                    </div>
                    <div class="addTransaction__form--submit">
                        <input type="submit" name="submit" class="btn" value="Submit">
                    </div>
                </form>
            
        </div>
        <div class="transactions">
            <div class="transactions__headers">
                <div class="transactions__headers--type">Type</div>
                <div class="transactions__headers--note">Note</div>
                <div class="transactions__headers--amount">Amount</div>
                <div class="transactions__headers--balance">Balance</div>
            </div>
            <?php if($transactions) : ?>
            <?php while($row = $transactions->fetch_assoc()) : ?>
            <form method="post" name="edit" action="index.php?id=<?php echo $row['id'] ?>">
            <div class="transactions__lineItem">              
                    <div class="transactions__lineItem--line1">
                        <div class="transactions__lineItem--line1-datePosted"><?php echo formatDate($row['transactionDate']); ?></div>
                        <div class="transactions__lineItem--line1-datePosted">
                            <input name="transactionDate" type="date" value="<?php echo formatDateHTMLInput($row['transactionDate']); ?>" hidden />
                        </div>
                        <div class="transactions__lineItem--line1-editDelete"> 
                             
                            <button name="edit" type="button" class="btn btn__secondary" onClick="startEditSelector(this)">Edit</button>
                            <button name="delete" type="button" class="btn btn__primaryVeryDark" onClick="startEditSelector(this)">Delete</button>

                        </div>
                    </div>
                    <div class="transactions__lineItem--line2">
                       
                        <div class="btn btn__primary transactions__lineItem--line2-type"><p><?php echo $row['transactionType']; ?></p></div>
                        <div>
                            <select  style="display:none" class="btn btn__primary transactions__lineItem--line2-type" name="transactionType">                               
                                <?php 
                                    //Create and run Type Selector Query
                                    $query = "SELECT * FROM transactionType ORDER BY transactionType";
                                    $transactionTypes = $db->select($query);
                                ?>
                                <?php while($typeRow = $transactionTypes->fetch_assoc()) : ?>
                                <?php if ($row['transactionType'] === $typeRow['transactionType']) {
                                    $selected = 'selected';
                                }else{
                                    $selected = "";
                                }
                                ?>
                                <option value="<?php echo $typeRow['transactionType']; ?>" <?php echo $selected; ?>>
                                    <?php echo $typeRow['transactionType']; ?>
                                </option>
                                <?php endwhile; ?>                    
                            </select>
                        </div>
                        <div class="transactions__lineItem--line2-note">
                            <h2><?php echo $row['transactionNote']; ?></h2>
                            <h2 hidden>
                                <input name="transactionNote" value="<?php echo $row['transactionNote']; ?>" /> 
                            </h2>
                        </div>
                        <div class="transactions__lineItem--line2-amount"><?php echo $row['transactionAmount']; ?>
                        </div>
                        <div class="transactions__lineItem--line2-amount" hidden>
                            <input name="transactionAmount" value="<?php echo $row['transactionAmount']; ?>" />                        
                        </div>
                        <div>
                            <?php 
                                //create and run sum query for current transaction balance
                                $lineTransactionDate = $row['transactionDate'];
                                $result=$db->select("SELECT SUM(transactionAmount) AS lineValueSum FROM transactions WHERE transactionDate <= '$lineTransactionDate';");
                                $sumRow=$result->fetch_assoc();
                                $lineSum=$sumRow['lineValueSum'];
                                //$lineSum=40.35;
                            ?>
                            <?php echo "$".$lineSum; ?>
                        </div>

                    </div>               
            </div>
            </form>
            <br>
            <hr>
            <?php endwhile; ?>
            <?php endif; ?>
        </div>

    </div>
    </div>

    <!-- Contact -->
    <section id="contact">
        <?php include 'php/reusables/about.php' ?>
    </section>
    <!-- FOOTER -->
    <section>
        <?php include 'php/reusables/footer.php' ?>
    </section>

</body>

</html>