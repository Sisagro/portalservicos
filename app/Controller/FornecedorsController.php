<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

/**
 * Fornecedores Controller
 */
class FornecedorsController extends AppController {

    function beforeFilter() {
        $this->set('title_for_layout', 'Fornecedores');
    }

    public function isAuthorized($user) {
        $Users = new UsersController;
        return parent::isAuthorized($user);
    }

    /**
     * index method
     */
    public function index() {

        $dadosUser = $this->Session->read();
        $this->set('dadosUser', $dadosUser);

        $this->Fornecedor->recursive = 0;
        $this->Paginator->settings = array(
            'order' => array('descricao' => 'asc')
        );
        $this->set('fornecedors', $this->Paginator->paginate('Fornecedor'));
    }

    /**
     * view method
     */
    public function view($id = null) {

        $this->Fornecedor->id = $id;
        if (!$this->Fornecedor->exists($id)) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $dadosUser = $this->Session->read();

        $this->Fornecedor->recursive = 0;

        $fornecedor = $this->Fornecedor->read(null, $id);

        $fornecedor_servicos = $this->Fornecedor->find('all', array(
            'fields' => array('User.id', 'User.nome', 'User.sobrenome', 'User.lote', 'Servico.descricao', 'Tiposervico.descricao',
                'Fornecedorservico.valor', 'Fornecedorservico.avaliacao', 'Fornecedorservico.observacao', 'Fornecedorservico.created'),
            'conditions' => array('Fornecedor.id' => $id),
            'joins' => array(
                array(
                    'table' => 'fornecedorservicos',
                    'alias' => 'Fornecedorservico',
                    'type' => 'INNER',
                    'conditions' => [
                        'Fornecedor.id = Fornecedorservico.fornecedor_id',
                    ],
                ),
                array(
                    'table' => 'servicos',
                    'alias' => 'Servico',
                    'type' => 'INNER',
                    'conditions' => [
                        'Servico.id = Fornecedorservico.servico_id',
                    ],
                ),
                array(
                    'table' => 'tiposervicos',
                    'alias' => 'Tiposervico',
                    'type' => 'INNER',
                    'conditions' => [
                        'Tiposervico.id = Servico.tiposervico_id',
                    ],
                ),
            ),
            'limit' => '',
            'order' => array('Fornecedorservico.created' => 'desc')
        ));

        $this->set('fornecedor_servicos', $fornecedor_servicos);

        $this->set('fornecedor', $fornecedor);

        $avaliacao = $this->busca_mediaavaliacoes($id);

        $this->set('avaliacao', $avaliacao);
    }

    /**
     * add method
     */
    public function add() {

        $dadosUser = $this->Session->read();

        if ($this->request->is('post')) {

            $valida_cpf = $this->validaCPF($this->request->data['Fornecedor']['cpf']);

            if (!$valida_cpf) {
                $this->Session->setFlash('CPF inválido.', 'default', array('class' => 'mensagem_erro'));
                return;
            }

            $valida_fornecedor = $this->Fornecedor->find('count', array('conditions' => array('email' => $this->request->data['Fornecedor']['email'])));

            if ($valida_fornecedor > 0) {
                $this->Session->setFlash('E-mail já foi vinculado a outro fornecedor.', 'default', array('class' => 'mensagem_erro'));
                return;
            }
            $separadores = array(".", "-", "/", "(", ")");
            $this->request->data['Fornecedor']['cpf'] = str_replace($separadores, '', $this->request->data['Fornecedor']['cpf']);
            $this->request->data['Fornecedor']['cel'] = str_replace($separadores, '', $this->request->data['Fornecedor']['cel']);
            $this->request->data['Fornecedor']['telefone'] = str_replace($separadores, '', $this->request->data['Fornecedor']['telefone']);
            $this->request->data['Fornecedor']['usercad_id'] = $dadosUser['Auth']['User']['id'];
            $this->Fornecedor->create();
            if ($this->Fornecedor->save($this->request->data)) {
                $this->Session->setFlash('Fornecedor adicionado com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }

    /**
     * edit method
     */
    public function edit($id = null) {

        $this->Fornecedor->id = $id;
        if (!$this->Fornecedor->exists($id)) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $dadosUser = $this->Session->read();

        $fornecedor = $this->Fornecedor->read(null, $id);

        if ($this->request->is('post') || $this->request->is('put')) {
            $valida_cpf = $this->validaCPF($this->request->data['Fornecedor']['cpf']);

            if (!$valida_cpf) {
                $this->Session->setFlash('CPF inválido.', 'default', array('class' => 'mensagem_erro'));
                return;
            }
            $separadores = array(".", "-", "/", "(", ")");
            $this->request->data['Fornecedor']['cpf'] = str_replace($separadores, '', $this->request->data['Fornecedor']['cpf']);
            $this->request->data['Fornecedor']['cel'] = str_replace($separadores, '', $this->request->data['Fornecedor']['cel']);
            $this->request->data['Fornecedor']['telefone'] = str_replace($separadores, '', $this->request->data['Fornecedor']['telefone']);
            if ($this->Fornecedor->save($this->request->data)) {
                $this->Session->setFlash('Fornecedor alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi alterado. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
            $this->Fornecedor->recursive = 0;
            $this->request->data = $this->Fornecedor->read(null, $id);
        }
    }

    /**
     * delete method
     */
    public function delete($id = null) {

        $this->Fornecedor->id = $id;
        if (!$this->Fornecedor->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->Fornecedor->delete()) {
            $this->Session->setFlash('Fornecedor deletado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Registro não foi deletado.', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * experience method
     */
    public function experience($id = null) {

        $dadosUser = $this->Session->read();

        $fornecedor = $this->Fornecedor->read(null, $id);
        $this->set('fornecedor', $fornecedor);

        $this->loadModel('Tiposervico');
        $tiposervicos = $this->Tiposervico->find('list', array(
            'fields' => array('id', 'descricao'),
            'order' => array('descricao' => 'asc')
        ));
        $this->set('tiposervicos', $tiposervicos);

        $avaliacao = array('0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5);
        $this->set('avaliacao', $avaliacao);

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Fornecedorservico']['fornecedor_id'] = $id;
            $this->request->data['Fornecedorservico']['user_id'] = $dadosUser['Auth']['User']['id'];
            if (empty($this->request->data['Fornecedorservico']['valor'])) {
                $this->request->data['Fornecedorservico']['valor'] = 0;
            }
            if ($this->Fornecedor->Fornecedorservico->save($this->request->data['Fornecedorservico'])) {
                $this->Session->setFlash('Obrigado por compartilhar a sua experiência com este fornecedor.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi alterado. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }

    /**
     * validaCPF method
     */
    function validaCPF($cpf) {

        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }
        return true;
    }

    /**
     * experience method
     */
    public function busca_numeroavaliacoes($id = null) {
        $result = $this->Fornecedor->query('select count(*) as cont from fornecedorservicos where fornecedor_id = ' . $id);

        return $result[0][0]['cont'];
    }

    /**
     * experience method
     */
    public function busca_mediaavaliacoes($id = null) {

        $result = $this->Fornecedor->query('select (sum(avaliacao) / count(*)) as cont from fornecedorservicos where fornecedor_id = ' . $id);

        return $result[0][0]['cont'];
    }

}

?>
