<?php


use Assert\Assert;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use PageObject\Crm\Clients\ClientsPageObject;
use PageObject\Crm\LoginPageObject;
use PageObject\My\LoginPageObject as MyLoginPageObject;
use PageObject\Crm\Users\UserDocumentsAddNewPoiPageObject;
use PageObject\Crm\Users\UserDocumentsAddNewPopPageObject;
use PageObject\Crm\Users\UserDocumentsAddNewPorPageObject;
use PageObject\Crm\Users\UserDocumentsPageObject;
use PageObject\Crm\Users\UserDocumentsTabPageObject;
use PageObject\Crm\Users\UserOverviewPageObject;
use PageObject\Crm\Users\UserPageObject;
use PageObject\Crm\Users\UserProfilePageObject;
use PageObject\My\Profile\ProfileEditPageObject;

class FeatureContext implements Context
{
    /**
     * @var RemoteWebDriver $webDriver
     */
    private static $webDriver;
    private static $crmUrl = 'https://staging.crm.ifa-fx.com';
    private static $myUrl = 'https://staging.my.ifa-fx.com';
    private static $username = null;
    private static $password = null;
    private static $dataSave = [];
    private static $prefix = [];


    public static function runChrome()
    {
        $range = 0;
        while (true) {
            $range++;
            if ($range > 10) {
                break;
            }
            sleep(3);
            try {
                $capabilities = DesiredCapabilities::chrome();
                self::$webDriver = RemoteWebDriver::create("hub:4444/wd/hub", $capabilities, 90 * 1000, 900 * 1000);
                self::$webDriver->manage()->window();
                self::$webDriver->manage()->window()->maximize();
            } catch (\Exception $e) {
                print $e->getMessage() . PHP_EOL;
            }
            if (self::$webDriver == null) {
                continue;
            }
            break;
        }
    }

    /**
     * @return RemoteWebDriver
     */
    public static function getWebDriver()
    {
        return self::$webDriver;
    }

    public static function getSiteUrl()
    {
        return self::$crmUrl;
    }

    /**
     * @BeforeScenario
     * @param BeforeScenarioScope $scope
     */
    public function BeforeScenario(BeforeScenarioScope $scope)
    {
        self::runChrome();
    }

    /**
     * @AfterScenario
     * @param AfterScenarioScope $scope
     */
    public function AfterScenario(AfterScenarioScope $scope)
    {
        file_put_contents("gen.png", self::$webDriver->takeScreenshot());
        file_put_contents("gen.html", self::$webDriver->getPageSource());
        self::$webDriver->quit();
    }


    /**
     * @Given /^Generate\/Update prefix for "([^"]*)"$/
     */
    public function generateUpdatePrefixFor($arg1)
    {
        self::$prefix[$arg1] = self::generateString(4);
    }

    private static function generateString($numAlpha = 6)
    {
        $listAlpha = 'abcdefghijklmnopqrstuvwxyz';
        return str_shuffle(
            substr(str_shuffle($listAlpha), 0, $numAlpha)
        );
    }

    /**
     * @Given /^Create user by API == API ==$/
     */
    public function createUserByAPIAPI()
    {
        self::$username = 'admin_ifa_fx@site.com';
        self::$password = '12345678';
    }


    /**
     * @Given /^Sleep "([^"]*)"$/
     */
    public function sleepStep($arg1)
    {
        sleep($arg1);
    }

    /**
     * @Given /^Exception "([^"]*)"$/
     */
    public function exceptionStep($arg1)
    {
        throw new \Exception('Exception step');
    }

    /**
     * @Given /^Open Login page == CRM path: \/login ==$/
     */
    public function openLoginPagePathLogin()
    {
        LoginPageObject::openUrlLoginPage(self::$crmUrl);
    }

    /**
     * @Given /^Check is this Login page == CRM path: \/login ==$/
     */
    public function checkIsThisLoginPagePathLogin()
    {
        LoginPageObject::checkOnLoginPage();
    }

    /**
     * @Given /^Send keys in Username input create username api data == CRM path: \/login ==$/
     */
    public function sendKeysInUsernameInputCreateUsernameApiDataPathLogin()
    {
        LoginPageObject::sendKeysInUsernameInput(self::$username);
    }

    /**
     * @Given /^Send keys in Password input create password api data== CRM path: \/login ==$/
     */
    public function sendKeysInPasswordInputCreatePasswordApiDataPathLogin()
    {
        LoginPageObject::sendKeysInPasswordInput(self::$password);
    }

    /**
     * @Given /^Click on Login button == CRM path: \/login ==$/
     */
    public function clickOnLoginButtonPathLogin()
    {
        LoginPageObject::clickOnLoginButton();
    }

    /**
     * @Given /^Check is this Clients page == CRM path: \/clients ==$/
     */
    public function checkIsThisClientsPagePathClients()
    {
        ClientsPageObject::checkOnPage();
    }

    /**
     * @Given /^Click on email "([^"]*)" in clients table == CRM path: \/clients ==$/
     */
    public function clickOnEmailInClientsTablePathClients($arg1)
    {
        if (!is_null(self::$prefix['client_email'])) {
            $arg1 = self::$prefix['client_email'] . $arg1;
        }
        ClientsPageObject::clickOnEmailUserInTable($arg1);
    }

    /**
     * @Given /^Check on Overview Client Page == CRM path: \/clients ==$/
     */
    public function checkOnOverviewClientPagePathClients()
    {
        UserOverviewPageObject::checkOnPage();
    }

    /**
     * @Given /^Check that Login credentials contains Default email "([^"]*)" == CRM path: users\/\{id\}\/overview ==$/
     */
    public function checkThatLoginCredentialsContainsDefaultEmailPathUsersIdOverview($arg1)
    {
        if (!is_null(self::$prefix['client_email'])) {
            $arg1 = self::$prefix['client_email'] . $arg1;
        }
        UserOverviewPageObject::checkLoginCredentialsDefaultEmail($arg1);
    }

    /**
     * @Given /^Check that Login credentials contains Default phone "([^"]*)" == CRM path: users\/\{id\}\/overview ==$/
     */
    public function checkThatLoginCredentialsContainsDefaultPhonePathUsersIdOverview($arg1)
    {
        UserOverviewPageObject::checkLoginCredentialsDefaultPhone($arg1);
    }

    /**
     * @Given /^Check that Personal info contains First name "([^"]*)" == CRM path: users\/\{id\}\/overview ==$/
     */
    public function checkThatPersonalInfoContainsFirstNamePathUsersIdOverview($arg1)
    {
        UserOverviewPageObject::checkPersonalInfoFirstName($arg1);
    }

    /**
     * @Given /^Check that Personal info contains Last name "([^"]*)" == CRM path: users\/\{id\}\/overview ==$/
     */
    public function checkThatPersonalInfoContainsLastNamePathUsersIdOverview($arg1)
    {
        UserOverviewPageObject::checkPersonalInfoLastName($arg1);
    }

    /**
     * @Given /^Check that Personal info contains Country "([^"]*)" == CRM path: users\/\{id\}\/overview ==$/
     */
    public function checkThatPersonalInfoContainsCountryPathUsersIdOverview($arg1)
    {
        UserOverviewPageObject::checkPersonalInfoCountry($arg1);
    }

    /**
     * @Given /^Check that Personal info contains Date of birth "([^"]*)" == CRM path: users\/\{id\}\/overview ==$/
     */
    public function checkThatPersonalInfoContainsDateOfBirthPathUsersIdOverview($arg1)
    {
        UserOverviewPageObject::checkPersonalInfoDateOfBirth($arg1);
    }

    /**
     * @Given /^Check that Personal info contains City\/Village "([^"]*)" == CRM path: users\/\{id\}\/overview ==$/
     */
    public function checkThatPersonalInfoContainsCityVillagePathUsersIdOverview($arg1)
    {
        UserOverviewPageObject::checkPersonalInfoCityVillage($arg1);
    }

    /**
     * @Given /^Check that Personal info contains Region\/District "([^"]*)" == CRM path: users\/\{id\}\/overview ==$/
     */
    public function checkThatPersonalInfoContainsRegionDistrictPathUsersIdOverview($arg1)
    {
        UserOverviewPageObject::checkPersonalInfoRegionDistrict($arg1);
    }

    /**
     * @Given /^Check that Name "([^"]*)" contains in left panel  == CRM path: users\/\{id\}\/... ==$/
     */
    public function checkThatNameContainsInLeftPanelPathUsersIdOverview($arg1)
    {
        UserPageObject::checkName($arg1);
    }

    /**
     * @Given /^Click on \[Add client\] button == CRM path: \/clients ==$/
     */
    public function clickOnAddClientButtonPathClients()
    {
        ClientsPageObject::clickOnAddClientButton();
    }

    /**
     * @Given /^Click on \[Add new client using email\] text in client registration popup == CRM path: \/clients ==$/
     */
    public function clickOnAddNewClientUsingEmailTextInClientRegistrationPopupPathClients()
    {
        ClientsPageObject::clickOnClientRegistrationPopupAddNewClientUsingEmailText();
    }

    /**
     * @Given /^Send keys "([^"]*)" in email input in client registration popup == CRM path: \/clients ==$/
     */
    public function sendKeysInEmailInputInClientRegistrationPopupPathClients($arg1)
    {
        if (!is_null(self::$prefix['client_email'])) {
            $arg1 = self::$prefix['client_email'] . $arg1;
        }
        ClientsPageObject::sendKeysInClientRegistrationPopupEmailInput($arg1);
    }

    /**
     * @Given /^Click on \[Submit\] button in client registration popup == CRM path: \/clients ==$/
     */
    public function clickOnSubmitButtonInClientRegistrationPopupPathClients()
    {
        ClientsPageObject::clickOnClientRegistrationPopupSubmitButton();
    }

    /**
     * @Given /^I show success label user create == CRM path: \/clients ==$/
     */
    public function iShowSuccessLabelUserCreatePathClients()
    {
        ClientsPageObject::checkPopupRegistrationSuccessLabel();
    }

    /**
     * @Given /^In success popup label contain email "([^"]*)" == CRM path: \/clients ==$/
     */
    public function inSuccessPopupLabelContainEmailPathClients($arg1)
    {
        if (!is_null(self::$prefix['client_email'])) {
            $arg1 = self::$prefix['client_email'] . $arg1;
        }
        ClientsPageObject::checkPopupRegistrationSuccessEmail($arg1);
    }

    /**
     * @Given /^In success popup label contain password == CRM path: \/clients ==$/
     */
    public function inSuccessPopupLabelContainPasswordPathClients()
    {
        ClientsPageObject::getPopupRegistrationSuccessPassword();
    }

    /**
     * @Given /^Save user "([^"]*)" password == CRM path: \/clients ==$/
     */
    public function saveUserPasswordPathClients($arg1)
    {
        if (!is_null(self::$prefix['client_email'])) {
            $arg1 = self::$prefix['client_email'] . $arg1;
        }
        $password = trim(str_replace('Password', '', ClientsPageObject::getPopupRegistrationSuccessPassword()));
        self::$dataSave['user_login_info'][$arg1] = $password;
    }

    /**
     * @Given /^Press \[Close button\] == CRM path: \/clients ==$/
     */
    public function pressCloseButtonPathClients()
    {
        ClientsPageObject::popupRegistrationSuccessClickCloseButton();
    }

    /**
     * @Given /^Refresh page$/
     */
    public function refreshPage()
    {
        self::getWebDriver()->navigate()->refresh();
    }

    /**
     * @Given /^Click on \[Profile\] button on left panel == CRM path: users\/\{id\}\/\.\.\.==$/
     */
    public function clickOnProfileButtonOnLeftPanelPathUsersId()
    {
        UserPageObject::clickOnProfileButton();
    }

    /**
     * @Given /^Check on Users profile page == CRM path: users\/\{id\}\/profile ==$/
     */
    public function checkOnUsersProfilePagePathUsersIdProfile()
    {
        UserProfilePageObject::checkOnPage();
    }

    /**
     * @Given /^Send keys "([^"]*)" in Name input == CRM path: users\/\{id\}\/profile ==$/
     */
    public function sendKeysInNameInputPathUsersIdProfile($arg1)
    {
        UserProfilePageObject::sendKeysInNameInput($arg1);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Last Name input == CRM path: users\/\{id\}\/profile ==$/
     */
    public function sendKeysInLastNameInputPathUsersIdProfile($arg1)
    {
        UserProfilePageObject::sendKeysInLastNameInput($arg1);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Address input == CRM path: users\/\{id\}\/profile ==$/
     */
    public function sendKeysInAddressInputPathUsersIdProfile($arg1)
    {
        UserProfilePageObject::sendKeysInAddressInput($arg1);
    }

    /**
     * @Given /^Send keys "([^"]*)" in City input == CRM path: users\/\{id\}\/profile ==$/
     */
    public function sendKeysInCityInputPathUsersIdProfile($arg1)
    {
        UserProfilePageObject::sendKeysInCityInput($arg1);
    }

    /**
     * @Given /^Click on Country select == CRM path: users/{id}/profile ==$/
     */
    public function clickOnCountrySelect()
    {
        UserProfilePageObject::clickOnCountrySelect();
    }

    /**
     * @Given /^Click on Country option "([^"]*)" == CRM path: users/{id}/profile ==$/
     */
    public function clickOnCountryOption($arg1)
    {
        UserProfilePageObject::clickOnCountryOption($arg1);
    }

    /**
     * @Given /^Click on B\-day day select == CRM path: users/{id}/profile ==$/
     */
    public function clickOnBDayDaySelect()
    {
        UserProfilePageObject::clickOnBdayDaySelect();
    }

    /**
     * @Given /^Click on B\-day day option "([^"]*)" == CRM path: users/{id}/profile ==$/
     */
    public function clickOnBDayDayOption($arg1)
    {
        UserProfilePageObject::clickOnBdayDayOption($arg1);
    }

    /**
     * @Given /^Click on B\-day month select == CRM path: users/{id}/profile ==$/
     */
    public function clickOnBDayMonthSelect()
    {
        UserProfilePageObject::clickOnBdayMonthSelect();
    }

    /**
     * @Given /^Click on B\-day month option "([^"]*)" == CRM path: users/{id}/profile ==$/
     */
    public function clickOnBDayMonthOption($arg1)
    {
        UserProfilePageObject::clickOnBdayMonthOption($arg1);
    }

    /**
     * @Given /^Click on B\-day year select == CRM path: users/{id}/profile ==$/
     */
    public function clickOnBDayYearSelect()
    {
        UserProfilePageObject::clickOnBdayYearSelect();
    }

    /**
     * @Given /^Click on B\-day year option "([^"]*)" == CRM path: users/{id}/profile ==$/
     */
    public function clickOnBDayYearOption($arg1)
    {
        UserProfilePageObject::clickOnBdayYearOption($arg1);
    }

    /**
     * @Given /^Click on \[Save\] button == CRM path: users/{id}/profile ==$/
     */
    public function clickOnSaveButton()
    {
        UserProfilePageObject::clickOnSaveButton();
    }

    /**
     * @Given /^Show save success label == CRM path: users/{id}/profile ==$/
     */
    public function showSaveSuccessLabel()
    {
        UserProfilePageObject::checkSuccessLabel();
    }

    /**
     * @Given /^Click on \[Overview\] button on left panel == CRM path: users\/\{id\}\/\.\.\.==$/
     */
    public function clickOnOverviewButtonOnLeftPanelPathUsersId()
    {
        UserPageObject::clickOnOverviewButton();
    }

    /**
     * @Given /^Click on \[Documents\] button on left panel == CRM path: users\/\{id\}\/\.\.\. ==$/
     */
    public function clickOnDocumentsButtonOnLeftPanelPathUsersId()
    {
        UserPageObject::clickOnDocumentsButton();
    }

    /**
     * @Given /^Check on Documents page == CRM path: users\/\{id\}\/documents ==$/
     */
    public function checkOnDocumentsPagePathUsersIdDocuments()
    {
        UserDocumentsPageObject::checkOnThePage();
    }

    /**
     * @Given /^Click on \[Add new POI\] tab == CRM path: users\/\{id\}\/documents\/\.\.\. ==$/
     */
    public function clickOnAddNewPOITabPathUsersIdDocuments()
    {
        UserDocumentsTabPageObject::clickOnAddNewPoiTab();
    }

    /**
     * @Given /^Check on Add new POI page == CRM path: users\/\{id\}\/documents\/create\-proof\-of\-identity ==$/
     */
    public function checkOnAddNewPOIPagePathUsersIdDocumentsCreateProofOfIdentity()
    {
        UserDocumentsAddNewPoiPageObject::checkOnPage();
    }

    /**
     * @Given /^Click on Subtype select == CRM path: users\/\{id\}\/documents\/create\-proof\-of\-identity ==$/
     */
    public function clickOnSubtypeSelectPathUsersIdDocumentsCreateProofOfIdentity()
    {
        UserDocumentsAddNewPoiPageObject::clickOnSubtypeSelect();
    }

    /**
     * @Given /^Click on Subtype option with value "([^"]*)" == CRM path: users\/\{id\}\/documents\/create\-proof\-of\-identity ==$/
     */
    public function clickOnSubtypeOptionWithValuePathUsersIdDocumentsCreateProofOfIdentity($arg1)
    {
        UserDocumentsAddNewPoiPageObject::clickOnSubtypeOption($arg1);
    }

    /**
     * @Given /^Send file in file input "([^"]*)" == CRM path: users\/\{id\}\/documents\/create\-proof\-of\-identity ==$/
     */
    public function sendFileInFileInputPathUsersIdDocumentsCreateProofOfIdentity($arg1)
    {
        UserDocumentsAddNewPoiPageObject::sendFileInInput($arg1);
    }

    /**
     * @Given /^Click on \[Save\] button == CRM path: users\/\{id\}\/documents\/create\-proof\-of\-identity ==$/
     */
    public function clickOnSaveButtonPathUsersIdDocumentsCreateProofOfIdentity()
    {
        UserDocumentsAddNewPoiPageObject::clickOnSaveButton();
    }

    /**
     * @Given /^Check in table "([^"]*)" line == CRM path: users\/\{id\}\/documents ==$/
     */
    public function checkInTableLinePathUsersIdDocuments($arg1)
    {
        UserDocumentsPageObject::checkNumberTableLine($arg1);
    }

    /**
     * @Given /^Check in table "([^"]*)" line with Type "([^"]*)" == CRM path: users\/\{id\}\/documents ==$/
     */
    public function checkInTableLineWithTypePathUsersIdDocuments($arg1, $arg2)
    {
        UserDocumentsPageObject::checkNumberTableLineByType($arg1, $arg2);
    }

    /**
     * @Given /^Click on \[Add new POR\] tab == CRM path: users\/\{id\}\/documents\/\.\.\. ==$/
     */
    public function clickOnAddNewPORTabPathUsersIdDocuments()
    {
        UserDocumentsTabPageObject::clickOnAddNewPorTab();
    }

    /**
     * @Given /^Check on Add new POR page == CRM path: users\/\{id\}\/documents\/create\-proof\-of\-residence ==$/
     */
    public function checkOnAddNewPORPagePathUsersIdDocumentsCreateProofOfResidence()
    {
        UserDocumentsAddNewPorPageObject::checkOnPage();
    }

    /**
     * @Given /^Click on Subtype select == CRM path: users\/\{id\}\/documents\/create\-proof\-of\-residence ==$/
     */
    public function clickOnSubtypeSelectPathUsersIdDocumentsCreateProofOfResidence()
    {
        UserDocumentsAddNewPorPageObject::clickOnSubtypeSelect();
    }

    /**
     * @Given /^Click on Subtype option with value "([^"]*)" == CRM path: users\/\{id\}\/documents\/create\-proof\-of\-residence ==$/
     */
    public function clickOnSubtypeOptionWithValuePathUsersIdDocumentsCreateProofOfResidence($arg1)
    {
        UserDocumentsAddNewPorPageObject::clickOnSubtypeOption($arg1);
    }

    /**
     * @Given /^Send file in file input "([^"]*)" == CRM path: users\/\{id\}\/documents\/create\-proof\-of\-residence ==$/
     */
    public function sendFileInFileInputPathUsersIdDocumentsCreateProofOfResidence($arg1)
    {
        UserDocumentsAddNewPorPageObject::sendFileInInput($arg1);
    }

    /**
     * @Given /^Click on \[Save\] button == CRM path: users\/\{id\}\/documents\/create\-proof\-of\-residence ==$/
     */
    public function clickOnSaveButtonPathUsersIdDocumentsCreateProofOfResidence()
    {
        UserDocumentsAddNewPorPageObject::clickOnSaveButton();
    }

    /**
     * @Given /^Click on \[Add new POP\] tab == CRM path: users\/\{id\}\/documents\/\.\.\. ==$/
     */
    public function clickOnAddNewPOPTabPathUsersIdDocuments()
    {
        UserDocumentsTabPageObject::clickOnAddNewPopTab();
    }

    /**
     * @Given /^Check on Add new POP page == CRM path: users\/\{id\}\/documents\/create\-proof\-of\-payment ==$/
     */
    public function checkOnAddNewPOPPagePathUsersIdDocumentsCreateProofOfPayment()
    {
        UserDocumentsAddNewPopPageObject::checkOnPage();
    }

    /**
     * @Given /^Click on Subtype select == CRM path: users\/\{id\}\/documents\/create\-proof\-of\-payment ==$/
     */
    public function clickOnSubtypeSelectPathUsersIdDocumentsCreateProofOfPayment()
    {
        UserDocumentsAddNewPopPageObject::clickOnSubtypeSelect();
    }

    /**
     * @Given /^Click on Subtype option with value "([^"]*)" == CRM path: users\/\{id\}\/documents\/create\-proof\-of\-payment ==$/
     */
    public function clickOnSubtypeOptionWithValuePathUsersIdDocumentsCreateProofOfPayment($arg1)
    {
        UserDocumentsAddNewPopPageObject::clickOnSubtypeOption($arg1);
    }

    /**
     * @Given /^Send file in file input "([^"]*)" == CRM path: users\/\{id\}\/documents\/create\-proof\-of\-payment ==$/
     */
    public function sendFileInFileInputPathUsersIdDocumentsCreateProofOfPayment($arg1)
    {
        UserDocumentsAddNewPopPageObject::sendFileInInput($arg1);
    }

    /**
     * @Given /^Click on \[Save\] button == CRM path: users\/\{id\}\/documents\/create\-proof\-of\-payment ==$/
     */
    public function clickOnSaveButtonPathUsersIdDocumentsCreateProofOfPayment()
    {
        UserDocumentsAddNewPopPageObject::clickOnSaveButton();
    }

    /**
     * @Given /^Open Login page == MY path: \/login ==$/
     */
    public function openLoginPageMYPathLogin()
    {
        MyLoginPageObject::openUrlLoginPage(self::$myUrl);
    }

    /**
     * @Given /^Check is this Login page == MY path: \/login ==$/
     */
    public function checkIsThisLoginPageMYPathLogin()
    {
        MyLoginPageObject::checkOnLoginPage();
    }


    /**
     * @Given /^Click on Login button == MY path: \/login ==$/
     */
    public function clickOnLoginButtonMYPathLogin()
    {
        MyLoginPageObject::clickOnLoginButton();
    }

    /**
     * @Given /^Send keys  "([^"]*)" in login input == MY path: \/login ==$/
     */
    public function checkIsThisLoginPageMYPathLogin1($arg1)
    {
        if (!is_null(self::$prefix['client_email'])) {
            $arg1 = self::$prefix['client_email'] . $arg1;
        }
        MyLoginPageObject::sendKeysInLoginInput($arg1);
    }

    /**
     * @Given /^Send keys in Password input save password "([^"]*)" user == MY path: \/login ==$/
     */
    public function sendKeysInPasswordInputSavePasswordUserMYPathLogin($arg1)
    {
        if (!is_null(self::$prefix['client_email'])) {
            $arg1 = self::$prefix['client_email'] . $arg1;
        }
        $password = self::$dataSave['user_login_info'][$arg1];
        MyLoginPageObject::sendKeysInPasswordInput($password);
    }

    /**
     * @Given /^Check on Profile edit page == MY path: \/profile\/edit =$/
     */
    public function checkOnProfileEditPageMYPathProfileEdit()
    {
        ProfileEditPageObject::checkOnPage();
    }

    /**
     * @Given /^Check that in the Name input value "([^"]*)" == MY path: \/profile\/edit ==$/
     */
    public function checkThatInTheNameInputValueMYPathProfileEdit($arg1)
    {
        Assert::that(ProfileEditPageObject::getNameInputValue())->eq($arg1);

    }

    /**
     * @Given /^Check that in the Surname input value "([^"]*)" == MY path: \/profile\/edit ==$/
     */
    public function checkThatInTheSurnameInputValueMYPathProfileEdit($arg1)
    {
        Assert::that(ProfileEditPageObject::getSurnameInputValue())->eq($arg1);
    }

    /**
     * @Given /^Check that in the City\/Town input value "([^"]*)" == MY path: \/profile\/edit ==$/
     */
    public function checkThatInTheCityTownInputValueMYPathProfileEdit($arg1)
    {
        Assert::that(ProfileEditPageObject::getCityInputValue())->eq($arg1);
    }

    /**
     * @Given /^Check that in the Address input value "([^"]*)" == MY path: \/profile\/edit ==$/
     */
    public function checkThatInTheAddressInputValueMYPathProfileEdit($arg1)
    {
        Assert::that(ProfileEditPageObject::getAddressInputValue())->eq($arg1);
    }

    /**
     * @Given /^Check that in the Day select value "([^"]*)" == MY path: \/profile\/edit ==$/
     */
    public function checkThatInTheDaySelectValueMYPathProfileEdit($arg1)
    {
        Assert::that(ProfileEditPageObject::getDateDaySelectedValue())->eq($arg1);
    }

    /**
     * @Given /^Check that in the Month select value "([^"]*)" == MY path: \/profile\/edit ==$/
     */
    public function checkThatInTheMonthSelectValueMYPathProfileEdit($arg1)
    {
        Assert::that(ProfileEditPageObject::getDateMonthSelectedValue())->eq($arg1);
    }

    /**
     * @Given /^Check that in the Year select value "([^"]*)" == MY path: \/profile\/edit ==$/
     */
    public function checkThatInTheYearSelectValueMYPathProfileEdit($arg1)
    {
        Assert::that(ProfileEditPageObject::getDateYearSelectedValue())->eq($arg1);
    }

    /**
     * @Given /^Check that in the Country select value "([^"]*)" == MY path: \/profile\/edit ==$/
     */
    public function checkThatInTheCountrySelectValueMYPathProfileEdit($arg1)
    {
        Assert::that(ProfileEditPageObject::getCountrySelectedValue())->eq($arg1);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Name input == MY path: \/profile\/edit =$/
     */
    public function sendKeysInNameInputMYPathProfileEdit($arg1)
    {
       ProfileEditPageObject::sendKeysInNameInput($arg1);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Surname input == MY path: \/profile\/edit =$/
     */
    public function sendKeysInLastNameInputMYPathProfileEdit($arg1)
    {
        ProfileEditPageObject::sendKeysInSurnameInput($arg1);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Address input == MY path: \/profile\/edit =$/
     */
    public function sendKeysInAddressInputMYPathProfileEdit($arg1)
    {
        ProfileEditPageObject::sendKeysInAddressInput($arg1);
    }

    /**
     * @Given /^Send keys "([^"]*)" in City input == MY path: \/profile\/edit =$/
     */
    public function sendKeysInCityInputMYPathProfileEdit($arg1)
    {
        ProfileEditPageObject::sendKeysInCityInput($arg1);
    }

    /**
     * @Given /^Click on Country select == MY path: \/profile\/edit =$/
     */
    public function clickOnCountrySelectMYPathProfileEdit()
    {
        ProfileEditPageObject::clickOnCountrySelect();
    }

    /**
     * @Given /^Click on Country option "([^"]*)" == MY path: \/profile\/edit =$/
     */
    public function clickOnCountryOptionMYPathProfileEdit($arg1)
    {
        ProfileEditPageObject::clickOnCountryOption($arg1);
    }

    /**
     * @Given /^Click on B\-day day select  == MY path: \/profile\/edit =$/
     */
    public function clickOnBDayDaySelectMYPathProfileEdit()
    {
        ProfileEditPageObject::clickOnBDaySelect();
    }

    /**
     * @Given /^Click on B\-day day option "([^"]*)"  == MY path: \/profile\/edit =$/
     */
    public function clickOnBDayDayOptionMYPathProfileEdit($arg1)
    {
        ProfileEditPageObject::clickOnBDayOption($arg1);
    }

    /**
     * @Given /^Click on B\-day month select == MY path: \/profile\/edit =$/
     */
    public function clickOnBDayMonthSelectMYPathProfileEdit()
    {
        ProfileEditPageObject::clickOnBMonthSelect();
    }

    /**
     * @Given /^Click on B\-day month option "([^"]*)"  == MY path: \/profile\/edit =$/
     */
    public function clickOnBDayMonthOptionMYPathProfileEdit($arg1)
    {
        ProfileEditPageObject::clickOnBMonthOption($arg1);
    }

    /**
     * @Given /^Click on B\-day year select == MY path: \/profile\/edit =$/
     */
    public function clickOnBDayYearSelectMYPathProfileEdit()
    {
        ProfileEditPageObject::clickOnBYearSelect();
    }

    /**
     * @Given /^Click on B\-day year option "([^"]*)" == MY path: \/profile\/edit =$/
     */
    public function clickOnBDayYearOptionMYPathProfileEdit($arg1)
    {
        ProfileEditPageObject::clickOnBYearOption($arg1);
    }

    /**
     * @Given /^Click on \[Update profile\] button == MY path: \/profile\/edit =$/
     */
    public function clickOnUpdateProfileButtonMYPathProfileEdit()
    {
        ProfileEditPageObject::clickOnUpdateProfileButton();
    }

}
