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

    await checkBtnHistorique()
}

async function print_tab_annoncements(annoncements, div) {
    let html = ""
    for (const annonce of annoncements) {
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

let chart = null;

const labels = ["BUT Info", "BUT GEA", "BUT MMI"];
const dataValues = [30, 20, 25];

function PrintStatAnnonce(annoncement) {

    console.log(annoncement);

    function createChart(type, labels, dataValues) {
        const canvas = document.getElementById('myChart');
        const ctx = canvas.getContext('2d');

        if (chart) chart.destroy(); // Supprimer l'ancien graphique
        chart = new Chart(ctx, {
            type: type,
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nombre d\'étudiants',
                    data: dataValues,
                    backgroundColor: ['red', 'blue', 'green']
                }]
            },
            options: {
                responsive: true,
                animation: {
                    duration: 800,
                    animateScale: true,
                    animateRotate: true
                },
                scales: type !== 'pie' ? {
                    y: { beginAtZero: true }
                } : {}
            },
        });

        // Quand on change de type pour les stats
        document.getElementById('chartType').addEventListener('change', function () {
            createChart(this.value, labels, dataValues);
            console.log(chart);
        });
    }

    const divStat = document.querySelector(`.stat_annonce${annoncement.id_product}`)
    divStat.innerHTML = ""
    let html = ""
    html = `
        <h1>Statistiques étudiantes</h1>
        <p>Choisissez le type de graphique :</p>
        <select id="chartType">
            <option value="bar">Barres</option>
            <option value="line">Lignes</option>
            <option value="pie">Camembert</option>
        </select>
        <canvas id="myChart" width="400" height="200" style="max-width: 600px; margin-top: 20px;"></canvas>
    `

    divStat.innerHTML += html

    const labels = ["BUT Info", "BUT GEA", "BUT MMI"];
    const dataValues = [30, 20, 25];

    createChart("bar", labels, dataValues);
    printGraph(`graphLike_${annoncement.id_product}`)
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
//Fonction Affichage personalisée//
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
            <button id="btnConfirm">Accepter</button>
            <button id="btnCancel">Refuser</button>
        </div>
    </div>
`;

    document.body.appendChild(popup);

    let button = document.querySelector("#btnConfirm")
    button.addEventListener('click', async () => {
        await fetch(`index.php?action=${action}&id_product=${id_product}`);
        popup.remove();
    })

    let cancel = document.querySelector("#btnCancel")
    cancel.addEventListener('click', () => {
        popup.remove();
    })
}

async function printGraph(id, title, allData) {
    let graph = ""


}


/////////////////////////////////////////////////////////////
//Fonction API//
////////////////////////////////////////////////////////////

async function getPrice(id_product) {
    // Appel pour fetch et récupéré le prix actuel
    const price = await fetch(`index.php?action=getLastPrice&id_product=${id_product}`);
    const price_json = await price.json();
    console.log(price_json);
    return price_json;
}

async function getGlobalViews(id_product) {
    // Appel pour fetch et récupéré le prix actuel
    const views = await fetch(`index.php?action=getGlobalViews&id_product=${id_product}`);
    const views_json = await views.json();
    console.log(views_json);
    return views_json;
}

async function getLikes(id_product) {
    // Appel pour fetch et récupéré le prix actuel
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
