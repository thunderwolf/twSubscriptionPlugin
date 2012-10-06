<?php

/**
 * esub_info actions.
 *
 * @package    subskrypcja
 * @subpackage esub_info
 * @author     Arkadiusz Tułodziecki
 */
class twSubscriptionInfoActions extends sfActions {
	public function preExecute() {
		sfConfig::set('tw_admin:default:module', 'tw_subscription');
		sfConfig::set('tw_admin:default:category', 'tw_subscription_info');
		sfConfig::set('tw_admin:default:nav', 'tabs');
		return parent::preExecute();
	}
	
	public function executeIndex($request) {
	}
	
	public function executeImport($request) {
		sfConfig::set('tw_admin:default:category', 'tw_subscription_import');
		$this->form = new twSubscriptionImportForm();
		if ($request->isMethod('post')) {
			$this->form->bind($request->getParameter('import'), $request->getFiles('import'));
			if ($this->form->isValid()) {
				//$values = $this->form->getValues();
				
				$this->list = twSubscriptionListPeer::retrieveByPk($this->form->getValue('list_id'));
				$this->forward404Unless($this->list);
				
				$file = $this->form->getValue('file');
				
				$filename = 'uploaded_' . sha1($file->getOriginalName());
				$extension = $file->getExtension($file->getOriginalExtension());
				$target = sfConfig::get('sf_upload_dir') . '/' . $filename . $file->getOriginalExtension();
				//				$file->save(sfConfig::get('sf_upload_dir').'/'.$filename.$extension);
				$file->save($target);
				
				$this->xls = new excelReader();
				$this->xls->read($target);
				
				$connection = Propel::getConnection();
				$query = 'DELETE FROM tw_subscription_email WHERE list_id = ' . $this->form->getValue('list_id');
				$statement = $connection->prepareStatement($query);
				$resultset = $statement->executeQuery();
				
				$c = new Criteria();
				$c->add(twSubscriptionStatusPeer::CODE, 'active');
				$active = twSubscriptionStatusPeer::doSelectOne($c);
				if (!($active instanceOf twSubscriptionStatus)) {
					throw new Exception('No status `active` in system');
				}
				
				$emails = 0;
				$created = array();
				for ($i = 2; $i <= $this->xls->sheets[0]['numRows']; $i++) {
					if (!empty($this->xls->sheets[0]['cells'][$i][2])) {
						$email = trim($this->xls->sheets[0]['cells'][$i][2]);
						if (preg_match('/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/i', $email) and !isset($created[$email])) {
							try {
								$tw_subscription_email = new twSubscriptionEmail();
								$tw_subscription_email->setListId($this->form->getValue('list_id'));
								$tw_subscription_email->setStatusId($active->getId());
								$tw_subscription_email->setRemail($email);
								if (!empty($this->xls->sheets[0]['cells'][$i][1])) {
									$tw_subscription_email->setRname(iconv('ISO-8859-2', 'UTF-8', $this->plXSL($this->xls->sheets[0]['cells'][$i][1])));
								}
								$tw_subscription_email->setExpires(null);
								$tw_subscription_email->setAuthKey(md5(microtime(true) . '.' . $i));
								$tw_subscription_email->setCreatedAt(date('Y-m-d H:i:s'));
								$tw_subscription_email->save();
							} catch (Exception $e) {
								continue;
							}
							$emails++;
							$created[$email] = true;
						}
					}
				}
				
				$this->getUser()->setFlash('notice', 'Dodano: ' . $emails . ' emaili do listy: ' . $this->list->getListname());
				
				$this->redirect('twSubscriptionList/list');
			}
		}
	}
	
	function plXSL($string) {
		$chArray = array(
			"\x42\x01" => "\xB3", "\x7b\x01" => "\xAF", "\x44\x01" => "\xF1", "\x41\x01" => "\xA3", "\x5b\x01" => "\xB6", "\x19\x01" => "\xEA",
			"\x05\x01" => "\xB1", "\x7c\x01" => "\xBF", "\x7a\x01" => "\xBC", "\x07\x01" => "\xE6", "\x44\x01" => "\xF1", "\x18\x01" => "\xCA",
			"\x04\x01" => "\xA1", "\x5a\x01" => "\xA6", "\x41\x01" => "\xA3", "\x7b\x01" => "\xAF", "\x79\x01" => "\xAC", "\x06\x01" => "\xC6",
			"\x43\x01" => "\xD1", "\x00" => ''
		);
		
		return strtr($string, $chArray);
	}
	
	public function executePytania($request) {
		sfConfig::set('tw_admin:default:category', 'tw_subscription_faq');
	}
}
