<?php require __DIR__ . '/modules/header.php'; ?>
<section class='content'>
    <div class='container'>
        <?php 
        // Display messages
        if (isset($_GET['error'])) {
            echo "<div class='error-msg'>" . htmlspecialchars($_GET['error']) . "</div>";
        }
        if (isset($_GET['success'])) {
            echo "<div class='success-msg'>" . htmlspecialchars($_GET['success']) . "</div>";
        }
        ?>
        
        <div class='container'>
            <div>
                <h1>Submit Ticket</h1>
                <form id="myForm" action="adminTicket/post" method="POST">
                <div class="form-group1">
                    <label for="requester">Requester</label>
                    <select id="requester" name="requester" required>
                        <option value="">Select a user</option>
                        <?php
                        // Fetch users and display email in the dropdown
                        $result = $conn->query("SELECT userid, email FROM user ORDER BY email ASC");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='".htmlspecialchars($row['email'])."' data-userid='".htmlspecialchars($row['userid'])."'>"
                                .htmlspecialchars($row['email'])."</option>";
                        }
                        ?>
                    </select>
                    <span class="error-text"><?php echo $_GET['email_error'] ?? ''; ?></span>
                </div>

                <!-- Hidden Input for Requester ID -->
                <input type="hidden" id="requester_id" name="requester_id" required>
                    <!-- Subject -->
                    <div class="form-group1" id="q1">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" placeholder="Enter subject">
                        <span class="error-text"><?php echo $_GET['subject_error'] ?? ''; ?></span>
                    </div>

                    <!-- Priority -->
                    <div class="form-group1" id="q2">
                        <label for="priority">Priority</label>
                        <select id="priority" name="priority">
                            <option value="">Select Priority</option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                        <span class="error-text"><?php echo $_GET['priority_error'] ?? ''; ?></span>
                    </div>

                    <!-- Topic -->
                    <div class="form-group1" id="q3">
                        <label for="topic">Topic</label>
                        <input type="text" id="topic" name="topic" placeholder="Enter topic">
                        <span class="error-text"><?php echo $_GET['topic_error'] ?? ''; ?></span>
                    </div>

                    <!-- Description -->
                    <div class="form-group1" id="q4">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" placeholder="Enter description"></textarea>
                        <span class="error-text"><?php echo $_GET['description_error'] ?? ''; ?></span>
                    </div>

                    <button type="submit">Submit</button>
                </form>
            </div>

            <div>
                <h1>Ticket Summary</h1>
                <a><div>Open tickets</div></a>
                <a><div>Closed tickets</div></a>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById("requester").addEventListener("change", function() {
    let selectedOption = this.options[this.selectedIndex]; 
    let email = selectedOption.value;
    let userId = selectedOption.getAttribute("data-userid");

    document.getElementById("requester_id").value = userId; // Store user ID
});

</script>
<?php require __DIR__ . '/modules/footer.php'; ?>