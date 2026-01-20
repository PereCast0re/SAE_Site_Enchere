
async function print_like_annoncement() {
    const div = document.getElementById('like_product')
    const id_user = document.getElementById('id_user').value
    let html = ""
    
    let likes = await getListAnnoncementLike(id_user);
    console.log('Like product');
    console.log(likes)

    if (likes) 
    {
        html += `<div class="profile-header"><h1>Mes annonces coup de coeur</h1><div class="separator-line"></div></div>`
        
        for (const like of likes) {
            let annonce = await getAnnonceLike(like.id_product)
            console.log(annonce)
            
            let price = await getPrice(annonce.id_product)

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
                                    ${price.lastPrice ? price.lastPrice : 'Prix non disponible faite une offre !'}
                                </span>
                            </div>

                            <div class="user_info">
                                <a href="index.php?action=product&id=${annonce.id_product}">Voir</a>
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

async function getImage(id_product) {
    const response = await fetch(`index.php?action=getImage&id_product=${id_product}`)
    const imagejson = await response.json();
    console.log(imagejson)
    return imagejson
}

async function getListAnnoncementLike(id_user) {
    const reponse = await fetch(`index.php?action=LisAnnoncementLike&id_user=${id_user}`)
    const annonce_json = await reponse.json();
    console.log('getListAnnoncementLike')
    console.log(annonce_json)
    return annonce_json
}

async function getAnnonceLike(id_product) {
    const reponse = await fetch(`index.php?action=AnnoncementLike&id_product=${id_product}`)
    const annonce_json = await reponse.json();
    console.log('getListAnnoncementLike')
    console.log(annonce_json)
    return annonce_json
}

async function getPrice(id_product){
    // Appel pour fetch et récupéré le prix actuel
    const price = await fetch(`index.php?action=getLastPrice&id_product=${id_product}`);
    const price_json = await price.json();
    console.log(price_json);
    return price_json;
}

addEventListener('DOMContentLoaded', print_like_annoncement);
