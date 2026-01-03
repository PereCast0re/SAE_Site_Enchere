function ouvrirPopup(page) {
    switch (page) {
        case "Adresse":
            fetch('templates/Event/Modif_Address.php')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('popup').innerHTML = html;
                    document.getElementById('popup_adresse').style.display = 'block';
                })
            break
        case "Email":
            fetch('templates/Event/Modif_Email.php')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('popup').innerHTML = html;
                    document.getElementById('popup_email').style.display = 'block';
                })
            break
        case "Password":
            fetch('templates/Event/Modif_Password.php')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('popup').innerHTML = html;
                    document.getElementById('popup_password').style.display = 'block';
                })
            break
        case "Bid":
            temp = document.querySelector('#bid_input').value;
            fetch('templates/Event/Bid_Validation.php')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('popup').innerHTML = html;
                    document.getElementById('popup_bid').style.display = 'block';
                    document.getElementById('bid_validation_text').textContent = "Voulez-vous enchérir " + parseInt(temp).toLocaleString('fr-FR') + " € ?";
                })
            break
        case "BidForm":
            temp = parseInt(document.querySelector('#bid_button').dataset.currentPrice);
            fetch('templates/Event/Bid_Form.php')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('popup').innerHTML = html;
                    document.getElementById('popup_bid_form').style.display = 'block';
                    const bidInput = document.getElementById('bid_input');
                    numberToAdd = addToPrice(temp);
                    bidInput.min = Math.round(temp + numberToAdd);
                    bidInput.value = Math.round(temp + numberToAdd);
                    bidInput.step = numberToAdd;
                })
            break
        default:
            console.log('Aucun changement')
            break
    }
}

//#region close popup
function fermerPopupMail() {
    document.getElementById('popup_email').style.display = 'none';
}

function fermerPopupPassword() {
    document.getElementById('popup_password').style.display = 'none';
}

function fermerPopupAdresse() {
    document.getElementById('popup_adresse').style.display = 'none';
}

function fermerPopupBid() {
    document.getElementById('popup_bid').style.display = 'none';
}

function fermerPopupBidForm() {
    document.getElementById('popup_bid_form').style.display = 'none';
}
//#endregion

async function checkupNewPWD(event) {
    event.preventDefault()

    // récupération mdp
    const pwd1 = document.querySelector('.new_password_1').value;
    const pwd2 = document.querySelector('.new_password_2').value;

    if (pwd1 != pwd2) {
        document.querySelector('.div_erreur').innerHTML = '<p style="color: red;"> Password error ! </p>';
    }
    else {
        document.querySelector('.div_erreur').innerHTML = '<p> </p>';
        event.target.submit();
    }
}

function addToPrice(currentPrice) {
    if (currentPrice < 100) return 5;
    else if (currentPrice < 500) return 10;
    else if (currentPrice < 1000) return 20;
    else if (currentPrice < 5000) return 50;
    else if (currentPrice < 10000) return 100;
    else if (currentPrice < 50000) return 500;
    return 1000;
}