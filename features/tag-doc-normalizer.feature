Feature: TagDocNormalizer

  Scenario: Simple tag normalization
    Given I have a TagDoc named "tagA"
    When I normalize tag
    Then I should have following normalized tag:
    """
    {
      "name": "tagA"
    }
    """

  Scenario: Tag normalization with description
    Given I have a TagDoc named "tag-b" with following description:
    """
    tag-b description
    """
    When I normalize tag
    Then I should have following normalized tag:
    """
    {
      "name": "tag-b",
      "description": "tag-b description"
    }
    """
