Feature: Book new Cargo
    In order to manage a transport of a Cargo
    As a booking manager
    I need to be able to book the Cargo on a Voyage with enough free capacity

@javascript
Scenario: Add a Cargo
    Given I am on "application/cargo/add"
    When I fill in "size" with "40"
    And I click the submit button
    Then the url should match "application/cargo/index"

@javascript
Scenario: Add a Voyage with low capacity
    Given I am on "application/voyage/add"
    When I fill in "voyage_number" with "LOW123"
    And I fill in "name" with "Low Voyage"
    And I fill in "capacity" with "30"
    And I click the submit button
    Then the url should match "application/voyage/index"

@javascript
Scenario: Add a Voyage with high capacity
    Given I am on "application/voyage/add"
    When I fill in "voyage_number" with "HIGH123"
    And I fill in "name" with "High Voyage"
    And I fill in "capacity" with "100"
    And I click the submit button
    Then the url should match "application/voyage/index"

@javascript
Scenario: Try to book Cargo on Voyage with not enough capacity
    Given I am on "application/cargo/index"
    When I click on first item in the list "cargo-list"
    And I wait until I am on page "application/cargo/show"
    And I select "LOW123" from "voyage_number"
    And I click the submit button
    Then the url should match "application/booking/booking"
    And the response should contain "Voyage [LOW123] has not enough capacity"

@javascript
Scenario: Book Cargo on Voyage with enough capacity
    Given I am on "application/cargo/index"
    When I click on first item in the list "cargo-list"
    And I wait until I am on page "application/cargo/show"
    And I select "HIGH123" from "voyage_number"
    And I click the submit button
    Then the url should match "application/booking/booking"
    And the response should contain "Cargo was successfully booked"