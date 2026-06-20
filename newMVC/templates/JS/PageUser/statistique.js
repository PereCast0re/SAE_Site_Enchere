/////////////////////////////////
// Statistiques //
/////////////////////////////////

import {getPriceWithOption, getViewsWithOption} from '../call-api.js'

let chartV = null;
let chartP = null;

export function createChart(chart, type, annoncement) {
    const canvas = document.getElementById('myChart' + type);
    console.log('myChart' + type);
    const ctx = canvas.getContext('2d');

    if (chart) chart.destroy(); // Supprimer l'ancien graphique
    chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: "",
                data: []
            }]
        },
        options: {
            responsive: true
        }
    });



    // Quand on change de type pour les stats
    document.getElementById('chartType' + type).addEventListener('change', async function () {
        updateChart(chart, this.value, type, annoncement);
        // console.log(chart);
        // console.log(dataValues, labels);
    });

    return chart;
}

export async function updateChart(chart, option, type, annoncement) {
    let labels = [];
    let dataValues = [];
    let data = null;

    switch (type) {
        case 'V':
            data = await getViewsWithOption(annoncement["id_product"], option);
            break;
        case 'P':
            data = await getPriceWithOption(annoncement["id_product"], option);
            break;
    }

    if (data === null) {
        if (chart) chart.destroy();
    } else {
        data.forEach(content => {
            labels.push(content.date);
            dataValues.push(content.value);
        });

        chart.data = {
            labels: labels,
            datasets: [{
                label: type == 'V' ? "Nombre de vues" : "Prix",
                data: dataValues,
                backgroundColor: ['red', 'blue', 'green']
            }]
        }
        chart.update();
    }
}

export async function PrintStatAnnonce(annoncement, divStat) {
    // console.log(annoncement);

    if (annoncement){
        console.log(annoncement.id_product)
    }
    else {
        console.log("pas load !!!")
    }
    
    divStat.style.display = 'block'
    divStat.innerHTML = "";
    let html = "";
    html = `
        <div class="stat_annonce_inner">
            <div class="charts_controls" style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:10px;align-items:center;">
                <button class='btn_close_stat'>X</button>
                <div>
                    <div class="chart-title">Évolution du nombre de vues</div>
                    <select id="chartTypeV">
                        <option value="D">Par jour</option>
                        <option value="M">Par mois</option>
                        <option value="Y">Par an</option>
                    </select>
                </div>
                <div>
                    <div class="chart-title">Évolution du prix</div>
                    <select id="chartTypeP">
                        <option value="D">Par jour</option>
                        <option value="M">Par mois</option>
                        <option value="Y">Par an</option>
                    </select>
                </div>
            </div>

            <div class="charts_container">
                <div class="chart-box">
                    <div class="chart-title">Nombre de vues</div>
                    <canvas id="myChartV"></canvas>
                </div>
                <div class="chart-box">
                    <div class="chart-title">Prix</div>
                    <canvas id="myChartP"></canvas>
                </div>
            </div>
        </div>
    `;

    divStat.innerHTML = html;

    const data = await getPriceWithOption(annoncement["id_product"], 'D');
    console.log(data);

    chartV = createChart(chartV, 'V', annoncement);
    updateChart(chartV, 'D', 'V', annoncement);

    chartP = createChart(chartP, 'P', annoncement);
    updateChart(chartP, 'D', 'P', annoncement);

    document.querySelectorAll('.btn_close_stat').forEach((button, index) => {
        button.addEventListener('click', () => {
            divStat.style.display = 'none'
            window.location.reload();
        });
    });
}
