<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Contacts Controller
 *
 * @property Contact $Contact
 * @property PaginatorComponent $Paginator
 */
class ContactsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		if ($this->request->is('post') || $this->request->is('pust')) {
			$this->Contact->set($this->request->data);
			if ($this->Contact->Validates()) {
				$vars = $this->request->data['Contact'];
				$email = new CakeEmail();
				$email->config('gmail')
				->from(array($this->request->data['Contact']['email'] => '○○お問い合わせ'))
				->to('test.20130312.164409@gmail.com')
				->viewVars($vars)
				->template('contact', 'contact')
				->subject('お問い合わせ')
				;
				if ($email->send()) {
					$this->Session->setFlash('問い合わせ完了');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('問い合わせに失敗しました。');
				}
			}
		}
	}
}