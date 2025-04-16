document.addEventListener('DOMContentLoaded', function () {
    const logoutButton = document.getElementById('logout-button');
    if (logoutButton) {
        logoutButton.addEventListener('click', async function () {
            try {
                const response = await fetch('/logout', { method: 'POST' });
                const result = await response.json();

                if (result.success) {
                    console.log(result.message);
                    window.location.href = '/'; // Redirect to homepage
                } else {
                    console.error('Logout failed:', result.message);
                }
            } catch (error) {
                console.error('An unexpected error occurred:', error);
            }
        });
    }
});
