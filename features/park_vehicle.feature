Feature: Park vehicle

    In order to not forget where I park my vehicle
    As an application user
    I should be able to store my vehicle location

    Scenario: Successfully parking of a vehicle
        Given I registred my vehicle with platenumber "3456 RT 567"
        When I park my vehicle with platenumber "3456 RT 567" at location "3.123456,2.7890"
        Then the known location of my vehicle "3456 RT 567" should be "3.123456,2.7890"
