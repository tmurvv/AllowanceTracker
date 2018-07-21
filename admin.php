<?php include 'php/config/config.php'; ?>
<?php include 'php/classes/Database.php'; ?>
<?php include 'php/helpers/controllers.php'; ?>
<?php include 'php/helpers/formatting.php'; ?>
<?php
    //Get message
    $msg = $_GET['msg'];
    // if($msg) {
    // header("Location: addeditselectors.php");
    // }
    $msg = completeMsg($msg);

  //Create DB Object
  $db = new Database();
  $categorySearchID = $_GET['category'];
  if(!$categorySearchID){
      $categorySearchID = "empty";
  }
  $jobtypeSearchID = $_GET['jobtype'];
  if (!$jobtypeSearchID){
      $jobtypeSearchID = "empty";
  }
  $locationSearchID = $_GET['location'];
  if (!$locationSearchID){
      $locationSearchID = "empty";
  }
  //Create Query
  $query = createQuery($categorySearchID, $jobtypeSearchID, $locationSearchID);

  //Run Query
  $listings = $db->select($query);
?>
    <!-- Create Selector Queries -->
    <?php include 'php/reusables/selectorQueries.php'; ?>

    <!DOCTYPE html>

    <html lang="en">

    <?php include 'php/reusables/head.php' ?>

    <body>
    <?php include 'php/reusables/hero.php' ?>

        <div class="menus">
            <div class="menus__addNav">
                <ul class="menus__addNav--container">
                    <li class="menus__addNav--container-item">
                        <a href="add.php">Add Job Listing</a>
                    </li>
                    <li class="menus__addNav--container-item">
                        <a href="addeditselectors.php">Update Categories</a>
                    </li>
                    <li class="menus__addNav--container-item">
                        <a href="addeditselectors.php#jobTypes">Update Job Types</a>
                    </li>
                    <li class="menus__addNav--container-item">
                        <a href="addeditselectors.php#locations">Update Locations</a>
                    </li>
                </ul>
            </div>
            <div class="search__form">
                <div class="search__form--title">
                    <h2>Search</h2>
                </div>
                <div class="search__form--selectBoxes">
                    <form action="admin.php?this.options[this.selectedIndex].value" id="main" name="main" method="get">
                        <?php include 'php/reusables/selectors.php' ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="mainBoard" id="jobs">
            <?php 
            if ($msg) {
                echo "<div class='admin__messageBox'>".$msg."</div>";
            } ?>
            <h1>Job<span>Board</span>
            </h1>
            <h3>Admin Page</h3>
            <div class="listings">
                <?php if($listings) : ?>
                <?php while($row = $listings->fetch_assoc()) : ?>
                <div class="listings__job">
                    <div class="listings__job--type">
                        <p class="btn btn__secondary">
                            <?php echo $row['jobtype'] ?>
                        </p>
                    </div>
                    <div class="listings__job--info">
                        <div class="listings__job--info-line1">
                            <h2>
                                <?php echo $row['title'] ?>
                                <?php echo $row['location'] ?>
                            </h2>
                        </div>
                        <div class="listings__job--info-line2">


                            <?php echo $row['category'] ?>

                            <div class="listings__job--info-line2-datePosted">
                                <?php echo $row['dateposted'] ?>
                            </div>
                        </div>
                        <div class="admin__editDelete">
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="admin__editDelete--edit btn btn__primary">Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="admin__editDelete--delete btn btn__danger">Delete</a>
                        </div>

                        <br>
                        <div class="listings__job--info-description">
                            <?php echo $row['description'] ?>
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
        </div>

          <!-- FOOTER -->

    <section>
        <?php include 'php/reusables/footer.php' ?>
    </section>

    </body>

    </html>