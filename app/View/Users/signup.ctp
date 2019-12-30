<?php

$this->layout = 'naoLogado'; ?>

<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br><br>
<div id="efetue_cadastro">
    <h1>&nbsp;&nbsp;&nbsp;&nbsp;Efetue seu cadastro</h1>
</div>
<br>
<?php echo $this->Form->create('User', array('action' => 'signup')); ?>

<?php
echo $this->Form->input('nome', array('id' => 'nome', 'label' => 'Nome'));
echo $this->Form->input('sobrenome', array('id' => 'nome', 'label' => 'Sobrenome'));
echo $this->Form->input('lote', array('id' => 'lote', 'label' => 'Lote'));
echo $this->Form->input('username', array('id' => 'username', 'label' => 'E-mail'));
echo $this->Form->input('new_password', array('id' => 'new_password', 'type' => 'password', 'label' => 'Senha'));
echo $this->Form->input('confirm_password', array('id' => 'confirm_password', 'type' => 'password', 'label' => 'Confirma senha'));
?>
<?php echo $this->Form->end(__('Efetuar cadastro')); ?>

<script type="text/javascript">

    jQuery(document).ready(function () {
        document.getElementById('nome').focus();
//        $("#fone").mask("(99)9999.9999");
    });

</script>