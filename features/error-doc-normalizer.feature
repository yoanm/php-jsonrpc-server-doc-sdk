Feature: ErrorDocNormalizer

  Scenario: Simple error normalization
    Given I have an ErrorDoc named "error A" with code 123
    When I normalize error
    Then I should have following normalized error:
    """
    {
      "id": "ErrorA123",
      "title": "error A",
      "type": "object",
      "properties": {
        "code": 123
      }
    }
    """

  Scenario: Fully configured error normalization
    Given I have an ErrorDoc named "error B" with code 456 and following calls:
    """
    [
      {"method": "setMessage", "arguments": ["error-message"]},
      {"method": "setIdentifier", "arguments": ["error identifier-test"]}
    ]
    """
    When I normalize error
    Then I should have following normalized error:
    """
    {
      "id": "ErrorIdentifier-test",
      "title": "error B",
      "type": "object",
      "properties": {
        "code": 456,
        "message": "error-message"
      }
    }
    """
