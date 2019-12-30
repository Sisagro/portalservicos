<!DOCTYPE html>
<html>
    <head>
        <?php
        echo $this->Html->charset();
        //Pegando dados da sessão do usuário
        $dadosUser = $this->Session->read();
        ?>
        <title>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('catalogo');
        echo $this->Html->css('south-street/jquery-ui-1.10.3.custom.min');
        echo $this->Html->css('colorpicker/colorpicker');

        echo $this->Html->script(array('jquery.js', 'gerais.js', 'jquery-ui.js', 'jquery.maskedinput.min.js', 'jquery.maskMoney.js', 'jquery-ui-1.10.3.custom.min.js', 'colorpicker.js', 'jquery.easing.min.js', 'jQueryRotateCompressed.js'));

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>

    </head>
    <body>

        <div id="global">

            <div id="diferenca">

            </div>

            <div id="topo">
                <div id="topoleftr">
                    <?php
                    echo $this->Html->link($this->Html->image("logo.gif", array("alt" => "Catálogo", "title" => "Catálogo")), array('controller' => 'homes', 'action' => 'index'), array('escape' => false));
                    ?>
                </div>
                <div id="toporight">
                    <div id="internadomenu">
                        <?php
                        echo $this->Html->link($this->Html->image("botoes/logout_01.png", array("alt" => "Sair", "title" => "Sair")), array('controller' => 'users', 'action' => 'logout'), array('escape' => false));
                        ?>
                        Bem vindo, <span class="fontNomeUsuario"><b><?php echo $dadosUser['Auth']['User']['nome']; ?></b></span>.
                        <br> <span class="fontUltimoAcesso">Seu último acesso foi: <?php echo $dadosUser['Auth']['User']['ultimoacesso']; ?></span>
                        <br></br>
                        <?php
                        //echo $this->Html->link($this->Html->image("botoes/logout_01.png", array("alt" => "Sair", "title" => "Sair")), array('controller' => 'users', 'action' => 'logout'), array('escape' => false));
                        ?>
                    </div>
                </div>
                <?php // echo $this->element('menu'); ?>
            </div>
            <div id="conteudo">

                <div id="corpo">
                    <h1><?php echo $this->element('navegacao'); ?></h1>
                    <?php echo $this->Session->flash(); ?>
                    <?php echo $this->fetch('content'); ?>
                </div>

            </div>

            <div id="rodape">
                <?php echo $this->Js->writeBuffer(); ?>
            </div>

        </div>

    </body>
</html>