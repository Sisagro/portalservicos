<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<p>
    <strong> Nome: </strong>
    <?php echo $user['User']['nome'] . " " . $user['User']['sobrenome']; ?>
    <br>
    <strong> Username: </strong>
    <?php echo $user['User']['username']; ?>
    <br>
    <strong> Último acesso: </strong>
    <?php echo $user['User']['ultimoacesso']; ?>
    <br>
</p>