<?php

declare(strict_types=1);

/**
* Digit Software Solutions.
*
* NOTICE OF LICENSE
*
* This source file is subject to the EULA
* that is bundled with this package in the file LICENSE.txt.
*
* @category  Dss
* @package   Dss_CheckoutValidation
* @author    Extension Team
* @copyright Copyright (c) 2024 Digit Software Solutions. ( https://digitsoftsol.com )
*/

namespace Dss\CheckoutValidation\Plugin\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessor;

class LayoutProcessorPlugin
{
    /**
     * After process plugin to add custom validation rules to the checkout address fields.
     *
     * @param LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        LayoutProcessor $subject,
        array $jsLayout
    ): array {
        if (isset($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children']['shipping-address-fieldset']['children'])
        ) {
            $shippingFields = &$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
            ['children']['shippingAddress']['children']['shipping-address-fieldset']['children'];
            $this->extendAddressFields($shippingFields);
        }

        if (isset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']['payments-list']['children'])
        ) {
            foreach ($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']['payments-list']['children'] as $key => &$payment) {
                if (isset($payment['children']['form-fields']['children'])) {
                    $billingFields = &$payment['children']['form-fields']['children'];
                    $this->extendAddressFields($billingFields);
                }
            }
        }

        if (isset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']['afterMethods']['children']['billing-address-form']['children']['form-fields']
            ['children'])
        ) {
            $billingFields = &$jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
            ['children']['payment']['children']['afterMethods']['children']['billing-address-form']['children']
            ['form-fields']['children'];
            $this->extendAddressFields($billingFields);
        }

        return $jsLayout;
    }

    /**
     * Extend the address fields with custom validation.
     *
     * @param array $fields
     */
    protected function extendAddressFields(array &$fields)
    {
        if (isset($fields['firstname'])) {
            $fields['firstname']['validation']['validate-alpha'] = true;
        }

        if (isset($fields['lastname'])) {
            $fields['lastname']['validation']['validate-alpha'] = true;
        }

        if (isset($fields['company'])) {
            $fields['company']['validation']['validate-alpha'] = true;
        }

        if (isset($fields['city'])) {
            $fields['city']['validation']['validate-alpha'] = true;
        }

        if (isset($fields['postcode'])) {
            $fields['postcode']['validation']['validate-alpha'] = true;
        }

        if (isset($fields['telephone'])) {
            $fields['telephone']['validation']['validate-alpha'] = true;
        }
    }
}
