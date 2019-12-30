<?php

echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br><br>
<div id="efetue_cadastro">
    <h1>&nbsp;&nbsp;&nbsp;&nbsp;Descreva a sua experiência com este fornecedor</h1>
</div>
<br><br>

<div id="informacao_servico">
    <h3>&nbsp;&nbsp;&nbsp;<u>Informações do fornecedor</u></h3>
    <br>
    <h4>&nbsp;&nbsp;&nbsp;Nome: <?php echo $fornecedor['Fornecedor']['nome'] . ' ' . $fornecedor['Fornecedor']['sobrenome'];?> </h4>
    <h4>&nbsp;&nbsp;&nbsp;E-mail: <?php echo $fornecedor['Fornecedor']['email'];?> </h4>
    <h4>&nbsp;&nbsp;&nbsp;Celular: <?php echo '('.substr($fornecedor['Fornecedor']['cel'], 0, 2).') '.substr($fornecedor['Fornecedor']['cel'], 2, 5).'.'.substr($fornecedor['Fornecedor']['cel'], 7, 4);?> </h4>
    <?php if (!empty($fornecedor['Fornecedor']['telefone'])) { ?>
    <h4>&nbsp;&nbsp;&nbsp;Telefone: <?php echo '('.substr($fornecedor['Fornecedor']['telefone'], 0, 2).') '.substr($fornecedor['Fornecedor']['telefone'], 2, 4).'.'.substr($fornecedor['Fornecedor']['telefone'], 6, 4); ?>&nbsp;</h4>
        <?php } else { ?>
    <h4>&nbsp;&nbsp;&nbsp;Telefone: <?php echo ''; ?>&nbsp;</h4>
        <?php } ?>
    <?php $media_avaliacoes = $this->requestAction('/Fornecedors/busca_mediaavaliacoes', array('pass' => array($fornecedor['Fornecedor']['id']))); ?>
    <h4>&nbsp;&nbsp;&nbsp;Média avaliação: <?php echo number_format($media_avaliacoes, 2, ",", "");?> </h4>
</div>
<br>
<?php echo $this->Form->create('Fornecedor'); ?>

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