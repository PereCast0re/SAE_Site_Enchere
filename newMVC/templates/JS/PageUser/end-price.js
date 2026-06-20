import { getListAnnoncementEnd } from "./call-api.js";

export function checkEndPrice(lastPrice) {
    if (lastPrice > 0) {
        return "<p> Vendu pour " + lastPrice + "€ </p>"
    }
    else {
        return "<p>Produit non vendu !<p>"
    }
}