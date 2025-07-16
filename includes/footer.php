        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <i class="fas fa-paw"></i> Pet Management
                    </div>
                    <p>Your trusted companion for managing your pet's health and wellness journey.</p>
                    <div class="footer-social">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <div class="footer-links">
                        <a href="index.php">Home</a>
                        <a href="about.php">About</a>
                        <a href="services.php">Services</a>
                        <a href="contact.php">Contact</a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Account</h3>
                    <div class="footer-links">
                        <?php if (!isset($_SESSION['user_id'])): ?>
                            <a href="login.php">Login</a>
                            <a href="register.php">Register</a>
                        <?php else: ?>
                            <a href="dashboard.php">Dashboard</a>
                            <a href="profile.php">Profile</a>
                            <a href="logout.php">Logout</a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="footer-copyright">
                    &copy; <?php echo date('Y'); ?> Pet Management System. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="js/navigation.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide flash messages after 5 seconds
            const flashMessages = document.querySelectorAll('.flash-message');
            
            flashMessages.forEach(message => {
                setTimeout(() => {
                    message.style.opacity = '0';
                    message.style.transition = 'opacity 0.5s ease';
                    
                    setTimeout(() => {
                        message.style.display = 'none';
                    }, 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>
