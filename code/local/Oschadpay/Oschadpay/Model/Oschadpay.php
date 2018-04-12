<?php

class Oschadpay_Oschadpay_Model_Oschadpay extends Mage_Payment_Model_Method_Abstract
{

    protected $_code = 'Oschadpay';
    protected $_formBlockType = 'Oschadpay/form';

    public function getCheckout()
    {
        return Mage::getSingleton('checkout/session');
    }

    public function getOrderPlaceRedirectUrl()
    {
        return Mage::getUrl('Oschadpay/redirect', array('_secure' => true));
    }

    public function getQuote()
    {
        $orderIncrementId = $this->getCheckout()->getLastRealOrderId();
        $order = Mage::getModel('sales/order')->loadByIncrementId($orderIncrementId);
        return $order;
    }

    public function getFormFields()
    {
        $order_id = $this->getCheckout()->getLastRealOrderId();
        $order = Mage::getModel('sales/order')->loadByIncrementId($order_id);
        $amount = round($order->getGrandTotal() * 100, 2);

        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $checkout = Mage::getSingleton('checkout/session')->getCustomer();
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $email = $customer->getEmail();
        $email = isset($email) ? $email : $quote->getBillingAddress()->getEmail();
        $email = isset($email) ? $email : $order->getCustomerEmail();
		
        $fields = array(
            'order_id' => $order_id . OschadpayForm::ORDER_SEPARATOR . time(),
            'merchant_id' => $this->getConfigData('merchant'),
            'order_desc' => Mage::helper('sales')->__('Order #') . $order_id,
            'amount' => $amount,
            'currency' => $this->getConfigData('currency'),
            'server_callback_url' => $this->getConfigData('back_ref'),
            'response_url' => $this->getConfigData('back_ref'),
            'lang' => $this->getConfigData('language'),
            'sender_email' => $email
        );

        $fields['signature'] = OschadpayForm::getSignature($fields, $this->getConfigData('secret_key'));

        $params = array(
            'button' => $this->getButton(),
            'fields' => $fields,
        );
        return $params;
    }

    function getButton()
    {
        $button = "<div style='position:absolute; top:50%; left:50%; margin:-40px 0px 0px -60px; '>" .
            #"<div><img src='http://www.payu.ua/sites/default/files/logo-payu.png' width='120px' style='margin:5px 5px;'></div>".
            "</div>" .
            "<script type=\"text/javascript\">
            setTimeout( subform, 200 );
            function subform(){ document.getElementById('OschadpayForm').submit(); }
            </script>";

        return $button;
    }

}


