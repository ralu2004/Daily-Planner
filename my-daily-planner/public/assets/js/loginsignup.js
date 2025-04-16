document.addEventListener("DOMContentLoaded", function() {
    const signUpButton = document.getElementById("signUp");
    const signInButton = document.getElementById("signIn");
    const container = document.getElementById("container");

    signUpButton.addEventListener("click", () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener("click", () => {
        container.classList.remove("right-panel-active");
    });

    document.getElementById("signUpForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        fetch("/", {
            method: "POST",
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`Server error: ${response.status} ${text}`);
                });
            }
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Unexpected response format');
            }
            return response.json();
        })
        .then(data => {
            if (!data.success) {
                // Display error message
                alert("Registration failed: " + data.message);
            } else {
                alert(data.message);
                window.location.href = "/home";
            }
        })
        .catch(error => console.error("Error:", error));
    });

    document.getElementById("logInForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        fetch("/", {
            method: "POST",
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`Server error: ${response.status} ${text}`);
                });
            }
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Unexpected response format');
            }
            return response.json();
        })
        .then(data => {
            if (!data.success) {
                console.log("Login failed: " + data.message);
                alert("Login failed: " + data.message); 
            } else {
                alert("Login successful! Welcome back!"); 
                window.location.href = "/home";
            }
        })
        .catch(error => {
            console.error("Error:", error);  
            alert("An error occurred. Please make sure your email are password are correct!");
        });
    });
});
