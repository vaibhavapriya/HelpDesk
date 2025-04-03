<?php require_once __DIR__ . '/modules/header.php';?>

<section class='content'>
    <div class="container">
        <h1>My Tickets</h1>
        <?php if (count($tickets) > 0): ?>  <!--($results->num_rows > 0) -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Error Message</th>
                        <th>Error File</th>
                        <th>Error Line</th> 
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $row): ?>
                        <tr>
                            <td>#<?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['error_message']); ?></td>
                            <td><?php echo htmlspecialchars($row['error_file']); ?></td> 
                            <td><?php echo htmlspecialchars($row['error_line']); ?></td> 
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
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