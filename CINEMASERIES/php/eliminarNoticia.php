<?php
function eliminarNoticia($pdo, $idNoticia)
{
  $consultaNumeroComentarios = "SELECT COUNT(id_noticia) FROM public.comentarios WHERE id_noticia = :idNoticia";

  $stmt = $pdo->prepare($consultaNumeroComentarios);
  $stmt->bindParam(':idNoticia', $idNoticia);
  $stmt->execute();

  $resultado = $stmt->fetchColumn();

  if ($resultado > 0) {
    $eliminarComentarios = "DELETE FROM public.comentarios WHERE id_noticia = :idNoticia";
    $stmt = $pdo->prepare($eliminarComentarios);
    $stmt->bindParam(':idNoticia', $idNoticia);
    $stmt->execute();
  }

  $eliminarNoticia = "DELETE FROM public.noticias WHERE id_noticia = :idNoticia";

  $stmt = $pdo->prepare($eliminarNoticia);
  $stmt->bindParam(':idNoticia', $idNoticia);
  $stmt->execute();
}
?>