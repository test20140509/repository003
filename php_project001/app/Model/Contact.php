<?php
App::uses('AppModel', 'Model');
/**
 * Contact Model
 *
 */
class Contact extends AppModel {

	/**
	 * @var unknown
	 */
	public $useTable = false;

	/**
	 * @var unknown
	 */
	public $validate = array(
		'email' => array(
			array('rule' => 'email', 'message' => 'メールアドレスを正しく入力して下さい。')
		),
		'body' => array(
			array('rule' => 'notEmpty', 'message' => '本文が入力されていません。')
		)
	);
}