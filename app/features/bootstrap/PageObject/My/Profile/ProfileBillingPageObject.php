<?php
/**
 * Created by PhpStorm.
 * User: meldon
 * Date: 12.1.18
 * Time: 15.54
 */

namespace PageObject\My\Profile;


use Assert\Assert;
use PageObject\PageObject;

class ProfileBillingPageObject extends PageObject
{
    const PATH_REGEX = '/\/profile\/billing$/';
    const BANK_ADD_BUTTON = './/button[@class="add_billing"][text()=" Add Bank"]';
    const BANK_NAME_INPUT = './/input[@id="bank_name"]';
    const BANK_SWIFT_CODE_INPUT = './/input[@id="bank_swiftCode"]';
    const BANK_COUNTRY_SELECT = './/select[@id="bank_countryAlpha3"]';
    const BANK_COUNTRY_OPTION = './/select[@id="bank_countryAlpha3"]//option[text()="VALUE"]';
    const BANK_CITY_INPUT = './/input[@id="bank_city"]';
    const BANK_ADDRESS_INPUT = './/input[@id="bank_address"]';
    const BANK_ACCOUNT_NUMBER_INPUT = './/input[@id="bank_accountNumber"]';
    const BANK_IBAN_INPUT = './/input[@id="bank_iban"]';
    const BANK_BENEFICIARY_FULL_NAME_INPUT = './/input[@id="bank_beneficiary"]';

    const BANK_ITEMS_IN_BLOCK = './/div[./*[text()="Your Banks"]]//div[@class="billing_block"]';
    const BANK_SAVE_BUTTON = './/*[@id="bank_submit"]';
    const BANK_BILLING_BLOCK_BANK_NAME = './/div[@class="billing_block"]/div[contains(@class,"title")]/span[text()="VALUE"]';
    const BANK_BILLING_BLOCK_SWIFT_CODE = './/div[@class="billing_block"][./div[contains(@class,"title")]/span[text()="BANK_NAME"]]//tbody/tr[td[text()="Swift code"] and td[text()="VALUE"]]';
    const BANK_BILLING_BLOCK_BANK_COUNTRY = './/div[@class="billing_block"][./div[contains(@class,"title")]/span[text()="BANK_NAME"]]//tbody/tr[td[text()="Bank country"] and td[text()="VALUE"]]';
    const BANK_BILLING_BLOCK_BANK_CITY = './/div[@class="billing_block"][./div[contains(@class,"title")]/span[text()="BANK_NAME"]]//tbody/tr[td[text()="Bank city"] and td[text()="VALUE"]]';
    const BANK_BILLING_BLOCK_BANK_ADDRESS = './/div[@class="billing_block"][./div[contains(@class,"title")]/span[text()="BANK_NAME"]]//tbody/tr[td[text()="Bank address"] and td[text()="VALUE"]]';
    const BANK_BILLING_BLOCK_ACCOUNT_NUMBER = './/div[@class="billing_block"][./div[contains(@class,"title")]/span[text()="BANK_NAME"]]//tbody/tr[td[text()="Account number"] and td[text()="VALUE"]]';
    const BANK_BILLING_BLOCK_IBAN = './/div[@class="billing_block"][./div[contains(@class,"title")]/span[text()="BANK_NAME"]]//tbody/tr[td[text()="IBAN"] and td[text()="VALUE"]]';
    const BANK_BILLING_BLOCK_BENEFICIARY_FULL_NAME = './/div[@class="billing_block"][./div[contains(@class,"title")]/span[text()="BANK_NAME"]]//tbody/tr[td[text()="Beneficiary Full name"] and td[text()="VALUE"]]';

    const BANK_BILLING_BLOCK_WAITING_FOR_VERIFICATION = './/div[@class="billing_block"][./div[contains(@class,"title")]/span[text()="VALUE"]]//span[text()="Waiting for verification"]';
    const CARD_ADD_BUTTON = './/button[./text()=" Add new Credit Card"]';
    const CARD_TYPE_SELECT = './/select[@id="card_type"]';
    const CARD_TYPE_OPTION = './/select[@id="card_type"]//option[text()="VALUE"]';
    const CARD_HOLDER_NAME_INPUT = './/input[@id="card_holder"]';
    const CARD_NUMBER_INPUT = './/input[@id="card_number"]';
    const CARD_EXPIRATION_DATE_MONTH_SELECT = './/select[@id="card_expire_month"]';
    const CARD_EXPIRATION_DATE_MONTH_OPTION = './/select[@id="card_expire_month"]//option[text()="VALUE"]';
    const CARD_EXPIRATION_DATE_YEAR_SELECT = './/select[@id="card_expire_year"]';
    const CARD_EXPIRATION_DATE_YEAR_OPTION = './/select[@id="card_expire_year"]//option[text()="20VALUE"]';
    const CARD_CVV_NUMBER_INPUT = './/input[@id="card_cvv"]';
    const CARD_FRONT_COVER_FILE_INPUT = './/input[@id="card_front"]';
    const CARD_BACK_COVER_FILE_INPUT = './/input[@id="card_back"]';

    const CARD_SAVE_AND_VERIFY_BUTTON = './/*[@id="card_submit"]';
    const CARD_ITEMS_IN_BLOCK = './/div[./*[text()="Your Credit Cards"]]//div[@class="billing_block"]';
    const CARD_BILLING_BLOCK_CARD_WAITING_FOR_VERIFICATION_STATUS = './/div[@class="billing_block"]/div[contains(@class,"title")]/span[contains(text(),"VALUE")]';
    const CARD_BILLING_BLOCK_TYPE = './/div[@class="billing_block"][./div[contains(@class,"title")]/span[contains(text(),"BANK_NAME")]]//tbody/tr[td[text()="Type"] and td[text()="VALUE"]]';
    const CARD_BILLING_BLOCK_CARD_HOLDER_NAME = './/div[@class="billing_block"][./div[contains(@class,"title")]/span[contains(text(),"BANK_NAME")]]//tbody/tr[td[text()="Card holder name (As shown on the card)"] and td[text()="VALUE"]]';
    const CARD_BILLING_BLOCK_NUMBER = './/div[@class="billing_block"][./div[contains(@class,"title")]/span[contains(text(),"BANK_NAME")]]//tbody/tr[td[text()="Number"] and td[text()="VALUE"]]';
    const CARD_BILLING_BLOCK_EXPIRATION_DATE = './/div[@class="billing_block"][./div[contains(@class,"title")]/span[contains(text(),"BANK_NAME")]]//tbody/tr[td[text()="Expiration date"] and td[text()="VALUE"]]';
    const CARD_BILLING_BLOCK_RELATED_EMAIL = './/div[@class="billing_block"][./div[contains(@class,"title")]/span[contains(text(),"BANK_NAME")]]//tbody/tr[td[text()="Related email"] and td[text()="VALUE"]]';
    const CARD_BILLING_BLOCK_FRONT_COVER_LINK_FILE = './/div[@class="billing_block"][./div[contains(@class,"title")]/span[contains(text(),"BANK_NAME")]]//tbody/tr[td[text()="Front cover"]]//a';
    const CARD_BILLING_BLOCK_BACK_COVER_LINK_FILE = './/div[@class="billing_block"][./div[contains(@class,"title")]/span[contains(text(),"BANK_NAME")]]//tbody/tr[td[text()="Back cover"]]//a';

    public static function checkOnPage()
    {
        self::checkPathByRegex(self::PATH_REGEX);
    }

    public static function clickOnBankAddButton()
    {
        self::findElementAndClick(self::BANK_ADD_BUTTON);
    }

    public static function sendKeysInBankNameInput($value)
    {
        self::findElementAndSendKey(self::BANK_NAME_INPUT, $value);
    }


    public static function sendKeysInBankSwiftCodeInput($value)
    {
        self::findElementAndSendKey(self::BANK_SWIFT_CODE_INPUT, $value);
    }


    public static function clickOnBankCountrySelect()
    {
        self::findElementAndClick(self::BANK_COUNTRY_SELECT);
    }

    public static function clickOnBankCountryOption($value)
    {
        $xpath = str_replace('VALUE', $value, self::BANK_COUNTRY_OPTION);
        self::findElementAndClick($xpath);
    }

    public static function sendKeysInBankCityInput($value)
    {
        self::findElementAndSendKey(self::BANK_CITY_INPUT, $value);
    }


    public static function sendKeysInBankAddressInput($value)
    {
        self::findElementAndSendKey(self::BANK_ADDRESS_INPUT, $value);
    }


    public static function sendKeysInBankAccountNumberInput($value)
    {
        self::findElementAndSendKey(self::BANK_ACCOUNT_NUMBER_INPUT, $value);
    }

    public static function sendKeysInBankIbanInput($value)
    {
        self::findElementAndSendKey(self::BANK_IBAN_INPUT, $value);
    }


    public static function sendKeysInBankBeneficiaryFullNameInput($value)
    {
        self::findElementAndSendKey(self::BANK_BENEFICIARY_FULL_NAME_INPUT, $value);
    }

    public static function clickOnBankSaveButton()
    {
        self::findElementAndClick(self::BANK_SAVE_BUTTON);
    }

    public static function clickOnCardAddButton()
    {
        self::findElementAndClick(self::CARD_ADD_BUTTON);
    }

    public static function clickOnCardTypeSelect()
    {
        self::findElementAndClick(self::CARD_TYPE_SELECT);
    }

    public static function clickOnCardTypeOption($value)
    {
        $xpath = str_replace('VALUE', $value, self::CARD_TYPE_OPTION);
        self::findElementAndClick($xpath);
    }

    public static function sendKeysInCardHolderNameInput($value)
    {
        self::findElementAndSendKey(self::CARD_HOLDER_NAME_INPUT, $value);
    }

    public static function sendKeysInCardNumberInput($value)
    {
        self::findElementAndSendKey(self::CARD_NUMBER_INPUT, $value);
    }

    public static function clickOnCardExpirationDateMonthSelect()
    {
        self::findElementAndClick(self::CARD_EXPIRATION_DATE_MONTH_SELECT);
    }

    public static function clickOnCardExpirationDateMonthOption($value)
    {
        $xpath = str_replace('VALUE', $value, self::CARD_EXPIRATION_DATE_MONTH_OPTION);
        self::findElementAndClick($xpath);
    }

    public static function clickOnCardExpirationDateYearSelect()
    {
        self::findElementAndClick(self::CARD_EXPIRATION_DATE_YEAR_SELECT);
    }

    public static function clickOnCardExpirationDateYearOption($value)
    {
        $xpath = str_replace('VALUE', $value, self::CARD_EXPIRATION_DATE_YEAR_OPTION);
        self::findElementAndClick($xpath);
    }

    public static function sendKeysInCardCvvNumberInput($value)
    {
        self::findElementAndSendKey(self::CARD_CVV_NUMBER_INPUT, $value);
    }

    public static function sendKeysInFrontCoverFileInput($value)
    {
        $value = self::FILES_PATH . $value;
        self::findElementAndSendFile(self::CARD_FRONT_COVER_FILE_INPUT, $value);
    }

    public static function sendKeysInBackCoverFileInput($value)
    {
        $value = self::FILES_PATH . $value;
        self::findElementAndSendFile(self::CARD_BACK_COVER_FILE_INPUT, $value);
    }

    public static function clickOnSaveAndVerifyButton()
    {
        self::findElementAndClick(self::CARD_SAVE_AND_VERIFY_BUTTON);
    }

    public static function checkBankNameInYourBanksBlock($bankName)
    {
        $xpath = str_replace('VALUE', $bankName, self::BANK_BILLING_BLOCK_BANK_NAME);
        self::findElement($xpath, false);
    }

    public static function checkSwiftCodeInYourBanksBlock($bankName, $value)
    {
        $xpath = str_replace('BANK_NAME', $bankName, self::BANK_BILLING_BLOCK_SWIFT_CODE);
        $xpath = str_replace('VALUE', $value, $xpath);
        self::findElement($xpath, false);
    }

    public static function checkBankCountryInYourBanksBlock($bankName, $value)
    {
        $xpath = str_replace('BANK_NAME', $bankName, self::BANK_BILLING_BLOCK_BANK_COUNTRY);
        $xpath = str_replace('VALUE', $value, $xpath);
        self::findElement($xpath, false);
    }

    public static function checkBankCityInYourBanksBlock($bankName, $value)
    {
        $xpath = str_replace('BANK_NAME', $bankName, self::BANK_BILLING_BLOCK_BANK_CITY);
        $xpath = str_replace('VALUE', $value, $xpath);
        self::findElement($xpath, false);
    }

    public static function checkBankAddressInYourBanksBlock($bankName, $value)
    {
        $xpath = str_replace('BANK_NAME', $bankName, self::BANK_BILLING_BLOCK_BANK_ADDRESS);
        $xpath = str_replace('VALUE', $value, $xpath);
        self::findElement($xpath, false);
    }

    public static function checkAccountNumberInYourBanksBlock($bankName, $value)
    {
        $xpath = str_replace('BANK_NAME', $bankName, self::BANK_BILLING_BLOCK_ACCOUNT_NUMBER);
        $xpath = str_replace('VALUE', $value, $xpath);
        self::findElement($xpath, false);
    }

    public static function checkIBANInYourBanksBlock($bankName, $value)
    {
        $xpath = str_replace('BANK_NAME', $bankName, self::BANK_BILLING_BLOCK_IBAN);
        $xpath = str_replace('VALUE', $value, $xpath);
        self::findElement($xpath, false);
    }

    public static function checkBeneficiaryFullNameInYourBanksBlock($bankName, $value)
    {
        $xpath = str_replace('BANK_NAME', $bankName, self::BANK_BILLING_BLOCK_BENEFICIARY_FULL_NAME);
        $xpath = str_replace('VALUE', $value, $xpath);
        self::findElement($xpath, false);
    }

    public static function checkWatingForVerificationStatusBankInTourBanksBlock($bankName)
    {
        $xpath = str_replace('VALUE', $bankName, self::BANK_BILLING_BLOCK_WAITING_FOR_VERIFICATION);
        self::findElement($xpath, false);
    }

    public static function checkStatusWaitingForVerificationCardInCardBlock($shortCardNumber)
    {
        $xpath = str_replace('VALUE', $shortCardNumber, self::CARD_BILLING_BLOCK_CARD_WAITING_FOR_VERIFICATION_STATUS);
        self::findElement($xpath,false);
    }

    public static function checkTypeCardInCardBlock($shortCardNumber, $value)
    {
        $xpath = str_replace('BANK_NAME', $shortCardNumber, self::CARD_BILLING_BLOCK_TYPE);
        $xpath = str_replace('VALUE', $value, $xpath);
        self::findElement($xpath,false);
    }

    public static function checkCardHolderNameCardBlock($shortCardNumber, $value)
    {
        $xpath = str_replace('BANK_NAME', $shortCardNumber, self::CARD_BILLING_BLOCK_CARD_HOLDER_NAME);
        $xpath = str_replace('VALUE', $value, $xpath);
        self::findElement($xpath,false);
    }

    public static function checkNumberCardBlock($shortCardNumber, $value)
    {
        $xpath = str_replace('BANK_NAME', $shortCardNumber, self::CARD_BILLING_BLOCK_NUMBER);
        $xpath = str_replace('VALUE', $value, $xpath);
        self::findElement($xpath,false);
    }

    public static function checkExpirationDateCardBlock($shortCardNumber, $value)
    {
        $xpath = str_replace('BANK_NAME', $shortCardNumber, self::CARD_BILLING_BLOCK_EXPIRATION_DATE);
        $xpath = str_replace('VALUE', $value, $xpath);
        self::findElement($xpath,false);
    }


    public static function checkRelatedEmailCardBlock($shortCardNumber, $value)
    {
        $xpath = str_replace('BANK_NAME', $shortCardNumber, self::CARD_BILLING_BLOCK_RELATED_EMAIL);
        $xpath = str_replace('VALUE', $value, $xpath);
        self::findElement($xpath,false);
    }

    public static function checkFrontCoverFileCardBlock($shortCardNumber, $value)
    {
        $xpath = str_replace('BANK_NAME', $shortCardNumber, self::CARD_BILLING_BLOCK_FRONT_COVER_LINK_FILE);
        $xpath = str_replace('VALUE', $value, $xpath);
        $href = self::findElement($xpath,false)->getAttribute('href');
        $md5DownloadFile = md5($fileString = self::downloadByUrl($href));
        $md5CheckFile = md5(file_get_contents($value = self::FILES_PATH . $value));
        Assert::that($md5DownloadFile)->eq($md5CheckFile);
    }

    public static function checkBackCoverFileCardBlock($shortCardNumber, $value)
    {
        $xpath = str_replace('BANK_NAME', $shortCardNumber, self::CARD_BILLING_BLOCK_BACK_COVER_LINK_FILE);
        $xpath = str_replace('VALUE', $value, $xpath);
        $href = self::findElement($xpath,false)->getAttribute('href');
        $md5DownloadFile = md5($fileString = self::downloadByUrl($href));
        $md5CheckFile = md5(file_get_contents($value = self::FILES_PATH . $value));
        Assert::that($md5DownloadFile)->eq($md5CheckFile);

    }

    public static function checkNumberCardsInBlockYourCreditCards($checkNumber){
        $elements = self::findElements(self::CARD_ITEMS_IN_BLOCK);
        Assert::that($checkNumber)->eq(count($elements));
    }

    public static function checkNumberBanksInBlockYourBanks($checkNumber){
        $elements = self::findElements(self::BANK_ITEMS_IN_BLOCK);
        Assert::that($checkNumber)->eq(count($elements));
    }
}