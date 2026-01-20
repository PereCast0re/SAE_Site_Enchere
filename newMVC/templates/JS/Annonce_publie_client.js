async function afficher() {
    const values_annoncements = document.getElementById("values_annoncements")
    const div = document.querySelector(".section_annonce_publier")
    const id_user = document.getElementById('id_user');

    json_values = JSON.parse(values_annoncements.value)

    let nb = json_values.length
    console.log(nb)
    console.log(json_values)

    if (nb == 0) {
        div.style.display = 'none'
    }
    else if (nb == 1) {
        div.innerHTML = `<div class="pending_section_header">
                        <p>Vos annonce publiée</p>
                        <div class="separator-line"></div>
                        </div>`
        await print_tab_annoncements(json_values, div)
    }
    else {
        div.innerHTML = `<div class="pending_section_header">
                        <p>Vos annonce publiées</p>
                        <div class="separator-line"></div>
                        </div>`
        await print_tab_annoncements(json_values, div)
    }

    const divAnnonceReserved = document.getElementById("div_end_annoncement_with_reserved")
    await print_end_annoncement_reserved(id_user.value, divAnnonceReserved)

    const divhistorique = document.getElementById('historique_product')
    if (divhistorique){
        await print_historique_annoncement(id_user.value, divhistorique)
    }

    const divAnnonceVerifAdmin = document.getElementById('Product_verif_admin')
    await print_unverifed_product(divAnnonceVerifAdmin, json_values)

    await checkBtnHistorique(id_user.value)
}

async function print_tab_annoncements(annoncements, div) {
    let html = ""
    for (const annonce of annoncements) {
        // on change d'incrément si une annonce est expirée et si elle doit être verifier
        if(new Date(annonce.end_date) < new Date()){continue}
        if(annonce.status == 0){continue}
        let price = await getPrice(annonce.id_product);
        if (price.last_price === null) {
            price.last_price = annonce.start_price;
        }

        let like = await getLikes(annonce.id_product);
        if (like.nbLike === null) {
            like.nbLike = 0;
        }
        let image_url = await getImage(annonce.id_product);
        let firstImg = (
            Array.isArray(image_url) &&
            image_url.length > 0 &&
            image_url[0].url_image
        ) ? image_url[0].url_image : "assets/default.png";

        celebrity = await getCelebrity(annonce.id_product);
        if (celebrity != null){
            if (celebrity.url == null){
                celebrity.url = 'templates/Images/profil-icon.png'
            }
        }

        category = await getCategory(annonce.id_product);
        console.log("category")
        console.log(category)

        let city = document.getElementById('city_hidden').value;

        html +=
            `
            <div class="annonce_wrapper">
                <div class="annonce_card">
                    <img class="annonce_img" src="${firstImg}" alt="${annonce.title}" />
                    <div class="annonce_info_top">
                        <span class="categorie_annonce">${category.name}</span>
                        <span class="ville_annonce">${city}</span>
                    </div>
                    <div class="annonce_details">
                        <h3 class="annonce_title">${annonce.title}</h3>
                        <div class="annonce_meta">
                            <span class="timer_display timer" data-end="${annonce.end_date}">Chargement...</span>
                            <span class="price_display price_annonce_${annonce.id_product}">${price.last_price} €</span>
                            <a href="index.php?action=product&id=${annonce.id_product}">Voir</a>
                        </div>
                        <button type='button' class='btn_moreoption' onclick='ShowPopUpOption(${annonce.id_product})'>...</button>
                        <div class="user_info">
                            <img class="celebrity_img" src="${celebrity.url}" alt="${celebrity.name}" />
                            <span>Celebrite : ${celebrity.name}</span>
                            <span>Like(s): ${like.nbLike}</span>
                            <button type='button' class='stat_button'>Voir les statistiques</button>
                        </div>
                    </div>
                </div>
                <div class="stat_annonce${annonce.id_product}"></div>
            </div>
            `
    };

    div.innerHTML += html;

    document.querySelectorAll('.timer').forEach(timerElement => {
        const endDate = timerElement.getAttribute('data-end');
        if (endDate) {
            startCountdown(endDate, timerElement);
        }
    });

    document.querySelectorAll('.stat_button').forEach((button, index) => {
        button.addEventListener('click', () => {
            PrintStatAnnonce(annoncements[index]);
        });
    });
}

async function print_unverifed_product(div, annoncements) {
    console.log("print unverifed");
    
    // Vérification de la présence d'annonces
    $nb = annoncements.some(a => a.status === 0);

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
        // Correction : si annoncements est un objet avec 'statut', s'assurer de boucler sur la bonne propriété 
        // ou adapter selon la structure de ton JSON
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

// Div when a annoncement is end and if a reserved price is set and the finsih price is under of reserved price
async function print_end_annoncement_reserved($id_user, div) {
    let annoncements = await getAnnonceReserved($id_user);
    const nbreserved = annoncements.some(a => a.reserve_price !== null);

    if (nbreserved) {
        console.log('on passe en block reserved')
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
                        <img class="annonce_img" src="${firstImg}" alt="${annonce.title}" />
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

    document.querySelectorAll('.btn_agree').forEach((button) => {
        button.addEventListener('click', async () => {
            const id_product = button.getAttribute('data-id');
            const lastPrice = await getPrice(id_product);
            alertConfirmation('Accepter la dernière offre et conclure la vente ' + lastPrice.last_price +'  ?', 'acceptReservedPrice', id_product);
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

/////////////////////////////////
// Statistiques //
/////////////////////////////////

let chartV = null;
let chartP = null;

function createChart(chart, type, annoncement) {
    const canvas = document.getElementById('myChart' + type);
    console.log('myChart' + type);
    const ctx = canvas.getContext('2d');

    if (chart) chart.destroy(); // Supprimer l'ancien graphique
    chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: "",
                data: []
            }]
        },
        options: {
            responsive: true
        }
    });



    // Quand on change de type pour les stats
    document.getElementById('chartType' + type).addEventListener('change', async function () {
        updateChart(chart, this.value, type, annoncement);
        // console.log(chart);
        // console.log(dataValues, labels);
    });

    return chart;
}

async function updateChart(chart, option, type, annoncement) {
    let labels = [];
    let dataValues = [];
    let data = null;

    switch (type) {
        case 'V':
            data = await getViewsWithOption(annoncement["id_product"], option);
            break;
        case 'P':
            data = await getPriceWithOption(annoncement["id_product"], option);
            break;
    }

    if (data === null) {
        if (chart) chart.destroy();
    } else {
        data.forEach(content => {
            labels.push(content.date);
            dataValues.push(content.value);
        });

        chart.data = {
            labels: labels,
            datasets: [{
                label: type == 'V' ? "Nombre de vues" : "Prix",
                data: dataValues,
                backgroundColor: ['red', 'blue', 'green']
            }]
        }
        chart.update();
    }
}

async function PrintStatAnnonce(annoncement) {
    // console.log(annoncement);

    const divStat = document.querySelector(`.stat_annonce${annoncement.id_product}`);
    divStat.style.display = 'block'
    divStat.innerHTML = "";
    let html = "";
    html = `
        <div class="stat_annonce_inner">
            <div class="charts_controls" style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:10px;align-items:center;">
                <button class='btn_close_stat'>X</button>
                <div>
                    <div class="chart-title">Évolution du nombre de vues</div>
                    <select id="chartTypeV">
                        <option value="D">Par jour</option>
                        <option value="M">Par mois</option>
                        <option value="Y">Par an</option>
                    </select>
                </div>
                <div>
                    <div class="chart-title">Évolution du prix</div>
                    <select id="chartTypeP">
                        <option value="D">Par jour</option>
                        <option value="M">Par mois</option>
                        <option value="Y">Par an</option>
                    </select>
                </div>
            </div>

            <div class="charts_container">
                <div class="chart-box">
                    <div class="chart-title">Nombre de vues</div>
                    <canvas id="myChartV"></canvas>
                </div>
                <div class="chart-box">
                    <div class="chart-title">Prix</div>
                    <canvas id="myChartP"></canvas>
                </div>
            </div>
        </div>
    `;

    divStat.innerHTML = html;

    data = await getPriceWithOption(annoncement["id_product"], 'D');
    console.log(data);

    chartV = createChart(chartV, 'V', annoncement);
    updateChart(chartV, 'D', 'V', annoncement);

    chartP = createChart(chartP, 'P', annoncement);
    updateChart(chartP, 'D', 'P', annoncement);

    document.querySelectorAll('.btn_close_stat').forEach((button, index) => {
        button.addEventListener('click', () => {
            divStat.style.display = 'none'
        });
    });
}

async function checkBtnHistorique(id_user) {
    product = await getListAnnoncementEnd(id_user) 
    if (product && product.length >= 1) {
        btn.style.display = "block"
    }
}


/////////////////////////////////////////////////////////////
//Fonction Affichage Personalisé//
////////////////////////////////////////////////////////////

function checkEndPrice(lastPrice) {
    if (lastPrice > 0) {
        return "<p> Vendu pour " + lastPrice + "€ </p>"
    }
    else {
        return "<p>Produit non vendu !<p>"
    }
}

async function alertConfirmation(message, action, id_product) {
    const popup = document.createElement('div')
    console.log("affichage la popup")
    popup.classList.add('popup-overlay');
    popup.innerHTML = `
    <div class="popup-box">
        <p>${message}</p>
        <div style="display: flex; justify-content: space-around; margin-top: 15px;">
            <button class="btnConfirm">Accepter</button>
            <button class="btnCancel">Quitter</button>
        </div>
    </div>
`;

    document.body.appendChild(popup);

    let button = popup.querySelector(".btnConfirm")
    // Si on a besoin de refaire une redirection (avec navigation dans les pages) on simule l'envoie d'un form 
    button.addEventListener('click', async () =>{
        if (action === 'updateProduct') {
            const frm = document.createElement('form')
            frm.value = id_product
            frm.action = 'index.php?action=updateProduct'
            frm.method = 'POST'
            frm.style.display = 'none'

            const input = document.createElement('input')
            input.type = 'hidden'
            input.name = 'id_product'
            input.value = id_product
            frm.appendChild(input)

            document.body.appendChild(frm)
            frm.submit()
            return
        }
        await fetch(`index.php?action=${action}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id_product=${id_product}`
        });
        popup.remove();
        location.reload();
    })

    let cancel = popup.querySelector(".btnCancel")
    cancel.addEventListener('click', () =>{
        popup.remove();
    })
}

async function printGraph(id, title, allData) {
    let graph = ""
    

}

async function ShowPopUpOption(id_product) { // On reçoit l'ID ici
    const popup = document.createElement('div');
    popup.classList.add('popup-overlay'); 
    popup.innerHTML = `
    <div class="popup-box">
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <button class="btnsupprimer" style="background: #ff4444; color: white;">Supprimer</button>
            <button class="btnmodifier">Modifier</button>
            <button class="btn_retour">Retour</button>
        </div>
    </div>`;

    document.body.appendChild(popup);

    // BOUTON SUPPRIMER
    popup.querySelector('.btnsupprimer').addEventListener('click', () => {
        alertConfirmation('Voulez-vous vraiment supprimer ce produit ?', 'deleteProduct', id_product);
        popup.remove();
    });

    popup.querySelector('.btnmodifier').addEventListener('click', () => {
        alertConfirmation('Voulez-vous modifier cette annonce ?', 'updateProduct', id_product);
        popup.remove();
    })

    popup.querySelector('.btn_retour').addEventListener('click', () => popup.remove());
}


/////////////////////////////////////////////////////////////
//Fonction API//
////////////////////////////////////////////////////////////

async function deleteProduct(id_product) {
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

async function getPrice(id_product){
    // Appel pour fetch et récupéré le prix actuel
    const price = await fetch(`index.php?action=getLastPrice&id_product=${id_product}`);
    const price_json = await price.json();
    console.log(price_json);
    return price_json;
}

async function getPriceWithOption(id_product, option) {
    // Appel pour fetch et récupéré le prix trié en fonction de "option" donc par jour/année/an 
    const price = await fetch(`index.php?action=getLastPrice&id_product=${id_product}&option=${option}`);
    const price_json = await price.json();
    console.log(price_json);
    return price_json;
}

async function getGlobalViews(id_product) {
    // Appel pour fetch le nombre total de vue
    const views = await fetch(`index.php?action=getGlobalViews&id_product=${id_product}`);
    const views_json = await views.json();
    console.log(views_json);
    return views_json;
}

async function getViewsWithOption(id_product, option) {
    // Appel pour fetch le nombre vue trié en fonction de "option" donc par jour/année/an 
    const views = await fetch(`index.php?action=getGlobalViews&id_product=${id_product}&option=${option}`);
    const views_json = await views.json();
    console.log(views_json);
    return views_json;
}

async function getLikes(id_product) {
    // Appel pour fetch le nombre total de likes
    const likes = await fetch(`index.php?action=getLikes&id_product=${id_product}`);
    const likes_json = await likes.json();
    console.log(likes_json);
    return likes_json;
}

async function getAnnonceReserved($id_user) {
    const reponse = await fetch(`index.php?action=reservedAnnoncement&id_user=${$id_user}`);
    const annonce_json = await reponse.json();
    console.log(annonce_json)
    return annonce_json;
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

async function getCelebrity(id_product) {
    const response = await fetch(`index.php?action=getCelebrityFromProduct&id_product=${id_product}`);
    const celebrity_json = await response.json();
    console.log(celebrity_json);
    return celebrity_json;
}

async function getCategory(id_product) {
    const response = await fetch(`index.php?action=getCategoryFromProduct&id_product=${id_product}`);
    const category_json = await response.json();
    console.log(category_json);
    return category_json;
}


addEventListener('DOMContentLoaded', afficher);
