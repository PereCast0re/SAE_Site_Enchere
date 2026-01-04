<div id="popup_bid_form"
    style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; margin:10vh auto; padding:2em; width:300px; border-radius:8px; position:relative;">


        <button onclick="fermerPopupBidForm()"
            style="position:absolute; top:-20px; right:-20px; border-radius: 50%; width: 20px; height: 60px; text-align: center; display: flex; justify-content: center; align-items: center; font-size: 16px; background-color: #D2A047; border: none;">
            X
        </button>

        <!-- <input id="bid_input" type="number" required>
        <button onclick="ouvrirPopup('Bid')">Enchérir</button> -->

        <form id="bid-form" style="margin: 20px">
            <input type="hidden" id="idProduct_form">
            <input type="hidden" id="currentPrice_form">
            <label id="bid-label-form" for="bid_input_form">Quel somme souhaitez-vous entrer ? </label>
            <input id="bid_input_form" type="number" required>
            <button type="button" onclick="event.preventDefault(); ouvrirPopup('Bid')">Enchérir</button>
        </form>

    </div>
</div>
<script src="templates/JS/OuverturePopUp.js"></script>