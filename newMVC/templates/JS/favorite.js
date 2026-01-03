const btnFav = document.querySelector('#fav')
let active = false;

btnFav.addEventListener("click", async () => {
    if (active) return;
    try {
        active = true;
        const idProduct = btnFav.dataset.idProduct;
        const value = !(btnFav.dataset.isFav === "true");

        if (value) {
            // console.log("j'ajoute le produit en favoris");

            const response = await fetch("index.php?action=favorite&id=" + idProduct);
            const data = await response.text();

            if (data === "not_logged") {
                window.location.href = "index.php?action=connection";
                return;
            }

            btnFav.textContent = "★";
        } else {
            // console.log("j'enlève");

            const response = await fetch("index.php?action=unfavorite&id=" + idProduct);
            const data = await response.text();

            if (data === "not_logged") {
                window.location.href = "index.php?action=connection";
                return;
            }

            btnFav.textContent = "☆";
        }

        btnFav.dataset.isFav = value;
        // btnFav.textContent = value ? "★" : "☆";

        // console.log(idProduct, value);

        window.location.reload();

        // Réactive le clic après 1s (éviter les abus)
        setTimeout(() => active = false, 1000);
    } catch (e) {
        console.error("Erreur lors du fetch : ", e)
        setTimeout(() => active = false, 1000);
    }
})