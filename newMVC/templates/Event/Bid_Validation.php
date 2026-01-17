<div class="popup" id="popup_bid">
    <div>
        <button id="closeBtn" onclick="fermerPopupBid()">
            <span></span>
            <span></span>
        </button>

        <h2 id="bid_validation_text"></h2>

        <form class="popup-form" id="bid-form" method="POST">
            <input type="hidden" id="idProduct_validation">
            <input type="hidden" id="currentPrice_validation">
            <input type="hidden" id="newPrice_validation">
            <button class="btn" id="bid-button" type="submit" onclick="fermerPopupBid()">Oui, je souhaite enchérir</button>
            <button class="btn-second" type="button" onclick="fermerPopupBid()">Non</button>
        </form>
    </div>
</div>
<script src="templates/JS/OuverturePopUp.js"></script>