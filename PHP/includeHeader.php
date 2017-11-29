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
                echo "<li><a href=\"history.php\">Historico</a></li>";
                echo "<li><a href=\"logout.php\">Log out</a></li>";
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
        <input type=submit class="input-group-btn" value="Buscar">
        <select class="select-header" name="genre">
            <option value="All" selected>All</option>"
            <?php 
            /*Conexion con la base de datos*/
            try {
                $database = new PDO("pgsql:dbname=si1 host=localhost", "alumnodb", "alumnodb");
                $query = "SELECT genrename FROM genres";
                foreach ($database->query($query) as $genre)
                    echo "<option value=\"".$genre['genrename']."\">".$genre['genrename']."</option>";
            } catch (PDOException $e) {
            }

           ?>
        </select>
        <div class="header-form">
        <input type="text" class="form-control" name="search">
            </div>
    </form>

</header>
