<?php session_start(); ?>
<?php require_once('inc/header.php'); ?>
<?php require_once('inc/navbar.php'); ?>

<div class="container-fluid pt-4">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="d-flex justify-content-between border-bottom mb-5">
                <div>
                    <h3>Create Post</h3>
                </div>
                <div>
                    <a href="index.php" class="text-decoration-none">Back</a>
                </div>
            </div>

            <div class="container w-50">
                <!-- Display Errors -->
                <?php if (!empty($_SESSION['errors'])): ?>
                <?php foreach ($_SESSION['errors'] as $error): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
                <?php endforeach; ?>
                <?php unset($_SESSION['errors']); ?>
                <?php endif; ?>

                <!-- Display Success Message -->
                <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['success']; ?>
                </div>
                <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
            </div>

            <form method="POST" action="handle/store-post.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control"
                        value="<?php if (isset($_SESSION['title'])) echo $_SESSION['title'] ?>" id="title" name="title">
                </div>
                <div class="mb-3">
                    <label for="body" class="form-label">Body</label>
                    <textarea class="form-control" id="body" name="body"
                        rows="5"><?php if (isset($_SESSION['body'])) echo $_SESSION['title'] ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </form>
        </div>
    </div>
</div>