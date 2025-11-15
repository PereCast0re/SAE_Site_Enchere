<div id="popup_adresse" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; margin:10vh auto; padding:2em; width:300px; border-radius:8px; position:relative;">
        
        <button onclick="fermerPopupAdresse()" style="position:absolute; top:10px; right:10px;">X</button>
        
        <h1>Modifier votre Adresse</h1>

        <div class="erreur_adresse">

        </div>
        
        <form action="index.php?action=update_address" class="form_modif_Adresse" method="POST">
            <p>Taper votre nouvelle adresse </p>
            <input type="text" name="address" placeholder="adresse">

            <p>Taper votre nouveau code postal</p>
            <input type="text" name="postal_code" placeholder="Code postal">

            <p>Taper votre nouvelle ville</p>
            <input type="text" name="city" placeholder="Ville">

            <button type="submit" name="action" value="update_address">Valider</button>
        </form>

    </div>
</div>
<script src="templates/JS/OuverturePopUp.js"></script>