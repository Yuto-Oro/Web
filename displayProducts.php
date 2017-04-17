<link rel="stylesheet" type="text/css" href="css/estilos.css">
<a href="logout.php"><span class="form"><button class="button button-block" name="logout"/>Log Out</button></span></a>
<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'movies';
$mysqli = new mysqli($host,$user,$pass,$db); 
//call query method of $mysqli object
$result = $mysqli->query 
        //SELECT queries siempre son retorndaso como mysqli result objects
("SELECT * FROM movies WHERE year BETWEEN 2000 AND 2016 ORDER BY rand() LIMIT 20") 
or die($mysqli->error); 
?> <div class='main-container'> <?php
//llamamos el metodo fetch_assoc() de $result object
//Seguimos obteniendo la informacion row's column como un arreglo asociativo hasta NULL (no se regresan rows)
//Por eso podemos ponerlo en el loop y seguir obteniendo nuevas rows
while ($movie = $result->fetch_assoc()): ?> 
<div class='movie-container'>
    <div class='header'>
        <h1><?= $movie['title'] ?></h1>
        <span class='year'>( <?= $movie['year'] ?> )</span>
    </div>
    <div class='content'>
        <div class='left-column'>
            <img width='<?php 67*1.3 ?>' height='<?= 98*1.3 ?>' src='<?= $movie['image_url'] ?>'>
            <div id='ratings'>     
                <div class='imdb'><?= $movie['imdb_rating'] ? $movie['imdb_rating'] : '' ?></div>
                <div class='metascore'><?= $movie['metascore'] ? $movie['metascore'] : '' ?></div>
            </div>
        </div>
        <div class='right-column'>

            <span class='content blue'>
                <?= $movie['certificate']; ?>
            </span>

            <?php 
            //Solo estamos imprimiendo el pipe '|'
            echo $movie['certificate'] ? ' |' : ''; 
            ?>

            <span class='content blue'>
                <?= $movie['runtime'] .' min'; ?>
            </span>

            <?php
            //generos
            $result2 = $mysqli->query
            ("SELECT genres_id FROM movies_genres WHERE movies_id={$movie['id']}") or
            die($mysqli->error);
            //fetch_all regresa arreglo multidimensional
            $genres = $result2->fetch_all();
            //array_column convierte arreglo multidimensional a uno simple
            //limpiamos
            $genres = array_column($genres, 0); 

            //recorremos los ids de genero y obtenemos el record de la tabla generos
            for ($i = 0; $i < count($genres);$i++)
            {
                $genre = $mysqli->query("SELECT name from genres where id = '{$genres[$i]}'")->fetch_assoc();
                //imprime | antes de cada genero
                echo $i == 0 ? ' | ' : ''; 
                echo "<span class='content blue'>".$genre['name']."</span>";
                echo $genres[$i] != end($genres) ? ', ' : ''; //si no estamos al final de generos imprime una coma
            }
        ?>
        <div class='content description'><?= $movie['description'] ?></div>

        <?php
        //obtenemos los directores
        $result3 = $mysqli->query
        ("SELECT directors_id FROM movies_directors WHERE movies_id={$movie['id']}") or
        die($mysqli->error);
        $directors = $result3->fetch_all();
        $directors = array_column($directors, 0);
        //obtenemos las estrellas
        $result4 = $mysqli->query
        ("SELECT stars_id FROM movies_stars WHERE movies_id={$movie['id']}") or
        die($mysqli->error);
        $stars = $result4->fetch_all();
        $stars = array_column($stars, 0);
        ?>
        <div>
            <?php

            //recorremos a directores
            for ($i = 0; $i < count($directors);$i++)
            {
                $director = $mysqli->query
                ("SELECT name from directors where id = '{$directors[$i]}'")->fetch_assoc();

                //si tenemos mas de un director, ponemos la letra s dentro de la variable $s :)
                $s = count($directors) > 1 ? 's' : '';
                //ponemos la variable $s al final de director, asi sera plural si hay mas de un director
                echo $i == 0 ? "<span class='content yellow'>Director$s: </span>" : ''; 
                echo "<span class='content text'>".$director['name']."</span>";
                //si no estamos al final de directores imprimimos coma
                if ($directors[$i] != end($directors))
                {
                    echo ', ';
                }
                else 
                {
                    //al final de directores, imprimimos pipe pero solo si hay 3 estrellas
                    if (count($stars) > 0) 
                    {
                        echo ' | ';
                    }
                }
            }
            ?>
            <?php
            //recorremos las estrellas
            for ($i = 0; $i < count($stars);$i++)
            {
                $star = $mysqli->query("SELECT name from stars where id = '{$stars[$i]}'")->fetch_assoc();
                $s = count($stars) > 1 ? 's' : ''; //hacemos lo mismo de $s
                echo $i == 0 ? "<span class='content yellow'>Star$s: </span>" : ''; 
                echo "<span>".$star['name']."</span>";
                echo $stars[$i] != end($stars) ? ', ' : ''; //imprimimos coma si no estamos al final de stars
            }
        ?>
    </div>
    <div class='bottom'>
        <?php 
            //checamos si existen votos
        if ($movie['votes']) 
        {
            echo "<span class='content yellow'>Votes: </span>".number_format($movie['votes']);
                //si existe 'gross' imprimimos pipe despues de este
                //ya sabemos que los votos existen con el if de arriba
            echo $movie['gross'] ? ' | ' : '';
        }
        ?>
        <span class='content green'>
            <?= $movie['gross'] ? "<span class='content yellow'>Gross: </span>$".
            number_format($movie['gross']) : '' ?>
        </span>
    </div>
</div>
</div>
</div>
</div>
<?php endwhile; ?>
