/////// Import ///////
import { getListAnnoncementEnd } from "../call-api.js";

// permet d'afficher le button de redirection vers l'historique si il y en as 1
// param -> id (int) -> identifient de l'utilisareur
export async function checkBtnHistorique(id_user) {

    const btn = document.getElementById("btn_historique_annonce_published");

    product = await getListAnnoncementEnd(id_user)
    if (product && product.length >= 1) {
        btn.style.display = "block"
    }
}