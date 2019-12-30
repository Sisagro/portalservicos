<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

/**
 * Licitacaos Controller
 */
class LicitacaosController extends AppController {

    function beforeFilter() {
        $this->set('title_for_layout', 'Licitações');
    }

    public function isAuthorized($user) {
        $Users = new UsersController;
        return parent::isAuthorized($user);
    }

    /**
     * index method
     */
    public function index() {

        CakeSession::write('dadosFormulario', '');

        $dadosUser = $this->Session->read();
        $this->Licitacao->recursive = 0;
        $this->Paginator->settings = array(
            'order' => array('descricao' => 'asc')
        );
        $this->set('licitacaos', $this->Paginator->paginate('Licitacao'));
    }

    /**
     * view method
     */
    public function view($id = null) {

        $this->loadModel('Tiposervico');

        $tiposervicos = $this->Tiposervico->find('list', array(
            'fields' => array('id', 'descricao'),
            'order' => array('descricao' => 'asc')
        ));
        $this->set('tiposervicos', $tiposervicos);

        $this->Licitacao->id = $id;
        if (!$this->Licitacao->exists($id)) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $dadosUser = $this->Session->read();

        $licitacao = $this->Licitacao->read(null, $id);

        $this->set('licitacao', $licitacao);
    }

    /**
     * add method
     */
    public function add() {

        $licitacao_id = '';
        $servicos = '';

        $dadosUser = $this->Session->read();
        $dadosFormulario = $this->Session->read('dadosFormulario');
        $this->set('dadosFormulario', $dadosFormulario);

        $this->loadModel('Tiposervico');

        $tiposervicos = $this->Tiposervico->find('list', array(
            'fields' => array('id', 'descricao'),
            'order' => array('descricao' => 'asc')
        ));
        $this->set('tiposervicos', $tiposervicos);

        if ($this->request->is('post')) {

            if ($this->request->data['Licitacao']['confirma'] == 'N') {

                foreach ($this->request->data['Licitacao']['servico_id'] as $item) :
                    if (empty($servicos_aux)) {
                        $servicos_aux = $item;
                    } else {
                        $servicos_aux .= ',' . $item;
                    }
                endforeach;

                $this->loadModel('Servico');

                $this->Servico->recursive = 0;

                $servicos = $this->Servico->find('all', array(
                    'fields' => array('Tiposervico.descricao', 'Servico.descricao'),
                    'conditions' => array('Servico.id IN ' . '(' . $servicos_aux . ')'),
                    'order' => array('Servico.descricao' => 'asc')
                ));

                $this->set('servicos', $servicos);

                $this->loadModel('Fornecedorservico');

                $this->Fornecedorservico->recursive = 0;

                $fornecedores_aux = $this->Fornecedorservico->find('all', array(
                    'fields' => array('DISTINCT Fornecedor.id', 'Fornecedor.nome', 'Fornecedor.sobrenome', 'Fornecedor.email', 'Fornecedor.cel'),
                    'conditions' => array('Fornecedorservico.servico_id IN ' . '(' . $servicos_aux . ')'),
                    'joins' => array(
                        array(
                            'table' => 'tiposervicos',
                            'alias' => 'Tiposervico',
                            'type' => 'INNER',
                            'conditions' => [
                                'Tiposervico.id = Servico.tiposervico_id',
                            ],
                        ),
                    ),
                    'order' => array('Fornecedor.nome' => 'asc')
                ));

                foreach ($fornecedores_aux as $key => $item) {
                    $fornecedores[$item['Fornecedor']['id'] . '|' . $item['Fornecedor']['email']] = $item['Fornecedor']['nome'] . ' ' . $item['Fornecedor']['sobrenome'] . ' / ' . '(' . substr($item['Fornecedor']['cel'], 0, 2) . ') ' . substr($item['Fornecedor']['cel'], 2, 5) . '.' . substr($item['Fornecedor']['cel'], 7, 4) . ' / ' . $item['Fornecedor']['email'];
                }
                $this->set('fornecedores', $fornecedores);

                CakeSession::write('dadosFormulario', $this->request->data);

                $this->render('addLicitacao');
            }
            if ($this->request->data['Licitacao']['confirma'] == 'S') {

                try {

                    $this->Licitacao->begin();

                    $this->request->data['Licitacao']['user_id'] = $dadosUser['Auth']['User']['id'];
                    $this->request->data['Licitacao']['descricao'] = $dadosFormulario['Licitacao']['descricao'];
                    $this->request->data['Licitacao']['observacao'] = $dadosFormulario['Licitacao']['observacao'];

                    $this->Licitacao->create();

                    if ($this->Licitacao->save($this->request->data)) {

                        $licitacao_id = $this->Licitacao->getLastInsertID();

                        //Grava os serviços
                        foreach ($dadosFormulario['Licitacao']['servico_id'] as $key => $item) :
                            $this->request->data['Licitacaoservico']['licitacao_id'] = $licitacao_id;
                            $this->request->data['Licitacaoservico']['servico_id'] = $item;
                            $this->Licitacao->Licitacaoservico->save($this->request->data['Licitacaoservico']);
                        endforeach;

                        //Grava os fornecedores
                        foreach ($this->request->data['Licitacao']['fornecedor_id'] as $key => $item) :
                            $fornec = explode('|', $item);
                            $this->request->data['Licitacaofornecedor']['licitacao_id'] = $licitacao_id;
                            $this->request->data['Licitacaofornecedor']['fornecedor_id'] = $fornec[0];
                            $this->Licitacao->Licitacaofornecedor->save($this->request->data['Licitacaofornecedor']);
                        endforeach;

                        $this->Licitacao->commit();

                        $this->Session->setFlash('Licitação n°: ' . $licitacao_id . ' envidada para os fornecedores com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
                    }
                } catch (Exception $licitacao_id) {
                    $this->Licitacao->rollback();
                    $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
                }
            }
        }
    }

    /**
     * licitacao_lancamento method
     */
    public function licitacao_lancamento_fornec($licitacao_id = null, $fornecedor_id = null) {

        $dadosUser = $this->Session->read();

        $licitacao = $this->Licitacao->read(null, $licitacao_id);

        debug($licitacao);

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Licitacao->save($this->request->data)) {
                $this->Session->setFlash('Obrigado, valor lançado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi alterado. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
            $this->request->data = $this->Licitacao->read(null, $licitacao_id);
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

        $this->Licitacao->id = $id;
        if (!$this->Licitacao->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->Licitacao->delete()) {
            $this->Session->setFlash('Licitação cancelada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Registro não foi deletado.', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }

}

?>
