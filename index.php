<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilost9.css">
    <title>Hazte Con Todos</title>
</head>
<body>
    <header class="titulo">
        <h1 id="titulo">¡HAZTE CON TODOS!</h1>
    </header>

    <div class="">
    <h2 class="texto">¡Busca tus Pokémon de todas las generaciones!</h2>
    <form action="" method="get" class="formulario">
        <label for="idpoke">Nombre o ID:</label>
        <input type="text" name="pokemon" id="idpoke" require placeholder="Introduzca nombre o ID numérico" class="poke">
        <input type="submit" value="Buscar" name="search" class="boton">
    </form>
</div>

<div class="contenido">
    <?php
    /**
    * @author 
    * Este es el código principal de la aplicación
    * @global mixed $_GET['search'] Contiene valor si se ha pulsado el input submit
    * @global string $_GET['pokemon'] Valor recogido en el input tipo text de nuestro formulario
    */
    if (isset($_GET['search'])) {
        $expresionRegular = "/^[a-zA-Z0-9]+$/";
        // Controlamos si el valor introducido es texto o número sin espacios
        if (preg_match($expresionRegular, $_GET['pokemon'])) {
            // Recuperamos los datos de la API
            $respuestaPokemon = @file_get_contents("https://pokeapi.co/api/v2/pokemon/" . strtolower($_GET['pokemon']));
            $respuestaPokemon = json_decode($respuestaPokemon);
            // Controlamos si esa respuesta tiene datos
            if ($respuestaPokemon) {
                $img = $respuestaPokemon->sprites->other->home->front_default;
                echo '<div class="especificaciones">';
                echo "<img src='" . $img . "' alt='" . $respuestaPokemon->name . "'>";
                echo "<h3 class='especificacionesTexto'>" . $respuestaPokemon->id . "-" . ucfirst($respuestaPokemon->name) . "</h3>";
                echo '<ul class="lista-grupo">';
                echo '<li class="lista-grupo-item">Altura: ' . ($respuestaPokemon->height / 10) . " metros</li>";
                echo '<li class="lista-grupo-item">Peso: ' . ($respuestaPokemon->weight / 10) . " kg</li>";
                echo '<li class="lista-grupo-item">Tipos: ';
                $tipos = array();
                foreach ($respuestaPokemon->types as $item) {
                    $tipos[] = $item->type->name;
                }
                echo implode(", ", $tipos);
                echo '</li>';
                echo '<li class="lista-grupo-item">Experiencia base: ' . $respuestaPokemon->base_experience . " puntos</li>";
                echo '</ul>';
                echo '</div>';
            } else {
                echo '<div class="mensaje_error" role="alert">¡EL NOMBRE O ID DEL POKÉMON NO EXISTE!</div>';
            }
        } else {
            echo '<div class="mensaje_error" role="alert">¡DEBES INTRODUCIR UN NOMBRE O ID DEL POKÉMON!</div>';
        }
    }
    ?>
</div>

<script src="./scriptst9.js"></script>