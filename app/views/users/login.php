<?php
    require_once APPROOT . '/views/includes/head.php';
?>
    <div class="container">
    <?php
        require_once APPROOT . '/views/includes/navigation.php';
    ?>
        <div class="form-container">
            <h1>Login</h1>
            <form action="<?php echo URLROOT . '/users/login'; ?>" method="POST">
                <input type="text" name="username" placeholder="Username*">
                <?php if($data['usernameError']) : ?>
                    <div class="errors">
                        <?php echo $data['usernameError']; ?>
                    </div>
                <?php endif; ?>

                <input type="password" name="password" placeholder="Password*">
                <?php if($data['passwordError']) : ?>
                    <div class="errors">
                        <?php echo $data['passwordError']; ?>
                    </div>
                <?php endif; ?>

                <button class="btn btn-wide" type="submit">Login</button>

                <p class="links">New User? <a href="<?php echo URLROOT . '/users/register'; ?>">Register Here!</a></p>
            </form>
        </div>
    </div>
<?php
    require_once APPROOT . '/views/includes/foot.php';
?>