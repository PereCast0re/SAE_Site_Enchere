function ouvrirPopup(page){
    switch (page){
        case "adresse":
            console.log("Adresse")
            break
        case "Email":
            fetch('../Vue/Event/Modif_Email.php')
            .then(response => response.text())
            .then(html => {
                document.getElementById('popup').innerHTML = html;
                document.getElementById('popup_email').style.display = 'block';
            })
            break
        case "Password":
            fetch('../Vue/Event/Modif_Email.php')
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

function  fermerPopup() {
    document.getElementById('popup').style.display = 'none';
}