import { print_tab_annoncements } from "./print-annoncements.js";
import { print_end_annoncement_reserved } from "./end-annoncemend-without-reserved-price-achieved.js";
import { print_historique_annoncement } from "../Historique_product.js";
import { print_unverifed_product } from "./unverified-product.js";
import { checkBtnHistorique } from "./check-historique.js";
import { getListAnnoncementEnd } from "../call-api.js";
import { getAllAnnoncementUser } from "../call-api.js";

export async function afficher() {
    console.log("afficher start")

    const div = document.querySelector(".section_annonce_publier")
    const id_user = document.getElementById('id_user');

    console.log("utilisateur : " + id_user.value);
    let annoncements = await getAllAnnoncementUser(id_user.value);
    let nb = annoncements.length

    if (nb == 0) {
        div.style.display = 'none'
    }
    else if (nb == 1) {
        div.innerHTML = `<div class="pending_section_header">
                        <p>Vos annonces publiées</p>
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
    
    const divAnnonceReserved = document.getElementById("div_end_annoncement_with_reserved")
    await print_end_annoncement_reserved(id_user.value, divAnnonceReserved)
    
    const divhistorique = document.getElementById('historique_product')
    if (divhistorique) {
        await print_historique_annoncement(id_user.value, divhistorique)
    }
    /*
    const divAnnonceVerifAdmin = document.getElementById('Product_verif_admin')
    await print_unverifed_product(divAnnonceVerifAdmin, annoncements) */

    /*await checkBtnHistorique(id_user.value)*/
}

addEventListener('DOMContentLoaded', afficher);



