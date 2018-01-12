<?php

namespace PageObject\Crm\Users;

use PageObject\PageObject;

class UserDocumentsAddNewPopPageObject extends PageObject
{
    const PATH_REGEX = '/(\/documents\/create-proof-of-payment$)/';
    const SUBTYPE_SELECT = './/select[@id="proof_of_payment_form_subtype"]';
    const SUBTYPE_OPTION = './/select[@id="proof_of_payment_form_subtype"]/option[text()="VALUE"]';
    const FILE_INPUT = './/*[@id="proof_of_payment_form_file"]';
    const SAVE_BUTTON = './/button[@type="submit"][normalize-space(text())="Save"]';

    public static function checkOnPage()
    {
        self::checkPathByRegex(self::PATH_REGEX);
    }

    public static function clickOnSubtypeSelect()
    {
        self::findElementAndClick(self::SUBTYPE_SELECT);
    }

    public static function clickOnSubtypeOption($value)
    {
        $xpath = str_replace('VALUE', $value, self::SUBTYPE_OPTION);
        self::findElementAndClick($xpath);
    }

    public static function sendFileInInput($filePath)
    {
        $filePath = self::FILES_PATH . $filePath;
        self::findElementAndSendFile(self::FILE_INPUT, $filePath);
    }

    public static function clickOnSaveButton()
    {
        self::findElementAndClick(self::SAVE_BUTTON);
    }
}