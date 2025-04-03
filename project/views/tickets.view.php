<?php require_once __DIR__ . '/modules/header.php';?>

<section class='content'>
    <div class="container">
        <h1>Tickets</h1>
        <?php if (count($tickets) > 0): ?>  <!--($results->num_rows > 0) -->
            <table>
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>Subject</th>
                        <th>Priority</th>
                        <th>Requester Name</th> <!-- New column for requester name -->
                        <th>Requester Phone</th> <!-- New column for requester phone -->
                        <th>Last Replier</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $row): ?>
                        <tr>
                            <td>#<?php echo htmlspecialchars($row['ticket_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['subject']); ?></td>
                            <td><?php echo htmlspecialchars($row['priority'] ?? 'N/A'); ?></td> 
                            <td><?php echo htmlspecialchars($row['requester_name'] ?? 'N/A'); ?></td> <!-- Requester name -->
                            <td><?php echo htmlspecialchars($row['requester_phone'] ?? 'N/A'); ?></td> <!-- Requester phone -->
                            <td><?php echo htmlspecialchars($row['last_replier'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
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