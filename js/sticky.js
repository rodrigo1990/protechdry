  $(document).ready(function() {
    $("#primer-row").css({
            paddingRight:"1%"
        });  
  });

  $(window).scroll(function (event) {
    var scroll = $(window).scrollTop();

    if(scroll==0){
        $("#primer-row").css({
            paddingRight:"1%"
        });  
        

    }else{
        $("#primer-row").css({
            paddingRight:"2%"
        });  
        
    }
    // Do something
});


    