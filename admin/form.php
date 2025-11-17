<form action="insert-discipline.php" method="POST">
    <input type="hidden" name="staff_id" value="123"> <!-- Set this dynamically -->

    <label>Offense Type:</label>
    <input type="text" name="offense_type" required><br>

    <label>Description:</label>
    <textarea name="description" required></textarea><br>

    <label>Date Reported:</label>
    <input type="date" name="date_reported" required><br>

    <label>Action Taken:</label>
    <textarea name="action_taken"></textarea><br>

    <label>Status:</label>
    <select name="status">
        <option value="Pending">Pending</option>
        <option value="Resolved">Resolved</option>
    </select><br>

    <input type="submit" name="save_discipline" value="Save Record">
</form>
