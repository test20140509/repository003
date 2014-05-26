<?php
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 *
 * @property Post $Post
 */
class PostsController extends AppController {

	/**
	 * @var unknown
	 */
	public $components = array('Search.Prg' => array(
		'commonProcess' => array(
			'paramType' => 'querystring',
		)
	));

	/**
	 * @var unknown
	 */
	public $presetVars = array(
		'author_id' => array('type' => 'checkbox', 'empty' => true),
		'keyword' => array('type' => 'value', 'empty' => true),
		'andor' => array('type' => 'value', 'empty' => true),
		'from' => array('type' => 'value', 'empty' => true),
		'to' => array('type' => 'value', 'empty' => true),
	);

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Post->recursive = 0;
		$authors = $this->Post->Author->find('list');
		$this->set(compact('authors'));

		$this->Prg->commonProcess();
		$req = $this->request->query;
		if (!empty($this->request->query['keyword'])) {
			$andor = !empty($this->request->query['andor']) ? $this->request->query['andor'] : null;
			$word = $this->Post->multipleKeywords($this->request->query['keyword'], $andor);
			$req = array_merge($req, array("word" => $word));
		}
		$this->paginate = array(
			'conditions' => $this->Post->parseCriteria($req),
			'paramType' => 'querystring',
		);
		$this->set('posts', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @throws NotFoundException
 * @return void
 */
	public function view($id = null) {
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid %s', __('post')));
		}
		$this->set('post', $this->Post->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Post->create();
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('post')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('post')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
		$authors = $this->Post->Author->find('list');
		$this->set(compact('authors'));
	}

/**
 * edit method
 *
 * @param string $id
 * @throws NotFoundException
 * @return void
 */
	public function edit($id = null) {
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid %s', __('post')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('post')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('post')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->Post->read(null, $id);
		}
		$authors = $this->Post->Author->find('list');
		$this->set(compact('authors'));
	}

/**
 * delete method
 *
 * @param string $id
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid %s', __('post')));
		}
		if ($this->Post->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('post')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('post')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}