<?php

App::uses('AppModel', 'Model');

/**
 * Contato Model
 *
 */
class Contato extends AppModel {

    public $useTable = "despesas";

    /**
     * Validation rules
     *
     * @var array
     */
    var $validate = array(
        'nome' => array(
            'rule' => 'notEmpty',
            'message' => 'O campo nome é obrigatorio.'
        ),
        'email' => array(
            'rule' => 'email',
            'message' => 'O campo e-mail é obrigatório.'
        ),
        'mensagem' => array(
            'rule' => 'notEmpty',
            'message' => 'O campo mensagem do contato é obrigatório.'
        )
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
     *
     * @var array
     */
    public $hasMany = array(
    );

}
