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
            <?php if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) { ?>
            <a href='register'>
            <div><i class="fa-regular fa-pen-to-square icon-large"></i></div>
            <div>Register</div>
            </a>
            <?php } ?>
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
        </div>
        <div>
            <!-- all pages only for users if admin logs in different page  -->
        </div>
        </main>
<?php require_once __DIR__ . '/modules/footer.php'; ?>