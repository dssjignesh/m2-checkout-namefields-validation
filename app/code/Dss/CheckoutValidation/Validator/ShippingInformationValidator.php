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

namespace Dss\CheckoutValidation\Validator;

use Magento\Framework\Exception\InputException;

class ShippingInformationValidator
{
    /**
     * Validate first name and last name fields
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $company
     * @param string $city
     * @param mixed $postcode
     * @param int $telephone
     * @throws bool
     */
    public function validate($firstName, $lastName, $company, $city, $postcode, $telephone)
    {
         $regex = '/[!#$@%{}[]&()?/>.<,\'"`;\|*^]/';

        if (preg_match($regex, $firstName) || preg_match($regex, $lastName) || preg_match($regex, $company) ||
            preg_match($regex, $city) || preg_match($regex, $postcode) || preg_match($regex, $telephone)
            ) {
            throw new InputException(__('Invalid characters in the first name or last name.'));
        }
    }
}
