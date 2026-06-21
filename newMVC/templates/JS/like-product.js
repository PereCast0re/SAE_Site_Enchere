/////// Import ///////
import { getAnnonceLike } from "./call-api.js";
import { getPrice } from "./call-api.js";
import { getImage } from "./call-api.js";
import { getListAnnoncementLike } from "./call-api.js";

// Fonction d'affichage des card récapitulative des annonces mises en favorie
export async function print_like_annoncement() {
    const div = document.getElementById('like_product')
    const id_user = document.getElementById('id_user').value
    let html = ""
    
    let likes = await getListAnnoncementLike(id_user);

    if (likes) 
    {
        html += `<div class="profile-header"><h1>Mes annonces coup de coeur</h1><div class="separator-line"></div></div>`
        
        for (const like of likes) {
            let annonce = await getAnnonceLike(like.id_product)
            
            let price = await getPrice(annonce.product.id_product)

            let image_url = await getImage(annonce.product.id_product);
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
                            <h3 class="annonce_title">${annonce.product.title}</h3>
                            
                            <div class="annonce_meta">
                                <span id="td_info_lastPrice${annonce.product.id_product}" class="price_display">
                                    ${price.lastPrice ? price.lastPrice : 'Prix non disponible faite une offre !'}
                                </span>
                            </div>

                            <div class="user_info">
                                <a href="index.php?action=product&id=${annonce.product.id_product}">Voir</a>
                            </div>
                        </div>

                        <div class="tags-row">
                            <span class="tag">Like</span>
                        </div>
                    </div>
                </div>
            `
        }
        div.innerHTML = html
    }
    else {
        div.style.display = "none"
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

addEventListener('DOMContentLoaded', print_like_annoncement);
