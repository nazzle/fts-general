$(function(){
    //Get the click event for popup
    $('#modalButton').click(function(){
           $('#modal').modal('show')
                   .find('#modalContent')
                   .load($(this).attr('value'));
    });
    
    //Get the click event for popup
    $('#filesButton').click(function(){
           $('#files').modal('show')
                   .find('#filesContent')
                   .load($(this).attr('value'));
    });
    
    $("#btn-alert").click(function() {
    krajeeDialog.alert("This is a Krajee Dialog Alert!")
    });
    
    $('#popup-modal').click(function(e) {
    e.preventDefault();
    var modal = $('#modal-delete').modal('show');
    modal.find('.modal-body').load($('.modal-dialog'));
    var that = $(this);
    var id = that.data('id');
    modal.find('.modal-title').text('Supprimer la ressource ' + id);
    });

   });
   

   
