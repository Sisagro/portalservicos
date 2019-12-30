<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('User'); ?>
<fieldset>
    <?php
    echo $this->Form->input('nome');
    echo $this->Form->input('sobrenome');
    echo $this->Form->input('email');
    if ($dadosUser['user'][0]['Group']['tipo'] == 'A') {
        echo $this->Form->input('username');
        echo $this->Form->input('password');
        echo $this->Form->input('Cartao.Cartao', array('id' => 'cartaoID', 'title' => 'CTRL + Click (para selecionar mais de um)', 'label' => 'Escolha o(s) cartão(ões)', 'type' => 'select', 'multiple' => true, 'style' => 'height: 150px;'));
        echo $this->Form->input('Placa.Placa', array('id' => 'placaID', 'title' => 'CTRL + Click (para selecionar mais de um)', 'label' => 'Escolha o(s) veículo(s)', 'type' => 'select', 'multiple' => true, 'style' => 'height: 150px;'));
        echo $this->Form->input('pais_id', array('id' => 'paisID', 'type' => 'select', 'options' => $paises, 'label' => 'País', 'empty' => ' -- Selecione o país -- '));
        echo $this->Form->input('estado_id', array('id' => 'estadoID', 'type' => 'select', 'label' => 'Estados'));
        echo $this->Form->input('cidade_id', array('id' => 'cidadeID', 'type' => 'select', 'label' => 'Cidade base'));
        echo $this->Form->input('usernamedominio', array('id' => 'usernamedominio', 'type' => 'text', 'label' => 'Nome do usuário correspondente na domínio'));
        echo $this->Form->input('historico_contabil_dominio_cartao', array('id' => 'historico_contabil_dominio_cartao', 'type' => 'text', 'label' => 'Código do histórico do lançamento contábil na domínio para pagamentos cartão de crédito'));
        echo $this->Form->input('historico_contabil_dominio_dinheiro', array('id' => 'historico_contabil_dominio_dinheiro', 'type' => 'text', 'label' => 'Código do histórico do lançamento contábil na domínio para pagamentos em dinheiro'));
        echo $this->Form->input('conta_credito_adiantamento', array('id' => 'conta_credito_adiantamento', 'type' => 'text', 'label' => 'Código da conta crédito de adiantamento'));
    }
    ?>
</fieldset>
<?php echo $this->Form->end(__('Adicionar')); ?>

<?php
$this->Js->get('#paisID')->event(
        'change', $this->Js->request(
                array('controller' => 'Estados', 'action' => 'buscaEstados', 'User'), array('update' => '#estadoID',
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

$this->Js->get('#estadoID')->event(
        'change', $this->Js->request(
                array('controller' => 'Cidades', 'action' => 'buscaCidades', 'User'), array('update' => '#cidadeID',
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

<script>
    jQuery(document).ready(function() {
//        document.getElementById('paisID').focus();
    });
</script>
