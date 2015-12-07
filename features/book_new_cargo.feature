Feature: Book new Cargo
    In order to manage a transport of a Cargo
    As a booking clerk
    I need to define an origin and a destination of a Cargo and assign it to a proper route

@javascript
Scenario: Add a Cargo and assign route
    Given I am on "/#booking"
    Then I should wait until I see "#book-cargo"
    When I follow "book-cargo"
    And I select "DEHAM" from "origin"
    And I select "USNYC" from "final_destination"
    And I click the submit button
    Then I should wait until I see "#route-candidate-list"
    When I follow first ".assign-cargo-btn" link
    Then I should wait until I see "#cargo-list"
    When I click on first item in the list "#cargo-list"
    Then I should see 1 ".itinerary" elements
