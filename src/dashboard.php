<?php

// Connect to the database
$db = dbConnect();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        // Handle delete action
        $id = intval($_POST['delete']);
        $stmt = $db->prepare("DELETE FROM profiles WHERE id = ?");
        $stmt->execute([$id]);
    } elseif (isset($_POST['edit'])) {
        // Handle edit action
        $id = intval($_POST['edit']);
        $stmt = $db->prepare("SELECT * FROM profiles WHERE id = ?");
        $stmt->execute([$id]);
        $profileToEdit = $stmt->fetch(PDO::FETCH_ASSOC);
    } elseif (isset($_POST['update']) && $_POST['update'] != '') {
        // Handle update action
        $id = intval($_POST['update']);
        $priority = htmlspecialchars($_POST['priority']);
        $name = htmlspecialchars($_POST['name']);
        $link = htmlspecialchars($_POST['link']);
        $bell = isset($_POST['bell']) ? 1 : 0; // Convert to 1 or 0
        $status = isset($_POST['status']) ? 1 : 0; // Convert to 1 or 0

        // Prepare the SQL statement to update data
        $stmt = $db->prepare("UPDATE profiles SET priority = ?, name = ?, link = ?, bell = ?, status = ? WHERE id = ?");
        // Execute the prepared statement
        $stmt->execute([$priority, $name, $link, $bell, $status, $id]);
    } else {
        // Sanitize and store the submitted data
        $priority = htmlspecialchars($_POST['priority']);
        $name = htmlspecialchars($_POST['name']);
        $link = htmlspecialchars($_POST['link']);
        $bell = isset($_POST['bell']) ? 1 : 0; // Convert to 1 or 0
        $status = isset($_POST['status']) ? 1 : 0; // Convert to 1 or 0

        // Prepare the SQL statement to insert data
        $stmt = $db->prepare("INSERT INTO profiles (priority, name, link, bell, status) VALUES (?, ?, ?, ?, ?)");
        // Execute the prepared statement
        $stmt->execute([$priority, $name, $link, $bell, $status]);
    }
}

// Prepare the SQL statement to retrieve data
$stmt = $db->prepare("SELECT * FROM profiles");
$stmt->execute();

// Fetch all records
$profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <div class="row justify-content-between">
        <div class="col-8">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Priority</th>
                        <th>Name</th>
                        <th>Link</th>
                        <th>Bell</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($profiles as $profile): ?>
                        <tr>
                            <td>
                                <select class="form-control">
                                    <option value="daily" <?php echo ($profile['priority'] == 'daily') ? 'selected' : ''; ?>>Daily</option>
                                    <option value="intermittent" <?php echo ($profile['priority'] == 'intermittent') ? 'selected' : ''; ?>>Intermittent</option>
                                    <option value="random" <?php echo ($profile['priority'] == 'random') ? 'selected' : ''; ?>>Random</option>
                                    <option value="testing" <?php echo ($profile['priority'] == 'testing') ? 'selected' : ''; ?>>Testing</option>
                                    <option value="celebrity" <?php echo ($profile['priority'] == 'celebrity') ? 'selected' : ''; ?>>Celebrity</option>
                                </select>
                            </td>
                            <td><?php echo htmlspecialchars($profile['name']); ?></td>
                            <td><a href="<?php echo htmlspecialchars($profile['link']); ?>" target="_blank">Profile</a></td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="bellSwitch<?php echo $profile['id']; ?>" <?php echo $profile['bell'] ? 'checked' : ''; ?>>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="statusSwitch<?php echo $profile['id']; ?>" <?php echo $profile['status'] ? 'checked' : ''; ?>>
                                </div>
                            </td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="populateEditForm(<?php echo $profile['id']; ?>, '<?php echo htmlspecialchars($profile['name']); ?>', '<?php echo htmlspecialchars($profile['link']); ?>', '<?php echo htmlspecialchars($profile['priority']); ?>', <?php echo $profile['bell']; ?>, <?php echo $profile['status']; ?>)">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $profile['id']; ?>)">Delete</button>
                                    <input type="hidden" name="delete" value="<?php echo $profile['id']; ?>">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-3">
            <form method="POST" action="">
                <div class="form-group mb-2">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="<?php echo isset($profileToEdit) ? htmlspecialchars($profileToEdit['name']) : ''; ?>" required>
                </div>
                <div class="form-group mb-2">
                    <label for="link">Link</label>
                    <input type="url" class="form-control" name="link" id="link" value="<?php echo isset($profileToEdit) ? htmlspecialchars($profileToEdit['link']) : ''; ?>" required>
                </div>
                <div class="form-group mb-2">
                    <label for="priority">Priority</label>
                    <select class="form-control" name="priority" id="priority" required>
                        <option value="daily" <?php echo (isset($profileToEdit) && $profileToEdit['priority'] == 'daily') ? 'selected' : ''; ?>>Daily</option>
                        <option value="intermittent" <?php echo (isset($profileToEdit) && $profileToEdit['priority'] == 'intermittent') ? 'selected' : ''; ?>>Intermittent</option>
                        <option value="random" <?php echo (isset($profileToEdit) && $profileToEdit['priority'] == 'random') ? 'selected' : ''; ?>>Random</option>
                        <option value="testing" <?php echo (isset($profileToEdit) && $profileToEdit['priority'] == 'testing') ? 'selected' : ''; ?>>Testing</option>
                        <option value="celebrity" <?php echo (isset($profileToEdit) && $profileToEdit['priority'] == 'celebrity') ? 'selected' : ''; ?>>Celebrity</option>
                    </select>
                </div>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="bell" name="bell" <?php echo (isset($profileToEdit) && $profileToEdit['bell']) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="bell">Bell Notification</label>
                </div>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" <?php echo (isset($profileToEdit) && $profileToEdit['status']) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="status">Active Status</label>
                </div>
                <div class="form-group mb-2">
                    <button type="submit" class="btn btn-primary" name="update" value="<?php echo isset($profileToEdit) ? htmlspecialchars($profileToEdit['id']) : ''; ?>"><?php echo isset($profileToEdit) ? 'Update' : 'Save' ?></button>
                    <a href="/" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this profile?')) {
            const form = document.querySelector(`form input[value="${id}"]`).closest('form');
            form.submit();
        }
    }

    function populateEditForm(id, name, link, priority, bell, status) {
        document.getElementById('name').value = name;
        document.getElementById('link').value = link;
        document.getElementById('priority').value = priority;
        document.getElementById('bell').checked = bell;
        document.getElementById('status').checked = status;

        // Set the update button value to the id of the profile being edited
        document.querySelector('button[name="update"]').value = id;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const switches = document.querySelectorAll('.form-check-input');

        switches.forEach(switchElement => {
            switchElement.addEventListener('change', function() {
                // Just check or uncheck the input
                console.log(`Checkbox for "${this.dataset.setting}" is now ${this.checked ? 'checked' : 'unchecked'}.`);
            });
        });
    });
</script>
