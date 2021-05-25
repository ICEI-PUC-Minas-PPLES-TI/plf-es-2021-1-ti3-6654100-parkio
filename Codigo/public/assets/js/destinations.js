window.addEventListener("load", function () {
    updateDestinationsTable();
    document.getElementById('btnFilterDestination').addEventListener("click", (evt) => updateDestinationsTable());

    // $('#CreateCategoryModal').on('hidden.bs.modal', function(e) {
    //     $(this).find(".modal-title").text("Cadastro de Categoria de Visitantes");
    //     $(this).find(".btn").text("Cadastrar");
    //     $("#categoryId").val("");
    //     $("#input-description").val("");
    //     $("#input-time").val("");
    // })
})

function updateDestinationsTable(page = 1) {
    var bloco = document.getElementById('inputSearchBlock').value;
    var apartamento = document.getElementById('inputSearchApartament').value;

    var filter = '';
    if(bloco)
        filter += `&block=${bloco}`
    if(apartamento)
        filter += `&apartament=${apartamento}`

    $.ajax({
        //url: `/api/destinations?page=${page}`,
        url: '/api/destinations?page='+page+'&'+filter,
        type: "GET",
        success: function(jsonRes) {

            const result = jsonRes.data;
            let html = '';
            let htmlSm = '';
            result.forEach(destination => {

                var htmlSegment;
                var htmlSegmentSm;

                htmlSegment = `<tr>
                                    <td>${destination.block}</th>
                                    <td>${destination.apartament}</td>
                                    <td class="acoes">
                                        <button class="btn btn-secondary" onclick="modalEditDestination(${destination.id},\`${destination.block}\`,\`${destination.apartament}\`)"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-danger" onclick="removeDestination(${destination.id})"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>`;

                htmlSegmentSm = `<div class="destinationCard mb-2">
                                        <button class="btn btn-danger" onclick="removeDestination(${destination.id})"><i class="fas fa-trash-alt"></i></button>
                                        <button class="btn btn-secondary" onclick="modalEditDestination(${destination.id},\`${destination.block}\`,\`${destination.apartament}\`)"><i class="fas fa-edit"></i></button>
                                        <div class="type">
                                            <h6>Bloco:</h6>
                                            <p>${destination.block}</p>
                                        </div>
                                        <div class="time">
                                            <h6>Apartamento:</h6>
                                            <p>${destination.apartament}</p>
                                        </div>
                                    </div>`;


                html += htmlSegment;
                htmlSm += htmlSegmentSm;
            });

            $(".destinations-pagination").html('')
            for(let i=0;i<jsonRes.last_page;i++){
                $(".destinations-pagination").append(`<li onclick="updateDestinationsTable(${i+1})" class="page-item ${(i+1)==page?'active':''}"><a class="page-link" href="#">${i+1}</a></li>`);
            }

            let container;
            container = document.querySelector('#destination-table-body');
            container.innerHTML = html;

            container = document.querySelector('#lista-destination');
            container.innerHTML = htmlSm;
        },
        error: function(err, status) {
            console.error('Failed retrieving information', err);
        },
    });
}

function removeDestination(destinationId) {

    var result = confirm("Você deseja excluir este destino? Essa ação é irreversível!");

    if (result) {
        $.ajax({
            url: '/api/destinations/' + destinationId,
            type: 'DELETE',
            success: function(res) {
                showToast(res.message);
                updateDestinationsTable();
            },
            error: function(err, status) {
                showToast(err);
            },
        });
    }
}

function modalEditDestination(id, bloco, apartamento) {
    var myModal = $("#destinationModal");
    myModal.find(".modal-title").text("Editar Destino");
    myModal.find('#destinationId').val(id);
    myModal.find('#destination-block').val(bloco);
    myModal.find('#destination-ap').val(apartamento);
    myModal.find(".btn").text("Editar");
    myModal.modal('show');
};

function handleDestinationFormSubmit(event) {
    event.preventDefault();

    var request = 'POST'
    // by default request is POST unless the modal has id of any category
    const id = $("#destinationId").val();
    const block = document.querySelector('#destination-block').value
    const apt = document.querySelector('#destination-ap').value

    const data = {
        block,
        apt
    }

    if (id != null && id != "") {
        request = 'PUT';
    }

    $.ajax({
        url: `/api/destinations/${id}`,
        type: request,
        data: data,
        success: function(res) {
            document.getElementById('destination-form').reset();
            updateDestinationsTable();
            $("#destinationModal").modal('hide')
            showToast("Destino criado com sucesso!")
        },
        error: function(err, status) {
            console.log(err)
            showToast(err)
        },
    });
}
