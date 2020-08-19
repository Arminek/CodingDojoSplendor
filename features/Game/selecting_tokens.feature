Feature: Taking tokens from assortment
    In order to be able to purchase development cards
    As a Merchant
    I want to gather tokens

    Background:
        Given the game has been set up for "jesse@pinkman.com", "walter@white.com", "mike@ehrmantraut.com" and "skyler@white.com" merchants
        And token piles have been set up for them

    @domain
    Scenario Outline: Taking three gem tokens of different color
        Given current turn is for the "jesse@pinkman.com" merchant
        When I take "<colors>" gem tokens
        And I end turn
        Then I should have in my gem sack <colors> gem tokens
        And in token piles should be <onyx> onyx, <ruby> ruby, <sapphire> sapphire, <diamond> diamond, <emerald> emerald gem tokens and <gold> gold tokens
        Examples:
            | colors                 | onyx | ruby | sapphire | diamond | emerald | gold |
            | onyx, ruby, sapphire   | 6    | 6    | 6        | 7       | 7       | 5    |
            | diamond, emerald, ruby | 7    | 6    | 7        | 6       | 6       | 5    |

    @todo
    Scenario Outline: Taking two gem tokens of the same color
        Given current turn is for the "jesse@pinkman.com" merchant
        When I take "<colors>" gem tokens
        And I end turn
        Then I should have in my gem sack <colors> gem tokens
        And in token piles should be <onyx> onyx, <ruby> ruby, <sapphire> sapphire, <diamond> diamond, <emerald> emerald gem tokens and <gold> gold tokens
        Examples:
            | colors             | onyx | ruby | sapphire | diamond | emerald | gold |
            | onyx, onyx         | 5    | 7    | 7        | 7       | 7       | 5    |
            | ruby, ruby         | 7    | 5    | 7        | 7       | 7       | 5    |
            | sapphire, sapphire | 7    | 7    | 5        | 7       | 7       | 5    |
            | diamond, diamond   | 7    | 7    | 7        | 5       | 7       | 5    |
            | emerald, emerald   | 7    | 7    | 7        | 7       | 5       | 5    |

    @todo
    Scenario Outline: Trying to take gem tokens where there is not enough of them
        Given "walter@white.com" has taken <first merchant's gems> gem tokens
        And "mike@ehrmantraut.com" has taken <second merchant's gems> gem tokens
        And "skyler@white.com" has taken <third merchant's gems> gem tokens
        And "jesse@pinkman.com" has taken <fourth merchant's gems> gem tokens
        And current turn is for the "walter@white.com" merchant
        When I try to take <colors>
        Then I should not be able to do that
        And in token piles still should be <onyx> onyx, <ruby> ruby, <sapphire> sapphire, <diamond> diamond, <emerald> emerald gem tokens and <gold> gold tokens
        And I should not be able to end turn
        Examples:
            | colors                  | first merchant's gems | second merchant's gems | third merchant's gems | fourth merchant's gems  | onyx | ruby | sapphire | diamond | emerald | gold |
            | onyx, onyx              | onyx, onyx            | onyx, onyx             | onyx, onyx            | onyx, sapphire, ruby    | 0    | 6    | 6        | 7       | 7       | 5    |
            | ruby, ruby              | ruby, ruby            | ruby, ruby             | ruby, ruby            | onyx, sapphire, ruby    | 6    | 0    | 6        | 7       | 7       | 5    |
            | sapphire, sapphire      | sapphire, sapphire    | sapphire, sapphire     | sapphire, sapphire    | onyx, sapphire, ruby    | 6    | 6    | 0        | 7       | 7       | 5    |
            | diamond, diamond        | diamond, diamond      | diamond, diamond       | diamond, diamond      | diamond, sapphire, ruby | 7    | 6    | 6        | 0       | 7       | 5    |
            | emerald, emerald        | emerald, emerald      | emerald, emerald       | emerald, emerald      | emerald, sapphire, ruby | 7    | 6    | 6        | 7       | 0       | 5    |
            | ruby, ruby              | emerald, emerald      | ruby, ruby             | ruby, ruby            | diamond, sapphire, onyx | 6    | 3    | 6        | 6       | 5       | 5    |
            | sapphire, ruby, emerald | emerald, emerald      | emerald, emerald       | emerald, emerald      | emerald, sapphire, ruby | 7    | 6    | 6        | 7       | 0       | 5    |

    @todo
    Scenario Outline: Cannot end turn if merchant have more then 10 tokens
        Given "walter@white.com" has taken in <first turn>, <second turn> and <third turn> gem tokens
        And current turn is for the "walter@white.com" merchant
        When I take "<colors>" gem tokens
        Then I should have in my gem sack <colors>, <first turn>, <second turn> and <third turn> gem tokens
        And in token piles should be <onyx> onyx, <ruby> ruby, <sapphire> sapphire, <diamond> diamond, <emerald> emerald gem tokens and <gold> gold tokens
        But I should not be able to end turn
        Examples:
            | colors                 | first turn          | second turn            | third turn              | onyx | ruby | sapphire | diamond | emerald | gold |
            | onyx, onyx             | onyx, ruby, emerald | onyx, emerald, diamond | sapphire, diamond, ruby | 3    | 5    | 6        | 5       | 5       | 5    |
            | onyx, emerald, diamond | onyx, ruby, emerald | onyx, emerald, diamond | sapphire, diamond, ruby | 4    | 5    | 6        | 4       | 4       | 5    |

    @todo
    Scenario Outline: Retuning redundant gem tokens
        Given "walter@white.com" has taken in <first turn>, <second turn>, <third turn> and <fourth turn> gem tokens
        And current turn is for the "walter@white.com" merchant
        When I return <colors> gem tokens
        And I end turn
        Then I should have in my gem sack <first turn>, <second turn>, <third turn> and <fourth turn> except <colors> gem tokens
        And in token piles should be <onyx> onyx, <ruby> ruby, <sapphire> sapphire, <diamond> diamond, <emerald> emerald gem tokens and <gold> gold tokens
        Examples:
            | colors           | first turn          | second turn            | third turn              | fourth turn            | onyx | ruby | sapphire | diamond | emerald | gold |
            | ruby             | onyx, ruby, emerald | onyx, emerald, diamond | sapphire, diamond, ruby | onyx, onyx             | 3    | 6    | 6        | 5       | 5       | 5    |
            | diamond, emerald | onyx, ruby, emerald | onyx, emerald, diamond | sapphire, diamond, ruby | onyx, emerald, diamond | 4    | 5    | 6        | 5       | 5       | 5    |

    @todo
    Scenario: Trying to take different color while taking two gem tokens
        Given current turn is for the "walter@white.com" merchant
        When I try to take ruby, sapphire gem tokens
        Then I should not be able to do that
        And in token piles still should be five gold tokens and seven gem tokens
        And I should not be able to end turn

    @todo
    Scenario: Trying to take same color twice while taking three gem tokens
        Given current turn is for the "walter@white.com" merchant
        When I try to take ruby, sapphire and ruby gem tokens
        Then I should not be able to do that
        And in token piles still should be five gold tokens and seven gem tokens
        And I should not be able to end turn

    @todo
    Scenario: Trying to take gem tokens and coin while taking three gem tokens
        Given current turn is for the "walter@white.com" merchant
        When I try to take ruby, sapphire gem tokens and coin
        Then I should not be able to do that
        And in token piles still should befive gold tokens and seven gem tokens
        And I should not be able to end turn

    @todo
    Scenario: Trying to take gem tokens and gold while taking two gem tokens
        Given current turn is for the "walter@white.com" merchant
        When I try to take ruby and coin
        Then I should not be able to do that
        And in token piles still should be five gold tokens and seven gem tokens
        And I should not be able to end turn

    @todo
    Scenario: Trying to take two gold tokens
        Given current turn is for the "walter@white.com" merchant
        When I try to take two gold tokens
        Then I should not be able to do that
        And in token piles still should befive gold tokens and seven gem tokens
        And I should not be able to end turn