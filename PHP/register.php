<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>UAM PLAY</title><!-- Bootstrap -->
        <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet"><!-- Font Awesome -->
        <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet"><!-- User -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<!-- NUESTROS SCRIPTS JS/JQ-->


        <!-- len username-->
        <script type="text/javascript">
            $(document).ready(function() {
               $('#send').click(function(){
                if($("#nick").val().length < 8) {
                $("#errorNick").show();
                return false;
                }
               });
            });
        </script>
       <!-- valid email-->
       <script>
           function validar_email( email ){
             var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
             return regex.test(email) ? true : false;
           }
           $(document).ready(function() {
              $('#send').click(function(){
                 if( !validar_email( $("#email").val() ) ){
                  $("#errorEmail").show();
                  return false;
                }
              });
            });

        </script>

        <script>

        //works fine????????
            $(document).ready(function(){
              if( $("#ccard").isNumeric() ==false){
               $("#errorCcard").show();
               return false;
              }



            });


        </script>

        <!--PASSWORD STR METER-->
        <script>
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
        </script>








        <!--complexify para el meter de la password-->
        <!-- works fine ??
        <script type="text/javascript" src="/js/jquery.complexify.js"></script>
        <script type="text/javascript">
        $("#password").complexify({}, callback(valid, complexity){
          $("#scoreMeter").text=complexity);
        });
        </script>
-->






<!---->


        <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../CSS/style.css">

    </head>
    <body>
      <header>
            <!-- cambio orden-->
            <div class="divHeaderButton">
                <a class="headerButton" href="login.html">Identifícate</a>
                <a class="headerButton" href="register.html">Regístrate</a>

            </div>
            <!---->
            <div>
                <a href="index.html"><h1 class="main-header">UAM Play</h1></a>
            </div>
            <div class="input-group">
                <input type="text" class="form-control">
                <a class="input-group-btn" href="index.html">Buscar</a>
            </div>

        </header>
		<div class="container-fluid">
      <nav class="navMenu">
          <div class="dropdown">
              <button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">Géneros <span class="caret"></span></button>
              <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                  <li><a href="index.html">Acción</a></li>
                  <li><a href="index.html"></a></li>
                  <li><a href="index.html">Comedia</a></li>
                  <li><a href="index.html">Drama</a></li>
                  <li><a href="index.html">Animación</a></li>
                  <li><a href="index.html">Infantil</a></li>
              </ul>
          </div>
      </nav>
      <div class="main-content">
            <form class="divLogin" action="../PHP/check-register.php" METHOD=post>

		        <div class="LogInput">
			        <h2>Regístrate</h2>
                </div>

                <div class="LogInput">
    		        <h5>Nombre de usuario: </h5>
                    <input type="text" name="nick" id=nick class="form-control" placeholder="Nombre de usuario" required>
                    <?php echo "<h6 class=\"error\">$msg_nick</h6>" ?>

                    <h5 id='errorNick' class="errorHidden" ><!-- display:block-->
                      El nick debe tener 8 caracteres minimo
                    </h5>


                </div>
    	          <div class="LogInput">
    	            <h5>e-mail: </h5>
                    <input type="text" name="email" id=email class="form-control" placeholder="e-mail" required>
                    <?php echo "<h6 class=\"error\">$msg_email</h6>" ?>

                    <h5 id='errorEmail' class="errorHidden" ><!-- display:block-->
                      Introduce un mail valido
                    </h5>


                </div>
                <div class="LogInput">
                    <h5>Contraseña: </h5>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>

                    <div><!--estos div calculan la fortaleza de la password-->
                        <span id="scoreStr"></span>
                        <span id="scoreNum"></span>
                    </div>
                    <meter class=meter value=0.01 id="scoreMeter"></meter>

                    <?php echo "<h6 class=\"error\">$msg_password</h6>" ?>
                </div>


                <div class="LogInput">
                    <h5>Repita contraseña: </h5>
                    <input type="password" name="password_rep" class="form-control" placeholder="Repita contraseña" required>
                    <?php echo "<h6 class=\"error\">$msg_password_rep</h6>" ?>
                </div>


                <div class="LogInput">
    	            <h5> Tarjeta de crédito </h5>
                    <input type="number" name="ccard" id="ccard" class="form-control" placeholder="Tarjeta de crédito" required>
                    <?php echo "<h6 class=\"error\">$msg_card</h6>" ?>

                    <h5 id='errorCcard' class="errorHidden" ><!-- display:block-->
                      Introduce un mail valido
                    </h5>
                </div>


                <div class="LogInput">
                  <input type="Submit" id='send' class="login" value="Registrate">
                </div>


                <div class="LogInput">
                ¿Ya tienes cuenta? <a href="login.html">Identifícate aquí</a>
                </div>


            </form>
        </div>
      </div>
        <footer>Antonio Amor, Esther López, Sistemas Informáticos</footer>


</body></html>
