<?php
class Oschadpay_OschadpayOnPage_ResponseController extends Mage_Core_Controller_Front_Action {
    
	public function indexAction() {

        $this->getResponse()
            ->setHeader('Content-type', 'text/html; charset=utf8')
            ->setBody($this->getLayout()
            ->createBlock('OschadpayOnPage/response')
            ->toHtml());
    }
}

?>
