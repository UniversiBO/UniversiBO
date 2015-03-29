Feature: Login
    In order to use my custom settings
    As registered user
    I need to login

    Scenario Outline: Successful login
        Given I'm not logged in
        When I follow "Login"
        And I fill in "username" with "<username>"
        And I fill in "password" with "padrino"
        And I press "Login"
        Then the response should contain "Benvenuto <username>"
        And the response should contain "Il tuo livello di utenza è <level>"

    Examples:
        | username  | level                 |
        | moderator | Collaboratore         |
        | student   | Studente              |
        | professor | Docente               |
        | tutor     | Tutor                 |
        | staff     | Personale non docente |
