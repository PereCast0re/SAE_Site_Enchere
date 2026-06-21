/////// Import ///////
import { afficherInputPrixReserve } from "./print-input-reserved-price.js";
import { checkExistingCategory } from "./check-category.js";
import { checkExistingCelebrity } from "./check-celebrity.js";

////////////// Event Listener Pour la page de vente //////////////

/// Event Listener pour affichée le champs de saisie du prix de réserve au clique
document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.getElementById('prix_reserve_checkbox');
    if(checkbox.checked){
        const div = document.getElementById('input_prix_reserve')
        div.innerHTML = '<input type="number" name="valeur_reserve" value="' + checkbox.value + '">'
    }
});

/// Event listener pour verifié si le checkbox et checked
const inputPrixReserve = document.getElementById("prix_reserve_checkbox")
inputPrixReserve.addEventListener("change", afficherInputPrixReserve)

/// Event listener pour verifier si la catégorie existe
const inputCategorie = document.getElementById('lst_categorie_vente');
inputCategorie.addEventListener("input", checkExistingCategory);

/// Event listener pour verifier si la célébrité existe
const inputCelebrite = document.getElementById('inputcelebrity')
inputCelebrite.addEventListener("input", checkExistingCelebrity)

/// Event listener pour la gestion des images
document.querySelectorAll('.img_selector_input').forEach(input => {
    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        // Récupérer l'image correspondante
        const index = this.id.replace('img', '');
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

/// Gestion de la prévisualisation du pdf
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