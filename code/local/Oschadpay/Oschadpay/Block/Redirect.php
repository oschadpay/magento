<?php
/*
 *
 * @category   Community
 * @package    Oschadpay_Oschadpay
 * @copyright  http://www.oschadbank.ua
 * @license    Open Software License (OSL 3.0)
 *
 */

/*
 * Oschadpay payment module
 *
 * @author     Oschadpay
 *
 */

class Oschadpay_Oschadpay_Block_Redirect extends Mage_Core_Block_Abstract
{
    protected function _toHtml()
    {
        include_once "Oschadpay.cls.php";
        $oplata = Mage::getModel('Oschadpay/Oschadpay');

        $data = $oplata->getFormFields();


        $state = $oplata->getConfigData('order_status');

        $order = $oplata->getQuote();
        $order->setStatus($state);
        $order->save();
		
        $html ='<form name="OschadpayForm" id="OschadpayForm" method="post" action="'.OschadpayForm::URL.'">';

        foreach ($data['fields'] as $fieldName => $field) {
            $html .= '<input type="hidden" name="'.$fieldName.'" value="'.$field.'">';
        }

        $html .= $data['button'];

        $html .= '</form>';

        return $html;
    }
}
