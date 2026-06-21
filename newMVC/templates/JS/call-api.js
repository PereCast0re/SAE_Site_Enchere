////////////////////////////////////////////////////////////
                    //Fonction API//
////////////////////////////////////////////////////////////

/// Appel API pour supprimer un produit
/// param -> id du produit 
export async function deleteProduct(id_product) {
    const response = await fetch(`index.php?action=deleteProduct&id_product=${id_product}`);
    console.log(response);
    const result = await response.json();
    console.log(result);

    if (result.success) {
        console.log('Suppression réussie');
        //location.reload(); // Recharge la page pour mettre à jour la liste
    } else {
        alert('Erreur lors de la suppression en base de données');
    }
}

/// Appel API pour récupéré le prix d'un produit
/// param -> id du produit 
export async function getPrice(id_product) {
    const price = await fetch(`index.php?action=getLastPrice&id_product=${id_product}`);
    const price_json = await price.json();
    console.log(price_json);
    return price_json;
}

/// Appel API pour fetch et récupéré le prix trié en fonction de "option" donc par jour/année/an 
/// param -> id du produit 
export async function getPriceWithOption(id_product, option) {
    const price = await fetch(`index.php?action=getLastPrice&id_product=${id_product}&option=${option}`);
    const price_json = await price.json();
    console.log(price_json);
    return price_json;
}

/// Appel API pour fetch le nombre de vue
/// param -> id du produit 
export async function getGlobalViews(id_product) {
    const views = await fetch(`index.php?action=getGlobalViews&id_product=${id_product}`);
    const views_json = await views.json();
    console.log(views_json);
    return views_json;
}

/// Appel API pour fetch le nombre de vu trié en fonction de "option" donc par jour/année/an
/// param -> id du produit 
export async function getViewsWithOption(id_product, option) {
    const views = await fetch(`index.php?action=getGlobalViews&id_product=${id_product}&option=${option}`);
    const views_json = await views.json();
    console.log(views_json);
    return views_json;
}

/// Appel API pour fetch le nombre total de likes
/// param -> id du produit 
export async function getLikes(id_product) {
    const likes = await fetch(`index.php?action=getLikes&id_product=${id_product}`);
    const likes_json = await likes.json();
    console.log(likes_json);
    return likes_json;
}

/// Appel API pour récupéré toute les annonces qui ont un prix de réserve
/// param -> id de l'utilisateur 
export async function getAnnonceReserved($id_user) {
    const reponse = await fetch(`index.php?action=reservedAnnoncement&id_user=${$id_user}`);
    const annonce_json = await reponse.json();
    console.log(annonce_json)
    return annonce_json;
}

/// Appel API pour récupéré les information d'un image path
/// param -> id du produit 
export async function getImage(id_product) {
    const response = await fetch(`index.php?action=getImage&id_product=${id_product}`)
    const imagejson = await response.json();
    console.log(imagejson)
    return imagejson
}

/// Appel API pour récupéré la liste des annonces finis d'un utilisateurs
/// Utilsé dans des cas comme l'historique des annonces d'un utilisateur
/// param -> id de l'utilisateur
export async function getListAnnoncementEnd(id_user) {
    console.log("Annoncement End :")
    const reponse = await fetch(`index.php?action=ListAnnoncementEnd&id_user=${id_user}`)
    const annonce_json = await reponse.json();
    console.log('getListAnnoncementEnd')
    console.log(annonce_json)
    return annonce_json
}

/// Appel API pour récupéré les informations autour de la célébrité d'un produit
/// param -> id du produit 
export async function getCelebrity(id_product) {
    const response = await fetch(`index.php?action=getCelebrityFromProduct&id_product=${id_product}`);
    const celebrity_json = await response.json();
    console.log(celebrity_json);
    return celebrity_json;
}

/// Appel API pour récupéré la catégory d'un produit 
/// param -> id du produit 
export async function getCategory(id_product) {
    const response = await fetch(`index.php?action=getCategoryFromProduct&id_product=${id_product}`);
    const category_json = await response.json();
    console.log(category_json);
    return category_json;
}

/// Appel API pour récupéré toute les annonces d'un utilisateur
/// param -> id de l'utilisateur
export async function getAllAnnoncementUser(id_user) {
    const response = await fetch(`index.php?action=getAllAnnoncementUser&id_user=${id_user}`);
    const annonce_json = await response.json();
    console.log(annonce_json)
    return annonce_json;
}

/// Appel Api pour récupéré la liste des célébrités en fonction de la saisie de l'utilisateur
/// param -> contenue de la zone de saisie d'une célébrité page vente
export async function getSaisieCelebrity(input) {
    const reponse = await fetch(`index.php?action=getCelebrityMod&writting=${encodeURIComponent(input)}`);
    const reponse_json = await reponse.json();
    console.log(reponse_json);
    return reponse_json;
}

/// Appel Api pour récupéré la liste des catégorie en fonction de la saisie de l'utilisateur
/// param -> contenue de la zone de saisie d'une catégorie page vente
export async function getSaisiCategories(input) {
    const reponse = await fetch(`index.php?action=getCategoriesMod&writting=${encodeURIComponent(input)}`);
    const reponse_json = await reponse.json();
    console.log(reponse_json);
    return reponse_json;
}

/// Appel API pour récupéré la liste des commentaire d'une annonce 
/// param -> id du produit
export function getComments(id_product) {
    return fetch(`index.php?action=getComments&id_product=${id_product}`)
        .then((response) => response.json());
}

/// Appel API pour récupéré les annonce qui ont un ou des likes d'une annonce
/// param -> id de l'utilisateur
export async function getListAnnoncementLike(id_user) {
    const reponse = await fetch(`index.php?action=LisAnnoncementLike&id_user=${id_user}`)
    const annonce_json = await reponse.json();
    console.log('getListAnnoncementLike')
    console.log(annonce_json)
    return annonce_json
}

/// Appel API pour récupéré les likes d'une annonce
/// param -> id d'un produit 
export async function getAnnonceLike(id_product) {
    const reponse = await fetch(`index.php?action=AnnoncementLike&id_product=${id_product}`)
    const annonce_json = await reponse.json();
    console.log('getListAnnoncementLike')
    console.log(annonce_json)
    return annonce_json
}
