<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

/**
 * Servicos Controller
 */
class ServicosController extends AppController {

    function beforeFilter() {
        $this->set('title_for_layout', 'Servicos');
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
        $this->Servico->recursive = 0;
        $this->Paginator->settings = array(
            'order' => array('descricao' => 'asc')
        );
        $this->set('servicos', $this->Paginator->paginate('Servico'));
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

        $tiposervicos = $this->Servico->Tiposervico->find('list', array(
            'fields' => array('id', 'descricao'),
            'order' => array('descricao' => 'asc')
        ));
        $this->set('tiposervicos', $tiposervicos);

        if ($this->request->is('post')) {
            $this->Servico->create();
            if ($this->Servico->save($this->request->data)) {
                $this->Session->setFlash('Serviço adicionado com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
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

        $this->Servico->id = $id;
        if (!$this->Servico->exists($id)) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $dadosUser = $this->Session->read();

        $servico = $this->Servico->read(null, $id);

        $tiposervicos = $this->Servico->Tiposervico->find('list', array(
            'fields' => array('id', 'descricao'),
            'order' => array('descricao' => 'asc')
        ));
        $this->set('tiposervicos', $tiposervicos);

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Servico->save($this->request->data)) {
                $this->Session->setFlash('Serviço alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi alterado. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
            $this->request->data = $this->Servico->read(null, $id);
        }
    }

    /**
     * delete method
     */
    public function delete($id = null) {

        $this->Tiposervico->id = $id;
        if (!$this->Tiposervico->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->Tiposervico->delete()) {
            $this->Session->setFlash('Tipo de serviço deletado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Registro não foi deletado.', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * Funções ajax
     */
    public function buscaServicos($chave) {
        $this->layout = 'ajax';

        $servicos = $this->Servico->find('list', array('order' => 'descricao ASC', 'fields' => array('id', 'descricao'), 'conditions' => array('tiposervico_id' => $this->request->data['Fornecedorservico']['tiposervico_id'])));

        $this->set('servicos', $servicos);
    }

}

?>
