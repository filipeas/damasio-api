$(function () {
    // SCRIPT EXECUTAR CHAMADA A CADA 15s PARA ATUALIZAR BARRA DE PROGRESSO
    if ($('.JProgressPDF').length > 0) {
        var route = $('.JProgressPDF').data('route');

        setInterval(function () {
            $.ajax({
                url: route,
                type: "get",
                data: {},
                dataType: "json",
                success: function (response) {
                    // console.log(response.data);
                    if (response.data.countAllCategories == response.data.countFinished) {
                        $('.JProgressPDF').css("width", ((response.data.countFinished / response.data.countAllCategories) * 100) + "%");
                        $('.JProgressPDF').text("100%");
                    } else {
                        var progress = Math.round(((response.data.countFinished / response.data.countAllCategories) * 100));
                        $('.JProgressPDF').css("width", (progress == 0 ? 10 : progress) + "%");
                        $('.JProgressPDF').text(progress + "%");
                    }
                    $('.jProgressPDFFinal').css('color', (response.data.pdfFinalIsGenerated == true ? 'green' : 'red'));
                    $('.jProgressPDFFinal').text((response.data.pdfFinalIsGenerated == true ? 'Sim' : 'Não'));
                }
            });
        }, 15000);
    }
});