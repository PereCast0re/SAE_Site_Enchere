import { getListAnnoncementEnd } from "../call-api.js";

export async function checkBtnHistorique(id_user) {
    product = await getListAnnoncementEnd(id_user)
    if (product && product.length >= 1) {
        btn.style.display = "block"
    }
}