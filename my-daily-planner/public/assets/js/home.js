document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.delete-task').forEach(button => {
        button.addEventListener('click', async (e) => {
            const taskId = e.target.getAttribute('data-task-id');
            console.log('Deleting task with ID:', taskId);  // Log the task ID for debugging
           
            if (confirm('Are you sure you want to delete this task?')) {
                try {
                    // Send request to the correct server endpoint
                    const response = await fetch('/delete-task', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ id: taskId }),
                    });

                    const responseData = await response.json();  // Parse JSON response
                    console.log('Response from server:', responseData);  // Log the response

                    if (response.ok && responseData.status === 'success') {
                        // Remove task from DOM after successful deletion
                        const taskElement = document.getElementById(`task-${taskId}`);
                        if (taskElement) {
                            taskElement.remove();  // Remove task from DOM
                        }
                    } else {
                        alert('Failed to delete task: ' + responseData.message);
                    }
                } catch (error) {
                    console.error('Error deleting task:', error);
                    alert('Error deleting task. Please try again.');
                }
            }
        });
    });
});
