<?php include 'php/config/config.php'; ?>
<?php include 'php/classes/Database.php'; ?>
<?php include 'php/helpers/formatting.php'; ?>
<?php
    //Retrieve id for job editting
    $id = $_GET['id'];

    //Create DB Object
    $db = new Database();

    //Create Query
    $query = "SELECT * FROM joblistings WHERE id = ".$id;
    //Run Query
    $update = $db->select($query)->fetch_assoc();

    // //Create Category Query 
    // $query = "SELECT * FROM categories"; 
    // //Run Query 
    // $categories = $db->select($query); 

    // //Create Job Type Query 
    // $query = "SELECT * FROM jobtypes"; 
    // //Run Query 
    // $jobtypes = $db->select($query); 

    // //Create Location Query 
    // $query = "SELECT * FROM locations"; 
    // //Run Query 
    // $locations = $db->select($query); 
?><?php include 'php/reusables/selectorQueries.php'; ?>
<?php 
 if(isset($_POST['submit'])){
    //Assign Vars
    $title = mysqli_real_escape_string($db->link, $_POST['title']);
    $description = mysqli_real_escape_string($db->link, $_POST['description']);
    $dateposted = mysqli_real_escape_string($db->link, $_POST['dateposted']);
    $category = mysqli_real_escape_string($db->link, $_POST['category']);
    $jobtype = mysqli_real_escape_string($db->link, $_POST['jobtype']);
    $location = mysqli_real_escape_string($db->link, $_POST['location']);
    
    ob_start();
    //Simple validation
    //if($title == '' || $body == '' || $category == '' || $author == ''){
    if($title == ''){
      //Set error
      $error = 'Please fill out all required fields.';
    } else {
      $query = "UPDATE joblistings
                  SET
                  title = '$title',
                  description = '$description',
                  dateposted = '$dateposted',
                  category = '$category',
                  jobtype = '$jobtype',
                  location = '$location'
                  WHERE id=".$id;
        
      $update = $db->insert($query);
    }
}
?>
<!DOCTYPE html>

    <html lang="en">

    <?php include 'php/reusables/head.php' ?>

    <body>
    <?php include 'php/reusables/hero.php' ?>
        <div class="addJob">
            <h2 class="addJob__mainHeading">
                Job<span>Board</span>
            </h2>

            <h3>Edit Job Listing</h3>
            <form method="post" action="edit.php?id=<?php echo $id; ?>">
                <div class="addJob__job">
                    <div class="addJob__job--title">
                        <input name="title" type="text" placeholder="Enter Job Title" value="<?php echo $update['title']; ?>">
                    </div>
                    <div class="addJob__job--datePosted">
                        <input name="dateposted" type="date" value="<?php echo $update['dateposted']; ?>">
                        <p style="display:inline; font-size:12px;"> Enter Date of Job Posting or Today's Date </p>
                    </div>
                    <div class="addJob__job--description">
                        <textarea name="description" id="" cols="100" rows="10" placeholder="Enter Job Description">
                            <?php echo $update['description']; ?>
                        </textarea>
                        <script>CKEDITOR.replace( 'description' );</script>
                    </div>

                    <select name="category" class="addSearch__form--selectBoxes-item" id="">
                        
                        <?php while($row = $categories->fetch_assoc()) : ?>
                        <?php if ($update['category'] === $row['category']) {
                            $selected = 'selected';
                        }else{
                            $selected = "";
                        }
                        ?>
                        <option value="<?php echo $row['category']; ?>" <?php echo $selected; ?>>
                            <?php echo $row['category']; ?>
                        </option>
                        <?php endwhile; ?>
                        
                    </select>
                    <select name="jobtype" class="addSearch__form--selectBoxes-item" id="">
                        <?php while($row = $jobtypes->fetch_assoc()) : ?>
                            <?php if ($update['jobtype'] === $row['jobType']) {
                                $selected = 'selected';
                            }else{
                                $selected = "";
                            }
                            ?>
                            <option value="<?php echo $row['jobType']; ?>" <?php echo $selected; ?>>
                                <?php echo $row['jobType']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <select name="location" class="addSearch__form--selectBoxes-item" id="">
                        <?php while($row = $locations->fetch_assoc()) : ?>
                            <?php if ($update['location'] === $row['location']) {
                                $selected = 'selected';
                            }else{
                                $selected = "";
                            }
                            ?>
                            <option value="<?php echo $row['location']; ?>" <?php echo $selected; ?>>
                                <?php echo $row['location']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <input type="submit" name="submit" class="addSearch__form--selectBoxes-item btn btn__primary" value="Submit" />
                <a href="index.php" class="edit__cancel btn btn__secondary">Cancel</a>
            </form>
        </div>

     <!-- FOOTER -->

    <section>
        <?php include 'php/reusables/footer.php' ?>
    </section>

    </body>

    </html>