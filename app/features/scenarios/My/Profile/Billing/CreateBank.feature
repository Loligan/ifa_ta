Feature: MY - Create bank in billing panel

  Background:
    And Create user by API == API ==
    And Open Login page == CRM path: /login ==
    And Check is this Login page == CRM path: /login ==
    And Send keys in Username input create username api data == CRM path: /login ==
    And Send keys in Password input create password api data== CRM path: /login ==
    And Click on Login button == CRM path: /login ==
    And Check is this Clients page == CRM path: /clients ==
    And Click on [Add client] button == CRM path: /clients ==
    And Click on [Add new client using email] text in client registration popup == CRM path: /clients ==
    And Generate/Update prefix for "client_email"
    And Send keys "ta@mail.com" in email input in client registration popup == CRM path: /clients ==
    And Click on [Submit] button in client registration popup == CRM path: /clients ==
    And Sleep "1"
    And I show success label user create == CRM path: /clients ==
    And In success popup label contain email "ta@mail.com" == CRM path: /clients ==
    And In success popup label contain password == CRM path: /clients ==
    And Save user "ta@mail.com" password == CRM path: /clients ==
    And Press [Close button] == CRM path: /clients ==
    And Refresh page
    And Click on email "ta@mail.com" in clients table == CRM path: /clients ==
    And Check on Overview Client Page == CRM path: /clients ==
    And Check that Login credentials contains Default email "ta@mail.com" == CRM path: users/{id}/overview ==
    And Check that Personal info contains Date of birth "01 / 01 / 1970" == CRM path: users/{id}/overview ==
    And Open Login page == MY path: /login ==
    And Send keys  "ta@mail.com" in login input == MY path: /login ==
    And Send keys in Password input save password "ta@mail.com" user == MY path: /login ==
    And Click on Login button == MY path: /login ==
    And Check on Profile edit page == MY path: /profile/edit =
    And Click on Billing tab in profile menu == MY path: /profile/... =
    And Check in Profile Billing page == MY path: /profile/billing ==

  @my @profile @billing @bank @create @positive
  Scenario Outline: Create bank in billing panel
    And Click on [Add bank] button == MY path: /profile/billing ==
    And Send keys "<bank-name>" in Bank name input == MY path: /profile/billing ==
    And Send keys "<swift>" in Swift code input == MY path: /profile/billing ==
    And Click on Bank country select  == MY path: /profile/billing ==
    And Click on Bank country option "<country>" == MY path: /profile/billing ==
    And Send keys "<city>" in Bank city input == MY path: /profile/billing ==
    And Send keys "<address>" in Bank address input == MY path: /profile/billing ==
    And Send keys "<account-number>" in Account number input == MY path: /profile/billing ==
    And Send keys "<iban>" in IBAN input == MY path: /profile/billing ==
    And Send keys "<benef-fullname>" in Beneficiary Full name input == MY path: /profile/billing ==
    And Click on [Save] Bank button == MY path: /profile/billing ==
    And On page "1" bank in Your banks block == MY path: /profile/billing ==
    And Check in Profile Billing page == MY path: /profile/billing ==
    And Check Waiting for verification bank "<bank-name>" == MY path: /profile/billing ==
    And Check bank Swift code in save block "<swift>" for bank "<bank-name>" == MY path: /profile/billing ==
    And Check bank Bank country in save block "<country-short>" for bank "<bank-name>" == MY path: /profile/billing ==
    And Check bank Bank city in save block "<city>" for bank "<bank-name>" == MY path: /profile/billing ==
    And Check bank Bank address in save block "<address>" for bank "<bank-name>" == MY path: /profile/billing ==
    And Check bank Account number in save block "<account-number>" for bank "<bank-name>" == MY path: /profile/billing ==
    And Check bank IBAN in save block "<iban>" for bank "<bank-name>" == MY path: /profile/billing ==
    And Check bank Beneficiary Full name in save block "<benef-fullname>" for bank "<bank-name>" == MY path: /profile/billing ==

    Examples:
      | bank-name                   | swift     | country | country-short | city                        | address                     | account-number | iban    | benef-fullname              |
      | Bank name                   | S1W2I3F4T | Belarus | BLR           | City                        | Address                     | 1234567890     | I1B2A3N | Beneficiary Full name       |
      | B                           | S         | Belarus | BLR           | C                           | A                           | 1              | I       | B                           |
      | עברי                        | S1W2I3F4T | Belarus | BLR           | עברי                        | עברי                        | 1234567890     | I1B2A3N | עברי                        |
      | Тест                        | S1W2I3F4T | Belarus | BLR           | Тест                        | Тест                        | 1234567890     | I1B2A3N | Тест                        |
      | 中国                          | S1W2I3F4T | Belarus | BLR           | 中国                          | 中国                          | 1234567890     | I1B2A3N | 中国                          |
      | null                        | S1W2I3F4T | Belarus | BLR           | null                        | null                        | 1234567890     | I1B2A3N | null                        |
      | #@!$%&*(*)_#@               | S1W2I3F4T | Belarus | BLR           | #@!$%&*(*)_#@               | #@!$%&*(*)_#@               | 1234567890     | I1B2A3N | #@!$%&*(*)_#@               |
      | Тес %%%/%%%т                | S1W2I3F4T | Belarus | BLR           | %%%/%%%                     | %%%/%%%                     | 1234567890     | I1B2A3N | %%%/%%%                     |
      | “♣☺♂” “”‘~~/\,.?></b,./\<][ | S1W2I3F4T | Belarus | BLR           | “♣☺♂” “”‘~~/\,.?></b,./\<][ | “♣☺♂” “”‘~~/\,.?></b,./\<][ | 1234567890     | I1B2A3N | “♣☺♂” “”‘~~/\,.?></b,./\<][ |
      | Aa!@#$%^&*()                | S1W2I3F4T | Belarus | BLR           | Aa!@#$%^&*()                | Aa!@#$%^&*()                | 1234567890     | I1B2A3N | Aa!@#$%^&*()                |
      | SHOW TABLES                 | S1W2I3F4T | Belarus | BLR           | SHOW TABLES                 | SHOW TABLES                 | 1234567890     | I1B2A3N | SHOW TABLES                 |
