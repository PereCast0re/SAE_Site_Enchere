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
        div.innerHTML = '<h2 stryle="text-align: center;">Vôtre annonce publié</h2>'
        await print_tab_annoncements(json_values, div)
    }
    else {
        div.innerHTML = '<h2 style="text-align: center;">Vos annonces publiées</h2>'
        await print_tab_annoncements(json_values, div)
    }

    const divAnnonceReserved = document.getElementById("div_end_annoncement_with_reserved")
    await print_end_annoncement_reserved(id_user.value, divAnnonceReserved)

    const divhistorique = document.getElementById('div_historique_annoncement')
    await print_historique_annoncement(id_user.value, divhistorique)

    const divAnnonceVerifAdmin = document.getElementById('Product_verif_admin')
    await print_unverifed_product(divAnnonceVerifAdmin, json_values)

    await checkBtnHistorique()
}

async function print_tab_annoncements(annoncements, div) {
    let html = ""
    for (const annonce of annoncements) {
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

        html +=
            `
            <input type="hidden" id="id_product" value="${annonce.id_product}"/>
            <div class="annonce_user" style="padding: 10px; display: flex; background: white; border: 2px solid black; box-shadow: black 0px 3px 6px, black 0px 3px 6px; width: 50%; border-radius: 15px; align-items: center; margin-left: 5%; padding: 15px; gap:15px; margin-top:20px;">
                <table>
                    <tbody>
                    <tr>
                        <img src="${firstImg}" style="width: 80px;height: 80px; border-radius: 15px;"/>
                        <td>${annonce.title}</td>
                        <td><span class="timer" data-end="${annonce.end_date}">Chargement...</span></td>
                        <td class="price_annonce_${annonce.id_product}"> ${price.last_price} €</td>
                        <td><a href="index.php?action=product&id=${annonce.id_product}">See Annonce</a></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>photo user</td>
                        <td>utilisateur</td>
                        <td>Like(s) : ${like.nbLike}</td>
                        <td><button type="button" class="stat_button" style="display: block;"> See stats </button></td>
                    </tr>
                </tbody>
                </table>
                <button type='button' class='btn_moreoption' onclick='ShowPopUpOption(${annonce.id_product})'>...</button>
            </div>
            <div class="stat_annonce${annonce.id_product}"></div>
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
    let annonce_attente = "<div class='annonce_attente_validation'> <p style='text-align:center; font-size=15px;'> Annonce en attente de validation par nos Administrateurs </p>"
    for (const annonce of annoncements) {
        if(annonce.status == 1){continue}
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

        annonce_attente += 
            `
            <input type="hidden" id="id_product" value="${annonce.id_product}"/>
            <div class="annonce_user" style="padding: 10px; display: flex; background: white; border: 2px solid black; box-shadow: black 0px 3px 6px, black 0px 3px 6px; width: 50%; border-radius: 15px; align-items: center; margin-left: 5%; padding: 15px; gap:15px; margin-top:20px;">
                <table>
                    <tbody>
                    <tr>
                        <img src="${firstImg}" style="width: 80px;height: 80px; border-radius: 15px;"/>
                        <td>${annonce.title}</td>
                        <td><a href="index.php?action=product&id=${annonce.id_product}">See Annonce</a></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>photo user</td>
                        <td>utilisateur</td>
                    </tr>
                </tbody>
                </table>
                <button type='button' class='btn_moreoption' onclick='ShowPopUpOption(${annonce.id_product})'>...</button>
            </div>
            `
    };
    annonce_attente += '</div>'
    div.innerHTML += annonce_attente;
}

// Div when a annoncement is end and if a reserved price is set and the finsih price is under of reserved price
async function print_end_annoncement_reserved($id_user, div) {
    let annoncements = await getAnnonceReserved($id_user);
    console.log(annoncements)
    if (annoncements.length > 0) {
        div.style = 'display: block;'

        let html = ""
        html.innerHTML += `<h3 style="padding-top:20px;padding-bottom:10px;" >Vos annonces terminer avec prix de réserve non atteint</h3>`

        for (const annonce of annoncements) {

            let image_url = await getImage(annonce.id_product);
            let firstImg = (
                Array.isArray(image_url) &&
                image_url.length > 0 &&
                image_url[0].url_image
            ) ? image_url[0].url_image : "assets/default.png";

            html += `
                <div>
                    <div style="padding: 10px; display: flex; background: white; border: 2px solid black; box-shadow: black 0px 3px 6px, black 0px 3px 6px; width: 50%; border-radius: 15px; align-items: center; margin-left: 5%; padding: 15px; gap:15px; margin-top:20px;">
                        <img src="${firstImg}" style="width: 80px;height: 80px; border-radius: 15px;" />
                        <table>
                            <tbody>
                                <tr>
                                    <td>${annonce.title}</td>
                                    <td>Dernière enchére : <br> ${annonce.new_price} </td>
                                    <td>Vôtre prix de reserve : <br> ${annonce.reserve_price} </td>
                                    <td>
                                        <button id="btn_agree" type="button" style="display: block;">Accepter</button>
                                        <br>
                                        <button id="btn_refuse" type="button" style="display: block;">Refuser</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                `
        }
        div.innerHTML += html;
    }
    else {
        div.style.display = "none"
    }
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
    divStat.innerHTML = "";
    let html = "";
    html = `
        <h1>Évolution du nombre de vues</h1>
        <p>Choisissez le type de graphique :</p>
        <select id="chartTypeV">
            <option value="D">Par jour</option>
            <option value="M">Par mois</option>
            <option value="Y">Par an</option>
        </select>
        <canvas id="myChartV" width="400" height="200" style="max-width: 600px; margin-top: 20px;"></canvas>

        <h1>Évolution du prix</h1>
        <p>Choisissez le type de graphique :</p>
        <select id="chartTypeP">
            <option value="D">Par jour</option>
            <option value="M">Par mois</option>
            <option value="Y">Par an</option>
        </select>
        <canvas id="myChartP" width="400" height="200" style="max-width: 600px; margin-top: 20px;"></canvas>
    `

    divStat.innerHTML += html

    data = await getPriceWithOption(annoncement["id_product"], 'D');
    console.log(data);

    chartV = createChart(chartV, 'V', annoncement);
    updateChart(chartV, 'D', 'V', annoncement);

    chartP = createChart(chartP, 'P', annoncement);
    updateChart(chartP, 'D', 'P', annoncement);
}

//Button republish
//style="display: ${annonce.last_price > 0 ? "none" : "block"};"
async function print_historique_annoncement(id_user, div) {
    let html = ""

    let annoncements = await getListAnnoncementEnd(id_user);

    if (annoncements && annoncements.length > 0) {

        div.style.display = "block"
        div.innerHTML += `<h3 style="padding-top:20px;padding-bottom:10px;"> Vos annonces non concluante </h3>`
        for (const annonce of annoncements) {

            let image_url = await getImage(annonce.id_product);
            let firstImg = (
                Array.isArray(image_url) &&
                image_url.length > 0 &&
                image_url[0].url_image
            ) ? image_url[0].url_image : "assets/default.png";

            html += `
                <div style="padding: 10px; display: flex; background: white; border: 2px solid black; box-shadow: black 0px 3px 6px, black 0px 3px 6px; width: 50%; border-radius: 15px; align-items: center; margin-left: 5%; padding: 15px; gap:15px; margin-top:20px;">
                    <img src="${firstImg}" style="width: 80px;height: 80px; border-radius: 15px;" />
                    <table>
                        <tbody>
                            <tr>
                                <td>${annonce.title}</td>
                                <td id="td_info_lastPrice${annonce.id_product}">${checkEndPrice(annonce.last_price)}</td>
                                <td>
                                    <button id="btn_republish${annonce.id_product}" style="display: block;" type="button" onclick="alertConfirmation('Republiez cette annonce ?', 'republish', ${annonce.id_product})">Republier</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            `
        }
        div.innerHTML += html
    }
    else {
        div.style.display = "none"
        console.log('Aucune annonce dans votre historique !')
    }
}

async function checkBtnHistorique() {
    const btn = document.getElementById("btn_historique_annonce_published")
    btn.style.display = "none"

    const div_publier = await document.querySelector(".section_annonce_publier")
    const div_reserve = await document.getElementById("div_end_annoncement_with_reserved")
    const div_finish = await document.getElementById('div_historique_annoncement')
    if (div_finish.style.display === "none" && div_publier.style.display === "none" && div_reserve.style.display === "none") {
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
    button.addEventListener('click', async () =>{
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


addEventListener('DOMContentLoaded', afficher);
