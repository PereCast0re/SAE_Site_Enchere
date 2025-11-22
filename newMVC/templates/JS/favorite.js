const btnFav = document.querySelector('#fav')

btnFav.addEventListener("click", () => {
    const idProduct = btnFav.dataset.idProduct;
    let data;
    const value = !(btnFav.dataset.isFav === "true");

    if (value) {
        console.log("j'ajoute le produit en favoris");

        fetch("index.php?action=favorite&id=" + idProduct)
        .then(r => r.text())
        .then(data => {
            if (data === "not_logged") {
                window.location.href = "index.php?action=connection";
                return;
            }});
        
        btnFav.textContent = "★";
    } else {
        console.log("j'enlève");

        btnFav.textContent = "☆";
    }
    
    btnFav.dataset.isFav = value;
    // btnFav.textContent = value ? "★" : "☆";

    console.log(idProduct, value);
})