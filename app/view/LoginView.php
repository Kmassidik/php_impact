<section class="login-container">
    <form action="authHandler.php" method="post">
        <div class="login-box">
            <div class="login-form">
                <img src="https://impactlabs.id/wp-content/uploads/2023/03/Logo-Impact-Labs-300x53.png" alt="Logo"
                    class="img-fluid mb-3">
                <div class="py-2">
                    Welcome back, <br />Please login to your account.
                </div>
                <?php
                if (isset($_GET['error']) && ($_GET['error'] === 'invalid_credentials' || $_GET['error'] === 'empty_fields')) {
                    echo '<span style="color: red;">Username or password is incorrect. Please try again.</span>';
                }
                ?>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label for="password" class="form-label">Password</label>
                    </div>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="login-form-actions">
                    <button type="submit" class="btn"> <span class="icon"> <i class="bi bi-arrow-right-circle"></i>
                        </span>
                        Login</button>
                </div>
                <div class="login-form-footer">
                    <div class="additional-link">
                        Don't have an account? <h6 class="ms-2"> Call Administrator</h6>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>