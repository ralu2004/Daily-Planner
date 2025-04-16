<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>

    <!-- Link to the TaskEdit.css stylesheet -->
    <link rel="stylesheet" href="/assets/css/TaskEdit.css">
</head>
<body>
    <div class="container">
        <?php if (isset($task)) { ?>

        <h2>Edit Task</h2>

        <form method="POST" action="/task/edit/<?= $task->id ?>">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="<?= htmlspecialchars($task->title) ?>">

            <label for="description">Description:</label>
            <textarea name="description" id="description"><?= htmlspecialchars($task->description) ?></textarea>

            <label for="due_date">Due Date:</label>
            <input type="date" name="due_date" id="due_date" value="<?= $task->due_date ?>">

            <label for="priority">Priority:</label>
            <select name="priority" id="priority">
                <option value="Low" <?= $task->priority === 'Low' ? 'selected' : '' ?>>Low</option>
                <option value="Medium" <?= $task->priority === 'Medium' ? 'selected' : '' ?>>Medium</option>
                <option value="High" <?= $task->priority === 'High' ? 'selected' : '' ?>>High</option>
            </select>

            <input type="submit" value="Save Changes">
        </form>

        <?php } else { ?>
            <p>Task not found.</p>
        <?php } ?>
    </div>
</body>
</html>
