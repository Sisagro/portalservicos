<?php

echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('Servico'); ?>
<fieldset>
    <?php
    echo $this->Form->input('tiposervico_id', array('id' => 'tiposervicoID', 'type' => 'select', 'options' => $tiposervicos, 'label' => 'Tipos de serviço', 'empty' => ' -- Selecione o tipo de serviço -- '));
    echo $this->Form->input('descricao');
    ?>
</fieldset>

<?php echo $this->Form->end(__('Adicionar')); ?>

<script>
    jQuery(document).ready(function () {
        document.getElementById('tiposervicoID').focus();
    });
</script>