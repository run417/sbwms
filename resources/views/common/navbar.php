<nav id="navbar" class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-light">
            <i class="fas fa-bars"></i>
            <span></span>
        </button>
        <span class="text-primary"><?php echo isset($breadcrumbMarkUp) ? $breadcrumbMarkUp : 'SBWMS'; ?></span>
        <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarExpand" aria-controls="navbarExpand" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarExpand">
            <ul class=" navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="far fa-bell"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="far fa-envelope"></i></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="no-icon"><i class="far fa-user"></i></span>

                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <?php 
                            $logoutFilePath = url_for('/public/logout.php'); 
                            $isLoggedIn = true;
                            if ($isLoggedIn) {
                                echo "<a id=\"logout\" class=\"dropdown-item\" href=\"#\">Logout</a>" ;} 
                        ?>
                        
                        <a class="dropdown-item" href="#">SBWMS</a>
                        <div class="divider"></div>
                        <a class="dropdown-item" href="#">SBWMS</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>