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
                    <div class="rule length">8 caractères minimum</div>
                    <div class="rule number">Au moins un numéro</div>
                    <div class="rule lower">Au moins une lettre minuscule</div>
                    <div class="rule upper">Au moins une lettre majuscule</div>
                    <div class="rule special">Au moins un caractère spécial</div>

                </div>


                <div class="actions">
                    <button type="submit" class="btn-submit" id="loginSubmit">Connexion</button>
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

            const passwordInput = document.getElementById('login-password');
            const submitBtn = document.getElementById('loginSubmit');

            const rules = {
                length: document.querySelector('.rule.length'),
                number: document.querySelector('.rule.number'),
                lower: document.querySelector('.rule.lower'),
                upper: document.querySelector('.rule.upper'),
                special: document.querySelector('.rule.special')
            };

            // ---------- MODAL ----------
            if (openBtn) {
                openBtn.addEventListener('click', e => {
                    e.preventDefault();
                    modal.style.display = 'flex';
                });
            }

            closeBtn?.addEventListener('click', () => modal.style.display = 'none');

            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') modal.style.display = 'none';
            });

            const showLoginModal = <?= isset($_SESSION['show_login_modal']) ? 'true' : 'false' ?>;
            if (showLoginModal) modal.style.display = 'flex';

            // ---------- PASSWORD VALIDATION ----------
            function validatePassword(value) {
                const checks = {
                    length: value.length >= 8,
                    number: /\d/.test(value),
                    lower: /[a-z]/.test(value),
                    upper: /[A-Z]/.test(value),
                    special: /[^A-Za-z0-9]/.test(value)
                };

                let isValid = true;

                for (const rule in checks) {
                    if (checks[rule]) {
                        rules[rule].classList.add('valid');
                        rules[rule].classList.remove('invalid');
                    } else {
                        rules[rule].classList.add('invalid');
                        rules[rule].classList.remove('valid');
                        isValid = false;
                    }
                }

                submitBtn.disabled = !isValid;
            }

            passwordInput.addEventListener('input', e => {
                validatePassword(e.target.value);
            });

            // Empêche toute soumission forcée
            document.getElementById('login-form').addEventListener('submit', e => {
                if (submitBtn.disabled) {
                    e.preventDefault();
                }
            });
        });
    </script>


    <?php
    // Unset the session variable AFTER the JavaScript has read it
    if (isset($_SESSION['show_login_modal'])) {
        unset($_SESSION['show_login_modal']);
    }
?>
<?php endif; ?>