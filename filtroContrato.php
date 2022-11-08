<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="js/leaflet.css">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="icon" href="prosegur.png">
    <title>FILTRO DE CONTRATOS</title>
</head>

<body>
    <?php
    session_set_cookie_params(60 * 60 * 24 * 14); //haciendo que la sesion dure 14 dias
    session_start();
    if (!isset($_SESSION['contratos'])) {
        $_SESSION['contratos'] = array();
    }

    if (isset($_POST['contrato'])) {

        $contr = $_POST['contrato'];
        if (strlen($contr) > 0) {
            $tamanio = sizeof($_SESSION['contratos']);
            $_SESSION['contratos'][$tamanio + 1] = $contr;
        }
    }
    if (isset($_POST['vaciar'])) {
        $vaciar = $_POST['vaciar'];
        unset($_SESSION['contratos']);
    }


    ?>
    <div id="container">
        <h3>INSERTE CONTRATOS A FILTRAR</h3>
        <div id="formulario">
            <form action="filtroContrato.php" onsubmit="vaciarValorTexto()" method="post">
                <div id="entradaTexto">
                    <input type="text" autocomplete="off" name="contrato" size="23" id="contratos" placeholder="Ingrese contrato">
                </div>
                <br>
                <div id="botones">
                    <input type="submit" name="enviar" value="Agregar">
                    <br>
                    <input type="submit" name="vaciar" value="Vaciar">
                </div>
                <br><br>
                <a href="index.php">Volver al Mapa</a>

            </form>
        </div>
        <div id="muestracontratos">
            <?php
            if (isset($_SESSION['contratos'])) {
                foreach ($_SESSION['contratos'] as $elemento => $valor) {
                    echo $valor;
                    echo '<br>';
                };
            }
            ?>
        </div>
    </div>


</body>
<script>
    window.onload = function() {
        var input = document.getElementById("contratos").focus();
    }

    function vaciarValorTexto() {
        document.getElementsByName('contrato').values = "555";
    }
</script>



</html>