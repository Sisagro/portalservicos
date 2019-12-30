<?php

App::uses('AppModel', 'Model');

/**
 * Licitacaoservico Model
 *
 */
class Licitacaofornecedor extends AppModel {

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
        'licitacao_id' => array(
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
        'Fornecedor' => array(
            'className' => 'Fornecedor',
            'foreignKey' => 'fornecedor_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Licitacao' => array(
            'className' => 'Licitacao',
            'foreignKey' => 'licitacao_id',
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
