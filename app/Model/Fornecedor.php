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
                'rule' => array('notempty'),
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
        'Fornecedorservico' => array(
            'className' => 'Fornecedorservico',
            'foreignKey' => 'fornecedor_id',
            'dependent' => true,
        ),
    );

}

?>
