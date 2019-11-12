<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap">
                <div class="form-header">
                    
                </div>
                
                <div class="header-button">
                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            <div class="image">
                                <img src="../assets/img/profile.jpeg" alt="John Doe" />
                            </div>
                            <div class="content">
                                <a class="js-acc-btn" href="#" style="text-transform: lowercase;"><?php echo $_SESSION["username"];?> </a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        <a href="#">
                                            <img src="../assets/img/profile.jpeg" alt="John Doe" />
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5 class="name">
                                            <a href="#" style="text-transform: lowercase;"><?php echo $_SESSION["username"];?></a>
                                        </h5>
                                    </div>
                                </div>
                                <div class="account-dropdown__footer">
                                    <a href="../registration/logout.php">
                                        <i class="zmdi zmdi-power"></i>Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>