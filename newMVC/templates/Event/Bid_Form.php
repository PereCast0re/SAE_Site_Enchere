<div id="popup_bid_form"
    style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; margin:10vh auto; padding:2em; width:300px; border-radius:8px; position:relative;">

        <button onclick="fermerPopupBidForm()" style="position:absolute; top:10px; right:10px;">X</button>

        <p>Quel somme souhaitez-vous enchérir ?</p>
        <input id="bid_input" type="number" required>
        <button onclick="ouvrirPopup('Bid')">Enchérir</button>


    </div>
</div>
<script src="templates/JS/OuverturePopUp.js"></script>