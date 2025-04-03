<?php require_once __DIR__ . '/modules/header.php'; 
$token=$_GET['token']?>
<section class='content'>
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
                <div>register</div>
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
                <h1>Reset Password</h1>
                <form action="resetPassword/post" method='post' >
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your registered email" >
                        <span class="error-text"><?php echo $_GET['email_error'] ?? ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" >
                        <span class="error-text"><?php echo $_GET['password_error'] ?? ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password1">Confirm Password</label>
                        <input type="password" id="password1" name="password1" placeholder="Re-enter your password" >
                    </div>

                    <button type="submit">Send Token</button>

                </form>
                <a href="forgotPassword.php"><div>Forgot Password ?</div></a>
            </div>
        </div>
    </section>
<?php require_once __DIR__ . '/modules/footer.php'; ?>