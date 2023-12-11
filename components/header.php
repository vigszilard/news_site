<div id="header-container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">
            <img src="../logo.png" height="50" alt="Logo">
        </a>
        <div class="ml-auto d-flex align-items-center">
            <?php if (!isset($_SESSION["user"])): ?>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link d-none d-md-inline-block" href="login.php">
                                <button type="button" class="btn btn-primary">
                                    <i class="fas fa-user"></i>
                                    Log in
                                </button>
                            </a>
                            <a class="nav-link d-inline-block d-md-none" href="login.php">
                                <i class="fas fa-user"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-none d-md-inline-block" href="register.php">
                                <button type="button" class="btn btn-primary">
                                    <i class="fas fa-user-plus"></i>
                                    Register
                                </button>
                            </a>
                            <a class="nav-link d-inline-block d-md-none" href="register.php">
                                <i class="fas fa-user-plus"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="ml-auto d-flex align-items-center">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">
                                    Articles
                                </a>
                            </li>
                            <?php if ($_SESSION["user"]["role_id"] == 2 || $_SESSION["user"]["role_id"] == 3): // Writer or Editor ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="dashboard.php">
                                        Dashboard
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>

                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="scripts/process_logout.php">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Log out
                                    </button>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </nav>
</div>
