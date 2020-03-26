<?php

echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false));
?>
<br>
<br>
<?php echo $this->Form->create('Fornecedor'); ?>
<fieldset>
    <?php
    echo $this->Form->input('nome', array('id' => 'nome', 'label' => 'Nome'));
    echo $this->Form->input('sobrenome',  array('id' => 'nome', 'label' => 'Sobrenome'));
    echo $this->Form->input('email',  array('id' => 'email', 'label' => 'E-mail'));
    echo $this->Form->input('cel',  array('id' => 'cel', 'label' => 'Celular'));
    echo $this->Form->input('telefone',  array('id' => 'telefone', 'label' => 'Telefone'));
    ?>
</fieldset>

<?php echo $this->Form->end(__('Editar')); ?>

<script type="text/javascript">

    jQuery(document).ready(function () {
        $("#cel").mask("(99)99999.9999");
        $("#telefone").mask("(99)9999.9999");
    });

</script>