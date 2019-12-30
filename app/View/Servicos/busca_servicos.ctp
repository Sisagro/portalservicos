<?php

echo "<option value=\"\"> -- Selecione o serviço --</option>";
    foreach($servicos as $key => $subcat){
        echo "<option value=\"{$key}\">{$subcat}</option>";
    }
?>