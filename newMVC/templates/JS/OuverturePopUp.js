function ouvrirPopup(page) {
    let newPrice = null;
    let currentPrice = null;
    let idProduct = null;
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

            newPrice = document.querySelector('#bid_input_form').value;
            currentPrice = document.querySelector('#currentPrice_form').value;
            idProduct = document.querySelector('#idProduct_form').value;

            console.log(newPrice + " " + currentPrice + " " + idProduct);

            if (newPriceIsValid(newPrice, currentPrice)) {
                fetch('templates/Event/Bid_Validation.php')
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('popup').innerHTML = html;
                        document.getElementById('popup_bid').style.display = 'block';

                        document.getElementById('currentPrice_validation').value = currentPrice;
                        document.getElementById('idProduct_validation').value = idProduct;
                        document.getElementById('newPrice_validation').value = newPrice;

                        document.getElementById('bid_validation_text').textContent = "Voulez-vous enchérir " + parseInt(newPrice).toLocaleString('fr-FR') + " € ?";

                        // start
                        const bidForm = document.querySelector('#bid-form');

                        bidForm.addEventListener("submit", async (event) => {
                            event.preventDefault();
                            try {
                                console.log(currentPrice, newPrice, idProduct);

                                const toastEl = document.getElementById('myToast');
                                const toast = new bootstrap.Toast(toastEl);
                                toast.show();

                                // L’utilisateur a cliqué sur OUI
                                console.log("Confirmé !");

                                const response = await fetch(`index.php?action=bid&id=${idProduct}`, {
                                    method: "POST",
                                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                                    body: new URLSearchParams({ newPrice })
                                });
                                const data = await response.text();

                                if (data === "not_logged") {
                                    window.location.href = "index.php?action=connection";
                                    return;
                                }
                                if (data === "finished") {
                                    window.alert("L'annonce est terminé !");
                                    return;
                                }
                                if (data === "user_not_accepted") {
                                    window.alert("Vous êtes déjà le dernier à avoir enchéri !");
                                    return;
                                }
                                if (data === "price_not_accepted") {
                                    window.alert("Vous devez enchérir au dessus de la valeur actuelle !");
                                    return;
                                }
                                if (data === "price_not_available") {
                                    window.alert("Vous ne pouvez pas enchérir pour le moment !");
                                    return;
                                }

                                // window.alert(data);

                                window.location.reload();
                            } catch (e) {
                                console.error("Erreur lors du fetch : ", e)
                            }
                        });
                    })
            }
            break
        case "BidForm":
            const bidForm = document.querySelector('#bid-form-product');

            currentPrice = parseInt(bidForm.elements["currentPrice"].value);
            idProduct = parseInt(bidForm.querySelector('#bid-button').dataset.idProduct);

            fetch('templates/Event/Bid_Form.php')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('popup').innerHTML = html;
                    document.getElementById('popup_bid_form').style.display = 'block';

                    document.getElementById('idProduct_form').value = idProduct;
                    document.getElementById('currentPrice_form').value = currentPrice;

                    const bidInput = document.getElementById('bid_input_form');
                    numberToAdd = addToPrice(currentPrice);
                    bidInput.min = Math.round(currentPrice + numberToAdd);
                    bidInput.value = Math.round(currentPrice + numberToAdd);
                    bidInput.step = numberToAdd;


                    document.querySelector('#bid_input_form').addEventListener('input', () => {
                        document.querySelectorAll('.error-msg').forEach(e => e.remove());
                        newPrice = document.querySelector('#bid_input_form').value;
                        currentPrice = document.querySelector('#currentPrice_form').value;
                        newPriceIsValid(newPrice, currentPrice);
                    });
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

function newPriceIsValid(newPrice, currentPrice) {
    if (newPrice <= currentPrice) {

        const bidLabel = document.querySelector('#bid-label-form');

        bidLabel.querySelectorAll('.error-msg').forEach(e => e.remove());

        const star = document.createElement("span");
        star.classList.add("error-msg");
        star.textContent = "Le montant doit être supérieur à " + currentPrice + "*";
        star.style.color = "red";
        star.style.marginLeft = "5px";

        bidLabel.appendChild(star);

        return false;
    }
    return true;
}