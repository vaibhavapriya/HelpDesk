<?php require_once __DIR__ . '/modules/header.php'; ?>
<main class='content'>
    <div class="container">
        <?php 
        // Display error messages from GET parameters
        if (isset($_GET['error'])) {
            echo "<div class='error-msg'>" . htmlspecialchars($_GET['error']) . "</div>";
        }
        if (isset($_GET['success'])) {
            echo "<div class='success-msg'>" . htmlspecialchars($_GET['success']) . "</div>";
        }
        ?>

        <form action="register/post" method="POST" id="registerForm">
            <!-- Username -->
            <div class="form-group">
                <label for="user">Username</label>
                <input type="text" id="user" name="user" placeholder="Enter your username" >
                <span class="error-text"><?php echo $_GET['user_error'] ?? ''; ?></span>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" >
                <span class="error-text"><?php echo $_GET['email_error'] ?? ''; ?></span>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" >
                <span class="error-text"><?php echo $_GET['password_error'] ?? ''; ?></span>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password1">Confirm Password</label>
                <input type="password" id="password1" name="password1" placeholder="Re-enter your password" >
            </div>

            <button type="submit">Register</button>
        </form>

        <a href="login">Go to Login Page</a>
    </div>
</main>
<?php require_once __DIR__ . '/modules/footer.php'; ?>