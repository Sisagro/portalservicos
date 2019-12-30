<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 */
class UsersController extends AppController {

    var $components = array('Email');
    public $name = 'Users';

    public function isAuthorized($user) {
        if ($this->action == 'login' || $this->action == 'logout' || $this->action == 'validaAcesso') {
            return true;
        } else {
            return $this->validaAcesso($this->Session->read(), $this->request->controller);
        }
        return parent::isAuthorized($user);
    }

    public function beforeFilter() {
        $this->Auth->allow('Users', 'signup');
        Security::setHash('sha256');
        $this->set('title_for_layout', 'Usuários');
    }

    public function index() {

        $dadosUser = $this->Session->read();
        $this->set('dadosUser', $dadosUser);

        $this->User->recursive = 0;

        if ($dadosUser['user'][0]['Group']['tipo'] <> 'C') {
            $this->Paginator->settings = array(
                'fields' => array('User.id', 'User.nome', 'User.sobrenome', 'User.username', 'Cidade.nome', 'ultimoacesso'),
                'joins' => array(
                    array(
                        "table" => "cidades",
                        "alias" => "Cidade",
                        "type" => "LEFT",
                        "conditions" => array("Cidade.id = User.cidade_id")
                    )
                ),
                'order' => array('ultimoacesso' => 'desc',
                    'ultimoacesso' => 'desc',)
            );
        } else {
            $this->Paginator->settings = array(
                'fields' => array('User.id', 'User.nome', 'User.sobrenome', 'User.username', 'Cidade.nome', 'ultimoacesso'),
                'joins' => array(
                    array(
                        "table" => "cidades",
                        "alias" => "Cidade",
                        "type" => "INNER",
                        "conditions" => array("Cidade.id = User.cidade_id")
                    )
                ),
                'conditions' => array('User.id' => $dadosUser['Auth']['User']['id']),
                'order' => array('ultimoacesso' => 'desc',
                    'ultimoacesso' => 'desc',)
            );
        }

        $this->set('users', $this->Paginator->paginate('User'));
    }

    public function add() {

        $dadosUser = $this->Session->read();
        $this->set('dadosUser', $dadosUser);

        $this->loadModel('Paise');
        $paises = $this->Paise->find('list', array(
            'fields' => array('id', 'nome'),
            'order' => array('nome' => 'asc')
        ));
        $this->set('paises', $paises);

        $this->loadModel('Placa');
        $placa_aux = $this->Placa->find('all', array(
            'fields' => array('id', 'placa', 'descricao'),
            'conditions' => array('Placa.ativo' => 'S', 'Placa.id not in (select placa_id from userplacas)'),
            'order' => array('placa' => 'asc')
        ));

        foreach ($placa_aux as $key => $item) :
            $placas[$item['Placa']['id']] = substr($item['Placa']['placa'], 0, 3) . '-' . substr($item['Placa']['placa'], 3, 4) . ' ' . $item['Placa']['descricao'];
        endforeach;
        $this->set('placas', $placas);

        $this->loadModel('Cartao');
        $cartaos_aux = $this->Cartao->find('all', array(
            'fields' => array('Cartao.id', 'Cartao.numero', 'Bandeira.descricao'),
            'conditions' => array('Cartao.ativo' => 'S', 'Cartao.id not in (select cartao_id from usercartaos)'),
            'order' => array('numero' => 'asc')
        ));

        foreach ($cartaos_aux as $key => $item) :
            $cartaos[$item['Cartao']['id']] = 'xxxx.xxxx.xxxx.' . $item['Cartao']['numero'] . '  ' . $item['Bandeira']['descricao'];
        endforeach;
        $this->set('cartaos', $cartaos);

        if ($this->request->is('post')) {
            $this->User->create();
            $this->request->data['User']['ultimoacesso'] = date('Y-m-d');
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('Usuário salvo com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }

    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Registro inválido.'));
        }

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Registro inválido.'));
        }

        $dadosUser = $this->Session->read();
        $this->set('dadosUser', $dadosUser);

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('Usuário alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi alterado. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
        }
    }

    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash('Usuário deletado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Registro não foi deletado.', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function validaAcesso($user, $controller) {

    }

    public function login() {
        if ($this->request->is('post')) {

            if ($this->Auth->login()) {

                $usuario = $this->User->read(null, $this->Auth->user('id'));

                //Grava último acesso do usuário
                $this->User->saveField('ultimoacesso', date('Y-m-d H:i:s'));

                $this->redirect(array('controller' => 'homes', 'action' => 'index'));
            } else {
                $this->Session->setFlash('Usuário ou senha incorretos.', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }

    public function signup() {

        if ($this->request->is('post') || $this->request->is('put')) {

            $valida_usuario = $this->User->find('count', array('conditions' => array('username' => $this->request->data['User']['username'])));

            if ($valida_usuario > 0) {
                $this->Session->setFlash('E-mail já esta em uso.', 'default', array('class' => 'mensagem_erro'));
                return;
            }

            $this->request->data['User']['password'] = $this->request->data['User']['new_password'];

            if ($this->User->save($this->request->data, array('validate' => 'only'))) {

                $usuario = $this->User->read(null, $this->Auth->user('id'));
                CakeSession::write('usuario', $usuario);

                //Grava último acesso do usuário
                $this->User->saveField('ultimoacesso', date('Y-m-d H:i:s'));

                $this->Auth->login();

                $this->redirect(array('controller' => 'homes', 'action' => 'index'));
            }
        }
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    public function alteraSenha() {

        $this->set('title_for_layout', 'Altera senha');

        $dadosUser = $this->Session->read();

        $id = $dadosUser['Auth']['User']['id'];

        $user = $this->User->findById($id);

        if (!$this->request->data) {
            $this->request->data = $user;
            unset($this->request->data['User']['password']);
        }

        if ($this->request->is('post') || $this->request->is('put')) {

            $this->User->validator()->remove('nome');
            $this->User->validator()->remove('sobrenome');
            $this->User->validator()->remove('username');
            $this->User->validator()->remove('password');

            if ($this->User->saveAll($this->request->data, array('validate' => 'only'))) {
                $this->User->id = $dadosUser['Auth']['User']['id'];
                if ($this->User->saveField('password', $this->request->data['User']['new_password'])) {
                    $this->Session->setFlash('Senha alterada com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                    $this->redirect(array('action' => 'alteraSenha'));
                } else {
                    $this->Session->setFlash('Não foi possível editar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
                }
            }
        }
    }

}
