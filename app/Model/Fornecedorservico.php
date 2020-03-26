<?php

App::uses('AppModel', 'Model');

/**
 * Fornecedorservico Model
 *
 */
class Fornecedorservico extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'fornecedor_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'servico_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'user_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'valor' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'allowEmpty' => true,
            ),
        ),
        'avaliacao' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'observacao' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'allowEmpty' => true,
            ),
        ),
    );

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Fornecedor' => array(
            'className' => 'Fornecedor',
            'foreignKey' => 'fornecedor_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    /**
     * hasMany associations
     */
    public $hasMany = array(
    );

}

?>
