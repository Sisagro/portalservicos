<?php

$this->layout = 'naoLogado'; ?>
<br>
<br>
<?php echo $this->Form->create('User', array('action' => 'login')); ?>

<?php
echo $this->Form->input('username', array('id' => 'username', 'label' => 'E-mail'));
echo $this->Form->input('password', array('id' => 'password', 'label' => 'Senha'));
?>
<?php echo $this->Form->end('Entrar'); ?>
<br>
<a href="../Users/signup"><img src="../img/botoes/cadastro.png"></a>

<script type="text/javascript">
    jQuery(document).ready(function () {
        $('#username').focus();
    });
</script>