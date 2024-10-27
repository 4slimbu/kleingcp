<?php

// Connect to the database
$db = dbConnect();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

// Prepare the SQL statement to retrieve data
$stmt = $db->prepare("SELECT * FROM profiles");
$stmt->execute();

// Fetch all records
$profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-7">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Priority</th>
                        <th>Name</th>
                        <th>Link</th>
                        <th>Bell</th>
                        <th>Status</th>
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
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-3">
            <form method="POST" action="">
                <div class="form-group mb-2">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>
                <div class="form-group mb-2">
                    <label for="link">Link</label>
                    <input type="url" class="form-control" name="link" id="link" required>
                </div>
                <div class="form-group mb-2">
                    <label for="priority">Priority</label>
                    <select class="form-control" name="priority" id="priority" required>
                        <option value="daily">Daily</option>
                        <option value="intermittent">Intermittent</option>
                        <option value="random">Random</option>
                        <option value="testing">Testing</option>
                        <option value="celebrity">Celebrity</option>
                    </select>
                </div>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="bell" name="bell">
                    <label class="form-check-label" for="bell">Bell Notification</label>
                </div>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="status" name="status">
                    <label class="form-check-label" for="status">Active Status</label>
                </div>
                <div class="form-group mb-2">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="/" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
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
