$(function(){
    //Get the click event for popup
    $('#modalButton').click(function(){
           $('#modal').modal('show')
                   .find('#modalContent')
                   .load($(this).attr('value'));
    });
    
    $("#btn-alert").on("click", function() {
    krajeeDialog.alert("This is a Krajee Dialog Alert!")
});
   });