<?php include 'header.php'; ?>
<div class="container-fluid1">
 <form class="form-signin" action="login.php" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="input-block-level" placeholder="Email address" name="username">
        <input type="password" class="input-block-level" placeholder="Password" name="password">
        <p class="text-error"><?php echo $redirect ?></p>
        <button class="btn btn-large btn-primary" type="submit" name="login" value="1">Sign in</button>
    </form>
</div>
<?php include 'footer.php'; ?>