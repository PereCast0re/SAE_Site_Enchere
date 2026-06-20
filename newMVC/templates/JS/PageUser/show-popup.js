import { alertConfirmation } from "./alert-confirmation.js";

export async function ShowPopUpOption(id_product) { // On reçoit l'ID ici
    const popup = document.createElement('div');
    popup.classList.add('popup-overlay');
    popup.innerHTML = `
    <div class="popup-box">
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <button class="btnsupprimer" style="background: #ff4444; color: white;">Supprimer</button>
            <button class="btnmodifier">Modifier</button>
            <button class="btn_retour">Retour</button>
        </div>
    </div>`;

    document.body.appendChild(popup);

    // BOUTON SUPPRIMER
    popup.querySelector('.btnsupprimer').addEventListener('click', () => {
        alertConfirmation('Voulez-vous vraiment supprimer ce produit ?', 'deleteProduct', id_product);
        popup.remove();
    });

    popup.querySelector('.btnmodifier').addEventListener('click', () => {
        alertConfirmation('Voulez-vous modifier cette annonce ?', 'updateProduct', id_product);
        popup.remove();
    })

    popup.querySelector('.btn_retour').addEventListener('click', () => popup.remove());
}

