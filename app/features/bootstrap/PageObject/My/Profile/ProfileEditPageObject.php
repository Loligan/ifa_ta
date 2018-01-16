<?php

namespace PageObject\My\Profile;

use PageObject\PageObject;

class ProfileEditPageObject extends PageObject
{
    const PATH_REGEX = '/(\/profile\/edit$)/';
    const DATE_DAY_SELECT = './/select[@id="edit_birthDay"]';
    const DATE_DAY_OPTION = './/select[@id="edit_birthDay"]/option[text()="VALUE"]';

    const DATE_MONTH_SELECT = './/select[@id="edit_birthMonth"]';
    const DATE_MONTH_OPTION = './/select[@id="edit_birthMonth"]/option[text()="VALUE"]';

    const DATE_YEAR_SELECT = './/select[@id="edit_birthYear"]';
    const DATE_YEAR_OPTION = './/select[@id="edit_birthYear"]/option[text()="VALUE"]';

    const COUNTRY_SELECT = './/select[@id="edit_country"]';
    const COUNTRY_OPTION_INPUT = './/select[@id="edit_country"]/option[text()="VALUE"]';

    const NAME_INPUT = './/*[@id="edit_name"]';
    const SURNAME_INPUT = './/*[@id="edit_surname"]';
    const CITY_INPUT = './/*[@id="edit_city"]';
    const ADDRESS_INPUT = './/*[@id="edit_address"]';
    const UPDATE_PROFILE_BUTTON = './/*[@id="edit_submit"]';

    public static function checkOnPage()
    {
        self::checkPathByRegex(self::PATH_REGEX);
    }

    public static function getCountrySelectedValue(): string
    {
        return self::getTextSelectedOptions(self::COUNTRY_SELECT);
    }

    public static function getDateDaySelectedValue(): string
    {
        return self::getTextSelectedOptions(self::DATE_DAY_SELECT);
    }

    public static function getDateMonthSelectedValue(): string
    {
        return self::getTextSelectedOptions(self::DATE_MONTH_SELECT);
    }

    public static function getDateYearSelectedValue(): string
    {
        return self::getTextSelectedOptions(self::DATE_YEAR_SELECT);
    }

    public static function getNameInputValue(): string
    {
        return self::findElement(self::NAME_INPUT)->getAttribute('value');
    }

    public static function getSurnameInputValue(): string
    {
        return self::findElement(self::SURNAME_INPUT)->getAttribute('value');
    }

    public static function getCityInputValue(): string
    {
        return self::findElement(self::CITY_INPUT)->getAttribute('value');
    }

    public static function getAddressInputValue(): string
    {
        return self::findElement(self::ADDRESS_INPUT)->getAttribute('value');
    }

    public static function sendKeysInNameInput($value)
    {
        self::findElementAndSendKey(self::NAME_INPUT, $value);
    }

    public static function sendKeysInSurnameInput($value)
    {
        self::findElementAndSendKey(self::SURNAME_INPUT, $value);
    }

    public static function sendKeysInCityInput($value)
    {
        self::findElementAndSendKey(self::CITY_INPUT, $value);
    }

    public static function sendKeysInAddressInput($value)
    {
        self::findElementAndSendKey(self::ADDRESS_INPUT, $value);
    }

    public static function clickOnDateDaySelect()
    {
        self::findElementAndClick(self::DATE_DAY_SELECT);
    }

    public static function clikcOnDateDayOption($value)
    {
        $xpath = str_replace('VALUE', $value, self::DATE_DAY_OPTION);
        self::findElementAndClick($xpath);
    }

    public static function clickOnDateMonthSelect()
    {
        self::findElementAndClick(self::DATE_MONTH_SELECT);
    }

    public static function clikcOnDateMonthOption($value)
    {
        $xpath = str_replace('VALUE', $value, self::DATE_MONTH_OPTION);
        self::findElementAndClick($xpath);
    }

    public static function clickOnDateYearSelect()
    {
        self::findElementAndClick(self::DATE_YEAR_SELECT);
    }

    public static function clickOnDateYearOption($value)
    {
        $xpath = str_replace('VALUE', $value, self::DATE_YEAR_OPTION);
        self::findElementAndClick($xpath);
    }

    public static function clickOnCountrySelect(){
        self::findElementAndClick(self::COUNTRY_SELECT);
    }

    public static function clickOnCountryOption($value){
        $xpath = str_replace('VALUE',$value,self::COUNTRY_OPTION_INPUT);
        self::findElementAndClick($xpath);
    }

    public static function clickOnBDaySelect(){
        self::findElementAndClick(self::DATE_DAY_SELECT);
    }

    public static function clickOnBDayOption($value){
        $xpath = str_replace('VALUE',$value,self::DATE_DAY_OPTION);
        self::findElementAndClick($xpath);
    }

    public static function clickOnBMonthSelect(){
        self::findElementAndClick(self::DATE_MONTH_SELECT);
    }

    public static function clickOnBMonthOption($value){
        $xpath = str_replace('VALUE',$value,self::DATE_MONTH_OPTION);
        self::findElementAndClick($xpath);
    }

    public static function clickOnBYearSelect(){
        self::findElementAndClick(self::DATE_YEAR_SELECT);
    }

    public static function clickOnBYearOption($value){
        $xpath = str_replace('VALUE',$value,self::DATE_YEAR_OPTION);
        self::findElementAndClick($xpath);
    }

    public static function clickOnUpdateProfileButton(){
        self::findElementAndClick(self::UPDATE_PROFILE_BUTTON);
    }
}