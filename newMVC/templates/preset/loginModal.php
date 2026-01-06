<?php if (!isset($_SESSION['user'])): ?>
    <style>
        <?php include 'templates/Style/popupConnection.css'; ?>
    </style>
    <div id="loginModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <button class="close-btn" id="closeLogin">&times;</button>
            <h2>Connectez-vous</h2>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <form action="index.php?action=userConnection" method="post" id="login-form">
                <div class="field">
                    <label for="login-email">Email</label>
                    <input type="email" id="login-email" name="email" required placeholder="Email">
                </div>
                <div class="field">
                    <label for="login-password">Mot de passe</label>
                    <input type="password" id="login-password" name="password" required placeholder="Mot de passe">
                </div>
                <div class="password-rules">
                    <div class="valid">✔ 8 caractères minimum</div>
                    <div class="valid">✔ Au moins un numéro</div>
                    <div class="invalid">✖ Au moins une lettre minuscule</div>
                    <div class="invalid">✖ Au moins un caractère spécial</div>
                    <div class="invalid">✖ Au moins une lettre majuscule</div>
                </div>

                <div class="actions">
                    <button type="submit" class="btn-submit">Connexion</button>
                    <button type="button" class="btn-secondary"
                        onclick="window.location.href='index.php?action=inscription'">
                        Pas de compte ?
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('loginModal');
            const closeBtn = document.getElementById('closeLogin');
            const openBtn = document.getElementById('openLogin');

            // Open modal on button click
            if (openBtn) {
                openBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    modal.style.display = 'flex';
                });
            }

            // Close modal on X button
            if (closeBtn) {
                closeBtn.onclick = () => modal.style.display = 'none';
            }

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    modal.style.display = 'none';
                }
            });


            // Show modal if triggered by PHP session
            const showLoginModal = <?= isset($_SESSION['show_login_modal']) ? 'true' : 'false' ?>;
            if (showLoginModal && modal) {
                console.log('Opening login modal from session');
                modal.style.display = 'flex';
            }
        });
    </script>

    <?php
    // Unset the session variable AFTER the JavaScript has read it
    if (isset($_SESSION['show_login_modal'])) {
        unset($_SESSION['show_login_modal']);
    }
?>
<?php endif; ?>