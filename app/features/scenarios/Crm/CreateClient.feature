Feature: CRM - add new client

  Background:
    And Create user by API == API ==

  @crm @create-client @positive
  Scenario Outline: Add new client by email
    And Open Login page == CRM path: /login ==
    And Check is this Login page == CRM path: /login ==
    And Send keys in Username input create username api data == CRM path: /login ==
    And Send keys in Password input create password api data== CRM path: /login ==
    And Click on Login button == CRM path: /login ==
    And Check is this Clients page == CRM path: /clients ==
    And Click on [Add client] button == CRM path: /clients ==
    And Click on [Add new client using email] text in client registration popup == CRM path: /clients ==
    And Generate/Update prefix for "client_email"
    And Send keys "<email-client>" in email input in client registration popup == CRM path: /clients ==
    And Click on [Submit] button in client registration popup == CRM path: /clients ==
    And I show success label user create == CRM path: /clients ==
    And In success popup label contain email "<email-client>" == CRM path: /clients ==
    And In success popup label contain password == CRM path: /clients ==
    And Press [Close button] == CRM path: /clients ==
    And Refresh page
    And Click on email "<email-client>" in clients table == CRM path: /clients ==
    And Check on Overview Client Page == CRM path: /clients ==
    And Check that Login credentials contains Default email "<email-client>" == CRM path: users/{id}/overview ==
    And Check that Personal info contains Date of birth "01 / 01 / 1970" == CRM path: users/{id}/overview ==
    Examples:
      | email-client   |
      | ta@mail.com    |
      | ta123@mail.com |
