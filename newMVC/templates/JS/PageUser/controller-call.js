/////// Import ///////
import { print_tab_annoncements } from "./print-annoncements.js";
import { print_end_annoncement_reserved } from "./end-annoncemend-without-reserved-price-achieved.js";
import { print_unverifed_product } from "./unverified-product.js";
import { checkBtnHistorique } from "./check-historique.js";
import { getListAnnoncementEnd } from "../call-api.js";
import { getAllAnnoncementUser } from "../call-api.js";

// Mais function de la page utilisateur pour afficher le cotenue
export async function afficher() {

    const div = document.querySelector(".section_annonce_publier")
    const id_user = document.getElementById('id_user');

    console.log("utilisateur : " + id_user.value);
    let annoncements = await getAllAnnoncementUser(id_user.value);
    let nb = annoncements.length

    // Réglage du bon titre en fonction du nombre d'annonce
    // Si annonce alors ont appel la fonction d'affichage print_tab_annoncements
    if (nb == 0) {
        div.style.display = 'none'
    }
    else if (nb == 1) {
        div.innerHTML = `<div class="pending_section_header">
                        <p>Votre annonces publiée</p>
                        <div class="separator-line"></div>
                        </div>`
        await print_tab_annoncements(annoncements, div)
    }
    else {
        div.innerHTML = `<div class="pending_section_header">
                        <p>Vos annonces publiées</p>
                        <div class="separator-line"></div>
                        </div>`
        
        await print_tab_annoncements(annoncements, div)
    }
    
    // Affiche les annonces avec un prix de réserve fixé finit non atteint pour valider ou refuser la vente
    const divAnnonceReserved = document.getElementById("div_end_annoncement_with_reserved")
    await print_end_annoncement_reserved(id_user.value, divAnnonceReserved)
    
    // Affichage des annonces en cours de vérification par les adminitrateurs
    const divAnnonceVerifAdmin = document.getElementById('Product_verif_admin')
    await print_unverifed_product(divAnnonceVerifAdmin, annoncements) 

    await checkBtnHistorique(id_user.value)
}

addEventListener('DOMContentLoaded', afficher);



