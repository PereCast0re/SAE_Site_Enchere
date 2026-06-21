// Fonction pour faire afficher le formulaire de création de la newsletter
async function newsletter(){
    let div = document.getElementById('frm_new_newsletter');
    div.style.display = "block";
}

// Fonction pour affiché un essage d'evoie de la newsletter
async function turnOffNewsletter(){
    setTimeout(() => {
        console.log("Envoye de la newsletter en chargement ...");
    }, 5000);
    let div = document.getElementById('frm_new_newsletter');
    div.style.display = "none";
}