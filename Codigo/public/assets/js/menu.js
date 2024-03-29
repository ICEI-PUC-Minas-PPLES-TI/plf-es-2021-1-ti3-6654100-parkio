window.addEventListener("load", function () {
    let uinfo = JSON.parse(getCookie('PARKIO_UIF'))
    if(['A','P'].includes(uinfo.t)) {
        $('.gate').removeClass('d-none')
        $.ajax({
            url: '/api/gate',
            type: "GET",
            success: function(result){
                let html = ``;
                result.forEach(gate => {  
                    html += `
                    <a href="/gate/${gate.id}" class="col-12 col-sm-6 col-lg-2 menu-container-item rounded text-decoration-none">
                        <div class="px-3">
                            <img class="gate-icon d-block m-auto" src="/assets/img/gate.svg"  />
                            <p>${gate.description}</p>
                        </div>
                    </a>`;
                });
                $('.gate-items').html(html)
            },
            error: function(err){
                console.error('Failed retrieving information', err);
            },
        });
    }
    if(['A'].includes(uinfo.t)) {
        $('#btnConfig').removeClass('d-none')
        $('#btnUsers').removeClass('d-none')
        $('#btnReport').removeClass('d-none')
    }
    if(['A','R','S'].includes(uinfo.t))
        $('#btnList').removeClass('d-none')
    

    

    document.getElementById('btnLogout').addEventListener('click', logout)

})