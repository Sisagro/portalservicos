<?php

App::uses('AppModel', 'Model');

/**
 * Fornecedor Model
 *
 */
class Fornecedor extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'cpf' => array(
            'rule' => array('maxLength', '11'),
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'nome' => array(
            'rule' => array('maxLength', '200'),
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'sobrenome' => array(
            'rule' => array('maxLength', '200'),
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'telefone' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'allowEmpty' => true,
            ),
        ),
        'cel' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'email' => array(
            'rule' => array('maxLength', '200'),
            'notempty' => array(
                'allowEmpty' => true,
            ),
        ),
        'usercad_id' => array(
            'rule' => array('maxLength', '11'),
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
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'usercad_id',
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
            'foreignKey' => 'fornecedor_id',
            'dependent' => true,
        ),
        'Licitacaofornecedor' => array(
            'className' => 'Licitacaofornecedor',
            'foreignKey' => 'fornecedor_id',
            'dependent' => true,
        ),
    );

}

?>
