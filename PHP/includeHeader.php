<header>
    <div class="divHeaderButton">
        <?php
            if(isset($_SESSION['nick'])) {
                echo "<nav>";
                echo "<div class=\"dropdown\">";
                echo "<button class=\"btn dropdown-toggle\" type=\"button\" id=\"dropdownMenu2\" data-toggle=\"dropdown\">";
                echo $_SESSION['nick'];
                echo "<span class=\"caret\"></span></button>";
                echo "<ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dropdownMenu2\">";
                echo "<li><a href=\"../HTML/history.html\">Historico</a></li>";
                echo "<li><a href=\"../HTML/basket.html\">Carrito</a></li>";
                echo "<li><a href=\"login.php\">Log out</a></li>";
                echo "</ul>";
                echo "</div>";
                echo "</nav>";
            } else {
                echo "<a class=\"headerButton\" href=\"login.php\">Identifícate</a>";
                echo "<a class=\"headerButton\" href=\"register.php\">Regístrate</a>";
            }
        ?>
        <h6>Articulos en el <a class="header-link" href="basket.php">carro</a>: 
            <?php                     
            if(isset($_SESSION["basketNitems"])){
                echo $_SESSION["basketNitems"];
            } else {
                echo "0";
            }
            ?>
        </h6>

    </div>
    <div>
        <a href="index.php"><h1 class="main-header">UAM Play</h1></a>
    </div>
          
    <form class="input-group" method="get" action="index.php">
        <input type=submit class="input-group-btn">
        <select class="select-header" name="genre">
            <option value="Todos" selected>Todos</option>
            <option value="Accion">Accion</option>
            <option value="Aventuras">Aventuras</option> 
            <option value="Thriller">Thriller</option>
            <option value="Comedia">Comedia</option>
            <option value="Drama">Drama</option>
            <option value="Infantil">Infantil</option>
            <option value="Superheroes">Superheroes</option>
        </select>
        <div class="header-form">
        <input type="text" class="form-control" name="search">
            </div>
    </form>

</header>