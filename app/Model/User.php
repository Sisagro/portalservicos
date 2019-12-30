<?php

App::uses('AppModel', 'Model');

App::uses('AuthComponent', 'Controller/Component');

/**
 * User Model
 *
 */
class User extends AppModel {

    /**
     * Rules before save
     *
     */
    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }

    /**
     * Validation rules
     */
    public $validate = array(
        'username' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'password' => array(
            'vazio' => array(
                'rule' => array('notEmpty'),
                'message' => 'Este campo não pode ser vazio.'
            ),
        ),
        'new_password' => array(
            'vazio' => array(
                'rule' => array('notEmpty'),
                'message' => 'Este campo não pode ser vazio.'
            ),
        ),
        'old_password' => array(
            'vazio' => array(
                'rule' => array('validaSenhaAtual'),
                'message' => 'Senha diferente da senha atual.'
            ),
        ),
        'confirm_password' => array(
            'vazio' => array(
                'rule' => array('validaCofirmacao'),
                'message' => 'Confirmação da senha não confere com a senha digitada.'
            ),
        ),
        'nome' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'sobrenome' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'ultimoacesso' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'lote' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
    );

    /**
     * Regras de validação
     *
     */
    public function validaSenhaAtual($check) {

        $this->recursive = -1;
        $user = $this->find('first', array(
            'conditions' => array(
                'User.id' => AuthComponent::user('id'),
            ),
            'fields' => array('password')
        ));

        $storedHash = $user['User']['password'];
        $novaSenha = AuthComponent::password($this->data['User']['old_password']);
        $correct = $storedHash == $novaSenha;
        return $correct;
    }

    public function validaCofirmacao($check) {
        if ($this->data['User']['new_password'] == $this->data['User']['confirm_password']) {
            return true;
        }
        return false;
    }

    /**
     * belongsTo associations
     *
     */
    public $belongsTo = array(
    );

    /**
     * hasMany associations
     *
     */
    public $hasMany = array(
        'Fornecedor' => array(
            'className' => 'Fornecedor',
            'foreignKey' => 'usercad_id',
            'dependent' => true,
        ),
        'Fornecedorservico' => array(
            'className' => 'Fornecedorservico',
            'foreignKey' => 'user_id',
            'dependent' => true,
        ),
        'Licitacao' => array(
            'className' => 'Licitacao',
            'foreignKey' => 'user_id',
            'dependent' => true,
        ),
    );

    /**
     * hasAndBelongsToMany associations
     */
    public $hasAndBelongsToMany = array(
    );

    public function afterFind($dados, $primary = false) {
        foreach ($dados as $key => $value) {
            if (!empty($value["User"]["ultimoacesso"])) {
                $dados[$key]["User"]["ultimoacesso"] = $this->formataDataHora($value["User"]["ultimoacesso"], 'PT');
            }
        }
        return $dados;
    }

}