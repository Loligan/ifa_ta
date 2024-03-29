@crm @my @client
Feature: CRM - update profile client and check data in MY

  Background:
    Given Create user by API == API ==
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
    And Save user "ta@mail.com" password == CRM path: /clients ==
    And Press [Close button] == CRM path: /clients ==
    And Refresh page

  @positive
  Scenario Outline: CRM - update profile client and check data in MY
    When Click on email "ta@mail.com" in clients table == CRM path: /clients ==
    And Check on Overview Client Page == CRM path: /clients ==
    And Check that Login credentials contains Default email "ta@mail.com" == CRM path: users/{id}/overview ==
    And Check that Personal info contains Date of birth "01 / 01 / 1970" == CRM path: users/{id}/overview ==
    And Click on [Profile] button on left panel == CRM path: users/{id}/...==
    And Check on Users profile page == CRM path: users/{id}/profile ==
    And Send keys "<name>" in Name input == CRM path: users/{id}/profile ==
    And Send keys "<last-name>" in Last Name input == CRM path: users/{id}/profile ==
    And Send keys "<address>" in Address input == CRM path: users/{id}/profile ==
    And Send keys "<city>" in City input == CRM path: users/{id}/profile ==
    And Click on Country select == CRM path: users/{id}/profile ==
    And Click on Country option "<country>" == CRM path: users/{id}/profile ==
    And Click on B-day day select == CRM path: users/{id}/profile ==
    And Click on B-day day option "<b-day>" == CRM path: users/{id}/profile ==
    And Click on B-day month select == CRM path: users/{id}/profile ==
    And Click on B-day month option "<b-month>" == CRM path: users/{id}/profile ==
    And Click on B-day year select == CRM path: users/{id}/profile ==
    And Click on B-day year option "<b-year>" == CRM path: users/{id}/profile ==
    And Click on [Save] button == CRM path: users/{id}/profile ==
    And Show save success label == CRM path: users/{id}/profile ==
    And Open Login page == MY path: /login ==
    And Send keys  "ta@mail.com" in login input == MY path: /login ==
    And Send keys in Password input save password "ta@mail.com" user == MY path: /login ==
    And Click on Login button == MY path: /login ==
    And Check on Profile edit page == MY path: /profile/edit =
    Then Check that in the Name input value "<name>" == MY path: /profile/edit ==
    And Check that in the Surname input value "<last-name>" == MY path: /profile/edit ==
    And Check that in the City/Town input value "<city>" == MY path: /profile/edit ==
    And Check that in the Address input value "<address>" == MY path: /profile/edit ==
    And Check that in the Day select value "<b-day>" == MY path: /profile/edit ==
    And Check that in the Month select value "<b-month>" == MY path: /profile/edit ==
    And Check that in the Year select value "<b-year>" == MY path: /profile/edit ==
    And Check that in the Country select value "<country>" == MY path: /profile/edit ==
    Examples:
      | name                        | last-name                   | address                     | city                        | country                  | country-short | b-day | b-month | b-year |
      | Mitch                       | Lucker                      | Test address                | Test city                   | Canada  | CAN           | 04     | 02       | 1991   |
      | Mitch                       | Lucker                      | Test address                | Test city                   | Belarus                 | BLR           | 4     | 2       | 1991   |
      | Mitch                       | Lucker                      | Test address                | Test city                   | Canada  | CAN           | 15    | 12      | 1912   |
      | A                           | A                           | A                           | A                           | Canada  | CAN           | 4     | 2       | 1991   |
      | 1                           | 1                           | 1                           | 1                           | Canada  | CAN           | 4     | 2       | 1991   |
      | עברי                        | עברי                        | עברי                        | עברי                        | Canada  | CAN           | 4     | 2       | 1991   |
      | Тест                        | Тест                        | Тест                        | Тест                        | Canada  | CAN           | 4     | 2       | 1991   |
      | 中国                          | 中国                          | 中国                          | 中国                          | Canada  | CAN           | 4     | 2       | 1991   |
      | null                        | null                        | null                        | null                        | Canada  | CAN           | 4     | 2       | 1991   |
      | #@!$%&*(*)_#@               | #@!$%&*(*)_#@               | #@!$%&*(*)_#@               | #@!$%&*(*)_#@               | Canada  | CAN           | 4     | 2       | 1991   |
      | %%%/%%%                     | %%%/%%%                     | %%%/%%%                     | %%%/%%%                     | Canada  | CAN           | 4     | 2       | 1991   |
      | “♣☺♂” “”‘~~/\,.?></b,./\<][ | “♣☺♂” “”‘~~/\,.?></b,./\<][ | “♣☺♂” “”‘~~/\,.?></b,./\<][ | “♣☺♂” “”‘~~/\,.?></b,./\<][ | Canada  | CAN           | 4     | 2       | 1991   |
      | Aa!@#$%^&*()                | Aa!@#$%^&*()                | Aa!@#$%^&*()                | Aa!@#$%^&*()                | Canada  | CAN           | 4     | 2       | 1991   |
      | SHOW TABLES                 | SHOW TABLES                 | SHOW TABLES                 | SHOW TABLES                 | Canada  | CAN           | 4     | 2       | 1991   |
#
#