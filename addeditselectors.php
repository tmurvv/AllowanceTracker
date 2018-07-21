<?php include 'php/config/config.php'; ?>
<?php include 'php/classes/Database.php'; ?>
<?php include 'php/helpers/formatting.php'; ?>
<?php
    //Retrieve id for edit/delete
    $id = $_GET['id'];

    //Create DB Object
    $db = new Database();

    //Create Category Query 
    $query = "SELECT * FROM categories ORDER BY categoryViewOrder"; 
    //Run Query 
    $categories = $db->select($query);
    
    //Create Job Type Query 
    $query = "SELECT * FROM jobtypes ORDER BY jobTypeViewOrder"; 
    //Run Query 
    $jobtypes = $db->select($query); 

    //Create Location Query 
    $query = "SELECT * FROM locations ORDER BY locationViewOrder"; 
    //Run Query 
    $locations = $db->select($query); 
?>
<?php 
    if(isset($_POST['addcat'])){
        //Assign Vars   
        $category = mysqli_real_escape_string($db->link, $_POST['category']);
        $categoryViewOrder = mysqli_real_escape_string($db->link, $_POST['categoryvieworder']);
        
        //Simple validation
        
        $query = "INSERT INTO categories (category, categoryViewOrder) VALUES('$category', '$categoryViewOrder')";      
        $insert = $db->insert($query);
    }
    if(isset($_POST['editcat'])){
        //Assign Vars   
        $category = mysqli_real_escape_string($db->link, $_POST['category']);
        $categoryViewOrder = mysqli_real_escape_string($db->link, $_POST['categoryvieworder']);
        $oldCategory=mysqli_real_escape_string($db->link, $_POST['oldCategory']);
        
        //Simple validation
        
        $query = "UPDATE categories SET category = '$category', categoryViewOrder = '$categoryViewOrder' WHERE id=".$id;      
        $update = $db->update($query);

        //update all listings with changed category
        $query = "UPDATE joblistings SET category = '$category' WHERE category='$oldCategory'";      
        $update = $db->update($query);
    }
    if(isset($_POST['deletecat'])){
        
        $query = "DELETE FROM categories WHERE id=".$id;      
        $delete = $db->delete($query);
    }

    if(isset($_POST['addjobtype'])){
        //Assign Vars   
        $jobtype = mysqli_real_escape_string($db->link, $_POST['jobtype']);
        $jobtypevieworder = mysqli_real_escape_string($db->link, $_POST['jobtypevieworder']);
        
        //Simple validation
        
        $query = "INSERT INTO jobtypes (jobType, jobTypeViewOrder) VALUES('$jobtype', '$jobtypevieworder')";      
        $insert = $db->insert($query);
    }
    if(isset($_POST['editjobtype'])){
        //Assign Vars   
        $jobtype = mysqli_real_escape_string($db->link, $_POST['jobtype']);       
        $jobtypevieworder = mysqli_real_escape_string($db->link, $_POST['jobtypevieworder']);
        
        //Simple validation
        
        $query = "UPDATE jobtypes SET jobType = '$jobtype', jobTypeViewOrder = '$jobtypevieworder' WHERE id=".$id;      
        $update = $db->update($query);

        //update all listings with changed job type
        // $query = "UPDATE jobtypes SET jobType = '$jobtype', jobTypeViewOrder = '$jobtypevieworder' WHERE id=".$id;      
        // $update = $db->update($query);
    }
    if(isset($_POST['deletejobtype'])){
        
        $query = "DELETE FROM jobtypes WHERE id=".$id;      
        $delete = $db->delete($query);
    }
    if(isset($_POST['addlocation'])){
        //Assign Vars   
        $location = mysqli_real_escape_string($db->link, $_POST['location']);
        $locationvieworder = mysqli_real_escape_string($db->link, $_POST['locationvieworder']);
        
        //Simple validation
        
        $query = "INSERT INTO locations (location, locationViewOrder) VALUES('$location', '$locationvieworder')";      
        $insert = $db->insert($query);
    }
    if(isset($_POST['editlocation'])){
        //Assign Vars   
        $location = mysqli_real_escape_string($db->link, $_POST['location']);
        $locationvieworder = mysqli_real_escape_string($db->link, $_POST['locationvieworder']);
        
        //Simple validation
        
        $query = "UPDATE locations SET location = '$location', locationViewOrder = '$locationvieworder' WHERE id=".$id;      
        $update = $db->update($query);

        //update all listings with changed location
        // $query = "UPDATE locations SET location = '$location', locationViewOrder = '$locationvieworder' WHERE id=".$id;      
        // $update = $db->update($query);
    }
    if(isset($_POST['deletelocation'])){
        
        $query = "DELETE FROM locations WHERE id=".$id;      
        $delete = $db->delete($query);
    }
?>
<!DOCTYPE html>

<html lang="en">

<?php include 'php/reusables/head.php' ?>

<body>
    <?php include 'php/reusables/hero.php' ?>
    <div class="updateSelectorsHeading">
        <h2 class="addJob__mainHeading">Job<span>Board</span></h2>

        <h3>Add/Edit/Delete Selectors</h3>
    </div>
    <div class="updateSelectors">

        <div class="updateSelectors__selector" id="categories">
            <h4>Update Categories</h4>
            <p>SelectBox Order | Category</p>
            <form class="updateSelectors__selector--add" method="post" action="addeditselectors.php">
                <input type="text" name="categoryvieworder" placeholder="" />
                <input type="text" name="category" placeholder="Add Category" class="btn" />
                <button class="btn btn__primary" type="submit" name="addcat">Add</button>
            </form>

            <table name="category">

                <?php while($row = $categories->fetch_assoc()) : ?>
                <form method="post" action="addeditselectors.php?id=<?php echo $row['id'] ?>">
                    <div class="updateSelectors__selector--item">
                        <div class="updateSelectors__selector--item-order">
                            <input name="categoryvieworder" value="<?php echo $row['categoryViewOrder']; ?>"
                                disabled />
                            <input name="categoryvieworder" value="<?php echo $row['categoryViewOrder']; ?>"
                                hidden />
                        </div>
                        <div class="updateSelectors__selector--item-itemName">
                            <input name="category" value="<?php echo $row['category']; ?>" disabled />
                            <input name="category" id="categoryInitValue" value="<?php echo $row['category']; ?>" hidden />
                        </div>
                        <div class="updateSelectors__selector--item-saveEdit">
                            <button class="btn btn__primary" type="button" onclick="startEditSelector(this);"
                                name="editcat">Edit</button>
                        </div>
                        <div class="updateSelectors__selector--item-saveEdit">
                            <button type="button" name="deletecat" class="btn btn__danger" onclick="startEditSelector(this);">Delete</button>
                        </div>
                        <input name="oldCategory" value="<?php echo $row['category']; ?>" hidden />
                    </div>
                </form>
                <?php endwhile; ?>

            </table>
        </div>
        <hr>
        <div class="updateSelectors__selector" id="jobTypes">
            <h4>Update Job Types</h4>
            <p>SelectBox Order | Job Type</p>
            <form class="updateSelectors__selector--add" method="post" action="addeditselectors.php">
                <input type="text" name="jobtypevieworder" placeholder="" class="btn updateSelectors__selector--item-order" />
                <input type="text" name="jobtype" placeholder="Add Job Type" class="btn" />
                <button class="btn btn__primary" type="submit" name="addjobtype">Add</button>
            </form>
            <table name="jobtypes" id="">

                <?php while($row = $jobtypes->fetch_assoc()) : ?>
                <form method="post" action="addeditselectors.php?id=<?php echo $row['id'] ?>">
                    <div class="updateSelectors__selector--item">
                        <div class="updateSelectors__selector--item-order">
                            <input name="jobtypevieworder" value="<?php echo $row['jobTypeViewOrder']; ?>"
                                disabled />
                            <input name="jobtypevieworder" value="<?php echo $row['jobTypeViewOrder']; ?>"
                                hidden />
                        </div>
                        <div class="updateSelectors__selector--item-itemName">
                            <input name="jobtype" value="<?php echo $row['jobType']; ?>" disabled />
                            <input name="jobtype" value="<?php echo $row['jobType']; ?>" hidden />
                        </div>
                        <div class="updateSelectors__selector--item-saveEdit">
                            <button class="btn btn__primary" type="button" onclick="startEditSelector(this);"
                                name="editjobtype">Edit</button>
                        </div>
                        <div class="updateSelectors__selector--item-saveEdit">
                            <button type="button" name="deletejobtype" class="btn btn__danger" onclick="startEditSelector(this);">Delete</button>
                        </div>
                    </div>
                </form>
                <?php endwhile; ?>

            </table>

        </div>
        <hr>
        <div class="updateSelectors__selector" id="locations">
            <h4>Update Locations</h4>
            <p>SelectBox Order | Location</p>
            <form class="updateSelectors__selector--add" method="post" action="addeditselectors.php">
                <input type="text" name="locationvieworder" placeholder="" class="btn updateSelectors__selector--item-order" />
                <input type="text" name="location" placeholder="Add Location" class="btn" />
                <button class="btn btn__primary" type="submit" name="addlocation">Add</button>
            </form>

            

                <?php while($row = $locations->fetch_assoc()) : ?>
                <form method="post" action="addeditselectors.php?id=<?php echo $row['id'] ?>">
                    <div class="updateSelectors__selector--item">
                        <div class="updateSelectors__selector--item-order">
                            <input name="locationvieworder" value="<?php echo $row['locationViewOrder']; ?>"
                                disabled/>
                            <input name="locationvieworder" value="<?php echo $row['locationViewOrder']; ?>"
                                hidden/>
                        </div>
                        <div class="updateSelectors__selector--item-itemName">
                            <input name="location" value="<?php echo $row['location']; ?>" disabled/>
                            <input name="location" value="<?php echo $row['location']; ?>" hidden/>
                        </div>
                        <div class="updateSelectors__selector--item-saveEdit">
                            <button class="btn btn__primary" type="button" onclick="startEditSelector(this);"
                                name="editlocation">Edit</button>
                        </div>
                        <div class="updateSelectors__selector--item-saveEdit">
                            <button type="button" name="deletelocation" class="btn btn__danger" onclick="startEditSelector(this);">Delete</button>
                        </div>
                    </div>
                </form>
                <?php endwhile; ?>

          
        </div>
    </div>

    <!-- FOOTER -->
    <section>
        <?php include 'php/reusables/footer.php' ?>
    </section>

</body>

</html>