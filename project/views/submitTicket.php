<?php require __DIR__ . '/modules/header.php'; ?>

<section class='content'>
    <div class='container'>
        <?php 
        if (isset($_GET['error'])) {
            echo "<div class='error-msg'>" . htmlspecialchars($_GET['error']) . "</div>";
        }
        if (isset($_GET['success'])) {
            echo "<div class='success-msg'>" . htmlspecialchars($_GET['success']) . "</div>";
        }
        ?>
        <h1>Submit Ticket</h1>
        <form action='newTicket/post' method="POST" enctype="multipart/form-data">
            <input type="hidden" name="requester_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>"> 
            <div class="form-group1" >
                <label for="requester_input">Requester</label>
                <div id="requester_display" class="inputdupe" aria-labelledby="requester_label">
                    <?php echo htmlspecialchars($dbEmail); ?>
                </div> 
                <!-- Correct label reference -->
                <input type="hidden" id="requester_input" name="requester" value="<?php echo htmlspecialchars($dbEmail); ?>"> 
                <span class="error-text"><?php echo $_GET['email_error'] ?? ''; ?></span>
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" required>
            </div>
            <div class="form-group">
                <label for="priority">Priority</label>
                <select id="priority" name="priority" required>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>
            </div>
            <div class="form-group">
                <label for="topic">Topic</label>
                <input type="text" id="topic" name="topic" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="attachment">Attachment</label>
                <input type="file" id="attachment" name="attachment" accept="image/*">
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</section>

<?php require __DIR__ . '/modules/footer.php'; ?>
