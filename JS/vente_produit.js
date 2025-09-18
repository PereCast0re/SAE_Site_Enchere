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

async function affichageImage() {
    const fileInput = document.querySelector('input[type=file]')
    const file = fileInput.files[0]

    if (file){
        const reader = new FileReader
        reader.onload = function(e){
            // on remplie les différents img en fonction de leur dispo
            for (let i = 1; i <= 4; i++){
                const img = document.getElementById('img_annonce_' + i)
                if (!img.getAttribute("src")){
                    img.src = e.target.result;
                    break;
                }
            }
        }
        reader.readAsDataURL(file);
    }
}
