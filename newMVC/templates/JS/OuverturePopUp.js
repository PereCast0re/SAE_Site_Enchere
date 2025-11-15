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

