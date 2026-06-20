/////// Import 
import { getSaisiCategories } from "../call-api.js";

///////////////////// Categorie /////////////////////////////

export async function checkExistingCategory() {
    let div = document.getElementById('categorie_results')
    let inputCategorie = document.getElementById('lst_categorie_vente');
    div.innerHTML = "";

    const categories = await getSaisiCategories(inputCategorie.value);
    
    if (categories && categories.length > 0){
        let html = `<select name="select_categorie_vente" id="select_categorie_vente">
                <option value="" disabled selected hidden>-- Choisissez une catégorie --</option>
            `;
        for(let c of categories){
            html +=`
                <option id="select_${c.name}">${c.name}</option>
            `
        }
        html += `</select>`;
        div.innerHTML += html;

            const select = document.getElementById('select_categorie_vente');

            select.addEventListener('change', async function(){
            let selectedCategory = document.getElementById('select_categorie_vente').value;
            inputCategorie.value = selectedCategory;
            div.innerHTML = "";
        });
    }
    else{
        html = "<p>Vous avez inséré une nouvelle catégorie vôtre annonce seras validé par nos administrateur</p>";
        div.innerHTML += html;
    }
}