<?php session_start(); ?>
<?php include 'php/config/config.php'; ?>
<?php include 'php/classes/Database.php'; ?>
<?php include 'php/helpers/controllers.php'; ?>
<?php include 'php/helpers/formatting.php'; ?>
<?php
  //Initialize variables
  if(isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $piggyBankId = $_SESSION['piggyBankId'];
    $piggyBankName = $_SESSION['piggyBankName'];
    $owner = $_SESSION['piggyBankOwner'];
  }
?>
<?php 
  //Run Transaction Query
  $query  = "SELECT * FROM transactions WHERE piggyBankId=:piggyBankId ORDER BY transactionDate DESC";
  $statement = $db->prepare($query);
  $statement->execute(array(':piggyBankId'=>$piggyBankId));
  $transactions = $statement->fetchAll(PDO::FETCH_ASSOC); 

  //create and run sum query for balance
  $query="SELECT SUM(transactionAmount) AS valueSum FROM transactions WHERE piggyBankId=:piggyBankId";
  $statement=$db->prepare($query);
  $statement->execute(array(':piggyBankId'=>$piggyBankId));
  $row=$statement->fetch(PDO::FETCH_ASSOC);
  $sum=$row['valueSum'];

  //Create and run Type Selector Query
  $statement = $db->query("SELECT * FROM transactionType ORDER BY transactionType");
  $transactionTypes = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<?php 
    //Add new transaction
    if(isset($_SESSION['id'])) {
      if(isset($_POST['submit'])){
            //Assign Vars
            $transactionNote = $_POST['note'];  
            $transactionDate = $_POST['date'];     
            $transactionTime = $_POST['time'];
            $transactionDateTime = $transactionDate." ".$transactionTime;
            $transactionAmount = $_POST['amount'];
            $transactionType = $_POST['type'];
                       
            if ($transactionType == '' || $transactionType == null) {
                $transactionType = '0. Select your option';
            }

            //Create and run transaction
            $query = "INSERT INTO transactions
                        (transactionType, transactionAmount, transactionDate, transactionNote, piggyBankId)
                        VALUES(?,?,?,?,?)";
            $statement = $db->prepare($query); 
            
            $statement->execute([$transactionType, $transactionAmount, $transactionDateTime, $transactionNote, $piggyBankId]);         
            
            header("Location: index.php", true, 301);           
        }
    }else{
        $result = "User not found, please login again.";
    }
?>
<?php
    //Edit transaction
    if(isset($_POST['edit'])){
        //Assign Vars   
        $transactionNote = $_POST['transactionNote'];
        $transactionAmount = $_POST['transactionAmount'];
        $transactionDate = $_POST['transactionDate'];
        $transactionTime = $_POST['transactionTime'];
        $transactionDateTime = $transactionDate." ".$transactionTime;
        $transactionType = $_POST['transactionType'];
        $transactionId = $_POST['transactionId'];
          
        //Update Data       
        $query = "UPDATE transactions SET transactionNote = :transactionNote, 
                                            transactionAmount = :transactionAmount, 
                                            transactionDate = :transactionDateTime, 
                                            transactionType = :transactionType WHERE id=:id";      
        $statement = $db->prepare($query);
        $statement->execute(array(':transactionNote'=>$transactionNote,
                                    ':transactionAmount'=>$transactionAmount,
                                    ':transactionDateTime'=>$transactionDateTime,
                                    ':transactionType'=>$transactionType,
                                    ':id'=>$transactionId));
        header("Location: index.php", true, 301);
    }
?>
<?php
  //Delete transaction
  if(isset($_POST['delete'])){
    $id = $_GET['id'];
    $query = "DELETE FROM transactions WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->execute(array(":id"=>$id));
  }
?>
<!DOCTYPE html>

<html lang="en">

<?php include 'php/reusables/head.php' ?>

<body>
    <?php include 'php/reusables/hero.php' ?>

    <div class="mainBoard" id="lineItems">
        <h1>
            <?php echo $piggyBankName; ?>
        </h1>
        <div class="mainBoard__bankImage">
            <img src="img/piggyBankSmall.jpg" alt="PiggyBank Image">
            <p>$
                <?php echo $sum ?>
                <p>
        </div>
        <div class="addTransaction">
            <h3>Add<span>Transaction</span>
            </h3>
            
                <form action="index.php" method="post"class="addTransaction__form">
                    
                    <div class="addTransaction__form--type">
                        <label for="type">Type: </label>
                        <select name="type" id="">
                            <option value="" disabled selected>Select your option</option>                           
                            <?php foreach($transactionTypes as $typeRow) : ?>                           
                                <option value="<?php echo substr($typeRow['transactionType'], strpos($typeRow['transactionType'], ".") +1); ?>">
                                    <?php echo substr($typeRow['transactionType'], strpos($typeRow['transactionType'], ".") +1); ?>
                                </option>
                            <?php endforeach; ?>                     
                        </select>
                    </div>
                    
                    <div class="addTransaction__form--date">
                        <label for="date">Date: </label>
                        <input name="date" type="date">                      
                        <label for="time">Time(opt): </label>
                        <input name="time" type="time">                      
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
            <?php foreach($transactions as $row) : ?>
            <form method="post" name="edit" action="index.php?id=<?php echo $row['id'] ?>">
                <div class="transactions__lineItem">  
                   <div class="transactions__lineItem--line1">
                        <div class="transactions__lineItem--line1-datePosted">
                            <?php echo formatDate($row['transactionDate']); ?>
                        </div>
                        <div class="transactions__lineItem--line1-datePosted">
                            <input class="transactions__lineItem--line1-datePosted" name="transactionDate" type="date" value="<?php echo date('Y-m-d',strtotime($row['transactionDate'])); ?>" hidden />
                            <input name="transactionTime" type="time" value="<?php echo date('H:i:s',strtotime($row['transactionDate'])); ?>" hidden />
                        </div>
                        <div class="transactions__lineItem--line1-editDelete"> 
                             
                            <button name="edit" type="button" class="btn btn__secondary" onClick="startEditSelector(this)">Edit</button>
                            <button name="delete" type="button" class="btn btn__primaryVeryDark" onClick="startEditSelector(this)">Delete</button>
                        </div>
                        <div hidden><?php echo $row['transactionDate']; ?></div>
                    </div>
                    <div class="transactions__lineItem--line2">                     
                        <div class="transactions__lineItem--line2-type"><p class="btn btn__primary"><?php echo substr($row['transactionType'], strpos($row['transactionType'], ".") +1); ?></p></div>
                        <div>
                            <select style="display:none;" class="btn btn__primary transactions__lineItem--line2-type" name="transactionType">                               
                                <?php foreach($transactionTypes as $typeRow) : ?>
                                <?php
                                    if ($row['transactionType'] === substr($typeRow['transactionType'], strpos($typeRow['transactionType'], ".") +1)) {
                                        $selected = 'selected';
                                    }else{
                                        $selected = "";
                                    }
                                ?>
                                <option value="<?php echo substr($typeRow['transactionType'], strpos($typeRow['transactionType'], ".") +1)?>" <?php echo $selected; ?>>
                                    <?php echo substr($typeRow['transactionType'], strpos($typeRow['transactionType'], ".") +1); ?>
                                </option>
                                <?php endforeach; ?>                    
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

                                $query="SELECT SUM(transactionAmount) AS lineValueSum FROM transactions WHERE transactionDate <= :lineTransactionDate";
                                $statement= $db->prepare($query);
                                $statement->execute(array(':lineTransactionDate'=> $lineTransactionDate));
                                $lineSumRow=$statement->fetch(PDO::FETCH_ASSOC);
                                $lineSum=$lineSumRow['lineValueSum'];
                            ?>
                            <?php echo "$".$lineSum; ?>
                        </div>
                        <div><input name="transactionId" value="<?php echo $row['id'] ?>" hidden /></div>
                    </div>               
                </div>
            </form>
            <br>
            <hr>
            <?php endforeach; ?>
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