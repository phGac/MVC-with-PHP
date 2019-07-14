<?php

use App\Modules\View;

$tabla = '<table width="100%" class="table table-hover table-sm">'.
            '<thead>'.
                '<th>Nombre</th>'.
                '<th>Abreviatura</th>'.
                '<th>Estado</th>'.
                '<th></th>'.
            '</thead>'.
            '<tbody>';
foreach( $GRUPOS as $grupo ) {
    $estado = ( $grupo->getEstado() == 1 ) ? 'Activo' : 'Inactivo';
    $tabla .= '<tr>'.
                '<td>'.$grupo->getNombre().'</td>'.
                '<td>'.$grupo->getAbreviatura().'</td>'.
                '<td>'.$estado.'</td>'.
            '<td>';
    $tabla .= View::tablaHerramientas($grupo->getId(), true, 'grupo');
    $tabla .= '</td></tr>';
}

$tabla .= '</tbody></table>';

$dataData .= View::encapsularTabla($tabla, 'Grupo');
$dataData .= View::clickEliminar();

$dataData .= View::pagination($pag, $TOTAL, 10, 'grupo', $search);

?>

