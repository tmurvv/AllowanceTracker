<div class="hero" id='home'>
    <img class="hero__logo" src="img/logoAllowance.gif" alt="Tech Logo">
    <ul class="hero__mainNav js--mainNav">
        <li class="hero__mainNav--item">
            <a href="index.php">Home</a>
        </li>
        <?php if(isset($_SESSION['id'])) : ?>

            <li class="hero__mainNav--item">
                <a href="addEditPiggyBanks.php">Add/Edit PiggyBanks</a>
            </li>
            <li class="hero__mainNav--item">
                <a href="profile.php">View Profile</a>
            </li>
            <li class="hero__mainNav--item">
                <a href="logout.php">Logout</a>
            </li>
        <?php else : ?>
            <li class="hero__mainNav--item">
                <a href="index.php#about">About</a>
            </li>
            <li class="hero__mainNav--item">
                <a href="login.php">Login</a>
            </li>
            <li class="hero__mainNav--item">
                <a href="signup.php">Signup</a>
            </li>
        <?php endif; ?>
    </ul>
    <a class="hero__hamburger js--mainNav-icon"><i class="fas fa-bars"></i></a>
    
    <div class="hero__mainTitle">

        <h1 class="hero__mainTitle--mainHeading">
            <?php if(isset($_SESSION['piggyBankOwner']) && $_SESSION['piggyBankOwner']!="") : ?>
                <?php echo $_SESSION['piggyBankOwner'] ?>'s PiggyBank
            <?php else : ?>
                It's Your PiggyBank!
            <?php endif; ?>
        </h1>
        <h2 class="hero__mainTitle--subHeading">
            More <span>PIGGY</span> please!
        </h2>
    </div>
</div>