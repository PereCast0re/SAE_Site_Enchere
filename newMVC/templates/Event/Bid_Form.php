<div class="popup" id="popup_bid_form">
    <div>
        <button id="closeBtn" onclick="fermerPopupBidForm()">
            <span></span>
            <span></span>
        </button>

        <form class="popup-form" id="bid-form">
            <input type="hidden" id="idProduct_form">
            <input type="hidden" id="currentPrice_form">
            <label id="bid-label-form" for="bid_input_form">Quel somme souhaitez-vous entrer ? </label>
            <input id="bid_input_form" type="number" required>
            <button class="btn" type="button" onclick="event.preventDefault(); ouvrirPopup('Bid')">Enchérir</button>
        </form>

    </div>
</div>
<script src="templates/JS/OuverturePopUp.js"></script>