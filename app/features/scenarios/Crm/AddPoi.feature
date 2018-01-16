@crm @client @poi
Feature: CRM - Add POI

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
    And I show success label user create == CRM path: /clients ==
    And In success popup label contain email "ta@mail.com" == CRM path: /clients ==
    And In success popup label contain password == CRM path: /clients ==
    And Press [Close button] == CRM path: /clients ==
    And Refresh page
    And Click on email "ta@mail.com" in clients table == CRM path: /clients ==
    And Check on Overview Client Page == CRM path: /clients ==
    And Click on [Documents] button on left panel == CRM path: users/{id}/... ==
    And Check on Documents page == CRM path: users/{id}/documents ==

  @positive
  Scenario Outline: Add POI
    When Click on [Add new POI] tab == CRM path: users/{id}/documents/... ==
    And Check on Add new POI page == CRM path: users/{id}/documents/create-proof-of-identity ==
    And Send file in file input "<file>" == CRM path: users/{id}/documents/create-proof-of-identity ==
    And Click on Subtype select == CRM path: users/{id}/documents/create-proof-of-identity ==
    And Click on Subtype option with value "<subtype>" == CRM path: users/{id}/documents/create-proof-of-identity ==
    And Click on [Save] button == CRM path: users/{id}/documents/create-proof-of-identity ==
    Then Check on Documents page == CRM path: users/{id}/documents ==
    And Check in table "1" line == CRM path: users/{id}/documents ==
    And Check in table "1" line with Type "Proof of identity | <subtype>" == CRM path: users/{id}/documents ==
    Examples:
      | file          | subtype               |
      | img/838B.jpg  | Civil ID card         |
      | img/838B.jpg  | Passport              |
      | img/838B.jpg  | Residence permit card |
      | img/895B.gif  | Civil ID card         |
      | img/73B.png   | Civil ID card         |
      | img/9217B.bmp | Civil ID card         |