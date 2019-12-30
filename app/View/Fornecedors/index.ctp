<?php

echo $this->Html->link($this->Html->image("botoes/add.png", array("alt" => "Adicionar", "title" => "Adicionar")), array('action' => 'add'), array('escape' => false));
//echo $this->Html->link($this->Html->image("botoes/imprimir.png", array("alt" => "Imprimir", "title" => "Imprimir")), array('action' => 'print'), array('escape' => false));
?>
<br>
<br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('id'); ?></th>
        <th><?php echo $this->Paginator->sort('nome', 'Nome'); ?></th>
        <th><?php echo $this->Paginator->sort('cel', 'Cel'); ?></th>
        <th><?php echo $this->Paginator->sort('telefone', 'Fixo'); ?></th>
        <th><?php echo $this->Paginator->sort('email', 'E-mail'); ?></th>
        <th><?php echo 'N° avaliações'; ?></th>
        <th><?php echo 'Média (5)'; ?></th>
        <th><?php echo ''; ?></th>
        <th class="actions"><?php echo __('Ações'); ?></th>
    </tr>
    <?php foreach ($fornecedors as $item): ?>
    <tr>
        <td><?php echo $item['Fornecedor']['id']; ?>&nbsp;</td>
        <td><?php echo $item['Fornecedor']['nome'] . ' ' . $item['Fornecedor']['sobrenome']; ?>&nbsp;</td>
        <td><?php echo '('.substr($item['Fornecedor']['cel'], 0, 2).') '.substr($item['Fornecedor']['cel'], 2, 5).'.'.substr($item['Fornecedor']['cel'], 7, 4); ?>&nbsp;</td>
        <?php if (!empty($item['Fornecedor']['telefone'])) { ?>
        <td><?php echo '('.substr($item['Fornecedor']['telefone'], 0, 2).') '.substr($item['Fornecedor']['telefone'], 2, 4).'.'.substr($item['Fornecedor']['telefone'], 6, 4); ?>&nbsp;</td>
        <?php } else { ?>
        <td><?php echo ''; ?>&nbsp;</td>
        <?php } ?>
        <td><?php echo $item['Fornecedor']['email']; ?>&nbsp;</td>
        <?php $numero_avaliacoes = $this->requestAction('/Fornecedors/busca_numeroavaliacoes', array('pass' => array($item['Fornecedor']['id']))); ?>
        <td><?php echo $numero_avaliacoes; ?>&nbsp;</td>
        <?php $media_avaliacoes = $this->requestAction('/Fornecedors/busca_mediaavaliacoes', array('pass' => array($item['Fornecedor']['id']))); ?>
        <td><?php echo number_format($media_avaliacoes, 2, ",", ""); ?>&nbsp;</td>
        <td align="left"><?php echo $this->Html->link($this->Html->image("botoes/experiencia.png", array("alt" => "Compartilhar a sua experiência com este profissional", "title" => "Compartilhar a sua experiência com este profissional")), array('action' => 'experience', $item['Fornecedor']['id']), array('escape' => false));?></td>
        <td>
            <div id="botoes">
                    <?php
                    echo $this->Html->link($this->Html->image("botoes/view.png", array("alt" => "Visualizar", "title" => "Visualizar")), array('action' => 'view', $item['Fornecedor']['id']), array('escape' => false));
                    if ($dadosUser['Auth']['User']['id'] == $item['Fornecedor']['usercad_id']) {
                        echo $this->Html->link($this->Html->image("botoes/editar.gif", array("alt" => "Editar", "title" => "Editar")), array('action' => 'edit', $item['Fornecedor']['id']), array('escape' => false));
                    echo $this->Html->link($this->Html->image('botoes/excluir.gif', array('alt' => 'Exluir', 'title' => 'Exluir')),
                                               array('action' => 'delete', $item['Fornecedor']['id']), array('escape' => false),
                                               __('Você realmete deseja apagar esse item?')
                                              );
                    }
                    ?>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<br>
<p>
    <?php
    if ($this->Paginator->counter('{:pages}') > 1) {
        echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
    } else {
        echo $this->Paginator->counter('{:count}') . " registros encontrados.";
    }
    ?>
</p>