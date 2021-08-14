$(document).on("click", ".modal-button", function() {
    let modalID = $(this).data('url');
    let modalSize = $(this).data('mode');
    let modalBG = $(this).data('color');
    let modalTarget = $(this).data('target');
    if( modalBG === undefined ) {
        $('.modal').children().children('#content').removeClass().addClass('modal-content');
    }else{
        $('.modal').children().children('#content').removeClass().addClass('modal-content '+modalBG);
    }
    if( modalSize === undefined || modalSize === false || modalSize === 'md') {
        $('.modal').children().removeClass().addClass('modal-dialog modal-dialog-centered');
    }else {
        $('.modal').children().removeClass().addClass('modal-dialog modal-dialog-centered modal-'+modalSize);
    }
    if( modalTarget === 'alt' ) {
        $('#ModalFormAlt').modal('show').find('.modal-content-form').load(modalID);
    } else {
        $('#ModalForm').modal('show').find('.modal-content-form').load(modalID);
    }
});