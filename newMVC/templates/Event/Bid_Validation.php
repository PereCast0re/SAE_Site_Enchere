<div id="popup_bid"
    style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:#fff; margin:10vh auto; padding:2em; width:300px; border-radius:8px; position:relative;">

        <button onclick="fermerPopupBid()" style="position:absolute; top:10px; right:10px;">X</button>

        <p id="bid_validation_text"></p>

        <form id="bid-form" method="POST">
            <input type="hidden" id="idProduct_validation">
            <input type="hidden" id="currentPrice_validation">
            <input type="hidden" id="newPrice_validation">
            <button id="bid-button" type="submit" onclick="fermerPopupBid()">Oui, je souhaite enchérir</button>
            <button onclick="fermerPopupBid()">Non</button>
        </form>
    </div>
</div>
<script src="templates/JS/OuverturePopUp.js"></script>