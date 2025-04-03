<?php require_once __DIR__ . '/modules/header.php'; ?>
<section class='content'>
    <div class="container">
        <h2>Edit Profile</h2>

        <?php 
        // Display messages
        if (isset($_GET['success'])) {
            echo "<div class='success-msg'>" . htmlspecialchars($_GET['success']) . "</div>";
        }
        if (isset($_GET['error'])) {
            echo "<div class='error-msg'>" . htmlspecialchars($_GET['error']) . "</div>";
        }
        ?>

        <div class="form-container flexc">
            <!-- Update Profile Form -->
            <form action='profile/post' method="POST">
                <h3>Update Profile</h3>

                <label for="name">Name  <i class="fa-solid fa-pen" class="edit-icon" onclick="makeEditable('name')"></i></label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" readonly>

                <label for="email">Email  <i class="fa-solid fa-pen" class="edit-icon" onclick="makeEditable('email')"></i></label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>

                <label for="phone">Phone No   <i class="fa-solid fa-pen" class="edit-icon" onclick="makeEditable('phone')"></i></label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" readonly>

                <button type="submit">Update Profile</button>
            </form>

            <!-- Change Password Form -->
            <form action='profile/password/post' method="POST">
                <h3>Change Password</h3>

                <label for="old_password">Old Password</label>
                <input type="password" name="old_password" required>

                <label for="new_password">New Password</label>
                <input type="password" name="new_password" required>

                <label for="confirm_password">Confirm New Password</label>
                <input type="password" name="confirm_password" required>

                <button type="submit">Change Password</button>
            </form>
        </div>
    </div>
</section>
<script>
function makeEditable(fieldId) {
    document.getElementById(fieldId).removeAttribute("readonly");
    document.getElementById(fieldId).focus();
}
</script>
<?php require_once __DIR__ . '/modules/footer.php'; ?>