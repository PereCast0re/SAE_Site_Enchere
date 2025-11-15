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
