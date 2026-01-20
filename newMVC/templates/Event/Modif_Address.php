<style>
/* --- OVERLAY POUR TOUS LES POPUPS --- */
#popup_password, #popup_name, #popup_firstname, #popup_email, #popup_adresse {
    display: none; /* Reste géré par le JS */
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    background: rgba(14, 26, 51, 0.85) !important;
    backdrop-filter: blur(5px);
    z-index: 2000 !important;
    
    /* CENTRAGE GRID */
    display: none; /* Deviendra 'grid' via JS */
    place-items: center; 
    padding: 20px;
    box-sizing: border-box;
}

/* --- LE CONTENEUR BLANC (MODAL) --- */
#popup_password > div, #popup_name > div, #popup_firstname > div, #popup_email > div, #popup_adresse > div {
    margin: 0 !important; 
    position: relative !important;
    top: auto !important;
    left: auto !important;
    width: 100% !important;
    max-width: 400px !important;
    background: var(--bg-color, #fff) !important;
    border-radius: 20px !important;
    padding: 40px 30px !important;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5) !important;
    box-sizing: border-box !important;
}

/* --- BOUTONS FERMER (X) --- */
#popup_password button[onclick*="fermer"], 
#popup_name button[onclick*="fermer"], 
#popup_firstname button[onclick*="fermer"], 
#popup_email button[onclick*="fermer"], 
#popup_adresse button[onclick*="fermer"] {
    position: absolute !important;
    top: 15px !important;
    right: 15px !important;
    width: 32px;
    height: 32px;
    border-radius: 50% !important;
    background: var(--dark-blue, #112250) !important;
    color: white !important;
    border: none !important;
    cursor: pointer;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}

/* --- TEXTES ET TITRES --- */
#popup_password h1, #popup_name h1, #popup_firstname h1, #popup_email h1, #popup_adresse h1 {
    font-family: 'Lora', serif;
    color: var(--dark-blue, #112250);
    text-align: center;
    margin-bottom: 25px;
    font-size: 1.5rem;
}

#popup_password p, #popup_name p, #popup_firstname p, #popup_email p, #popup_adresse p {
    font-size: 0.8rem;
    font-weight: 800;
    color: var(--dark-blue, #112250);
    margin: 15px 0 5px 0;
    text-transform: uppercase;
}

/* --- INPUTS --- */
#popup_password input, #popup_name input, #popup_firstname input, #popup_email input, #popup_adresse input {
    width: 100% !important;
    padding: 12px 15px !important;
    border-radius: 10px !important;
    border: 1px solid rgba(17, 34, 80, 0.2) !important;
    background: white !important;
    box-sizing: border-box !important;
    font-size: 1rem;
}

/* --- BOUTONS VALIDER --- */
#popup_password button[type="submit"], 
#popup_name button[type="submit"], 
#popup_firstname button[type="submit"], 
#popup_email button[type="submit"], 
#popup_adresse button[type="submit"] {
    width: 100% !important;
    background: var(--dark-blue, #112250) !important;
    color: white !important;
    padding: 15px !important;
    border-radius: 10px !important;
    border: none !important;
    margin-top: 30px;
    font-weight: 700;
    cursor: pointer;
    transition: transform 0.2s;
}

#popup_password button[type="submit"]:hover, 
#popup_name button[type="submit"]:hover,
#popup_firstname button[type="submit"]:hover,
#popup_email button[type="submit"]:hover,
#popup_adresse button[type="submit"]:hover {
    transform: translateY(-2px);
    background: var(--darker-blue, #0e1a33) !important;
}
</style>

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