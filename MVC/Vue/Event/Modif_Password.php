<div id="popup_password" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; margin:10vh auto; padding:2em; width:300px; border-radius:8px; position:relative;">
        
        <button type="button" onclick="fermerPopupPassword()" style="position:absolute; top:10px; right:10px;">X</button>

        <h1>Modifier votre mot de passe</h1>
        
        <div class="div_erreur"></div>
        
        <form class="form_modif_password" id="form_modif_password" action="../Controlleur/C_update_client.php" method="POST" onsubmit="checkupNewPWD(event)">
            <input type="hidden" name="action" value="update_password">
            
            <p>Taper nouveau mot de passe </p>
            <input class="new_password_1" type="password" name="new_password_1" placeholder="Votre nouveau mot de passe">

            <p>Retaper nouveau mot de passe </p>
            <input class="new_password_2" type="password" name="new_password_2" placeholder="Répéter le mot de passe">

            <!-- Obligation de rajouté un input caché pour avoir l'action dans l'url du au onsubmit qui passe outre -->
            <button type="submit">Valider</button>
        </form>
    
    </div>
</div>

<script src="../JS/OuverturePopUp.js"></script>
