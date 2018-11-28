<div class="hero" id='home'>
    <img class="hero__logo" src="img/logoAllowance.gif" alt="Tech Logo">
    <ul class="hero__mainNav" id="js--mainNav">
        <li class="hero__mainNav--item">
            <a href="index.php">Home</a>
        </li>
        <li class="hero__mainNav--item">
            <a href="signup.php">Signup</a>
        </li>
        <?php if(isset($_SESSION['id']) && !$_SESSION['id'] == '') : ?>

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
        <?php endif; ?>
    </ul>
    <a href="javascript:void(0);" class="hero__hamburger" id="js--mobileIconContainer" onclick="mobileNav();"><i class="fas fa-bars" id="js--mobileNavIcon"></i></a>
    <script>
    window.addEventListener('resize', checkScreenWidth);
    function checkScreenWidth() {
        var mainNav = document.getElementById('js--mainNav');
        var mobileIcon = document.getElementById('js--mobileNavIcon');
        var mobileIconContainer = document.getElementById('js--mobileIconContainer');
        
        if (window.innerWidth > 900) {
            mainNav.style.display="flex";
            mobileIcon.classList.add("fa-bars");
            mobileIcon.classList.remove("fa-window-close");
        }else{
            if (mobileIcon.classList.contains('fa-bars')) {
                mainNav.style.display="none";
            } else {
                mainNav.style.display="block";
            }
        }
    }
    </script>
    <div class="hero__mainTitle">

        <h1 class="hero__mainTitle--mainHeading">
            <?php if(isset($_SESSION['piggyBankOwner']) && $_SESSION['piggyBankOwner']!="") : ?>
                <?php echo $_SESSION['piggyBankOwner'] ?>'s Virtual PiggyBank
            <?php else : ?>
                It's Your Virtual PiggyBank!
            <?php endif; ?>
        </h1>
        <h2 class="hero__mainTitle--subHeading">
            More <span>PIGGY</span> please!
        </h2>
    </div>
</div>