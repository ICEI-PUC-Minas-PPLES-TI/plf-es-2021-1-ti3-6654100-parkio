const url = '/api/vehicles';

// Capturar e renderizar veículos de visistantes cadastrados
async function renderVehicles() {

    const width_resolution = window.screen.width;

    fetch(url)
    .then(response => response.json()) // retorna uma promise
    .then(result => {
        console.log(result.data)
        
        
        let html = '';
        result.data.forEach(vehicle => {

            let created_at = new Date(vehicle.created_at);
            let created_at_formatada = ((created_at.getDate().toString().padStart(2, "0"))) + "/" + ((created_at.getMonth() + 1).toString().padStart(2, "0")) + "/" + created_at.getFullYear() + " " + (created_at.getHours().toString().padStart(2, "0")) + ":" + (created_at.getMinutes().toString().padStart(2, "0")); 
            
            let left_at = new Date(vehicle.left_at);
            let left_at_formatada = ((left_at.getDate().toString().padStart(2, "0"))) + "/" + ((left_at.getMonth() + 1).toString().padStart(2, "0")) + "/" + left_at.getFullYear() + " " + (left_at.getHours().toString().padStart(2, "0")) + ":" + (left_at.getMinutes().toString().padStart(2, "0")); 
            
            let gate = vehicle.gate.description;          

            var htmlSegment;
            if(width_resolution>900) {
                htmlSegment =   `<tr>
                                    <td scope="row">${vehicle.plate}</th>
                                    <td>${vehicle.model}</td>
                                    <td> <span style="backgroud-color: ${vehicle.color};"></span>${vehicle.color}</td>
                                    <td>${gate}</td>
                                    <td>${vehicle.user_in.name}</td>
                                    <td>${created_at_formatada}</td>
                                    <td>${left_at_formatada}</td>
                                    <td>
                                        <button lass="btn btn-secondary"><i class="fas fa-edit botoes"></i></button>
                                    </td>
                                </tr>`;
            } else {
                htmlSegment =   `<div class="componente">
                                    <button lass="btn btn-secondary"><i class="fas fa-edit botoes"></i></button>
                                    <div class="placa">
                                        <h6>Placa:</h6>
                                        <p>${vehicle.plate}</p>
                                    </div>
                                    <div class="modelo">
                                        <h6>Modelo:</h6>
                                        <p>${vehicle.model}</p>
                                    </div>
                                    <div class="portaria">
                                        <h6>Portaria:</h6>
                                        <p>${gate}</p>
                                    </div>
                                    <div class="porteiro">
                                        <h6>Porteiro:</h6>
                                        <p>${vehicle.user_in.name}</p>
                                    </div>
                                    <div class="criadoHora">
                                        <h6>Horário de entrada:</h6>
                                        <p>${created_at_formatada}</p>
                                    </div>
                                    <div class="atualizadoHora">
                                        <h6>Horário de saída:</h6>
                                        <p>${left_at_formatada}</p>
                                    </div>
                                </div>`;
            }
    
            html += htmlSegment;
        });

        let container;
        if(width_resolution>900)
            container = document.querySelector('#table-body');
        else
            container = document.querySelector('#lista-veiculo');
        
        container.innerHTML = html;
        
    })
    .catch(err => {
        console.error('Failed retrieving information', err);
    });


}

renderVehicles();