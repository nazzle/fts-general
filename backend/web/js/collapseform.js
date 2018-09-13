/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function updateUnsharp(newValue) {
     document.getElementById("unsharpValue").innerHTML=newValue;
   }

// Scene will need to be extracted from template
   var input_scene = 1234

   function generateUrl(){
     // var scene = $("#scene").val();
     // var input_scene = scene.replace(".tif", "");
     url = "/image/" + input_scene + "." + $('#filetype option:selected').val() + "?" + $("#order_form :not(.skipdata)").serialize();
    console.log(url);
    return url;
   }

   $("#order_form").on("submit", function(e){
     e.preventDefault();

     var format = $('input[name="filetype"]').val();
     if (format ===  "tif") {
       window.open(generateUrl(), '_blank');
     }
     else {
       $("#generate").text("Loading Image...")
         .css("background-color", "red")
         .attr("disabled", "disabled");
       $("#image").attr('src', generateUrl());
       $("#image").load(function(){
         $("#generate").text("Generate Image")
         .removeAttr("style")
         .removeAttr("disabled");
       });
     }
   });
