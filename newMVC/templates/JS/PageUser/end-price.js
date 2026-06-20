/////// Import ///////
import { getListAnnoncementEnd } from "./call-api.js";

// Fonction pour affiché le prix de vente si il y en as un
// param -> lastprice (float) -> dernier prix enregistré de type float ou null
export function checkEndPrice(lastPrice) {
    if (lastPrice > 0) {
        return "<p> Vendu pour " + lastPrice + "€ </p>"
    }
    else {
        return "<p>Produit non vendu !<p>"
    }
}