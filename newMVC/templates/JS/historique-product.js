/////// Import ///////
import { getListAnnoncementEnd } from "./call-api.js";
import {getImage} from "./call-api.js";

// Fonction d'affichage des card récapitulative des annonces terminée
// param -> id_user (int) -> identifiant de l'utilisateur
// param -> divToPrint (élément html) -> localisation du rendu de la fonction
export async function print_historique_annoncement(id_user, divToPrint) {
    let html = ""

    console.log('Test');
    
    let annoncements = await getListAnnoncementEnd(id_user);

    if (annoncements) 
    {
        html += `<div class="pending_section_header">
                    <H1>Vos annonces terminées</H1>
                        <div class="separator-line"></div>
                        </div>`
        
        for (const annonce of annoncements) {

            console.log("id_product : ", annonce.id_product) // ajoute ça
            let image_url = await getImage(annonce.id_product);
            let firstImg = (
                Array.isArray(image_url) &&
                image_url.length > 0 &&
                image_url[0].url_image
            ) ? image_url[0].url_image : "assets/default.png";

            html += `
                <div class="annonce_wrapper">
                    <div class="annonce_card history_card">
                        <img src="${firstImg}" class="annonce_img" loading="lazy" />
                        
                        <div class="annonce_details">
                            <h3 class="annonce_title">${annonce.title}</h3>
                            
                            <div class="annonce_meta">
                                <span id="td_info_lastPrice${annonce.id_product}" class="price_display">
                                    ${checkEndPrice(annonce.last_price)}
                                </span>
                            </div>
                        </div>

                        <div class="tags-row">
                            <span class="tag">ARCHIVE</span>
                        </div>
                    </div>
                </div>
            `
        }
        divToPrint.innerHTML = html
    }
    else {
        divToPrint.style.display = "none"
        console.log('Aucune annonce dans votre historique !')
    }
}

// Petite mise à jour pour que le texte s'intègre bien dans le span .price_display
function checkEndPrice(lastPrice) {
    if (lastPrice > 0) {
        return "Vendu pour " + lastPrice + "€";
    }
    else {
        return "Non vendu";
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const id = document.getElementById("id_user");
    const div = document.getElementById("historique_product");
    print_historique_annoncement(id.value, div)
})
