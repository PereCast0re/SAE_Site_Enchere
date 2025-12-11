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

