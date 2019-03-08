<?php session_start(); 
?>
<?php include 'php/config/config.php'; ?>
<?php include 'php/classes/Database.php'; ?>
<?php include 'php/helpers/controllers.php'; ?>
<?php include 'php/helpers/formatting.php'; ?>
<?php 
    include 'php/reusables/addEditDeleteTransactions.php';
?>
<?php
    include 'php/reusables/getTransactions.php';
?>
<?php 
    include 'php/reusables/getPiggyBanks.php';
?>
<!DOCTYPE html>

<html lang="en">

<?php include 'php/reusables/head.php' ?>

<body>
    <?php include 'php/reusables/hero.php' ?>

    <div class="mainPage" id="lineItems">        
        <div class="mainPage__piggyName">
            <h1><?php echo $piggyBankName; ?></h1> 
        </div>   
        <!-- <div style="display: flex">
            <h3 style="color: #D9AE5C"><span style="color: #e47587">Piggy Says: </span>This website is under construction, but mostly works.</h3>
        </div> -->
        
        <div class="mainPage__bankImage">
            <img src="img/piggyBankSmall.jpg" alt="PiggyBank Image">
            <p>$
                <?php echo $sum ?>
            <p>
            
        </div>
        <div class="addTransaction">
            <h3>Add<span>Transaction</span></h3>
            
            <form action="index.php" method="post" class="addTransaction__form">                
                <div class="addTransaction__form--type">
                    <label for="type">Type: </label>
                    <select name="type" id="js--addTransType">
                        <option value="" disabled selected>Select your option</option>                           
                        <?php foreach($transactionTypes as $typeRow) : ?>                           
                            <option value="<?php echo $typeRow['transactionType']; ?>">
                                <?php echo $typeRow['transactionType']; ?>
                            </option>
                        <?php endforeach; ?>                     
                    </select>
                </div>
                
                <div class="addTransaction__form--date">
                    <label for="date">Date: </label>
                    <input name="date" type="date" id="js--addTransDate">                                           
                    <label for="time">Time(opt): </label>
                    <input name="time" type="time" id="js--addTransTime">                      
                </div>                 
                <div class="addTransaction__form--note">
                    <label for="note">Note: </label>
                    <input name="note" type="text" placeholder="  enter note">                
                </div>
                <div class="addTransaction__form--amount">
                    <label for="amount">Amount: </label>
                    <input name="amount" type="text" oninput="checkMinusSign();" id="js--addTransAmount" placeholder="  enter amount">                   	
                </div>
                <div class="addTransaction__form--submit">
                    <input type="submit" name="submit" class="btn" value="Submit">
                    <button name="resetAdd" type="reset" class="btn btn__secondary">Reset</button> 
                </div>
            </form>
            
        </div>
        <div class="transactions">
            <form name="switchPiggy" method="post" action="index.php">            
                <div class="mainPage__switchPiggy">
                    <form>
                    <p>Change PiggyBank:&nbsp;&nbsp;&nbsp;</p>
                    <select name="switchPiggyName" id="js--switchPiggyName" onchange="this.form.submit()">                                  
                        <option value="Switch PiggyBank">Switch PiggyBank</option>
                        <?php foreach($piggies as $piggy) : ?>
                            <?php
                                if ($piggy['piggyBankName'] === $_SESSION['piggyBankName']) {
                                    $selected = 'selected';
                                }else{
                                    $selected = "";
                                }
                            ?>
                            <option value="<?php echo $piggy['piggyBankName']; ?>" <?php if(isset($selected)) {echo $selected;} ?> >
                                <?php echo $piggy['piggyBankName']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    </form>
                </div>
            </form>
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
                             
                            <button name="edit" type="button" class="btn btn__secondary" onClick="startEditTransaction(this)">Edit</button>
                            <button name="delete" type="button" class="btn btn__primaryVeryDark" onClick="startEditTransaction(this)">Delete</button>
                        </div>
                        <div hidden><?php echo $row['transactionDate']; ?></div>
                    </div>
                    <div class="transactions__lineItem--line2">                     
                        <div class="transactions__lineItem--line2-type"><p class="btn btn__primary"><?php echo $row['transactionType']; ?></p></div>
                        <div>
                            <select style="display:none;" class="btn btn__primary transactions__lineItem--line2-type" name="transactionType">                               
                                <?php foreach($transactionTypes as $typeRow) : ?>
                                <?php
                                    if ($row['transactionType'] === $typeRow['transactionType']) {
                                        $selected = 'selected';
                                    }else{
                                        $selected = "";
                                    }
                                ?>
                                <option value="<?php echo $typeRow['transactionType'];?>" <?php echo $selected; ?>>
                                    <?php echo $typeRow['transactionType']; ?>
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

                                $query="SELECT SUM(transactionAmount) AS lineValueSum FROM transactions WHERE transactionDate <= :lineTransactionDate AND piggyBankId=:piggyBankId";
                                $statement= $db->prepare($query);
                                $statement->execute(array(':lineTransactionDate'=> $lineTransactionDate, ':piggyBankId' => $piggyBankId));
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