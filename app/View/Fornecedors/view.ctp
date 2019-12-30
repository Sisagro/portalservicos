<?php

echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false));
?>
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
    <h4><?php echo ''; ?>&nbsp;</h4>
        <?php } ?>
    <h4>&nbsp;&nbsp;&nbsp;Média avaliação: <?php echo number_format($avaliacao, 2, ",", "");?> </h4>
</div>
<br><br>
<div id="informacao_servico">
    <h3>&nbsp;&nbsp;&nbsp;<u>Serviços realizados</u></h3>
    <br>
<?php foreach ($fornecedor_servicos as $key => $item) : ?>
    <h4>&nbsp;&nbsp;&nbsp;Serviço: <?php echo $item['Tiposervico']['descricao'] . ' / ' . $item['Servico']['descricao'];?> </h4>
    <h4>&nbsp;&nbsp;&nbsp;Valor: <?php echo number_format($item['Fornecedorservico']['valor'], 2, ",", "");?> </h4>
    <h4>&nbsp;&nbsp;&nbsp;Observação: <?php echo $item['Fornecedorservico']['observacao'];?> </h4>
    <h4>&nbsp;&nbsp;&nbsp;Avaliação: <?php echo $item['Fornecedorservico']['avaliacao'];?> </h4>
    <h4>&nbsp;&nbsp;&nbsp;Data: <?php echo date('d/m/Y H:i', strtotime($item['Fornecedorservico']['created']));?> </h4>
    <h4>&nbsp;&nbsp;&nbsp;Avaliado por: <?php echo $item['User']['nome']. ' ' . $item['User']['sobrenome']. ' / ' . $item['User']['lote'];?> </h4>
    <br>
<?php endforeach; ?>
</div>