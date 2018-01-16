<?php

namespace PageObject\My\Profile;


use PageObject\PageObject;

class ProfileMenuPageObject extends PageObject
{
    const BILLING_TAB = './/div[@class="dropdown-menu"]//*[@href="/profile/billing"][text()="Billing"]';

    public static function clickOnBillingTab(){
        self::findElementAndClick(self::BILLING_TAB);
    }

}