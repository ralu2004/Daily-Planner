<?php

namespace RalucaAdam\MyDailyPlanner\views;

class LogInSignUpView
{
    public function render()
    {
        echo '<!DOCTYPE html>
              <html lang="en">
              <head>
                  <meta charset="UTF-8">
                  <meta name="viewport" content="width=device-width, initial-scale=1.0">
                  <title>Log In / Sign Up</title>
                  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
                  <link rel="stylesheet" href="/assets/css/LogInSignUp.css">
              </head>
              <body>
                  <div class="description-container">
                      <h2>My Daily Planner</h2>
                      <p>Organize your tasks and manage your time efficiently with an easy-to-use daily planner. Sign up to get started or log in if you already have an account.</p>
                  </div>
                  <div class="container" id="container">
                      <div class="form-container sign-up-container">
                          <form id="signUpForm" method="POST">
                              <h1 class="title">Create Account</h1>
                              <input type="text" name="name" placeholder="Name" />
                              <input type="email" name="email" placeholder="Email" />
                              <input type="password" name="password" placeholder="Password" />
                              <button type="submit">Register</button>
                          </form>
                      </div>
                      <div class="form-container sign-in-container">
                          <form id="logInForm" method="POST">
                              <h1 class="title">Log in</h1>
                              <input type="email" name="email" placeholder="Email" />
                              <input type="password" name="password" placeholder="Password" />
                              <a href="/password" class="forgot-password">Forgot your password?</a>
                              <button type="submit">Log In</button>
                          </form>
                      </div>
                      <div class="overlay-container">
                          <div class="overlay">
                              <div class="overlay-panel overlay-left">
                                  <h1>Welcome Back!</h1>
                                  <p>To keep connected with us please login with your personal info</p>
                                  <button class="ghost" id="signIn">Log In</button>
                              </div>
                              <div class="overlay-panel overlay-right">
                                  <h1>Hello, Friend!</h1>
                                  <p>Enter your personal details and start journey with us</p>
                                  <button class="ghost" id="signUp">Register</button>
                              </div>
                          </div>
                      </div>
                  </div>
                  <script src="/assets/js/loginsignup.js"></script>
              </body>
              </html>';
    }
}
?>