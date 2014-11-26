Feature: Login
    In order to use my custom settings
    As registered user
    I need to login

    Scenario: Logging in as an Administrator
        Given I'm not logged in
        When I follow "Login"
        And I fill in "username" with "admin"
        And I fill in "password" with "padrino"
        And I press "Login"
        Then the response should contain "Benvenuto admin"
        And the response should contain "Il tuo livello di utenza è Admin"

    Scenario: Logging in as a Moderator
        Given I'm not logged in
        When I follow "Login"
        And I fill in "username" with "moderator"
        And I fill in "password" with "padrino"
        And I press "Login"
        Then the response should contain "Benvenuto moderator"
        And the response should contain "Il tuo livello di utenza è Collaboratore"

    Scenario: Logging in as a Student
        Given I'm not logged in
        When I follow "Login"
        And I fill in "username" with "student"
        And I fill in "password" with "padrino"
        And I press "Login"
        Then the response should contain "Benvenuto student"
        And the response should contain "Il tuo livello di utenza è Studente"

    Scenario: Logging in as a Professor
        Given I'm not logged in
        When I follow "Login"
        And I fill in "username" with "professor"
        And I fill in "password" with "padrino"
        And I press "Login"
        Then the response should contain "Benvenuto professor"
        And the response should contain "Il tuo livello di utenza è Docente"

    Scenario: Logging in as a Tutor
        Given I'm not logged in
        When I follow "Login"
        And I fill in "username" with "tutor"
        And I fill in "password" with "padrino"
        And I press "Login"
        Then the response should contain "Benvenuto tutor"
        And the response should contain "Il tuo livello di utenza è Tutor"

    Scenario: Logging in as a non-teaching staff member
        Given I'm not logged in
        When I follow "Login"
        And I fill in "username" with "staff"
        And I fill in "password" with "padrino"
        And I press "Login"
        Then the response should contain "Benvenuto staff"
        And the response should contain "Il tuo livello di utenza è Personale non docente"
