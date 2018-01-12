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

    /**
     * @BeforeScenario
     */
    public function BeforeScenario()
    {
        $capabilities = DesiredCapabilities::chrome();
        self::$webDriver = RemoteWebDriver::create("hub:4444/wd/hub", $capabilities, 90 * 1000, 900 * 1000);
        self::$webDriver->manage()->window();
        self::$webDriver->manage()->window()->maximize();

    }

    /**
     * @AfterScenario
     */
    public function AfterScenario()
    {
        file_put_contents("gen.png", self::$webDriver->takeScreenshot());
        file_put_contents("gen.html", self::$webDriver->getPageSource());
        self::$webDriver->quit();
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
    public function clickOnEmailInClientsTablePathClients($email)
    {
        if (!is_null(self::$prefix['client_email'])) {
            $email = self::$prefix['client_email'] . $email;
        }
        ClientsPageObject::clickOnEmailUserInTable($email);
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
    public function checkThatLoginCredentialsContainsDefaultEmailPathUsersIdOverview($email)
    {
        if (!is_null(self::$prefix['client_email'])) {
            $email = self::$prefix['client_email'] . $email;
        }
        UserOverviewPageObject::checkLoginCredentialsDefaultEmail($email);
    }

    /**
     * @Given /^Check that Login credentials contains Default phone "([^"]*)" == CRM path: users\/\{id\}\/overview ==$/
     */
    public function checkThatLoginCredentialsContainsDefaultPhonePathUsersIdOverview($phone)
    {
        UserOverviewPageObject::checkLoginCredentialsDefaultPhone($phone);
    }

    /**
     * @Given /^Check that Personal info contains First name "([^"]*)" == CRM path: users\/\{id\}\/overview ==$/
     */
    public function checkThatPersonalInfoContainsFirstNamePathUsersIdOverview($firstName)
    {
        UserOverviewPageObject::checkPersonalInfoFirstName($firstName);
    }

    /**
     * @Given /^Check that Personal info contains Last name "([^"]*)" == CRM path: users\/\{id\}\/overview ==$/
     */
    public function checkThatPersonalInfoContainsLastNamePathUsersIdOverview($lastName)
    {
        UserOverviewPageObject::checkPersonalInfoLastName($lastName);
    }

    /**
     * @Given /^Check that Personal info contains Country "([^"]*)" == CRM path: users\/\{id\}\/overview ==$/
     */
    public function checkThatPersonalInfoContainsCountryPathUsersIdOverview($country)
    {
        UserOverviewPageObject::checkPersonalInfoCountry($country);
    }

    /**
     * @Given /^Check that Personal info contains Date of birth "([^"]*)" == CRM path: users\/\{id\}\/overview ==$/
     */
    public function checkThatPersonalInfoContainsDateOfBirthPathUsersIdOverview($dateOfBirth)
    {
        UserOverviewPageObject::checkPersonalInfoDateOfBirth($dateOfBirth);
    }

    /**
     * @Given /^Check that Personal info contains City\/Village "([^"]*)" == CRM path: users\/\{id\}\/overview ==$/
     */
    public function checkThatPersonalInfoContainsCityVillagePathUsersIdOverview($cityVillage)
    {
        UserOverviewPageObject::checkPersonalInfoCityVillage($cityVillage);
    }

    /**
     * @Given /^Check that Personal info contains Region\/District "([^"]*)" == CRM path: users\/\{id\}\/overview ==$/
     */
    public function checkThatPersonalInfoContainsRegionDistrictPathUsersIdOverview($regionDistrict)
    {
        UserOverviewPageObject::checkPersonalInfoRegionDistrict($regionDistrict);
    }

    /**
     * @Given /^Check that Name "([^"]*)" contains in left panel  == CRM path: users\/\{id\}\/... ==$/
     */
    public function checkThatNameContainsInLeftPanelPathUsersIdOverview($firstNameWithLastName)
    {
        UserPageObject::checkName($firstNameWithLastName);
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
    public function sendKeysInEmailInputInClientRegistrationPopupPathClients($email)
    {
        if (!is_null(self::$prefix['client_email'])) {
            $email = self::$prefix['client_email'] . $email;
        }
        ClientsPageObject::sendKeysInClientRegistrationPopupEmailInput($email);
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
    public function inSuccessPopupLabelContainEmailPathClients($email)
    {
        if (!is_null(self::$prefix['client_email'])) {
            $email = self::$prefix['client_email'] . $email;
        }
        ClientsPageObject::checkPopupRegistrationSuccessEmail($email);
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
    public function sendKeysInNameInputPathUsersIdProfile($value)
    {
        UserProfilePageObject::sendKeysInNameInput($value);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Last Name input == CRM path: users\/\{id\}\/profile ==$/
     */
    public function sendKeysInLastNameInputPathUsersIdProfile($value)
    {
        UserProfilePageObject::sendKeysInLastNameInput($value);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Address input == CRM path: users\/\{id\}\/profile ==$/
     */
    public function sendKeysInAddressInputPathUsersIdProfile($value)
    {
        UserProfilePageObject::sendKeysInAddressInput($value);
    }

    /**
     * @Given /^Send keys "([^"]*)" in City input == CRM path: users\/\{id\}\/profile ==$/
     */
    public function sendKeysInCityInputPathUsersIdProfile($value)
    {
        UserProfilePageObject::sendKeysInCityInput($value);
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
    public function clickOnCountryOption($value)
    {
        UserProfilePageObject::clickOnCountryOption($value);
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
    public function clickOnBDayDayOption($value)
    {
        UserProfilePageObject::clickOnBdayDayOption($value);
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
    public function clickOnBDayMonthOption($value)
    {
        UserProfilePageObject::clickOnBdayMonthOption($value);
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
    public function clickOnBDayYearOption($value)
    {
        UserProfilePageObject::clickOnBdayYearOption($value);
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
    public function clickOnSubtypeOptionWithValuePathUsersIdDocumentsCreateProofOfIdentity($value)
    {
        UserDocumentsAddNewPoiPageObject::clickOnSubtypeOption($value);
    }

    /**
     * @Given /^Send file in file input "([^"]*)" == CRM path: users\/\{id\}\/documents\/create\-proof\-of\-identity ==$/
     */
    public function sendFileInFileInputPathUsersIdDocumentsCreateProofOfIdentity($filePath)
    {
        UserDocumentsAddNewPoiPageObject::sendFileInInput($filePath);
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
    public function checkInTableLinePathUsersIdDocuments($checkNumberLine)
    {
        UserDocumentsPageObject::checkNumberTableLine($checkNumberLine);
    }

    /**
     * @Given /^Check in table "([^"]*)" line with Type "([^"]*)" == CRM path: users\/\{id\}\/documents ==$/
     */
    public function checkInTableLineWithTypePathUsersIdDocuments($checkNumberLine, $type)
    {
        UserDocumentsPageObject::checkNumberTableLineByType($checkNumberLine, $type);
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
    public function clickOnSubtypeOptionWithValuePathUsersIdDocumentsCreateProofOfResidence($value)
    {
        UserDocumentsAddNewPorPageObject::clickOnSubtypeOption($value);
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
    public function sendFileInFileInputPathUsersIdDocumentsCreateProofOfPayment($filePath)
    {
        UserDocumentsAddNewPopPageObject::sendFileInInput($filePath);
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
    public function checkIsThisLoginPageMYPathLogin1($value)
    {
        if (!is_null(self::$prefix['client_email'])) {
            $value = self::$prefix['client_email'] . $value;
        }
        MyLoginPageObject::sendKeysInLoginInput($value);
    }

    /**
     * @Given /^Send keys in Password input save password "([^"]*)" user == MY path: \/login ==$/
     */
    public function sendKeysInPasswordInputSavePasswordUserMYPathLogin($user)
    {
        if (!is_null(self::$prefix['client_email'])) {
            $user = self::$prefix['client_email'] . $user;
        }
        $password = self::$dataSave['user_login_info'][$user];
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
    public function checkThatInTheNameInputValueMYPathProfileEdit($name)
    {
        Assert::that(ProfileEditPageObject::getNameInputValue())->eq($name);

    }

    /**
     * @Given /^Check that in the Surname input value "([^"]*)" == MY path: \/profile\/edit ==$/
     */
    public function checkThatInTheSurnameInputValueMYPathProfileEdit($surname)
    {
        Assert::that(ProfileEditPageObject::getSurnameInputValue())->eq($surname);
    }

    /**
     * @Given /^Check that in the City\/Town input value "([^"]*)" == MY path: \/profile\/edit ==$/
     */
    public function checkThatInTheCityTownInputValueMYPathProfileEdit($cityTown)
    {
        Assert::that(ProfileEditPageObject::getCityInputValue())->eq($cityTown);
    }

    /**
     * @Given /^Check that in the Address input value "([^"]*)" == MY path: \/profile\/edit ==$/
     */
    public function checkThatInTheAddressInputValueMYPathProfileEdit($address)
    {
        Assert::that(ProfileEditPageObject::getAddressInputValue())->eq($address);
    }

    /**
     * @Given /^Check that in the Day select value "([^"]*)" == MY path: \/profile\/edit ==$/
     */
    public function checkThatInTheDaySelectValueMYPathProfileEdit($day)
    {
        Assert::that(ProfileEditPageObject::getDateDaySelectedValue())->eq($day);
    }

    /**
     * @Given /^Check that in the Month select value "([^"]*)" == MY path: \/profile\/edit ==$/
     */
    public function checkThatInTheMonthSelectValueMYPathProfileEdit($month)
    {
        Assert::that(ProfileEditPageObject::getDateMonthSelectedValue())->eq($month);
    }

    /**
     * @Given /^Check that in the Year select value "([^"]*)" == MY path: \/profile\/edit ==$/
     */
    public function checkThatInTheYearSelectValueMYPathProfileEdit($year)
    {
        Assert::that(ProfileEditPageObject::getDateYearSelectedValue())->eq($year);
    }

    /**
     * @Given /^Check that in the Country select value "([^"]*)" == MY path: \/profile\/edit ==$/
     */
    public function checkThatInTheCountrySelectValueMYPathProfileEdit($country)
    {
        Assert::that(ProfileEditPageObject::getCountrySelectedValue())->eq($country);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Name input == MY path: \/profile\/edit =$/
     */
    public function sendKeysInNameInputMYPathProfileEdit($name)
    {
        ProfileEditPageObject::sendKeysInNameInput($name);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Surname input == MY path: \/profile\/edit =$/
     */
    public function sendKeysInLastNameInputMYPathProfileEdit($surname)
    {
        ProfileEditPageObject::sendKeysInSurnameInput($surname);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Address input == MY path: \/profile\/edit =$/
     */
    public function sendKeysInAddressInputMYPathProfileEdit($address)
    {
        ProfileEditPageObject::sendKeysInAddressInput($address);
    }

    /**
     * @Given /^Send keys "([^"]*)" in City input == MY path: \/profile\/edit =$/
     */
    public function sendKeysInCityInputMYPathProfileEdit($city)
    {
        ProfileEditPageObject::sendKeysInCityInput($city);
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
    public function clickOnCountryOptionMYPathProfileEdit($value)
    {
        ProfileEditPageObject::clickOnCountryOption($value);
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
    public function clickOnBDayDayOptionMYPathProfileEdit($value)
    {
        ProfileEditPageObject::clickOnBDayOption($value);
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
    public function clickOnBDayMonthOptionMYPathProfileEdit($value)
    {
        ProfileEditPageObject::clickOnBMonthOption($value);
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
    public function clickOnBDayYearOptionMYPathProfileEdit($value)
    {
        ProfileEditPageObject::clickOnBYearOption($value);
    }

    /**
     * @Given /^Click on \[Update profile\] button == MY path: \/profile\/edit =$/
     */
    public function clickOnUpdateProfileButtonMYPathProfileEdit()
    {
        ProfileEditPageObject::clickOnUpdateProfileButton();
    }

}
