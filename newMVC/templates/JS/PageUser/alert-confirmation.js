export async function alertConfirmation(message, action, id_product) {
    const popup = document.createElement('div')
    console.log("affichage la popup")
    popup.classList.add('popup-overlay');
    popup.innerHTML = `
    <div class="popup-box">
        <p>${message}</p>
        <div style="display: flex; justify-content: space-around; margin-top: 15px;">
            <button class="btnConfirm">Accepter</button>
            <button class="btnCancel">Quitter</button>
        </div>
    </div>
`;

    document.body.appendChild(popup);

    let button = popup.querySelector(".btnConfirm")
    // Si on a besoin de refaire une redirection (avec navigation dans les pages) on simule l'envoie d'un form 
    button.addEventListener('click', async () => {
        if (action === 'updateProduct') {
            const frm = document.createElement('form')
            frm.value = id_product
            frm.action = 'index.php?action=updateProduct'
            frm.method = 'POST'
            frm.style.display = 'none'

            const input = document.createElement('input')
            input.type = 'hidden'
            input.name = 'id_product'
            input.value = id_product
            frm.appendChild(input)

            document.body.appendChild(frm)
            frm.submit()
            return
        }
        const response = await fetch(`index.php?action=${action}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id_product=${id_product}`
        });
        // Il faudra gérer les erreurs
        // const trueResponse = await response.json()
        // console.log(trueResponse);
        popup.remove();
        location.reload();
    })

    let cancel = popup.querySelector(".btnCancel")
    cancel.addEventListener('click', () => {
        popup.remove();
    })
}
