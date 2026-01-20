
//Button republish
//style="display: ${annonce.last_price > 0 ? "none" : "block"};"
async function print_historique_annoncement() {
    const div = document.getElementById('historique_product')
    const id_user = document.getElementById('id_user').value
    let html = ""
    
    let annoncements = await getListAnnoncementEnd(id_user);

    if (annoncements) 
    {
        html += `<div class="pending_section_header">
                        <p>Vos annonces terminées</p>
                        <div class="separator-line"></div>
                        </div>`
        
        for (const annonce of annoncements) {

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

                            <div class="user_info">
                                <button id="btn_republish${annonce.id_product}" 
                                        class="btn-modifier" 
                                        style="display: block;" 
                                        type="button" 
                                        onclick="alertConfirmation('Republiez cette annonce ?', 'republish', ${annonce.id_product})">
                                    Republier l'annonce
                                </button>
                            </div>
                        </div>

                        <div class="tags-row">
                            <span class="tag">ARCHIVE</span>
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

async function getImage(id_product) {
    const response = await fetch(`index.php?action=getImage&id_product=${id_product}`)
    const imagejson = await response.json();
    console.log(imagejson)
    return imagejson
}

async function getListAnnoncementEnd(id_user) {
    const reponse = await fetch(`index.php?action=LisAnnoncementEnd&id_user=${id_user}`)
    const annonce_json = await reponse.json();
    console.log('getListAnnoncementEnd')
    console.log(annonce_json)
    return annonce_json
}

addEventListener('DOMContentLoaded', print_historique_annoncement);
