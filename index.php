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
?>
<?php
    if(isset($_POST['edit'])){
        //Retrieve id for editting
        $id = $_GET['id'];

        //Create DB Object
        $db = new Database();

        //Create Query
        $query = "SELECT * FROM transactions WHERE id = ".$id;
        //Run Query
        $update = $db->select($query)->fetch_assoc();
    }
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
                (addSubtract, transactionAmount, dateTransaction, transactionNote, piggyUser)
                VALUES('$transactionType', '$transactionAmount', '$transactionDate', '$transactionNote', '$piggyUser')";
    $insert_row = $db->insert($query);           
    
    //header("Location: admin.php", true, 301);
    
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

    <div class="mainBoard" id="jobs">
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
            <div class="addTransaction__form">
                <form action="index.php" method="post">
                    <label for="type">Type: </label>
                    <select name="type" id="">
                        <option value="Select Type">Select Type</option>
                        <option value="Deposit">Deposit</option>
                        <option value="Withdrawal">Withdrawal</option>
                    </select>
                    <label for="date">Date: </label>
                    <input name="date" type="date" placeholder="enter date">
                    <label for="note">Note: </label>
                    <input name="note" type="text" placeholder="enter note">
                    <label for="amount">Amount: </label>
                    <input name="amount" type="text" placeholder="enter amount">
                    <input type="submit" name="submit" class="btn" value="Submit">
                </form>
            </div>
        </div>
        <div class="listings">
            <div class="listings__headers">
                <div class="listings__headers--type">Type</div>
                <div class="listings__headers--note">Note</div>
                <div class="listings__headers--amount">Amount</div>
                <div class="listings__headers--balance">Balance</div>
            </div>
            <?php if($transactions) : ?>
            <?php while($row = $transactions->fetch_assoc()) : ?>
            <div class="listings__job">

                <div class="listings__job--info">
                    <div class="listings__job--info-line1">
                        <div class="listings__job--info-line1-datePosted">
                            <?php echo formatDate($row['dateTransaction']); ?>
                        </div>
                        <div class="listings__job--info-line1-editDelete">
                            
                            <form method="post" action="index.php?id=<?php echo $row['id'] ?>">
                                <button name="edit" type="button" class="btn btn__secondary" onClick="startEditSelector(this)">Edit</button>
                                <button name="delete" type="button" class="btn btn__primaryVeryDark" onClick="startEditSelector(this)">Delete</button>
                            </form>

                        </div>
                    </div>
                    <div class="listings__job--info-line2">
                        <div class="listings__job--info-line2Type">
                            <p class="btn btn__primary">
                                <?php if($row['addSubtract']=="Deposit") : echo "Cha-CHING"; else: echo "Spent It"; endif; ?>
                                
                                
                                <select name="type" id="">
    <option value="Select Type">Select Type</option>
    <option value="Deposit">Deposit</option>
    <option value="Withdrawal">Withdrawal</option>
</select>
                                    <?php //while($row = $transactionType->fetch_assoc()) : ?>
                                        <?php //if ($update['transactionType'] === $row['transactionType']) {
                                            //$selected = 'selected';
                                            //}else{
                                            //    $selected = "";
                                            //}
                                        ?>
                                        <!-- <option value="<?php //echo $row['transactionType']; ?>" <?php //echo $selected; ?>>
                                            <?php //echo $row['transactionType']; ?>
                                        </option> -->
                                    <?php //endwhile; ?>
                                    
                            
                            </p>    
                        </div>
                        <h2>
                            <?php echo $row['transactionNote']; ?>
                            <input name="transactionNote" value="<?php echo $row['transactionNote']; ?>"/>
                        </h2>
                        <div class="listings__job--info-line2Amount">
                            <?php echo "$".$row['transactionAmount']; ?>
                            
                        </div>
                        <div>
                        <?php 
                            //create and run sum query for current transaction balance
                            $lineTransactionDate = $row['dateTransaction'];
                            $result=$db->select("SELECT SUM(transactionAmount) AS lineValueSum FROM transactions WHERE dateTransaction <= '$lineTransactionDate';");
                            $sumRow=$result->fetch_assoc();
                            $lineSum=$sumRow['lineValueSum'];
                            //$lineSum=40.35;
                        ?>
                        <?php echo "$".$lineSum; ?>
                        </div>

                    </div>
                </div>
            </div>
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