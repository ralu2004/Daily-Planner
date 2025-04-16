<?php

namespace RalucaAdam\MyDailyPlanner\views;

class ForgotPasswordView
{
    public function render()
    {
        return "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Forgot Password</title>
            <link rel='stylesheet' href='/assets/css/PassReset.css'>
        </head>
        <body>
            <div class='container'>
                <h1>Forgot Password</h1>
                <form id='forgot-password-form' method='POST' action='/reset-password'>
                    <label for='username'>Username:</label>
                    <input type='text' id='username' name='username' required><br>
                    <label for='email'>Email:</label>
                    <input type='email' id='email' name='email' required><br>
                    <label for='new_password'>New Password:</label>
                    <input type='password' id='new_password' name='new_password' required><br>
                    <label for='confirm_new_password'>Confirm New Password:</label>
                    <input type='password' id='confirm_new_password' name='confirm_new_password' required><br>
                    <input type='submit' value='Reset Password'>
                </form>
                <script src='/assets/js/password-reset.js'></script>
            </div>
        </body>
        </html>";
    }
}
?>