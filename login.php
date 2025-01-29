<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/header.php'); ?>
<?php require_once('inc/navbar.php'); ?>

<div class="container-fluid pt-4">
    <div class="row">

        <div class="col-md-6 offset-md-3">
            <div class="d-flex justify-content-between border-bottom mb-5">
                <div>
                    <h3>Login</h3>
                </div>
                <div>
                    <a href="index.php" class="text-decoration-none">Back</a>
                </div>
            </div>

            <?php if (!empty($_SESSION['errors'])): ?>
            <?php foreach ($_SESSION['errors'] as $error): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>


            <form method="POST" action="handle/handle-login.php">

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Login</button>
            </form>
        </div>
    </div>
</div>