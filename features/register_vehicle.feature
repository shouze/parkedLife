Feature: Register vehicle

    In order to follow many vehicles with my application
    As an application user
    I should be able to register my vehicle

    @critical
    Scenario: Successfully registring of a vehicle
        When I register my vehicle with platenumber "123 DE 456" described as "My sport car" in my vehicle fleet
        Then print response
        Then the vehicle with platenumber "123 DE 456" should be part of my vehicle fleet
