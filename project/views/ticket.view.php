<?php require_once __DIR__ . '/modules/header.php'; ?>

<section class='content'>
    <div class="container">
        <h1>Ticket Details</h1>
        <?php 
        // Display error messages from GET parameters
        if (isset($_GET['error'])) {
            echo "<div class='error-msg'>" . htmlspecialchars($_GET['error']) . "</div>";
        }
        if (isset($_GET['success'])) {
            echo "<div class='success-msg'>" . htmlspecialchars($_GET['success']) . "</div>";
        }
        ?>

        <table>
            <tr><th>Ticket ID</th><td>#<?php echo htmlspecialchars($ticket['id']); ?></td></tr>
            <tr><th>Subject</th><td><?php echo htmlspecialchars($ticket['subject']); ?></td></tr>
            <tr><th>Message</th><td><?php echo nl2br(htmlspecialchars($ticket['description'])); ?></td></tr>
            <tr><th>Last Replier</th><td><?php echo htmlspecialchars($ticket['last_replier'] ?? 'N/A'); ?></td></tr>
            <tr><th>Status</th><td><?php echo htmlspecialchars($ticket['status']); ?></td></tr>
            <tr><th>Last Activity</th><td><?php echo htmlspecialchars($ticket['last_activity']); ?></td></tr>
        </table>
        <h3>Attachment:</h3>
            <img src="/project/image.php?id=<?php echo htmlspecialchars($ticket['id']); ?>" 
                alt="Ticket Attachment" style="max-width: 400px; height: auto;">

        <!-- <?php if (!empty($ticket['attachment'])): ?> -->
            
        <?php else: ?>
            <p>No attachment available.</p>
        <?php endif; ?>


        <a href="/project/myTickets" class="btn">Back to My Tickets</a>
    </div>
</section>

<?php require_once __DIR__ . '/modules/footer.php'; ?>
