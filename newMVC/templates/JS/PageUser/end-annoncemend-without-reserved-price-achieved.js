/////// Import ///////
import { getAnnonceReserved } from "../call-api.js";
import { getImage } from "../call-api.js";
import { getPrice } from "../call-api.js";
import { alertConfirmation } from "./alert-confirmation.js";

// Fonction pour affiché une annonce avec un prix de réserve fixée non atteint et finis 
// Objectif : proposer au vendeur de valider ou non la vente même si le prix de reserve n'est pas atteint ou dépasée
// param -> id_user (int) -> identifiant utilisateur
// param -> div (élément html) -> localisation dans laquelle vas se déployer le contenu crée
export async function print_end_annoncement_reserved($id_user, div) {
    let annoncements = await getAnnonceReserved($id_user);
    const nbreserved = annoncements.some(a => a.reserve_price !== null);

    if (nbreserved) {
        div.style.display = 'block';

        let html = `<div class="pending_section_header">
            <p>Vos annonces terminées avec prix de réserve non atteint</p>
            <div class="separator-line"></div>
            </div>`

        for (const annonce of annoncements) {
            let image_url = await getImage(annonce.id_product);
            let firstImg = (
                Array.isArray(image_url) && image_url.length > 0 && image_url[0].url_image
            ) ? image_url[0].url_image : "assets/default.png";

            html += `
                <div class="annonce_wrapper">
                    <div class="annonce_card">
                        <img class="annonce_img" src="${firstImg}" alt="${annonce.title}" loading="lazy" />
                        <div class="annonce_details">
                            <h3 class="annonce_title">${annonce.title}</h3>
                            <div class="annonce_meta">
                                <span>Dernière enchère : <strong>${annonce.new_price ?? 'Aucune'}</strong></span>
                                <span>Prix de réserve : <strong>${annonce.reserve_price}</strong></span>
                            </div>
                        </div>
                        <div class="tags-row">
                            <button class="btn_agree btn-modifier" data-id="${annonce.id_product}">Accepter</button>
                            <button class="btn_refuse btn-modifier" data-id="${annonce.id_product}">Refuser</button>
                        </div>
                    </div>
                </div>
            `;
        }

        div.innerHTML = html;
    } else {
        div.style.display = 'none';
        div.innerHTML = '';
    }

    // Action si accepter ou refuser
    // Appel de la popup de confirmation qui gére la redirection en fonction de la saisie
    document.querySelectorAll('.btn_agree').forEach((button) => {
        button.addEventListener('click', async () => {
            const id_product = button.getAttribute('data-id');
            const lastPrice = await getPrice(id_product);
            alertConfirmation('Accepter la dernière offre et conclure la vente ' + lastPrice.last_price + '  ?', 'acceptReservedPrice', id_product);
        });
    });

    document.querySelectorAll('.btn_refuse').forEach((button) => {
        button.addEventListener('click', async () => {
            const id_product = button.getAttribute('data-id');
            const lastPrice = await getPrice(id_product);
            alertConfirmation('Refuser la dernière offre de ' + lastPrice.last_price + ' et annuler la vente ?', 'refuseReservedPrice', id_product);
        });
    });
}
