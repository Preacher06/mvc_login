<?php
    require_once APPROOT . '/views/includes/head.php';
?>
    <div class="container">
    <?php
        require_once APPROOT . '/views/includes/navigation.php';
    ?>
        <div class="form-container">
            <h1>Register</h1>
            <form action="<?php echo URLROOT . '/users/register'; ?>" method="POST">
                <input type="text" name="username" placeholder="Username*">
                <?php if($data['usernameError']) : ?>
                    <div class="errors">
                        <?php echo $data['usernameError']; ?>
                    </div>
                <?php endif; ?>

                <input type="email" name="email" placeholder="Email*">
                <?php if($data['emailError']) : ?>
                    <div class="errors">
                        <?php echo $data['emailError']; ?>
                    </div>
                <?php endif; ?>

                <input type="password" name="password" placeholder="Password*">
                <?php if($data['passwordError']) : ?>
                    <div class="errors">
                        <?php echo $data['passwordError']; ?>
                    </div>
                <?php endif; ?>

                <input type="password" name="confirmPassword" placeholder="Confirm Password*">
                <?php if($data['confirmPasswordError']) : ?>
                    <div class="errors">
                        <?php echo $data['confirmPasswordError']; ?>
                    </div>
                <?php endif; ?>

                <button class="btn btn-wide" type="submit">Register</button>

                <p class="links">Already an User? <a href="<?php echo URLROOT . '/users/login'; ?>">Login Here!</a></p>
            </form>
        </div>
    </div>
<?php
    require_once APPROOT . '/views/includes/foot.php';
?>