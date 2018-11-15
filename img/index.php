<?php
    $thisURL = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $myMessage = $_GET['msg'];
    
    if ($myMessage == "Record Added") {
        header("Location: admin.php?msg=added");  
    } 
    if ($myMessage == "Record Deleted") {
        header("Location: admin.php?msg=deleted");  
    } 
    if ($myMessage == "Record Updated") {
        header("Location: admin.php?msg=updated");  
    }
?>
<?php include 'php/config/config.php'; ?>
<?php include 'php/classes/Database.php'; ?>
<?php include 'php/helpers/controllers.php'; ?>
<?php include 'php/helpers/formatting.php'; ?>
<?php

  //Create DB Object
  $db = new Database();
  
  //Create Query
  $query = createQuery();  
  //Run Query
  $transactions = $db->select($query);

//   //Create Query
//   $query = sumQuery();
//   //Run Query
//   $balance = $db->select($query);


    $result=$db->select('SELECT SUM(transactionAmount) AS valueSum FROM transactions');
    $row=$result->fetch_assoc();
    $sum=$row['valueSum'];
    echo $sum;
    
?>

<!DOCTYPE html>

<html lang="en">

<?php include 'php/reusables/head.php' ?>

<body>
    <?php include 'php/reusables/hero.php' ?>

        <div class="mainPage" id="jobs">
            <h1>
                Allowance<span>Tracker</span>
            </h1>
            <div class="mainPage__bankImage"></div>
            <div class="listings">
                <p class="btn btn__primary">
                    <?php $rowsum = $res->fetch_assoc(); ?>
                    <?php $rowtest = 100.50 ?>
                    <?php echo "Balance: ".$rowtest ; ?>
                </p>
                <?php if($transactions) : ?>
                <?php while($row = $transactions->fetch_assoc()) : ?>
                <div class="listings__job">
                    <div class="listings__job--type">
                        <p class="btn btn__secondary">
                            <?php echo $row['addSubtract'] ?>
                        </p>
                    </div>
                    <div class="listings__job--info">
                        <div class="listings__job--info-line1">
                            <h2>
                                <?php echo $row['transactionNote'] ?>
                                <?php echo $row['transactionAmount'] ?>
                            </h2>
                        </div>
                        <div class="listings__job--info-line2">

                            <div class="listings__job--info-line2-datePosted">
                                <?php echo formatDate($row['dateTransaction']); ?>
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
<section>
<?php include 'php/reusables/contact.php' ?>
</section>
    <!-- FOOTER -->
<section>
<?php include 'php/reusables/footer.php' ?>
</section>
    
</body>
</html>