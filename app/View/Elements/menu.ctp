<div id="menu">
    <ul id="jsddm">

        <?php
        $menu_1 = 0;
        $menu_2 = 0;
        $menu_3 = 0;
        $menu_4 = 0;
        $menu_5 = 0;
        $menu_6 = 0;
        $menu_7 = 0;
        $menu_8 = 0;
        $menu_9 = 0;
        $menu_10 = 0;

        foreach ($menuCarregado as $itemMenu):

            if ($itemMenu['Menu']['menu'] == 1 && $menu_1 == 0) {
                ?>
        <li><a href="https://portalservicos/Menus/montamenu/1">GERAIS</a>
            <ul>
                        <?php
                        $menu_1++;
                    } elseif ($itemMenu['Menu']['menu'] == 2 && $menu_2 == 0) {
                        if ($menu_1 != 0) {
                            ?>
            </ul>
        </li>
                    <?php
                }
                ?>
        <li><a href="https://portalservicos/Menus/montamenu/2">CONTABILIDADE</a>
            <ul>
                        <?php
                        $menu_2++;
                    } elseif ($itemMenu['Menu']['menu'] == 3 && $menu_3 == 0) {
                        if ($menu_1 != 0 || $menu_2 != 0) {
                            ?>
            </ul>
        </li>
                    <?php
                }
                ?>
        <li><a href="https://www.portalservicos/Menus/montamenu/3">FINANCEIRO</a>
            <ul>
                        <?php
                        $menu_3++;
                    } elseif ($itemMenu['Menu']['menu'] == 4 && $menu_4 == 0) {
                        ?>
            </ul>
        </li>
        <li><a href="https://www.portalservicos/Menus/montamenu/4">PROCESSOS</a>
            <ul>
                        <?php
                        $menu_4++;
                    } elseif ($itemMenu['Menu']['menu'] == 5 && $menu_5 == 0) {
                        ?>
            </ul>
        </li>
        <li><a href="https://www.portalservicos/Menus/montamenu/5">RELATÓRIOS</a>
            <ul>
                        <?php
                        $menu_5++;
                    } elseif ($itemMenu['Menu']['menu'] == 6 && $menu_6 == 0) {
                        ?>
            </ul>
        </li>
        <li><a href="https://www.portalservicos/Menus/montamenu/6">AJUSTES</a>
            <ul>
                        <?php
                        $menu_6++;
                    } elseif ($itemMenu['Menu']['menu'] == 7 && $menu_7 == 0) {
                        ?>
            </ul>
        </li>
        <li><a href="https://www.portalservicos/Menus/montamenu/7">MANUAIS</a>
            <ul>
                        <?php
                        $menu_7++;
                    } elseif ($itemMenu['Menu']['menu'] == 8 && $menu_8 == 0) {
                        ?>
            </ul>
        </li>
        <li><a href="#"></a>
            <ul>
                        <?php
                        $menu_8++;
                    }
                    ?>
                <li><?php echo $this->Html->link($itemMenu['Menu']['nome'], array('controller' => $itemMenu['Menu']['controller'], 'action' => 'index')); ?></li>
                    <?php
                endforeach;
                ?>

            </ul>
        </li>

    </ul>
</div>