<?php

echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('Licitacao'); ?>
<div id="informacao_servico">
    <h3>Selecione os serviços que serão enviados para os fornecedores</h3>
</div>
<fieldset>
    <?php
    echo $this->Form->input('descricao', array('id' => 'descricaoID', 'type' => 'text', 'label' => 'Descrição'));
    echo $this->Form->input('Servico.tiposervico_id', array('id' => 'tiposervicoID', 'type' => 'select', 'options' => $tiposervicos, 'label' => 'Tipos de serviço', 'empty' => ' -- Selecione o tipo de serviço -- '));
    echo $this->Form->input('servico_id', array('id' => 'servicoID', 'type' => 'select', 'label' => 'Selecionar serviços', 'multiple' => true, 'style' => 'height: 220px;'));
    echo $this->Form->input('observacao', array('id' => 'observacao', 'type' => 'textarea', 'label' => 'Observação da licitação', 'escape' => false, 'style' => 'height: 200px;'));
    echo $this->Form->input('confirma', array('type' => 'hidden', 'value' => 'N'));
    ?>
</fieldset>

<?php echo $this->Form->end(__('Selecionar fornecedores')); ?>

<?php
$this->Js->get('#tiposervicoID')->event(
        'change', $this->Js->request(
                array('controller' => 'Servicos', 'action' => 'buscaLicitacaoServicos', 'Servico'), array('update' => '#servicoID',
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

<script type="text/javascript">
    jQuery(document).ready(function () {
        document.getElementById('descricaoID').focus();
    });
</script>