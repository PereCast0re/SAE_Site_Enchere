async function afficherInputPrixReserve(){
    const checkbox = document.getElementById('prix_reserve_checkbox')
    const div = document.getElementById('input_prix_reserve')

    if( checkbox.checked){
        div.innerHTML = '<input type="number" name="valeur_reserve" value="prix_reserve">'
    }
    else{
        div.innerHTML = ""
    }
}

async function checkExistingCategory() {
    let div = document.getElementById('categorie_results')
    div.innerHTML = "";
    let inputCategorie = document.getElementById('lst_categorie_vente');

    const categories = await getCategories(inputCategorie.value);

    let html = `<select name="select_categorie_vente" id="select_categorie_vente" required>`;
    for(let c of categories){
        html +=`
            <option id="select_${c.name}">${c.name}</option>
        `
    }
    html += `</select>`;
    div.innerHTML += html;

    select = document.getElementById('select_categorie_vente');
    select.addEventListener('click', async function(){
        let selectedCategory = document.getElementById('select_categorie_vente').value;
        inputCategorie.value = selectedCategory;
    });
}

async function getCategories(input) {
    const reponse = await fetch(`index.php?action=getCategoriesMod&writting=${encodeURIComponent(input)}`);
    const reponse_json = await reponse.json();
    console.log(reponse_json);
    return reponse_json;
}

/////////////// Celebritée /////////////////////

async function checkExistingCelebrity() {
    let div = document.getElementById('celebrity_results')
    div.innerHTML = "";
    const inputCelebrite = document.getElementById('inputcelebrity')

    const categories = await getCelebrity(inputCelebrite.value);

    let html = `<select name="select_celebrity" id="select_celebrity" required>`;
    for(let c of categories){
        html +=`
            <option id="select_${c.name}">${c.name}</option>
        `
    }
    html += `</select>`;
    div.innerHTML += html;

    select = document.getElementById('select_celebrity');
    select.addEventListener('click', async function(){
        let selectedCategory = document.getElementById('select_celebrity').value;
        inputCelebrite.value = selectedCategory;
    });
}

async function getCelebrity(input) {
    const reponse = await fetch(`index.php?action=getCelebrityMod&writting=${encodeURIComponent(input)}`);
    const reponse_json = await reponse.json();
    console.log(reponse_json);
    return reponse_json;
}

////////////// Event Listener //////////////

const inputCategorie = document.getElementById('lst_categorie_vente');
inputCategorie.addEventListener("input", checkExistingCategory);

const inputCelebrite = document.getElementById('inputcelebrity')
inputCelebrite.addEventListener("input", checkExistingCelebrity)


////////////// Image previsualisation //////////////
document.querySelectorAll('.img_selector_input').forEach(input => {
    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        // Récupérer l'image correspondante
        const index = this.id.replace('img', ''); // ex: "1", "2"
        const preview = document.getElementById('img_preview_' + index);

        // Afficher l'image sélectionnée
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);

        // Masquer le bouton
        const label = document.querySelector('label[for="' + input.id + '"]');
        if (label) label.style.display = 'none';
    });
});


////////////// PDF previsualisation //////////////
const pdfInput = document.getElementById('certificat_authenticite');
const pdfPreview = document.getElementById('pdf_preview');

if (pdfInput && pdfPreview) {
    pdfInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file && file.type === "application/pdf") {
            // Création d'une URL temporaire pour le PDF
            const blobUrl = URL.createObjectURL(file);
            pdfPreview.src = blobUrl;
            pdfPreview.style.display = 'block';
        } else {
            pdfPreview.style.display = 'none';
        }
    });
}