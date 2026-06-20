import { getListAnnoncementEnd, getImage } from "./call-api.js";

//Button republish
//style="display: ${annonce.last_price > 0 ? "none" : "block"};"
export async function print_historique_annoncement(id_user, divToPrint) {
    let html = ""

    console.log('Test');
    
    let annoncements = await getListAnnoncementEnd(id_user);

    if (annoncements) 
    {
        html += `<div class="pending_section_header">
                        <p>Vos annonces terminées</p>
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
                        <img src="${firstImg}" class="annonce_img" />
                        
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

window.addEventListener('DOMContentLoaded', () => {
    console.log("Si je suis affiché autre que dans l'historique des annonces publiés, vérifier dans le JS");

    const div = document.querySelector(".Historique_annonces")
    const id_user = document.getElementById('id_user');
    print_historique_annoncement(id_user, div)
});
