<?php
class Oschadpay_OschadpayOnPage_CheckoutController extends Mage_Core_Controller_Front_Action {

    protected function _expireAjax() {
        if (!Mage::getSingleton('OschadpayOnPage/session')->getQuote()->hasItems()) {
            $this->getResponse()->setHeader('HTTP/1.1','403 Session Expired');
            exit;
        }
    }

    public function indexAction() {
        $this->loadLayout();
        $block = $this->getLayout()->createBlock('Mage_Core_Block_Template','oschadpay',array('template' => 'oschadpay/checkout.phtml'));
        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }

}

?>
