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

        $this->Tiposervico->id = $id;
        if (!$this->Tiposervico->exists($id)) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $dadosUser = $this->Session->read();

        $tiposervico = $this->Tiposervico->read(null, $id);

        $this->set('tiposervico', $tiposervico);
    }

    /**
     * add method
     */
    public function add() {

        $dadosUser = $this->Session->read();

        if ($this->request->is('post')) {
            $separadores = array(".", "-", "/", "(", ")");
            $this->request->data['Fornecedor']['cel'] = str_replace($separadores, '', $this->request->data['Fornecedor']['cel']);
            $this->request->data['Fornecedor']['telefone'] = str_replace($separadores, '', $this->request->data['Fornecedor']['telefone']);
            $this->request->data['Fornecedor']['user_id'] = $dadosUser['Auth']['User']['id'];
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
            $separadores = array(".", "-", "/", "(", ")");
            $this->request->data['Fornecedor']['cel'] = str_replace($separadores, '', $this->request->data['Fornecedor']['cel']);
            $this->request->data['Fornecedor']['telefone'] = str_replace($separadores, '', $this->request->data['Fornecedor']['telefone']);
            if ($this->Fornecedor->save($this->request->data)) {
                $this->Session->setFlash('Fornecedor alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi alterado. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
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
