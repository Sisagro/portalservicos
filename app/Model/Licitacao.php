<?php

App::uses('AppModel', 'Model');

/**
 * Licitacao Model
 *
 */
class Licitacao extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'descricao' => array(
            'rule' => array('maxLength', '250'),
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'user_id' => array(
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
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'dependent' => true,
        ),
    );

    /**
     * hasMany associations
     */
    public $hasMany = array(
        'Licitacaofornecedor' => array(
            'className' => 'Licitacaofornecedor',
            'foreignKey' => 'licitacao_id',
            'dependent' => false,
        ),
        'Licitacaoservico' => array(
            'className' => 'Licitacaoservico',
            'foreignKey' => 'licitacao_id',
            'dependent' => false,
        ),
    );

}

?>
