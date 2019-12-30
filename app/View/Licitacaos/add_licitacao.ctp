<?php

$dadosFormulario = $this->Session->read('dadosFormulario');
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('Licitacao'); ?>
<div id="informacao_servico">
    <h2>Selecione o(s) fonecedor(es) que irão participar da licitação</h2>
    <br>
    <h3>Descrição:</h3>
    <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $dadosFormulario['Licitacao']['descricao'] ?></h3>
    <h3>Tipo de serviço:</h3>
    <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $servicos[0]['Tiposervico']['descricao'] ?></h3>
    <h3>Serviço(s):</h3>
    <?php foreach ($servicos as $key => $item) : ?>
    <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $item['Servico']['descricao'] ?></h3>
    <?php endforeach; ?>
    <h3>Observação:</h3>
    <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $dadosFormulario['Licitacao']['observacao'] ?></h3>
</div>
<fieldset>
    <?php
    echo $this->Form->input('fornecedor_id', array('id' => 'fornecedorID', 'type' => 'select', 'label' => 'Selecionar os fornecedores', 'multiple' => true, 'style' => 'height: 220px;', 'options'=>$fornecedores));
    echo $this->Form->input('confirma', array('type' => 'hidden', 'value' => 'S'));
    ?>
</fieldset>

<?php echo $this->Form->end(__('Gravar licitação')); ?>

<script type="text/javascript">
    jQuery(document).ready(function () {
        document.getElementById('fornecedorID').focus();
    });
</script>