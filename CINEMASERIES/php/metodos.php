<?php
function mostrarCarousel($consulta, $pdo)
{
    $resultadoCarousel = $pdo->query($consulta);

    $carousel = '';
    $contador = 0; 

    while ($fila = $resultadoCarousel->fetch(PDO::FETCH_ASSOC)) {
        if ($contador < 3) { 
            $carousel .= '<div class="carousel-item active">
            <a href="/CINEMASERIES/html/noticia.php?idNoticia='.$fila['id_noticia'].'">
                                <img src="\CINEMASERIES\imagenes\\'. $fila['foto'] .'" class="d-block w-100 imagenesCarousel" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h1>'. $fila['categoria_principal'] .'</h1>
                                    <h4>'. $fila['titulo'] .'</h4>
                                </div>
                            </a>
                        </div>';
            $contador++;
        } else {
            break; 
        }
    }

    return $carousel;
}

function mostrarTarjeta($consulta, $pdo) {
    // Obtener el número de página actual
    $pagina_actual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;

    // Número de resultados por página
    $resultados_por_pagina = 5;

    // Calcular el índice del primer resultado de la página actual
    $indice_primer_resultado = ($pagina_actual - 1) * $resultados_por_pagina;

    // Consulta para obtener las noticias con límite y desplazamiento para la paginación
    $consulta_paginacion = $consulta . " LIMIT $resultados_por_pagina OFFSET $indice_primer_resultado";
    $resultadoTarjetaNoticia = $pdo->query($consulta_paginacion);

    $tarjetaNoticia = '';

    while ($fila = $resultadoTarjetaNoticia->fetch(PDO::FETCH_ASSOC)) {
        $tarjetaNoticia .= '<div class="row">
        <div class="border-bottom border-dark mt-4">
            <div class="row g-0 overflow-hidden flex-md-row mb-4 h-md-250 position-relative">
                <div class="col-auto" id="imagenArticulo">
                    <img src="\CINEMASERIES\imagenes\\'. $fila['foto'] .'" class="bd-placeholder-img" width="400" height="250" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false">
                    </img>
                </div>
                <div class="col p-4 d-flex flex-column position-static contenidoArticle">
                    <h1>
                        <a href="/CINEMASERIES/html/noticia.php?idNoticia='.$fila['id_noticia'].'">
                            '. $fila['titulo'] .'
                        </a>
                    </h1>
                    <p>
                        <a href="/CINEMASERIES/html/noticias.php?categoriaPrincipal='.$fila['categoria_principal'].'">
                            '. $fila['categoria_principal'] . '
                        </a>
                    </p>
                    <p>
                        ' . $fila['descripcion'] .' <a href="/CINEMASERIES/html/noticia.php?idNoticia='.$fila['id_noticia'].'">LEER MÁS »</a>
                    </p>
                    <p>
                        <a href="#">
                            <img src="/CINEMASERIES/imagenes/icono-comentarios.png" alt="">
                        </a>
                        '. $fila['num_comentarios'] . ' - '. $fila['nombre'] . ' ' . $fila['apellido1'] . ' ' . $fila['apellido2'] .' - '. $fila['fecha'] .'
                    </p>
                </div>
            </div>
        </div>
    </div>';
    }

    // Consulta para obtener el total de resultados
    $total_resultados = $pdo->query("SELECT COUNT(*) AS total FROM ($consulta) AS count")->fetchColumn();

    // Calcular el número total de páginas después de aplicar los filtros
    $total_paginas = ceil($total_resultados / $resultados_por_pagina);

    // Mostrar la paginación
    $pagination = '<div class="d-none d-sm-block py-5 text-center mx-auto" aria-label="Page navigation example">';
    $pagination .= '<ul class="pagination text-center">';
    for ($i = 1; $i <= $total_paginas; $i++) {
        $pagination .= '<li class="page-item ';
        if ($i == $pagina_actual) {
            $pagination .= 'active';
        }
        $pagination .= '"><a class="page-link px-5 mx-auto" href="?pagina=' . $i . '">' . $i . '</a></li>';
    }
    $pagination .= '</ul>';
    $pagination .= '</div>';

    // Mostrar la paginación responsive
    $paginationMobile = '<div class="d-block d-sm-none py-3 text-center mx-auto" aria-label="Page navigation example">';
    $paginationMobile .= '<div class="btn-group" role="group">';
    $paginationMobile .= '<button type="button" class="btn btn-secondary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
    $paginationMobile .= 'Página ' . $pagina_actual . ' de ' . $total_paginas;
    $paginationMobile .= '</button>';
    $paginationMobile .= '<div class="dropdown-menu">';
    for ($i = 1; $i <= $total_paginas; $i++) {
        $paginationMobile .= '<a class="dropdown-item';
        if ($i == $pagina_actual) {
            $paginationMobile .= ' active';
        }
        $paginationMobile .= '" href="?pagina=' . $i . '">' . $i . '</a>';
    }
    $paginationMobile .= '</div>';
    $paginationMobile .= '</div>';
    $paginationMobile .= '</div>';

    $tarjetaNoticia .= $pagination . $paginationMobile;

    return $tarjetaNoticia;
}

function mostrarNoticia($consulta, $pdo) {
    $resultadoNoticia = $pdo->query($consulta);
    $fila = $resultadoNoticia->fetch(PDO::FETCH_ASSOC);

    $noticia = ''; 

    if (is_array($fila)) {
        $noticia = '<div class="row">
        <div class="border-bottom border-dark mt-4">
            <div class="row g-0 overflow-hidden flex-md-row mb-4 h-md-250 position-relative">
                <img src="\CINEMASERIES\imagenes\\'. $fila['foto'] .'" class="bd-placeholder-img imagenesCarousel" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false"></img>
                <div class="col p-4 d-flex flex-column position-static contenidoArticle">
                    <h1>'.$fila['titulo'].'</h1>
                    <p><a href="/CINEMASERIES/html/noticias.php?categoriaPrincipal=ESTRENOS">'.$fila['categoria_principal'].'</a></p>
                    <p>'.$fila['contenido'].'</p>';
    
if ($fila['video'] != null) {
    $noticia .= '<div class="embed-responsive embed-responsive-16by9 d-flex justify-content-center">
    <iframe class="videos" width="590" height="345" src="'.$fila['video'].'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>';
}

$noticia .= '<p class="mt-3"><b>Escritor:</b> '.$fila['nombre'].'  '.$fila['apellido1'].'  '.$fila['apellido2'].' <b>Publicado:</b> '.$fila['fecha'].'</p>
                </div>
            </div>
        </div>
    </div>';
    }

    return $noticia;
}

function mostrarTarjetaPersonal($consulta, $pdo) {
    $resultadoTarjetaNoticia = $pdo->query($consulta);

    $tarjetaNoticia = '';

    while ($fila = $resultadoTarjetaNoticia->fetch(PDO::FETCH_ASSOC)) {
        $tarjetaNoticia .= '<div class="row">
        <div class="border-bottom border-dark mt-4">
            <div class="row g-0 overflow-hidden flex-md-row mb-4 h-md-250 position-relative">
                <div class="col-auto" id="imagenArticulo">
                    <img src="\CINEMASERIES\imagenes\\'. $fila['foto'] .'" class="bd-placeholder-img" width="400" height="250" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false">
                    </img>
                </div>
                <div class="col p-4 d-flex flex-column position-static contenidoArticle">
                    <h1>
                        <a href="/CINEMASERIES/html/noticia.php?idNoticia='.$fila['id_noticia'].'">
                            '. $fila['titulo'] .'
                        </a>
                    </h1>
                    <p>
                        <a href="/CINEMASERIES/html/noticias.php?categoriaPrincipal='.$fila['categoria_principal'].'">
                            '. $fila['categoria_principal'] . '
                        </a>
                    </p>
                    <p>
                        ' . $fila['descripcion'] .' <a href="/CINEMASERIES/html/noticia.php?idNoticia='.$fila['id_noticia'].'">LEER MÁS »</a>
                    </p>
                    <p>
                        <a href="#">
                            <img src="/CINEMASERIES/imagenes/icono-comentarios.png" alt="">
                        </a>
                        '. $fila['num_comentarios'] . ' - '. $fila['nombre'] . ' ' . $fila['apellido1'] . ' ' . $fila['apellido2'] .' - '. $fila['fecha'] .'
                    </p>
                    <form method="POST">
                        <input type="hidden" name="idNoticia" value="'.$fila['id_noticia'].'">
                        <button type="submit" class="btn btn-danger" name="eliminarNoticia">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>';
    }

    return $tarjetaNoticia;
}
?>