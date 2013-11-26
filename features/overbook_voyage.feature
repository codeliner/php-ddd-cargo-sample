Feature: Book new Cargo
    In order to overbook a Voyage
    As a booking manager
    I need to be able to book a Cargo that has a 10 percent larger size than the capacity of the Voyage

@javascript
Scenario: Add a Cargo
    Given I am on "application/cargo/add"
    When I fill in "size" with "110"
    And I click the submit button
    Then the url should match "application/cargo/index"

@javascript
Scenario: Add a Voyage with low capacity
    Given I am on "application/voyage/add"
    When I fill in "voyage_number" with "SHIP123"
    And I fill in "name" with "Low Voyage"
    And I fill in "capacity" with "100"
    And I click the submit button
    Then the url should match "application/voyage/index"

@javascript
Scenario: Book Cargo on Voyage even though Voyage has not enough free capacity
    Given I am on "application/cargo/index"
    When I click on first item in the list "cargo-list"
    And I wait until I am on page "application/cargo/show"
    And I select "SHIP123" from "voyage_number"
    And I click the submit button
    Then the url should match "application/booking/booking"
    And the response should contain "Cargo was successfully booked"