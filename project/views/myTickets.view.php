<?php require_once __DIR__ . '/modules/header.php';?>

<section class='content'>
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
        <h1>My Tickets</h1>
        <?php if (count($tickets) > 0): ?>  <!--($results->num_rows > 0) -->
            <table>
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>Subject</th>
                        <!-- <th>Requester</th> -->
                        <th>Last Replier</th>
                        <th>Status</th>
                        <th>Last Activity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $row): ?>  <!-- Use foreach instead of while -->
                        <tr>
                            <td>#<?php echo htmlspecialchars($row['id']); ?></td>
                            <td><a href="clientTicket?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['subject']); ?></a></td>
                            <!-- <td><?//php echo htmlspecialchars($row['requester']); ?></td> -->
                            <td><?php echo htmlspecialchars($row['last_replier']?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td><?php echo htmlspecialchars($row['last_activity']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No tickets found.</p>
        <?php endif; ?>
    </div>
</section>

<?php
$stmt->close();
$conn->close();
require_once __DIR__ . '/modules/footer.php'; ?>
?>
