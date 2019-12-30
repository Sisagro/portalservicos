<?php

App::uses('AppModel', 'Model');

/**
 * Servico Model
 *
 */
class Servico extends AppModel {

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
        'tiposervico_id' => array(
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
        'Tiposervico' => array(
            'className' => 'Tiposervico',
            'foreignKey' => 'tiposervico_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    /**
     * hasMany associations
     */
    public $hasMany = array(
        'Fornecedorservico' => array(
            'className' => 'Fornecedorservico',
            'foreignKey' => 'servico_id',
            'dependent' => true,
        ),
        'Licitacaoservico' => array(
            'className' => 'Licitacaoservico',
            'foreignKey' => 'servico_id',
            'dependent' => true,
        ),
    );

}

?>
