Feature:  MY - Create card in billing panel

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

  @my @profile @billing @card @create @positive
  Scenario Outline: Create card in billing panel
    And Click on [Add new credit card] button == MY path: /profile/billing ==
    And Click on select Type credit card == MY path: /profile/billing ==
    And Click on option "<type>" Type credit card == MY path: /profile/billing ==
    And Send keys "<name>" in Card holder name input == MY path: /profile/billing ==
    And Send keys "<number>" in Card number input == MY path: /profile/billing ==
    And Click on select expiration date month == MY path: /profile/billing ==
    And Click on option "<month>" expiration date month == MY path: /profile/billing ==
    And Click on select expiration date year == MY path: /profile/billing ==
    And Click on option "<year>" expiration date year == MY path: /profile/billing ==
    And Send keys "<CVV>" in CVV number input == MY path: /profile/billing ==
    And Send file "<front-image>" in Front cover input == MY path: /profile/billing ==
    And Send file "<back-image>" in Back cover input == MY path: /profile/billing ==
    And Click on [Save and verify] credit card button == MY path: /profile/billing ==
    And Refresh page
    And On page "1" card in Your credit cards block == MY path: /profile/billing ==
    And Check status "Waiting for verification" for card "<cut-number>" == MY path: /profile/billing ==
    And Check Type "<type>" for card "<cut-number>" == MY path: /profile/billing ==
    And Check Card holder name "<name>" for card "<cut-number>" == MY path: /profile/billing ==
    And Check Expiration date "<month>/<year>" for card "<cut-number>" == MY path: /profile/billing ==
    And Check Related email "ta@mail.com" for card "<cut-number>" == MY path: /profile/billing ==
    And Check md5 file "<front-image>" and md5 file front cover for card "<cut-number>" == MY path: /profile/billing ==
    And Check md5 file "<back-image>" and md5 file back cover for card "<cut-number>" == MY path: /profile/billing ==
    Examples:
      | type        | name                        | number           | cut-number       | month | year | CVV | front-image   | back-image    |
      | Visa        | Card name                   | 4539315475686527 | 4539........6527 | 01    | 21   | 411 | img/838B.jpg  | img/838B.jpg  |
      | Master Card | Card name                   | 5492026548211936 | 5492........1936 | 01    | 21   | 411 | img/838B.jpg  | img/838B.jpg  |
      | Visa        | Card name                   | 4539315475686527 | 4539........6527 | 10    | 22   | 411 | img/838B.jpg  | img/838B.jpg  |
      | Visa        | C                           | 4539315475686527 | 4539........6527 | 01    | 21   | 411 | img/838B.jpg  | img/838B.jpg  |
      | Visa        | עברי                        | 4539315475686527 | 4539........6527 | 01    | 21   | 411 | img/838B.jpg  | img/838B.jpg  |
      | Visa        | Тест                        | 4539315475686527 | 4539........6527 | 01    | 21   | 411 | img/838B.jpg  | img/838B.jpg  |
      | Visa        | 中国                          | 4539315475686527 | 4539........6527 | 01    | 21   | 411 | img/838B.jpg  | img/838B.jpg  |
      | Visa        | null                        | 4539315475686527 | 4539........6527 | 01    | 21   | 411 | img/838B.jpg  | img/838B.jpg  |
      | Visa        | #@!$%&*(*)_#@               | 4539315475686527 | 4539........6527 | 01    | 21   | 411 | img/838B.jpg  | img/838B.jpg  |
      | Visa        | %%%/%%%                     | 4539315475686527 | 4539........6527 | 01    | 21   | 411 | img/838B.jpg  | img/838B.jpg  |
      | Visa        | “♣☺♂” “”‘~~/\,.?></b,./\<][ | 4539315475686527 | 4539........6527 | 01    | 21   | 411 | img/838B.jpg  | img/838B.jpg  |
      | Visa        | Aa!@#$%^&*()                | 4539315475686527 | 4539........6527 | 01    | 21   | 411 | img/838B.jpg  | img/838B.jpg  |
      | Visa        | SHOW TABLES                 | 4539315475686527 | 4539........6527 | 01    | 21   | 411 | img/838B.jpg  | img/838B.jpg  |
      | Visa        | Card name                   | 4539315475686527 | 4539........6527 | 01    | 21   | 411 | img/73B.png   | img/73B.png   |
      | Visa        | Card name                   | 4539315475686527 | 4539........6527 | 01    | 21   | 411 | img/895B.gif  | img/895B.gif  |
      | Visa        | Card name                   | 4539315475686527 | 4539........6527 | 01    | 21   | 411 | img/9217B.bmp | img/9217B.bmp |
