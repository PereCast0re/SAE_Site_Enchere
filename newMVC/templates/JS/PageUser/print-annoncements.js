import { getPrice } from "../call-api.js";
import { getImage } from "../call-api.js";
import { getLikes } from "../call-api.js";
import { getCelebrity } from "../call-api.js";
import { getCategory } from "../call-api.js";
import { ShowPopUpOption } from "./show-popup.js";
import { startCountdown } from "./timer-annonce.js";
import { PrintStatAnnonce } from "./statistique.js";

export async function print_tab_annoncements(annoncements, div) {
    console.log("print_tab_annoncements start")
    let html = ""
    for (const annonce of annoncements) {
        // on change d'incrément si une annonce est expirée et si elle doit être verifier
        if (new Date(annonce.end_date) < new Date()) { continue }
        if (annonce.status == 0) { continue }
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

        let celebrity = await getCelebrity(annonce.id_product);
        if (celebrity != null) {
            if (celebrity.url == null) {
                celebrity.url = 'templates/Images/profil-icon.png'
            }
        }

        let category = await getCategory(annonce.id_product);
        if (!category) { 
            category = { name: 'Non défini' }; 
        }
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
                        </div>
                        <div class="user_info">
                            <a href="index.php?action=product&id=${annonce.id_product}">Voir</a>
                        </div>
                        <button type='button' class='btn_moreoption'data-id="${annonce.id_product}">...</button>
                        <div class="user_info">
                            <img class="celebrity_img" src="${celebrity.url}" alt="${celebrity.name}" />
                            <span>Celebrite : ${celebrity.name}</span>
                            <span>Like(s): ${like.nbLike}</span>
                            <button type='button' class='stat_button'>Voir les statistiques</button>
                        </div>
                    </div>
                </div>
                <div id="stat_annonce${annonce.id_product}" class="stat_annonce${annonce.id_product}"></div>
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
            const divStat = button.closest('.annonce_wrapper').querySelector('[class^="stat_annonce"]');
            PrintStatAnnonce(annoncements[index], divStat);
        });
    });

    document.querySelectorAll('.btn_moreoption').forEach((button) => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            ShowPopUpOption(id);
        });
    });
}