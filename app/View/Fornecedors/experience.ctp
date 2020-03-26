<div id="efetue_cadastro">
    <h1>&nbsp;&nbsp;&nbsp;&nbsp;Conte a sua experiência com este fornecedor</h1>
</div>
<br><br>
<?php

echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br><br>

<div id="informacao_servico">
    <h3>&nbsp;&nbsp;&nbsp;Informações do fornecedor</h3>
</div>
<br>
<?php echo $this->Form->create('Fornecedor'); ?>
<fieldset>
    <?php
    echo $this->Form->input('nome', array('id' => 'nome', 'label' => 'Nome', 'value'=> $fornecedor['Fornecedor']['nome']. ' '. $fornecedor['Fornecedor']['sobrenome'], 'readonly' => true));
    echo $this->Form->input('email',  array('id' => 'email', 'label' => 'E-mail', 'value'=> $fornecedor['Fornecedor']['email'], 'readonly' => true));
    echo $this->Form->input('cel',  array('id' => 'cel', 'label' => 'Celular', 'value'=> $fornecedor['Fornecedor']['cel'], 'readonly' => true));
    echo $this->Form->input('telefone',  array('id' => 'telefone', 'label' => 'Telefone', 'value'=> $fornecedor['Fornecedor']['telefone'], 'readonly' => true));
    ?>
</fieldset>
<div id="informacao_servico">
    <h3>Informações referente ao serviço prestado</h3>
</div>
<br>
<?php echo $this->Form->create('Fornecedorservico'); ?>
<fieldset>
    <?php
    echo $this->Form->input('tiposervico_id', array('id' => 'tiposervicoID', 'type' => 'select', 'options' => $tiposervicos, 'label' => 'Tipos de serviço', 'empty' => ' -- Selecione o tipo de serviço -- '));
    echo $this->Form->input('servico_id', array('id' => 'servicoID', 'type' => 'select', 'label' => 'Serviço realizado'));
    echo $this->Form->input('valor', array('id' => 'valorID', 'type' => 'text', 'label' => 'Valor cobrado'));
    echo $this->Form->input('avaliacao', array('id' => 'avaliacaoID', 'type' => 'select', 'options' => $avaliacao, 'label' => 'Avaliação do serviço prestado', 'empty' => ' -- Dê uma nota de zero a cinco -- '));
    echo $this->Form->input('observacao', array('id' => 'observacao', 'type' => 'textarea', 'label' => 'Compartilhe alguma informação que seja importante referente ao serviço realizado', 'escape' => false, 'style' => 'height: 200px;'));
    ?>
</fieldset>

<?php echo $this->Form->end(__('Cadastrar experiencia')); ?>

<?php
$this->Js->get('#tiposervicoID')->event(
        'change', $this->Js->request(
                array('controller' => 'Servicos', 'action' => 'buscaServicos', 'Servico'), array('update' => '#servicoID',
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
        $("#cel").mask("(99)99999.9999");
        $("#telefone").mask("(99)9999.9999");
        $("#valorID").maskMoney({showSymbol: false, decimal: ",", thousands: "", precision: 2});
    });

</script>