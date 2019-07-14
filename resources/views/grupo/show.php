
      <br/>


      <?php if($GRUPO != null){ ?>

        <div class="text-center">
          <h4>Grupo : <?=$GRUPO->getNombre()?></h4>
          <hr/>
        </div>

        <?php

            echo('nombre: '.$GRUPO->getNombre().'<br>');
            echo('abreviatura: '.$GRUPO->getAbreviatura().'<br>');
            echo('estado: '.$GRUPO->getEstado().'<br>');
            echo('id: '.$GRUPO->getId().'<br>');
          }else{
            echo('null');
          }
        ?>
      

      