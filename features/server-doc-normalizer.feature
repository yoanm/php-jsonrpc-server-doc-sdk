Feature: ServerDocNormalizer

  Scenario: Simple server normalization
    Given I have a ServerDoc with following calls:
    """
    [
      {"method": "setName", "arguments": ["my-server"]}
    ]
    """
    When I normalize server
    Then I should have following normalized server:
    """
    {
      "info": {
        "name": "my-server"
      },
      "methods": []
    }
    """

  Scenario: Server methods list normalization
    Given I have a ServerDoc
    And I have a MethodDoc with name "method-a" and following calls:
    """
    [
      {"method": "setDescription", "arguments": ["description-method-a"]}
    ]
    """
    And I append last method doc to server doc
    And I have a MethodDoc with name "method-b" and following calls:
    """
    [
      {"method": "addGlobalErrorRef", "arguments": ["global-error-a"]}
    ]
    """
    And I append last method doc to server doc
    And I have a MethodDoc with name "method-c"
    And I append last method doc to server doc
    When I normalize server
    Then I should have following normalized server:
    """
    {
      "methods": [
        {
          "identifier": "Method-a",
          "name": "method-a",
          "description": "description-method-a"
        },
        {
          "identifier": "Method-b",
          "name": "method-b",
          "errors": [
            {
              "$ref": "#/errors/global-error-a"
            }
          ]
        },
        {
          "identifier": "Method-c",
          "name": "method-c"
        }
      ]
    }
    """

  Scenario: Server tag list normalization
    Given I have a ServerDoc
    And I have a TagDoc named "tag-a" with following description:
    """
    description-tag-a
    """
    And I append last tag doc to server doc
    And I have a TagDoc named "tag-b"
    And I append last tag doc to server doc
    When I normalize server
    Then I should have following normalized server:
    """
    {
      "tags": [
        {
          "name": "tag-a",
          "description": "description-tag-a"
        },
        {
          "name": "tag-b"
        }
      ],
      "methods": []
    }
    """

  Scenario: Server error list normalization
    Given I have a ServerDoc
    And I have an ErrorDoc named "error-a" with code 123, message "message-error-a" and following calls:
    """
     [
      {"method": "setIdentifier", "arguments": ["error-a-id"]}
    ]
    """
    And I append last error doc to server errors
    And I have an ErrorDoc named "error-b" with code 321, message "message-error-b" and following calls:
    """
     [
      {"method": "setIdentifier", "arguments": ["error-b-id"]}
    ]
    """
    And I append last error doc to server errors
    When I normalize server
    Then I should have following normalized server:
    """
    {
      "methods": [],
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

  Scenario: Server global error list normalization
    Given I have a ServerDoc
    And I have an ErrorDoc named "global-error-a" with code 567, message "message-global-error-a" and following calls:
    """
     [
      {"method": "setIdentifier", "arguments": ["global-error-a-id"]}
    ]
    """
    And I append last error doc to global server errors
    And I have an ErrorDoc named "global-error-b" with code 987, message "message-global-error-b" and following calls:
    """
     [
      {"method": "setIdentifier", "arguments": ["global-error-b-id"]}
    ]
    """
    And I append last error doc to global server errors
    When I normalize server
    Then I should have following normalized server:
    """
    {
      "methods": [],
      "errors": [
        {
          "id": "Global-error-a-id",
          "title": "global-error-a",
          "type": "object",
          "properties": {
            "code": 567,
            "message": "message-global-error-a"
          }
        },
        {
          "id": "Global-error-b-id",
          "title": "global-error-b",
          "type": "object",
          "properties": {
            "code": 987,
            "message": "message-global-error-b"
          }
        }
      ]
    }
    """

  Scenario: Fully described Server normalization
    Given I have a ServerDoc with following calls:
    """
    [
      {"method": "setName", "arguments": ["my-server-2"]},
      {"method": "setVersion", "arguments": ["4.2.6"]}
    ]
    """
    And I have a MethodDoc with name "method-a" and following calls:
    """
    [
      {"method": "setDescription", "arguments": ["description-method-a"]}
    ]
    """
    And I append last method doc to server doc
    And I have a MethodDoc with name "method-b" and following calls:
    """
    [
      {"method": "addGlobalErrorRef", "arguments": ["global-error-a"]}
    ]
    """
    And I append last method doc to server doc
    And I have a MethodDoc with name "method-c"
    And I append last method doc to server doc
    And I have a TagDoc named "tag-a" with following description:
    """
    description-tag-a
    """
    And I append last tag doc to server doc
    And I have a TagDoc named "tag-b"
    And I append last tag doc to server doc
    And I have an ErrorDoc named "error-a" with code 123, message "message-error-a" and following calls:
    """
     [
      {"method": "setIdentifier", "arguments": ["error-a-id"]}
    ]
    """
    And I append last error doc to server errors
    And I have an ErrorDoc named "error-b" with code 321, message "message-error-b" and following calls:
    """
     [
      {"method": "setIdentifier", "arguments": ["error-b-id"]}
    ]
    """
    And I append last error doc to server errors
    And I have an ErrorDoc named "global-error-a" with code 567, message "message-global-error-a" and following calls:
    """
     [
      {"method": "setIdentifier", "arguments": ["global-error-a-id"]}
    ]
    """
    And I append last error doc to global server errors
    And I have an ErrorDoc named "global-error-b" with code 987, message "message-global-error-b" and following calls:
    """
     [
      {"method": "setIdentifier", "arguments": ["global-error-b-id"]}
    ]
    """
    And I append last error doc to global server errors
    When I normalize server
    Then I should have following normalized server:
    """
    {
      "info": {
        "name": "my-server-2",
        "version": "4.2.6"
      },
      "tags": [
        {
          "name": "tag-a",
          "description": "description-tag-a"
        },
        {
          "name": "tag-b"
        }
      ],
      "methods": [
        {
          "identifier": "Method-a",
          "name": "method-a",
          "description": "description-method-a"
        },
        {
          "identifier": "Method-b",
          "name": "method-b",
          "errors": [
            {
              "$ref": "#/errors/global-error-a"
            }
          ]
        },
        {
          "identifier": "Method-c",
          "name": "method-c"
        }
      ],
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
          "id": "Global-error-a-id",
          "title": "global-error-a",
          "type": "object",
          "properties": {
            "code": 567,
            "message": "message-global-error-a"
          }
        },
        {
          "id": "Global-error-b-id",
          "title": "global-error-b",
          "type": "object",
          "properties": {
            "code": 987,
            "message": "message-global-error-b"
          }
        }
      ]
    }
    """
