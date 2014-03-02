Feature: Book new Cargo
    In order to manage a transport of a Cargo
    As a booking clerk
    I need to define an origin and a destination of a Cargo and assign it to a proper itinerary

@javascript
Scenario: Add a Cargo and assign Itinerary
    Given I am on "application/cargo/add"
    When I select "DEHAM" from "origin"
    And I select "USNYC" from "destination"
    And I click the submit button
    And I follow "assign-itinerary-link-1"
    Then the url should match "application/cargo/show/trackingid/[\w-]{36,36}"
    And I should see 1 ".itinerary" elements
