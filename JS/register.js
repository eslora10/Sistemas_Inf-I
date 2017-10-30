//len username
    $(document).ready(function() {
       $('#nick').blur(function(){
        if(($('#nick').val().length == 0))
           return false
        var validFolder = /^([a-zA-Z0-9_\.\-])+$/;
        if(!validFolder.test($("#nick").val())){
          /*var txt = 'hola';
          txt.css("color","red")
          $('#nick').after(txt)*/
          $("#errorNick").show().text('Los nombres de usuario solo pueden contener letras, números, guiones bajos y puntos.');
          return
        }
       });
    });

//same password
$(document).ready(function() {
   $('#password').blur(function() {
       var pass = $('#password').val();

       if(($('#password').val().length >=8))
         return false
       $("#passLen").show().text('Las contraseña debe tener 8 caracteres como minimo.');
   });
});


//same password
$(document).ready(function() {
   $('#password_rep').blur(function() {
       var pass = $('#password').val();
       var repass = $('#password_rep').val();
       if(($('#password').val().length == 0) || ($('#password_rep').val().length == 0))
         return false
       if (pass !== repass)
         $("#password_OK").show().text('Las contraseñas no coinciden.');
   });
});




//valid email

   function validar_email( email ){
     var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
     return regex.test(email) ? true : false;
   }
   $(document).ready(function() {
      $('#email').blur(function(){
         if( !validar_email( $("#email").val() ) ){
          $("#errorEmail").show().text('Introduce un mail valido.');
          return false;
        }
      });
    });

   function calcScore(pass) {
     var score = 0;
     if (!pass)
         return score;

     // award every unique letter until 5 repetitions
     var letters = new Object();
     for (var i=0; i<pass.length; i++) {
         letters[pass[i]] = (letters[pass[i]] || 0) + 1;
         score += 5.0 / letters[pass[i]];
     }

     // bonus points for mixing it up
     var variations = {
         digits: /\d/.test(pass),
         lower: /[a-z]/.test(pass),
         upper: /[A-Z]/.test(pass),
         nonWords: /\W/.test(pass),
     }

     variationCount = 0;
     for (var check in variations) {
         variationCount += (variations[check] == true) ? 1 : 0;
     }
     score += (variationCount - 1) * 10;
     if (score >100){
         score=100;
     }

     return parseInt(score);
   }

    function passStr(s) {
        if (s > 80)
            return "strong";
        if (s > 60)
            return "good";
        return "weak";
    }

    $(document).ready(function() {
        $("#password").on("keypress keyup keydown", function() {
            var pass = $(this).val();
            var score=calcScore(pass)

            //$("#scoreStr").text('Fortaleza:'+passStr(score));
            //$("#scoreNum").text("("+score +"%)");

            //usamos sintaxis JS por que JQ daba error
            var meter = document.getElementById('scoreMeter');
            meter.value=score*0.01

        });
    });

    $(document).ready(function(){
        $('.desplegar').on("keypress keyup keydown", function(ev) {
           ev.preventDefault();
           $(this).closest('tr').nextAll('.prueba').css('background', 'red');


        });
    });
