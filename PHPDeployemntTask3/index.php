<?php
session_start();

// Initialize the task list if it doesn't exist
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_task']) && !empty($_POST['task'])) {
        $task = [
            'name' => $_POST['task'],
            'completed' => false
        ];
        $_SESSION['tasks'][] = $task;
    } elseif (isset($_POST['complete_task'])) {
        $taskIndex = $_POST['complete_task'];
        if (isset($_SESSION['tasks'][$taskIndex])) {
            $_SESSION['tasks'][$taskIndex]['completed'] = true;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Task List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        .completed {
            text-decoration: line-through;
            color: #888;
        }
    </style>
</head>
<body>
    <h1>Simple Task List</h1>
    
    <form method="post">
        <input type="text" name="task" placeholder="Enter a new task" required>
        <button type="submit" name="add_task">Add Task</button>
    </form>

    <h2>Tasks:</h2>
    <ul>
        <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
            <li>
                <?php if ($task['completed']): ?>
                    <span class="completed"><?php echo htmlspecialchars($task['name']); ?></span>
                <?php else: ?>
                    <?php echo htmlspecialchars($task['name']); ?>
                    <form method="post" style="display: inline;">
                        <button type="submit" name="complete_task" value="<?php echo $index; ?>">Complete</button>
                    </form>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>