
function changeContent(){
    $(document).ready(function () {
        $("#name").on("change", function () {
          alert($(this).val());  
          //$(".data").hide();
            //$("#" + $(this).val()).fadeIn(700);
          })
          //.change();
      });
    
}

