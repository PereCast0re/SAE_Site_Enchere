async function newsletter(){
    let div = document.getElementById('frm_new_newsletter');
    div.style.display = "block";
}

async function turnOffNewsletter(){
    setTimeout(() => {
        console.log("Envoye de la newsletter en chargement ...");
    }, 5000);
    let div = document.getElementById('frm_new_newsletter');
    div.style.display = "none";
}