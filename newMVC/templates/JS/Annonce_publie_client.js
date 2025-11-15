async function afficher() {
    const values_annoncements = document.getElementById("values_annoncements")
    const div = document.querySelector(".section_annonce_publier")
    
    let json_values = []
    json_values = JSON.parse(values_annoncements.value)
    let nb = json_values.length
    console.log(nb)
    console.log(json_values)

    if(nb == 0){
        div.style.display = 'none'
    }
    else if (nb == 1){
        div.innerHTML = '<h2>Vôtre annonce publié</h2>'
        print_tab_annoncements(json_values, div)
    }
    else{
        div.innerHTML = '<h2>Vos annonces publiées</h2>'
        print_tab_annoncements(json_values, div)
    }

}

function print_tab_annoncements(annoncements, div){
    let html = ""
    annoncements.forEach(annonce => {
        html += 
            `
            <div class="annonce" style="color: red; padding: 10px;">
                <table>
                    <tbody>
                    <tr>
                        <td>${annonce.title}</td>
                        <td><span class="timer" data-end="${annonce.end_date}">Chargement...</span></td>
                        <td>${ "A faire" } €</td>
                        <td><a href="../Controlleur/C_routeur.php?action=load_product&id_product=${annonce.id_product}">See Annonce</a></td>
                    </tr>
                    <tr>
                        <td>daily nb view</td>
                        <td>global nb view</td>
                        <td>nb like</td>
                        <td><a> See stats </a></td>
                    </tr>
                </tbody>
                </table>
            </div>
            `
    });
    
    // Aider avec ia car code collegue non compris 
    // Ajouter le HTML à la div
    div.innerHTML += html;
    
    // Initialiser les timers après avoir ajouté le HTML
    document.querySelectorAll('.timer').forEach(timerElement => {
        const endDate = timerElement.getAttribute('data-end');
        if (endDate) {
            startCountdown(endDate, timerElement);
        }
    });
}

async function current_price(id_annoncement) {
    const request = await fetch('../Controlleur/C_pageUser.php&action=get_current_price&id=${id_annoncement}')
    const value = await request.json()
    return value
}


addEventListener('DOMContentLoaded', afficher)

