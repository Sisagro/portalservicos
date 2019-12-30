<div id="formulario">
    <?php echo $this->Form->create('Contato', array('action' => 'index')); ?>
    <table style="border:none;">
        <tr>
            <td>Host</td>
            <td><?php echo $this->Form->input('config', array('id' => 'config', 'options' => $host, 'label' => false)); ?></td>
        </tr>
        <tr>
            <td>Para</td>
            <td><?php echo $this->Form->input('Contato.nome', array('id' => 'nome', 'label' => false, 'maxlength' => 100, 'size' => 40)); ?></td>
        </tr>
        <tr>
            <td>Assunto</td>
            <td><?php echo $this->Form->input('Contato.assunto', array('id' => 'assunto', 'label' => false, 'maxlength' => 100, 'size' => 40)); ?></td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Mensagem</td>
            <td><?php echo $this->Form->input('Contato.mensagem', array('label' => false, 'value' => 'Mensagem de teste', 'cols' => 50, 'rows' => 10)); ?></td>
        </tr>
        <tr>
            <td colspan="2" align="right"><br><?php echo $this->Form->end('Enviar e-mail'); ?></td>
        </tr>
    </table>
</div>