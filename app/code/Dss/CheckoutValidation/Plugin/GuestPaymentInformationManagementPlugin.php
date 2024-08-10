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

namespace Dss\CheckoutValidation\Plugin;

use Dss\CheckoutValidation\Validator\ShippingInformationValidator;
use Magento\Checkout\Model\GuestPaymentInformationManagement;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Framework\Exception\InputException;

class GuestPaymentInformationManagementPlugin
{
    /**
     * @var ShippingInformationValidator
     */
    protected $validator;

    /**
     * Constructor
     *
     * @param ShippingInformationValidator $validator
     */
    public function __construct(
        ShippingInformationValidator $validator
    ) {
        $this->validator = $validator;
    }

    /**
     * Before save payment information
     *
     * @param GuestPaymentInformationManagement $subject
     * @param string $cartId
     * @param string $email
     * @param PaymentInterface $paymentMethod
     * @param AddressInterface|null $billingAddress
     * @throws InputException
     */
    public function beforeSavePaymentInformation(
        GuestPaymentInformationManagement $subject,
        $cartId,
        $email,
        PaymentInterface $paymentMethod,
        AddressInterface $billingAddress = null
    ) {
        $firstName = $billingAddress->getFirstname();
        $lastName = $billingAddress->getLastname();
        $company = $billingAddress->getCompany();
        $city = $billingAddress->getCity();
        $postcode = $billingAddress->getPostcode();
        $telephone = $billingAddress->getTelephone();

        $this->validator->validate($firstName, $lastName, $company, $city, $postcode, $telephone);
    }
}
