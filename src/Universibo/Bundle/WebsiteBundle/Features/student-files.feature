Feature: Show students' files
    In order to monitor students' file upload activity
    As administrator
    I need to list all students' files

    Scenario Outline: List
        When I visit "/file/studenti/?order=<code>"
        Then the response should contain "Tutti i Files Studenti presenti su UniversiBO"
        And the response should contain "ordinati per <order>"

    Examples:
        | code | order               |
        | 0    | nome                |
        | 1    | data di inserimento |
        | 2    | voto medio          |
