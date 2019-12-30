<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('Cidade'); ?>
<fieldset>
    <?php
    echo $this->Form->input('nome');
    echo $this->Form->input('pais_id', array('id' => 'paisID', 'type' => 'select', 'options' => $paises, 'label' => 'País', 'empty' => ' -- Selecione o país -- ', 'value' => ''));
    echo $this->Form->input('estado_id', array('id' => 'estadoID', 'type' => 'select', 'label' => 'Estados'));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Editar')); ?>
<?php
$this->Js->get('#paisID')->event(
        'change', $this->Js->request(
                array('controller' => 'Estados', 'action' => 'buscaEstados', 'Cidade'), array('update' => '#estadoID',
            'async' => true,
            'method' => 'post',
            'dataExpression' => true,
            'data' => $this->Js->serializeForm(array(
                'isForm' => true,
                'inline' => true
            )),
                )
        )
);
?>