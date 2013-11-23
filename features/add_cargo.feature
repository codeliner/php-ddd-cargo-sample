Feature: Add a Cargo
    In order to ship a Cargo
    As a booking manager
    I need to be able to add a new Cargo

@javascript
Scenario: Add a new Cargo
    Given I am on "application/cargo/add"
    When I fill in "size" with "12"
    And I click the submit button
    Then the url should match "application/cargo/index"