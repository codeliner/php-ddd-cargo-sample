Feature: Add a Voyage
    In order to manage a Voyage
    As a booking manager
    I need to be able to add a new Voyage

@javascript
Scenario: Add a new Voyage
    Given I am on "application/voyage/add"
    When I fill in "voyage_number" with "SHIP123"
    And I fill in "name" with "HongkongToHamburg"
    And I fill in "capacity" with "50"
    And I click the submit button
    Then the url should match "application/voyage/index"