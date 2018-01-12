Feature: CRM - Add POR

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

  @crm @client @positive @por
  Scenario Outline: Add POR
    And Click on [Add new POR] tab == CRM path: users/{id}/documents/... ==
    And Check on Add new POR page == CRM path: users/{id}/documents/create-proof-of-residence ==
    And Send file in file input "<file>" == CRM path: users/{id}/documents/create-proof-of-residence ==
    And Click on Subtype select == CRM path: users/{id}/documents/create-proof-of-residence ==
    And Click on Subtype option with value "<subtype>" == CRM path: users/{id}/documents/create-proof-of-residence ==
    And Click on [Save] button == CRM path: users/{id}/documents/create-proof-of-residence ==
    And Check on Documents page == CRM path: users/{id}/documents ==
    And Check in table "1" line == CRM path: users/{id}/documents ==
    And Check in table "1" line with Type "Proof of residence | <subtype>" == CRM path: users/{id}/documents ==
    Examples:
      | file          | subtype                      |
      | img/img_1.jpg | Bank statement               |
      | img/img_1.jpg | Credit card statement        |
      | img/img_1.jpg | Utility bill                 |
      | img/img_1.jpg | Valid House Rental contract  |
      | img/img_1.jpg | Insurance policy             |
      | img/img_1.jpg | Other governmental documents |
      | img/895B.gif  | Bank statement               |
      | img/73B.png   | Bank statement               |
      | img/9217B.bmp | Bank statement               |
