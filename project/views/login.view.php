<?php require_once __DIR__ . '/modules/header.php'; ?>
    <main class='content'>
        <div class=container>
        <?php 
        // Display error messages from GET parameters
        if (isset($_GET['error'])) {
            echo "<div class='error-msg'>" . htmlspecialchars($_GET['error']) . "</div>";
        }
        if (isset($_GET['success'])) {
            echo "<div class='success-msg'>" . htmlspecialchars($_GET['success']) . "</div>";
        }
        ?>

            <div class='icons flexc'>
                <!-- login and home pagr -->
            <!-- login and home pagr -->
                <a href="register">
                <div><i class="fa-regular fa-pen-to-square icon-large"></i></div>
                <div>Register</div>
                </a>
                <a href="newTicket">
                <div><i class="fa-solid fa-rectangle-list icon-large"></i></div>
                <div>Submit ticket</div>
                </a>
                <a href="myTickets">
                <div><i class="fa-regular fa-newspaper icon-large"></i></i></div>
                <div>My Ticket</div>
                </a>
                <a href="knowledgeBase">
                <div><i class="fa-solid fa-lightbulb icon-large"></i></div>
                <div>Knowledge Base</div>
                </a>
            </div>
            <div>
                <form action="login/post" method='post' >
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" >
                        <span class="error-text"><?php echo $_GET['email_error'] ?? ''; ?></span>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" >
                        <span class="error-text"><?php echo $_GET['password_error'] ?? ''; ?></span>
                    </div>
                    <button type="submit">Login</button>

                </form>
                <a href="forgotPassword"><div>Forgot Password ?</div></a>
            </div>
        </div>
    </main>
<?php require_once __DIR__ . '/modules/footer.php'; ?>