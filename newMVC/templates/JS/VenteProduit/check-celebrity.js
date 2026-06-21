/////// Import ///////
import { getSaisieCelebrity } from "../call-api.js";

// Fonction pour vérifié sur une célébrité qui existe en base de donnée
// Si la saisie utilisater correspond a une célébrité alors on lui renvoie dans une liste déroulante en dessous de sa saisie
// Sinon on l'avertie que c'est une nouvelle et que les administrateur vont devoir valider l'annonce
export async function checkExistingCelebrity() {
    let div = document.getElementById('celebrity_results')
    div.innerHTML = "";
    const inputCelebrite = document.getElementById('inputcelebrity')

    const categories = await getSaisieCelebrity(inputCelebrite.value)
    if(categories && categories.length > 0){
        let html = `<select name="select_celebrity" id="select_celebrity" required>
                <option value="" disabled selected hidden>-- Choisissez une célébrité --</option>
        `;
        for(let c of categories){
            html +=`
                <option id="select_${c.name}">${c.name}</option>
            `
        }
        html += `</select>`;
        div.innerHTML += html;

            const select = document.getElementById('select_celebrity');
            select.addEventListener('change', async function(){
            
            let selectedCategory = document.getElementById('select_celebrity').value;
            inputCelebrite.value = selectedCategory;
            div.innerHTML = "";
        });
    }
    else{
        html = "<p>Vous avez inséré une nouvelle catégorie vôtre annonce seras validé par nos administrateur</p>";
        div.innerHTML += html;
    }
}