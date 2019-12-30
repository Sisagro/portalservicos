<?php

App::uses('AppModel', 'Model');

/**
 * Licitacaoservico Model
 *
 */
class Licitacaoservico extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'servico_id' => array(
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
        'Servico' => array(
            'className' => 'Servico',
            'foreignKey' => 'servico_id',
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
