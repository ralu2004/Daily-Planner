document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('forgot-password-form');

    form.addEventListener('submit', async (e) => {
        e.preventDefault(); 
        
        const formData = new FormData(form);

        try {
            const response = await fetch('/reset-password', {
                method: 'POST',
                body: formData
            });

            const result = await response.json(); 

            if (result.success) {
                console.log(`Success: ${result.message}`);
                alert(result.message);
                window.location.href = '/';
            } else {
                console.error(`Error: ${result.message}`);
                alert(result.message);
            }
        } catch (error) {
            console.error('An unexpected error occurred:', error);
            alert('An unexpected error occurred. Please try again.');
        }
    });
});
