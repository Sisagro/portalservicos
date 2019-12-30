<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

/**
 * Tipo de serviços Controller
 */
class TiposervicosController extends AppController {

    function beforeFilter() {
        $this->set('title_for_layout', 'Tipos de serviço');
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
        $this->Tiposervico->recursive = 0;
        $this->Paginator->settings = array(
            'order' => array('descricao' => 'asc')
        );
        $this->set('tiposervicos', $this->Paginator->paginate('Tiposervico'));
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
            $this->Tiposervico->create();
            if ($this->Tiposervico->save($this->request->data)) {
                $this->Session->setFlash('Tipo de serviço adicionado com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
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

        $this->Tiposervico->id = $id;
        if (!$this->Tiposervico->exists($id)) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $dadosUser = $this->Session->read();

        $tiposervico = $this->Tiposervico->read(null, $id);

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Tiposervico->save($this->request->data)) {
                $this->Session->setFlash('Tipo de serviço alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi alterado. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
            $this->request->data = $this->Tiposervico->read(null, $id);
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

}

?>
