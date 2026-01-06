<?php if (!isset($_SESSION['user'])): ?>
    <style>
        <?php include 'templates/Style/popupInscription.css'; ?>
    </style>

    <div id="registerPopup">
        <div class="rp-overlay">
            <div class="rp-modal">

                <button class="rp-close" id="rpClose">&times;</button>
                <h2 class="rp-title">Inscrivez-vous</h2>

                <form action="index.php?action=userInscription" method="post" class="rp-form">

                    <section class="rp-section">
                        <h3>Identité</h3>
                        <div class="rp-grid">
                            <div>
                                <label>Prénom</label>
                                <input type="text" name="firstname" required>
                            </div>
                            <div>
                                <label>Nom</label>
                                <input type="text" name="name" required>
                            </div>
                        </div>

                        <label>Date de naissance</label>
                        <input type="date" name="birth_date" required>
                    </section>

                    <section class="rp-section">
                        <h3>Domicile</h3>
                        <div class="rp-grid">
                            <div>
                                <label>Adresse</label>
                                <input type="text" name="address" required>
                            </div>
                            <div>
                                <label>Ville</label>
                                <input type="text" name="city" required>
                            </div>
                        </div>

                        <label>Code postal</label>
                        <input type="number" name="postal_code" required>
                    </section>

                    <section class="rp-section">
                        <h3>Identifiant de connexion</h3>

                        <label>Email</label>
                        <input type="email" name="email" required>

                        <label>Mot de passe</label>
                        <input type="password" name="password" required>
                        <div class="password-rules">
                            <div class="valid">✔ 8 caractères minimum</div>
                            <div class="valid">✔ Au moins un numéro</div>
                            <div class="invalid">✖ Au moins une lettre minuscule</div>
                            <div class="invalid">✖ Au moins un caractère spécial</div>
                            <div class="invalid">✖ Au moins une lettre majuscule</div>
                        </div>
                    </section>

                    <button type="submit" class="rp-submit">Inscription</button>
                    <button type="button" class="rp-alt" onclick="window.location.href='index.php'">
                        Déjà un compte ?
                    </button>

                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const popup = document.getElementById('registerPopup');
            const closeBtn = document.getElementById('rpClose');
            const overlay = popup.querySelector('.rp-overlay');

            // fermeture via X
            closeBtn.addEventListener('click', () => {
                popup.style.display = 'none';
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    popup.style.display = 'none';
                }
            });


            // ouverture UNIQUEMENT si demandé par le serveur
            const showRegisterModal = <?= isset($_SESSION['show_register_modal']) ? 'true' : 'false' ?>;
            if (showRegisterModal) {
                popup.style.display = 'flex';
            }
        });
    </script>

    <?php unset($_SESSION['show_register_modal']); ?>
<?php endif; ?>