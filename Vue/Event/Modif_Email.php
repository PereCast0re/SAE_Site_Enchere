<div id="popup_email" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; margin:10vh auto; padding:2em; width:300px; border-radius:8px; position:relative;">

        <button onclick="fermerPopupMail()" style="position:absolute; top:10px; right:10px;">X</button>
        
        <h1>Modifier votre email</h1>
        
        <form action="../Controlleur/C_update_client.php" class="form_modif_mail" method="POST">
            <p>Taper votre mail</p>
            <input type="email" name="new_email" placeholder="Votre nouvel email">
            <button type="submit" name="action" value="update_email">Valider</button>
        
        </form>

    </div>

</div>
<script src="../JS/OuverturePopUp.js"></script>
