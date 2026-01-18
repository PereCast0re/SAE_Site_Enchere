const btnFav = document.querySelector('#fav')
let active = false;
const fullHeart = '<i class="fa-solid fa-heart"></i>';
const emptyHeart = '<i class="fa-regular fa-heart"></i>';

btnFav.addEventListener("click", async () => {
    if (active) return;
    try {
        active = true;
        const idProduct = document.querySelector('#idProduct').value;
        console.log(idProduct);
        const value = !(btnFav.dataset.isFav === "true");

        if (value) {
            console.log("j'ajoute le produit en favoris");

            const response = await fetch("index.php?action=favorite&id=" + idProduct);
            const data = await response.text();

            if (data === "not_logged") {
                window.location.href = "index.php?action=connection";
                return;
            }

            btnFav.innerHTML = fullHeart;
        } else {
            console.log("j'enlève");

            const response = await fetch("index.php?action=unfavorite&id=" + idProduct);
            const data = await response.text();

            if (data === "not_logged") {
                window.location.href = "index.php?action=connection";
                return;
            }

            btnFav.innerHTML = emptyHeart;
        }

        btnFav.dataset.isFav = value;
        // btnFav.textContent = value ? "★" : "☆";

        // console.log(idProduct, value);

        // window.location.reload();

        // Réactive le clic après 1s (éviter les abus)
        setTimeout(() => active = false, 1000);
    } catch (e) {
        console.error("Erreur lors du fetch : ", e)
        setTimeout(() => active = false, 1000);
    }
})