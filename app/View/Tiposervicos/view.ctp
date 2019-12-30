<?php

echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false));
?>
<br>
<br>
<p>
    <strong> Descrição: </strong>
<?php echo $tiposervico ['Tiposervico']['descricao']; ?>
    <br>
</p>