/////// Import ///////
import { getImage } from "../call-api.js";
import { getPrice } from "../call-api.js";
import { ShowPopUpOption } from "./show-popup.js";

// Fonction d'affichage des card récapitulative des annonces en attente de validation des administrateurs
// param -> annoncement (List Annoncement) -> liste des annonces extraites de la base de données
// param -> div (élément html) -> localisation du rendu de la fonction
export async function print_unverifed_product(div, annoncements) {
    console.log("print unverifed");

    // Vérification de la présence d'annonces
    nb = annoncements.some(a => a.status === 0);

    if (!nb) {
        div.style.display = 'none';
        return;
    }

    div.style.display = 'block';

    // Header de la section avec le style du site
    let htmlContent = `
        <div class="pending_section_header">
            <p>Annonces en attente de validation par nos Administrateurs</p>
            <div class="separator-line"></div>
        </div>
        <div class="unverified_container">
    `;

    for (const annonce of annoncements) {
        if (annonce.status == 1) continue;

        // Récupération des données
        let price = await getPrice(annonce.id_product);
        let currentPrice = price.last_price ?? annonce.start_price;

        let image_url = await getImage(annonce.id_product);
        let firstImg = (Array.isArray(image_url) && image_url.length > 0 && image_url[0].url_image)
            ? image_url[0].url_image
            : "assets/default.png";

        // Construction de la carte (Style identique à .annonce_card)
        htmlContent += `
            <div class="annonce_wrapper">
                <input type="hidden" id="id_product" value="${annonce.id_product}"/>
                <div class="annonce_card pending_card">
                    <img src="${firstImg}" class="annonce_img" alt="${annonce.title}"/>
                    
                    <div class="annonce_details">
                        <h3 class="annonce_title">${annonce.title}</h3>
                    </div>

                    <button type='button' class='btn_moreoption' onclick='ShowPopUpOption(${annonce.id_product})'>...</button>
                    
                    <div class="tags-row">
                        <span class="tag" style="background: var(--gold); color: var(--dark-blue);">EN ATTENTE DE VERIFICATION</span>
                    </div>
                </div>
            </div>
        `;
    }

    htmlContent += '</div>';
    div.innerHTML = htmlContent;
}
