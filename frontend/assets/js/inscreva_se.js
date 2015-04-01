/* Brazilian initialisation for the jQuery UI date picker plugin. */
/* Written by Leonildo Costa Silva (leocsilva@gmail.com). */
jQuery(function($){
        $.datepicker.regional['pt-BR'] = {
                closeText: 'Fechar',
                prevText: '&#x3c;Anterior',
                nextText: 'Pr&oacute;ximo&#x3e;',
                currentText: 'Hoje',
                monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
                'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
                'Jul','Ago','Set','Out','Nov','Dez'],
                dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
                dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 0,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
});
(function($){
    $('.input-daterange').datepicker({
                    todayBtn: "linked",
                    format : "dd/mm/yyyy",
                    language: "pt-BR"
                });


    var
        $cnpj = $('#cnpj')
       ,$cpf = $('#cpf')
       ,$telefone = $('#telefone')
       ,$frmInscricao = $('#frm-inscricao')
    ;

    $cnpj.mask('99999999999999');
    $cpf.mask('99999999999');
    $telefone.focus(function () {
        $(this).mask("(99) 9999-9999?9");
    });
    $telefone.focusout(function () {
        var phone, element;
        element = $(this);
        element.unmask();
        phone = element.val().replace(/\D/g, '');
        if (phone.length > 10) {
            element.mask("(99) 99999-999?9");
        } else {
            element.mask("(99) 9999-9999?9");
        }
    });
    $frmInscricao.validate({
        focusInvalid: false,
        invalidHandler: function(form, validator) {

            if (!validator.numberOfInvalids())
                return;

            $('html, body').animate({
                scrollTop: $(validator.errorList[0].element).offset().top
            }, 1000);

        }
    });

        var today = new Date();
        var date = new Date(2015, 1, 9, 0, 0, 0, 0);
        //var y = today.getFullYear() + 1;
        $('.calendario').multiDatesPicker({
            onSelect: function(dateStr) {
                var date_parts = dateStr.split("/");

                if( 1 === new Date(date_parts[2], date_parts[1] -1, date_parts[0]).getDay()) {
                    $( "#dialog-confirm" ).dialog({
                      resizable: true,
                      height:300,
                      modal: true,
                      buttons: {
                        "OK": function() {
                          $( this ).dialog( "close" );
                        },
                        /*"Não": function() {

                          $("#calendario").val("");

                          $( this ).dialog( "close" );
                        }*/
                      }
                    });

                }
            },

            numberOfMonths: [1,1],
            dateFormat: "d/m/y",
            minDate: 88,
            maxDate: 202,
            addDisabledDates: [
                new Date(2015, 0, 12, 0, 0, 0, 0),
                new Date(2015, 0, 13, 0, 0, 0, 0),
                new Date(2015, 0, 14, 0, 0, 0, 0),
                new Date(2015, 0, 15, 0, 0, 0, 0),
                new Date(2015, 0, 19, 0, 0, 0, 0),
                new Date(2015, 0, 20, 0, 0, 0, 0),
                new Date(2015, 0, 21, 0, 0, 0, 0),
                new Date(2015, 0, 22, 0, 0, 0, 0),
                new Date(2015, 0, 26, 0, 0, 0, 0),
                new Date(2015, 0, 27, 0, 0, 0, 0),
                new Date(2015, 0, 28, 0, 0, 0, 0),
                new Date(2015, 1, 1, 0, 0, 0, 0),
                new Date(2015, 1, 2, 0, 0, 0, 0),
                new Date(2015, 1, 3, 0, 0, 0, 0),
                new Date(2015, 1, 4, 0, 0, 0, 0),
                new Date(2015, 1, 5, 0, 0, 0, 0),
                new Date(2015, 1, 9, 0, 0, 0, 0),
                new Date(2015, 1, 10, 0, 0, 0, 0),
                new Date(2015, 1, 11, 0, 0, 0, 0),
                new Date(2015, 1, 12, 0, 0, 0, 0),
                new Date(2015, 1, 16, 0, 0, 0, 0),
                new Date(2015, 1, 17, 0, 0, 0, 0),
                new Date(2015, 1, 18, 0, 0, 0, 0),
                new Date(2015, 1, 19, 0, 0, 0, 0),
                new Date(2015, 1, 23, 0, 0, 0, 0),
                new Date(2015, 1, 24, 0, 0, 0, 0),
                new Date(2015, 1, 25, 0, 0, 0, 0),
                new Date(2015, 1, 26, 0, 0, 0, 0),
                new Date(2015, 2, 2, 0, 0, 0, 0),
                new Date(2015, 2, 3, 0, 0, 0, 0),
                new Date(2015, 2, 4, 0, 0, 0, 0),
                new Date(2015, 2, 5, 0, 0, 0, 0),
                new Date(2015, 2, 9, 0, 0, 0, 0),
                new Date(2015, 2, 10, 0, 0, 0, 0),
                new Date(2015, 2, 11, 0, 0, 0, 0),
                new Date(2015, 2, 12, 0, 0, 0, 0),
                new Date(2015, 2, 16, 0, 0, 0, 0),
                new Date(2015, 2, 17, 0, 0, 0, 0),
                new Date(2015, 2, 18, 0, 0, 0, 0),
                new Date(2015, 2, 19, 0, 0, 0, 0),
                new Date(2015, 2, 23, 0, 0, 0, 0),
                new Date(2015, 2, 24, 0, 0, 0, 0),
                new Date(2015, 2, 25, 0, 0, 0, 0),
                new Date(2015, 2, 26, 0, 0, 0, 0),
                new Date(2015, 2, 30, 0, 0, 0, 0),
                new Date(2015, 2, 31, 0, 0, 0, 0),
                new Date(2015, 3, 1, 0, 0, 0, 0),
                new Date(2015, 3, 2, 0, 0, 0, 0),
                new Date(2015, 3, 6, 0, 0, 0, 0),
                new Date(2015, 3, 7, 0, 0, 0, 0),
                new Date(2015, 3, 8, 0, 0, 0, 0),
                new Date(2015, 3, 9, 0, 0, 0, 0),
                new Date(2015, 3, 13, 0, 0, 0, 0),
                new Date(2015, 3, 14, 0, 0, 0, 0),
                new Date(2015, 3, 15, 0, 0, 0, 0),
                new Date(2015, 3, 16, 0, 0, 0, 0),
                new Date(2015, 3, 20, 0, 0, 0, 0),
                new Date(2015, 3, 21, 0, 0, 0, 0),
                new Date(2015, 3, 22, 0, 0, 0, 0),
                new Date(2015, 3, 23, 0, 0, 0, 0),
                new Date(2015, 3, 27, 0, 0, 0, 0),
                new Date(2015, 3, 28, 0, 0, 0, 0),
                new Date(2015, 3, 29, 0, 0, 0, 0),
                new Date(2015, 3, 30, 0, 0, 0, 0),
            ]
        });

        // http://fullcalendar.io/
        new dgCidadesEstados({
              cidade: document.getElementById('municipio'),
              estado: document.getElementById('estado')
        });

})(jQuery);