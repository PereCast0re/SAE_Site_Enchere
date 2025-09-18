async function afficher() {
    const NbAnnonce = 1
    const div = document.querySelector(".section_annonce_publier")

    if(NbAnnonce == 0){
        div.style.dysplay = 'none'
    }
    else if (NbAnnonce == 1){
        div.innerHTML = '<h2>Vôtre annonce publié</h2>'
    }
    else{
        div.innerHTML = '<h2>Vos annonce publiées</h2>'
    }

}

addEventListener('DOMContentLoaded', afficher)
