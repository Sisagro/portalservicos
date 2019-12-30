<?php

App::uses('AppModel', 'Model');

/**
 * Tiposervico Model
 *
 */
class Tiposervico extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'descricao' => array(
            'rule' => array('maxLength', '100'),
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
    );

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
    );

    /**
     * hasMany associations
     */
    public $hasMany = array(
        'Servico' => array(
            'className' => 'Servico',
            'foreignKey' => 'tiposervico_id',
            'dependent' => true,
        ),
    );

}

?>
