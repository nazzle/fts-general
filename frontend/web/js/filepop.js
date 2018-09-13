/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function(){   
    //Get the click event for popup
    $('#filesModal').click(function(){
           $('#files').modal('show')
                   .find('#filesContent')
                   .load($(this).attr('value'));
    });
    
   });
   
