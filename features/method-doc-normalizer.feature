Feature: MethodDocNormalizer

  Scenario: Simple method doc normalization
    Given I have a MethodDoc with name "method-a"
    When I normalize method
    Then I should have following normalized method:
    """
    {
      "identifier": "Method-a",
      "name": "method-a"
    }
    """

  Scenario: Method with params documentation
    Given I have a MethodDoc with name "method-b"
    And last MethodDoc will have a string and array params doc
    When I normalize method
    Then I should have following normalized method:
    """
    {
      "identifier": "Method-b",
      "name": "method-b",
      "params": {
        "type": "object",
        "nullable": true,
        "required": true,
        "siblings": {
          "string-val": {
            "type": "string",
            "nullable": true,
            "required": false
          },
          "array-val": {
            "type": "array",
            "nullable": true,
            "required": false
          }
        }
      }
    }
    """

  Scenario: Method with result documentation
    Given I have a MethodDoc with name "method-c"
    And last MethodDoc will have a string and array result doc
    When I normalize method
    Then I should have following normalized method:
    """
    {
      "identifier": "Method-c",
      "name": "method-c",
      "result": {
        "type": "object",
        "nullable": true,
        "required": true,
        "siblings": {
          "string-val": {
            "type": "string",
            "nullable": true,
            "required": false
          },
          "array-val": {
            "type": "array",
            "nullable": true,
            "required": false
          }
        }
      }
    }
    """

  Scenario: Method with custom errors documentation
    Given I have a MethodDoc with name "method-d"
    And last MethodDoc will have a custom errors doc
    When I normalize method
    Then I should have following normalized method:
    """
    {
      "identifier": "Method-d",
      "name": "method-d",
      "errors": [
        {
          "id": "Error-a-id",
          "title": "error-a",
          "type": "object",
          "properties": {
              "code": 123,
              "message": "message-error-a"
          }
        },
        {
          "id": "Error-b-id",
          "title": "error-b",
          "type": "object",
          "properties": {
              "code": 321,
              "message": "message-error-b"
          }
        }
      ]
    }
    """

  Scenario: Fully described method
    Given I have a MethodDoc with name "method-e", identified by "Method-e-Id" and with following calls:
    """
    [
      {"method": "setDescription", "arguments": ["method-e-description"]},
      {"method": "addTag", "arguments": ["method-e-tag-a"]},
      {"method": "addTag", "arguments": ["method-e-tag-b"]},
      {"method": "addGlobalErrorRef", "arguments": ["global-error-a"]}
    ]
    """
    And last MethodDoc will have a string and array params doc
    And last MethodDoc will have a string and array result doc
    And last MethodDoc will have a custom errors doc
    When I normalize method
    Then I should have following normalized method:
    """
    {
      "identifier": "Method-e-Id",
      "name": "method-e",
      "description": "method-e-description",
      "tags": ["method-e-tag-a", "method-e-tag-b"],
      "params": {
        "type": "object",
        "nullable": true,
        "required": true,
        "siblings": {
          "string-val": {
            "type": "string",
            "nullable": true,
            "required": false
          },
          "array-val": {
            "type": "array",
            "nullable": true,
            "required": false
          }
        }
      },
      "result": {
        "type": "object",
        "nullable": true,
        "required": true,
        "siblings": {
          "string-val": {
            "type": "string",
            "nullable": true,
            "required": false
          },
          "array-val": {
            "type": "array",
            "nullable": true,
            "required": false
          }
        }
      },
      "errors": [
        {
          "id": "Error-a-id",
          "title": "error-a",
          "type": "object",
          "properties": {
              "code": 123,
              "message": "message-error-a"
          }
        },
        {
          "id": "Error-b-id",
          "title": "error-b",
          "type": "object",
          "properties": {
              "code": 321,
              "message": "message-error-b"
          }
        },
        {
          "$ref": "#/errors/global-error-a"
        }
      ]
    }
    """
