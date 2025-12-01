async function afficher() {
    const values_annoncements = document.getElementById("values_annoncements")
    const div = document.querySelector(".section_annonce_publier")
    const id_user = document.getElementById('id_user');

    let json_values = []
    json_values = JSON.parse(values_annoncements.value)

    let nb = json_values.length
    console.log(nb)
    console.log(json_values)

    if(nb == 0){
        div.style.display = 'none'
    }
    else if (nb == 1){
        div.innerHTML = '<h2>Vôtre annonce publié</h2>'
        print_tab_annoncements(json_values, div)
    }
    else{
        div.innerHTML = '<h2>Vos annonces publiées</h2>'
        print_tab_annoncements(json_values, div)
    }

    const divAnnonceReserved = document.getElementById("div_end_annoncement_with_reserved")
    print_end_annoncement_reserved(id_user.value, divAnnonceReserved)

    const divhistorique = document.getElementById('div_historique_annoncement')
    print_historique_annoncement(id_user.value, divhistorique)
}

async function print_tab_annoncements(annoncements, div){
    let html = ""
    for (const annonce of annoncements) {
        //price
        let price = await getPrice(annonce.id_product);
        if (price.last_price === null) {
            price.last_price = annonce.start_price;
        }
        //views
        let nb_views = await getDailyViews(annonce.id_product);
        // global views
        let global_views = await getGlobalViews(annonce.id_product);
        if (global_views.nbGlobalView === null) {
            global_views.nbGlobalView = 0;
        }
        // likes
        let like = await getLikes(annonce.id_product);
        if (like.nbLike === null) {
            like.nbLike = 0;
        }
        // image
        let image_url = await getImage(annonce.id_product, annonce.title);

        console.log(image_url);
        html += 
            `
            <div class="annonce" style="color: red; padding: 10px;">
                <table>
                    <tbody>
                    <tr>
                        <td>image ici ! </td>
                        <td>${annonce.title}</td>
                        <td><span class="timer" data-end="${annonce.end_date}">Chargement...</span></td>
                        <td class="price_annonce_${annonce.id_product}"> ${ price.last_price } €</td>
                        <td><a href="index.php?action=product&id=${annonce.id_product}">See Annonce</a></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Vue journaliére : ${nb_views.nbDailyView}</td>
                        <td>Vue total : ${global_views.nbGlobalView}</td>
                        <td>Like(s) : ${like.nbLike}</td>
                        <td><button type="button" class="stat_button"> See stats </button></td>
                    </tr>
                </tbody>
                </table>
            </div>
            `
    };
    
    // Aider avec ia car code collegue non compris 
    // Ajouter le HTML à la div
    div.innerHTML += html;

    // Initialiser les timers après avoir ajouté le HTML
    document.querySelectorAll('.timer').forEach(timerElement => {
        const endDate = timerElement.getAttribute('data-end');
        if (endDate) {
            console.log("Initialisation du timer pour la date de fin :", endDate);
            startCountdown(endDate, timerElement);
        }
        else {
            console.error("Date de fin non trouvée pour le timer.");
        }
    });

    // Ajouter d'un ecouteur pour un click btn stat
    document.querySelectorAll('.stat_button').forEach((button, index) => {
        button.addEventListener('click', () => {
            console.log("Stat button clicked for annonce index:", index);
            PrintStatAnnonce(annoncements[index]);
        });
    });
}

// Div when a annoncement is end and if a reserved price is set and the finsih price is under of reserved price
async function print_end_annoncement_reserved($id_user, div){
    let annoncements = await getAnnonceReserved($id_user);

    if (annoncements != null){
        div.style = 'display: block;'

        let html = ""

        for (const annonce of annoncements ){
            html += `
                <div>
                    <h3>Vos annonces terminer avec prix de réserve non atteint</h3>
                    <div>
                        <table>
                            <tbody>
                                <tr>
                                    <td>Image</td>
                                    <td>${annonce.title}</td>
                                    <td>Dernière enchére : <br> ${annonce.new_price} </td>
                                    <td>Vôtre prix de reserve : <br> ${annonce.reserve_price} </td>
                                    <td>
                                        <td>
                                            <button id="btn_agree" type="button">Accepter</button>
                                            <br>
                                            <button id="btn_refuse" type="button">Refuser</button>
                                        </td>
                                    </td>
                                </tr>
                            </tbody>
                        <table>
                    </div>
                </div>
                `
            div.innerHTML += html;
        }
    }
}

function PrintStatAnnonce(annoncement) {
    const divStat = document.querySelector(".stat_annonce")
    divStat.innerHTML = "" 
    html = `
        <div>
            <h3> Statistiques de l'annonce: ${annoncement.title} </h3>
            <div style="border: 1px solid black; display: flex; justify-content: space-around;">
                <div class="stat_views" style="background-color: lightgreen;">
                    <h4>Vues</h4>
                    <p> faie le graphe ici </p>
                </div>
                <div class="stat_likes" style="background-color: lightblue;">
                    <h4>Likes</h4>
                    <p> faie le graphe ici </p>
                </div>
            </div>
        </div>
    `

    divStat.innerHTML += html
}

async function print_historique_annoncement(id_user, div){
    let html = ""

    let annoncements = await getListAnnoncementEnd(id_user);

    if(annoncements && annoncements.length > 0){

        div.style = "display: block;"
        div.innerHTML += `<h3> Vos annonces non concluante </h3>`
        for (const annonce of annoncements){
            html += `
                <div>
                    <table>
                        <tbody>
                            <tr>
                                <td> Image </td>
                                <td>${annonce.title}</td>
                                <td id="td_info_lastPrice${annonce.id_product}">${checkEndPrice(annonce.last_price, annonce.id_product)}</td>
                                <td>
                                    <button id="btn_republish${annonce.id_product}" style="display: ${annonce.last_price > 0 ? "none" : "block"};" type="button" onclick="alertConfirmation("Republiez cette annoncer ?", "republish")">Republier</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <div>
            `
        }
        div.innerHTML += html
    }

    document.querySelector('.')
}

/////////////////////////////////////////////////////////////
            //Fonction Affichage personalisée//
////////////////////////////////////////////////////////////

function checkEndPrice(lastPrice){
    if(lastPrice > 0){
        return "<p> Vendu pour "+ lastPrice +"€ </p>" 
    }
    else{        
        return "<p>Produit non vendu !<p>" 
    }
}

async function alertConfirmation(message, action, id_product){
    const popup = document.createElement('div')
    console.log("affichage la popup")
    popup.classList.add('popup-overlay'); 
    popup.innerHTML = `
    <div class="popup-box">
        <p>${message}</p>
        <div style="display: flex; justify-content: space-around; margin-top: 15px;">
            <button id="btnConfirm">Accepter</button>
            <button id="btnCancel">Refuser</button>
        </div>
    </div>
`;

    document.body.appendChild(popup);

    let button = document.querySelector("#btnConfirm")
    button.addEventListener('click', async () =>{
        fetch(`index.php?action=${action}&id_product=${id_product}`);
        popup.remove();
    })
}


/////////////////////////////////////////////////////////////
                        //Fonction API//
////////////////////////////////////////////////////////////


async function getPrice(id_product){
    // Appel pour fetch et récupéré le prix actuel
    const price = await fetch(`index.php?action=getLastPrice&id_product=${id_product}`);
    const price_json = await price.json();
    console.log(price_json);
    return price_json;
}

async function getDailyViews(id_product){
    // Appel pour fetch et récupéré le prix actuel
    const views = await fetch(`index.php?action=getDailyViews&id_product=${id_product}`);
    const views_json = await views.json();
    console.log(views_json);
    return views_json;
}

async function getGlobalViews(id_product){
    // Appel pour fetch et récupéré le prix actuel
    const views = await fetch(`index.php?action=getGlobalViews&id_product=${id_product}`);
    const views_json = await views.json();
    console.log(views_json);
    return views_json;
}

async function getLikes(id_product){
    // Appel pour fetch et récupéré le prix actuel
    const likes = await fetch(`index.php?action=getLikes&id_product=${id_product}`);
    const likes_json = await likes.json();
    console.log(likes_json);
    return likes_json;
}

// A demander de l'aide !!!!!
async function getImage(id_product, title) {
    /*
    const response = await fetch(`index.php?action=getImage&id_product=${id_product}&title=${encodeURIComponent(title)}`);
    const image_url = await response.json();
    console.log(image_url)
    return image_url;
    */
}

async function getAnnonceReserved($id_user) {
    const reponse = await fetch(`index.php?action=reservedAnnoncement&id_user=${$id_user}`);
    const annonce_json = await reponse.json();
    console.log( annonce_json)
    return annonce_json;
}

async function getListAnnoncementEnd(id_user) {
    const reponse = await fetch(`index.php?action=LisAnnoncementEnd&id_user=${id_user}`)
    const annonce_json = await reponse.json();
    console.log(annonce_json)
    return annonce_json
}


addEventListener('DOMContentLoaded', afficher);
