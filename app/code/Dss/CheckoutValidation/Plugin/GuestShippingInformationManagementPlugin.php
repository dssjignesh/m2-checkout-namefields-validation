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
use Magento\Checkout\Model\GuestShippingInformationManagement;
use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Framework\Exception\InputException;

class GuestShippingInformationManagementPlugin
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
     * Before save address information
     *
     * @param GuestShippingInformationManagement $subject
     * @param string $cartId
     * @param ShippingInformationInterface $addressInformation
     * @throws InputException
     */
    public function beforeSaveAddressInformation(
        GuestShippingInformationManagement $subject,
        $cartId,
        ShippingInformationInterface $addressInformation
    ) {
        $address = $addressInformation->getShippingAddress();
        $firstName = $address->getFirstname();
        $lastName = $address->getLastname();
        $company = $address->getCompany();
        $city = $address->getCity();
        $postcode = $address->getPostcode();
        $telephone = $address->getTelephone();

        $this->validator->validate($firstName, $lastName, $company, $city, $postcode, $telephone);
    }
}
