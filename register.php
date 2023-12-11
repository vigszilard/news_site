<?php
    include "classes/Database.php";
    include "classes/Role.php";

    $database = new Database();
    $role = new Role($database);
    $all_roles = $role -> get_all_roles();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-b8PDDdPBdlHH38LY47D3l9pL+g0TCrxI3RxXUE1V8zIfoPKge+PnNQhT9CGCDaLR" crossorigin="anonymous">
        <link rel="stylesheet" href="css/styles.css">
        <base href="http://localhost:63342/newspaper/">
        <title>Newspaper | Register</title>
    </head>

    <body>

        <?php include "includes/header.php"; ?>
        <?php include "includes/error_toast.php"; ?>

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">User Registration</h5>
                        </div>
                        <div class="card-body">
                            <form action="scripts/process_registration.php" method="post">
                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-form-label">Email:</label>
                                    <div class="col-sm-9">
                                        <input id="email" type="email" class="form-control" name="email" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-sm-3 col-form-label">Password:</label>
                                    <div class="col-sm-9">
                                        <input id="password" type="password" class="form-control" name="password" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="firstname" class="col-sm-3 col-form-label">First Name:</label>
                                    <div class="col-sm-9">
                                        <input id="firstname" type="text" class="form-control" name="firstname" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="lastname" class="col-sm-3 col-form-label">Last Name:</label>
                                    <div class="col-sm-9">
                                        <input id="lastname" type="text" class="form-control" name="lastname" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="role_id" class="col-sm-3 col-form-label">Role:</label>
                                    <div class="col-sm-9">
                                        <select id="role_id" class="form-control" name="role_id">
                                            <?php foreach ($all_roles as $role): ?>
                                                <option value="<?php echo $role['id']; ?>">
                                                    <?php echo $role['name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include "includes/footer.php"; ?>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="js/script.js"></script>
    </body>

</html>
