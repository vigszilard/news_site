<div id="header-container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="../index.php">
            <img src="../logo.png" height="50" alt="Logo">
        </a>

        <div class="ml-auto d-flex align-items-center">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?php if (!isset($_SESSION['user'])): ?>
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
                                <button type="button" class="btn btn-success">
                                    <i class="fas fa-user-plus"></i>
                                    Register
                                </button>
                            </a>
                            <a class="nav-link d-inline-block d-md-none" href="register.php">
                                <i class="fas fa-user-plus"></i>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="scripts/process_logout.php">
                                <button type="button" class="btn btn-danger">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Logout
                                </button>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</div>
