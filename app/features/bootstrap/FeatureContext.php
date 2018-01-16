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
use PageObject\My\Profile\ProfileBillingPageObject;
use PageObject\My\Profile\ProfileEditPageObject;
use PageObject\My\Profile\ProfileMenuPageObject;

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
     * @Given /^Click on Country select == CRM path: users\/\{id\}\/profile ==$/
     */
    public function clickOnCountrySelect()
    {
        UserProfilePageObject::clickOnCountrySelect();
    }

    /**
     * @Given /^Click on Country option "([^"]*)" == CRM path: users\/\{id\}\/profile ==$/
     */
    public function clickOnCountryOption($value)
    {
        UserProfilePageObject::clickOnCountryOption($value);
    }

    /**
     * @Given /^Click on B\-day day select == CRM path: users\/\{id\}\/profile ==$/
     */
    public function clickOnBDayDaySelect()
    {
        UserProfilePageObject::clickOnBdayDaySelect();
    }

    /**
     * @Given /^Click on B\-day day option "([^"]*)" == CRM path: users\/\{id\}\/profile ==$/
     */
    public function clickOnBDayDayOption($value)
    {
        UserProfilePageObject::clickOnBdayDayOption($value);
    }

    /**
     * @Given /^Click on B\-day month select == CRM path: users\/\{id\}\/profile ==$/
     */
    public function clickOnBDayMonthSelect()
    {
        UserProfilePageObject::clickOnBdayMonthSelect();
    }

    /**
     * @Given /^Click on B\-day month option "([^"]*)" == CRM path: users\/\{id\}\/profile ==$/
     */
    public function clickOnBDayMonthOption($value)
    {
        UserProfilePageObject::clickOnBdayMonthOption($value);
    }

    /**
     * @Given /^Click on B\-day year select == CRM path: users\/\{id\}\/profile ==$/
     */
    public function clickOnBDayYearSelect()
    {
        UserProfilePageObject::clickOnBdayYearSelect();
    }

    /**
     * @Given /^Click on B\-day year option "([^"]*)" == CRM path: users\/\{id\}\/profile ==$/
     */
    public function clickOnBDayYearOption($value)
    {
        UserProfilePageObject::clickOnBdayYearOption($value);
    }

    /**
     * @Given /^Click on \[Save\] button == CRM path: users\/\{id\}\/profile ==$/
     */
    public function clickOnSaveButton()
    {
        UserProfilePageObject::clickOnSaveButton();
    }

    /**
     * @Given /^Show save success label == CRM path: users\/\{id\}\/profile ==$/
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

    /**
     * @Given /^Click on Billing tab in profile menu == MY path: \/profile\/\.\.\. =$/
     */
    public function clickOnBillingTabInProfileMenuMYPathProfile()
    {
        ProfileMenuPageObject::clickOnBillingTab();
    }

    /**
     * @Given /^Check in Profile Billing page == MY path: \/profile\/billing ==$/
     */
    public function checkInProfileBillingPageMYPathProfileBilling()
    {
        ProfileBillingPageObject::checkOnPage();
    }

    /**
     * @Given /^Send keys "([^"]*)" in Bank name input == MY path: \/profile\/billing ==$/
     */
    public function sendKeysInBankNameInputMYPathProfileBilling($value)
    {
        ProfileBillingPageObject::sendKeysInBankNameInput($value);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Swift code input == MY path: \/profile\/billing ==$/
     */
    public function sendKeysInSwiftCodeInputMYPathProfileBilling($value)
    {
        ProfileBillingPageObject::sendKeysInBankSwiftCodeInput($value);
    }

    /**
     * @Given /^Click on Bank country select  == MY path: \/profile\/billing ==$/
     */
    public function clickOnBankCountrySelectMYPathProfileBilling()
    {
        ProfileBillingPageObject::clickOnBankCountrySelect();
    }

    /**
     * @Given /^Click on Bank country option "([^"]*)" == MY path: \/profile\/billing ==$/
     */
    public function clickOnBankCountryOptionMYPathProfileBilling($value)
    {
        ProfileBillingPageObject::clickOnBankCountryOption($value);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Bank city input == MY path: \/profile\/billing ==$/
     */
    public function sendKeysInBankCityInputMYPathProfileBilling($value)
    {
        ProfileBillingPageObject::sendKeysInBankCityInput($value);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Bank address input == MY path: \/profile\/billing ==$/
     */
    public function sendKeysInBankAddressInputMYPathProfileBilling($value)
    {
        ProfileBillingPageObject::sendKeysInBankAddressInput($value);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Account number input == MY path: \/profile\/billing ==$/
     */
    public function sendKeysInAccountNumberInputMYPathProfileBilling($value)
    {
        ProfileBillingPageObject::sendKeysInBankAccountNumberInput($value);
    }

    /**
     * @Given /^Send keys "([^"]*)" in IBAN input == MY path: \/profile\/billing ==$/
     */
    public function sendKeysInIBANInputMYPathProfileBilling($value)
    {
        ProfileBillingPageObject::sendKeysInBankIbanInput($value);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Beneficiary Full name input == MY path: \/profile\/billing ==$/
     */
    public function sendKeysInBeneficiaryFullNameInputMYPathProfileBilling($value)
    {
        ProfileBillingPageObject::sendKeysInBankBeneficiaryFullNameInput($value);
    }

    /**
     * @Given /^Click on \[Save\] Bank button == MY path: \/profile\/billing ==$/
     */
    public function clickOnSaveBankButtonMYPathProfileBilling()
    {
        ProfileBillingPageObject::clickOnBankSaveButton();
    }

    /**
     * @Given /^Click on \[Add bank\] button == MY path: \/profile\/billing ==$/
     */
    public function clickOnAddBankButtonMYPathProfileBilling()
    {
        ProfileBillingPageObject::clickOnBankAddButton();
    }

    /**
     * @Given /^Check Waiting for verification bank "([^"]*)" == MY path: \/profile\/billing ==$/
     */
    public function checkWaitingForVerificationBankMYPathProfileBilling($bankName)
    {
        ProfileBillingPageObject::checkWatingForVerificationStatusBankInTourBanksBlock($bankName);
    }

    /**
     * @Given /^Check bank Swift code in save block "([^"]*)" for bank "([^"]*)" == MY path: \/profile\/billing ==$/
     */
    public function checkBankSwiftCodeInSaveBlockForBankMYPathProfileBilling($value, $bankName)
    {
        ProfileBillingPageObject::checkSwiftCodeInYourBanksBlock($bankName, $value);
    }

    /**
     * @Given /^Check bank Bank country in save block "([^"]*)" for bank "([^"]*)" == MY path: \/profile\/billing ==$/
     */
    public function checkBankBankCountryInSaveBlockForBankMYPathProfileBilling($value, $bankName)
    {
        ProfileBillingPageObject::checkBankCountryInYourBanksBlock($bankName, $value);
    }

    /**
     * @Given /^Check bank Bank city in save block "([^"]*)" for bank "([^"]*)" == MY path: \/profile\/billing ==$/
     */
    public function checkBankBankCityInSaveBlockForBankMYPathProfileBilling($value, $bankName)
    {
        ProfileBillingPageObject::checkBankCityInYourBanksBlock($bankName, $value);
    }

    /**
     * @Given /^Check bank Bank address in save block "([^"]*)" for bank "([^"]*)" == MY path: \/profile\/billing ==$/
     */
    public function checkBankBankAddressInSaveBlockForBankMYPathProfileBilling($value, $bankName)
    {
        ProfileBillingPageObject::checkBankAddressInYourBanksBlock($bankName, $value);
    }

    /**
     * @Given /^Check bank Account number in save block "([^"]*)" for bank "([^"]*)" == MY path: \/profile\/billing ==$/
     */
    public function checkBankAccountNumberInSaveBlockForBankMYPathProfileBilling($value, $bankName)
    {
        ProfileBillingPageObject::checkAccountNumberInYourBanksBlock($bankName, $value);
    }

    /**
     * @Given /^Check bank IBAN in save block "([^"]*)" for bank "([^"]*)" == MY path: \/profile\/billing ==$/
     */
    public function checkBankIBANInSaveBlockForBankMYPathProfileBilling($value, $bankName)
    {
        ProfileBillingPageObject::checkIBANInYourBanksBlock($bankName, $value);
    }

    /**
     * @Given /^Check bank Beneficiary Full name in save block "([^"]*)" for bank "([^"]*)" == MY path: \/profile\/billing ==$/
     */
    public function checkBankBeneficiaryFullNameInSaveBlockForBankMYPathProfileBilling($value, $bankName)
    {
        ProfileBillingPageObject::checkBeneficiaryFullNameInYourBanksBlock($bankName, $value);
    }

    /**
     * @Given /^Click on \[Add new credit card\] button == MY path: \/profile\/billing ==$/
     */
    public function clickOnAddNewCreditCardButtonMYPathProfileBilling()
    {
        ProfileBillingPageObject::clickOnCardAddButton();
    }

    /**
     * @Given /^Click on select Type credit card == MY path: \/profile\/billing ==$/
     */
    public function clickOnSelectTypeCreditCardMYPathProfileBilling()
    {
        ProfileBillingPageObject::clickOnCardTypeSelect();
    }

    /**
     * @Given /^Click on option "([^"]*)" Type credit card == MY path: \/profile\/billing ==$/
     */
    public function clickOnOptionTypeCreditCardMYPathProfileBilling($value)
    {
        ProfileBillingPageObject::clickOnCardTypeOption($value);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Card holder name input == MY path: \/profile\/billing ==$/
     */
    public function sendKeysInCardHolderNameInputMYPathProfileBilling($value)
    {
        ProfileBillingPageObject::sendKeysInCardHolderNameInput($value);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Card number input == MY path: \/profile\/billing ==$/
     */
    public function sendKeysInCardNumberInputMYPathProfileBilling($value)
    {
        ProfileBillingPageObject::sendKeysInCardNumberInput($value);
    }

    /**
     * @Given /^Click on select expiration date month == MY path: \/profile\/billing ==$/
     */
    public function clickOnSelectExpirationDateMonthMYPathProfileBilling()
    {
        ProfileBillingPageObject::clickOnCardExpirationDateMonthSelect();
    }

    /**
     * @Given /^Click on option "([^"]*)" expiration date month == MY path: \/profile\/billing ==$/
     */
    public function clickOnOptionExpirationDateMonthMYPathProfileBilling($value)
    {
        ProfileBillingPageObject::clickOnCardExpirationDateMonthOption($value);
    }

    /**
     * @Given /^Click on select expiration date year == MY path: \/profile\/billing ==$/
     */
    public function clickOnSelectExpirationDateYearMYPathProfileBilling()
    {
        ProfileBillingPageObject::clickOnCardExpirationDateYearSelect();
    }

    /**
     * @Given /^Click on option "([^"]*)" expiration date year == MY path: \/profile\/billing ==$/
     */
    public function clickOnOptionExpirationDateYearMYPathProfileBilling($value)
    {
        ProfileBillingPageObject::clickOnCardExpirationDateYearOption($value);
    }

    /**
     * @Given /^Send keys "([^"]*)" in CVV number input == MY path: \/profile\/billing ==$/
     */
    public function sendKeysInCVVNumberInputMYPathProfileBilling($value)
    {
        ProfileBillingPageObject::sendKeysInCardCvvNumberInput($value);
    }


    /**
     * @Given /^Send file "([^"]*)" in Front cover input == MY path: \/profile\/billing ==$/
     */
    public function sendFileInFrontCoverInputMYPathProfileBilling($value)
    {
        ProfileBillingPageObject::sendKeysInFrontCoverFileInput($value);
    }

    /**
     * @Given /^Send file "([^"]*)" in Back cover input == MY path: \/profile\/billing ==$/
     */
    public function sendFileInBackCoverInputMYPathProfileBilling($value)
    {
        ProfileBillingPageObject::sendKeysInBackCoverFileInput($value);
    }

    /**
     * @Given /^Click on \[Save and verify\] credit card button == MY path: \/profile\/billing ==$/
     */
    public function clickOnSaveAndVerifyCreditCardButtonMYPathProfileBilling()
    {
        ProfileBillingPageObject::clickOnSaveAndVerifyButton();
    }

    /**
     * @Given /^Check status "Waiting for verification" for card "([^"]*)" == MY path: \/profile\/billing ==$/
     */
    public function checkStatusForCardMYPathProfileBilling($shortCardNumber)
    {
        ProfileBillingPageObject::checkStatusWaitingForVerificationCardInCardBlock($shortCardNumber);
    }

    /**
     * @Given /^Check Type "([^"]*)" for card "([^"]*)" == MY path: \/profile\/billing ==$/
     */
    public function checkTypeForCardMYPathProfileBilling($value, $shortCardNumber)
    {
        ProfileBillingPageObject::checkTypeCardInCardBlock($shortCardNumber, $value);
    }

    /**
     * @Given /^Check Card holder name "([^"]*)" for card "([^"]*)" == MY path: \/profile\/billing ==$/
     */
    public function checkCardHolderNameForCardMYPathProfileBilling($value, $shortCardNumber)
    {
        ProfileBillingPageObject::checkCardHolderNameCardBlock($shortCardNumber, $value);
    }

    /**
     * @Given /^Check Expiration date "([^"]*)" for card "([^"]*)" == MY path: \/profile\/billing ==$/
     */
    public function checkExpirationDateForCardMYPathProfileBilling($value, $shortCardNumber)
    {
        ProfileBillingPageObject::checkExpirationDateCardBlock($shortCardNumber, $value);
    }

    /**
     * @Given /^Check Related email "([^"]*)" for card "([^"]*)" == MY path: \/profile\/billing ==$/
     */
    public function checkRelatedEmailForCardMYPathProfileBilling($value, $shortCardNumber)
    {
        if (!is_null(self::$prefix['client_email'])) {
            $value = self::$prefix['client_email'] . $value;
        }

        ProfileBillingPageObject::checkRelatedEmailCardBlock($shortCardNumber, $value);
    }

    /**
     * @Given /^Check md5 file "([^"]*)" and md5 file front cover for card "([^"]*)" == MY path: \/profile\/billing ==$/
     */
    public function checkMdfileAndMdfileFrontCoverForCardMYPathProfileBilling($value, $shortCardNumber)
    {
        ProfileBillingPageObject::checkFrontCoverFileCardBlock($shortCardNumber, $value);
    }

    /**
     * @Given /^Check md5 file "([^"]*)" and md5 file back cover for card "([^"]*)" == MY path: \/profile\/billing ==$/
     */
    public function checkMdfileAndMdfileBackCoverForCardMYPathProfileBilling($value, $shortCardNumber)
    {
        ProfileBillingPageObject::checkBackCoverFileCardBlock($shortCardNumber, $value);
    }

    /**
     * @Given /^On page "([^"]*)" card in Your credit cards block == MY path: \/profile\/billing ==$/
     */
    public function onPageCardInYourCreditCardsBlockMYPathProfileBilling($checkNumber)
    {
        ProfileBillingPageObject::checkNumberCardsInBlockYourCreditCards($checkNumber);
    }

    /**
     * @Given /^On page "([^"]*)" bank in Your banks block == MY path: \/profile\/billing ==$/
     */
    public function onPageBankInYourBanksBlockMYPathProfileBilling($checkNumber)
    {
        ProfileBillingPageObject::checkNumberBanksInBlockYourBanks($checkNumber);
    }


}
