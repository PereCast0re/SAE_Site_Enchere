const bidForm = document.querySelector('#bid-form')

bidForm.addEventListener("submit", async (event) => {
    event.preventDefault();
    try {
        const currentPrice = parseInt(bidForm.elements["currentPrice"].value);
        const newPrice = parseInt(bidForm.elements["newPrice"].value);

        if (newPrice <= currentPrice) {

            const bidLabel = bidForm.querySelector('#bid-label');

            const star = document.createElement("span");
            star.textContent = "Le montant doit être supérieur à " + currentPrice + "*";
            star.style.color = "red";

            bidLabel.appendChild(star);
        }
        console.log(currentPrice, newPrice);

        if (confirm("Etes-vous sûr de vouloir enchérir " + newPrice + "€ ?")) {
            // L’utilisateur a cliqué sur OUI
            console.log("Confirmé !");

            const bidButton = document.querySelector('#bid-button');
            const idProduct = bidButton.dataset.idProduct;
            const response = await fetch(`index.php?action=bid&id=${idProduct}`, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({ newPrice })
            });
            const data = await response.text();

            if (data === "not_logged") {
                window.location.href = "index.php?action=connection";
                return;
            }
            if (data === "finished") {
                window.alert("L'annonce est terminé !");
                return;
            }
            if (data === "user_not_accepted") {
                window.alert("Vous êtes déjà le dernier à avoir enchéri !");
                return;
            }
            if (data === "price_not_accepted") {
                window.alert("Vous devez enchérir au dessus de la valeur actuelle !");
                return;
            }
            if (data === "price_not_available") {
                window.alert("Vous ne pouvez pas enchérir pour le moment !");
                return;
            }

            // window.alert(data);
        } else {
            // L’utilisateur a cliqué sur NON
            console.log("Annulé !");
        }

        window.location.reload();
    } catch (e) {
        console.error("Erreur lors du fetch : ", e)
    }
});