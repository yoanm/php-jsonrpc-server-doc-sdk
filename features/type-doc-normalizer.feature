Feature: TypeDocNormalizer

  Scenario: Simple type normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc"
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "type": "string",
      "nullable": true,
      "required": false
    }
    """

  Scenario: Fully configured type normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["type-b"]},
      {"method": "setDescription", "arguments": ["type-b-description"]},
      {"method": "setDefault", "arguments": ["type-b-default"]},
      {"method": "setExample", "arguments": ["type-b-example"]},
      {"method": "setRequired", "arguments": [true]},
      {"method": "setNullable", "arguments": [false]},
      {"method": "addAllowedValue", "arguments": ["type-b-allowed-value-a"]},
      {"method": "addAllowedValue", "arguments": ["type-b-allowed-value-b"]}
    ]
    """
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "description": "type-b-description",
      "type": "string",
      "nullable": false,
      "required": true,
      "default": "type-b-default",
      "example": "type-b-example",
      "allowed_values": ["type-b-allowed-value-a", "type-b-allowed-value-b"]
    }
    """

  Scenario: Simple scalar normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\ScalarDoc"
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "type": "scalar",
      "nullable": true,
      "required": false
    }
    """

  Scenario: Fully configured scalar normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\ScalarDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["type-b"]},
      {"method": "setDescription", "arguments": ["type-b-description"]},
      {"method": "setDefault", "arguments": ["type-b-default"]},
      {"method": "setExample", "arguments": ["type-b-example"]},
      {"method": "setRequired", "arguments": [true]},
      {"method": "setNullable", "arguments": [false]},
      {"method": "addAllowedValue", "arguments": ["type-b-allowed-value-a"]},
      {"method": "addAllowedValue", "arguments": ["type-b-allowed-value-b"]}
    ]
    """
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "description": "type-b-description",
      "type": "scalar",
      "nullable": false,
      "required": true,
      "default": "type-b-default",
      "example": "type-b-example",
      "allowed_values": ["type-b-allowed-value-a", "type-b-allowed-value-b"]
    }
    """

  Scenario: Simple boolean normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\BooleanDoc"
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "type": "boolean",
      "nullable": true,
      "required": false
    }
    """

  Scenario: Fully configured boolean normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\BooleanDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["type-b"]},
      {"method": "setDescription", "arguments": ["type-b-description"]},
      {"method": "setDefault", "arguments": [true]},
      {"method": "setExample", "arguments": [true]},
      {"method": "setRequired", "arguments": [true]},
      {"method": "setNullable", "arguments": [false]},
      {"method": "addAllowedValue", "arguments": [true]},
      {"method": "addAllowedValue", "arguments": [false]}
    ]
    """
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "description": "type-b-description",
      "type": "boolean",
      "nullable": false,
      "required": true,
      "default": true,
      "example": true,
      "allowed_values": [true, false]
    }
    """

  Scenario: Simple string normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\StringDoc"
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "type": "string",
      "nullable": true,
      "required": false
    }
    """

  Scenario: Fully configured string normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\StringDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["type-b"]},
      {"method": "setDescription", "arguments": ["type-b-description"]},
      {"method": "setDefault", "arguments": ["type-b-default"]},
      {"method": "setExample", "arguments": ["type-b-example"]},
      {"method": "setRequired", "arguments": [true]},
      {"method": "setNullable", "arguments": [false]},
      {"method": "addAllowedValue", "arguments": ["type-b-allowed-value-a"]},
      {"method": "addAllowedValue", "arguments": ["type-b-allowed-value-b"]},
      {"method": "setFormat", "arguments": ["type-b-format"]},
      {"method": "setMinLength", "arguments": [2]},
      {"method": "setMaxLength", "arguments": [5]}
    ]
    """
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "description": "type-b-description",
      "type": "string",
      "nullable": false,
      "required": true,
      "default": "type-b-default",
      "example": "type-b-example",
      "format": "type-b-format",
      "allowed_values": ["type-b-allowed-value-a", "type-b-allowed-value-b"],
      "min_length": 2,
      "max_length": 5
    }
    """

  Scenario: Simple number normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\NumberDoc"
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "type": "number",
      "nullable": true,
      "required": false
    }
    """

  Scenario: Fully configured number normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\NumberDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["type-b"]},
      {"method": "setDescription", "arguments": ["type-b-description"]},
      {"method": "setDefault", "arguments": [2]},
      {"method": "setExample", "arguments": [5]},
      {"method": "setRequired", "arguments": [true]},
      {"method": "setNullable", "arguments": [false]},
      {"method": "addAllowedValue", "arguments": [1]},
      {"method": "addAllowedValue", "arguments": [2]},
      {"method": "addAllowedValue", "arguments": [3]},
      {"method": "addAllowedValue", "arguments": [4]},
      {"method": "addAllowedValue", "arguments": [5]},
      {"method": "setMin", "arguments": [3]},
      {"method": "setMax", "arguments": [6]},
      {"method": "setInclusiveMin", "arguments": [false]},
      {"method": "setInclusiveMax", "arguments": [false]}
    ]
    """
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "description": "type-b-description",
      "type": "number",
      "nullable": false,
      "required": true,
      "default": 2,
      "example": 5,
      "allowed_values": [1, 2, 3, 4, 5],
      "minimum": 3,
      "inclusive_minimum": false,
      "maximum": 6,
      "inclusive_maximum": false
    }
    """

  Scenario: Simple integer normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\IntegerDoc"
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "type": "integer",
      "nullable": true,
      "required": false
    }
    """

  Scenario: Fully configured integer normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\IntegerDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["type-b"]},
      {"method": "setDescription", "arguments": ["type-b-description"]},
      {"method": "setDefault", "arguments": [2]},
      {"method": "setExample", "arguments": [5]},
      {"method": "setRequired", "arguments": [true]},
      {"method": "setNullable", "arguments": [false]},
      {"method": "addAllowedValue", "arguments": [1]},
      {"method": "addAllowedValue", "arguments": [2]},
      {"method": "addAllowedValue", "arguments": [3]},
      {"method": "addAllowedValue", "arguments": [4]},
      {"method": "addAllowedValue", "arguments": [5]},
      {"method": "setMin", "arguments": [3]},
      {"method": "setMax", "arguments": [6]},
      {"method": "setInclusiveMin", "arguments": [false]},
      {"method": "setInclusiveMax", "arguments": [false]}
    ]
    """
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "description": "type-b-description",
      "type": "integer",
      "nullable": false,
      "required": true,
      "default": 2,
      "example": 5,
      "allowed_values": [1, 2, 3, 4, 5],
      "minimum": 3,
      "inclusive_minimum": false,
      "maximum": 6,
      "inclusive_maximum": false
    }
    """

  Scenario: Simple float normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\FloatDoc"
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "type": "float",
      "nullable": true,
      "required": false
    }
    """

  Scenario: Fully configured float normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\FloatDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["type-b"]},
      {"method": "setDescription", "arguments": ["type-b-description"]},
      {"method": "setDefault", "arguments": [2.4]},
      {"method": "setExample", "arguments": [5.8]},
      {"method": "setRequired", "arguments": [true]},
      {"method": "setNullable", "arguments": [false]},
      {"method": "addAllowedValue", "arguments": [1]},
      {"method": "addAllowedValue", "arguments": [2.4]},
      {"method": "addAllowedValue", "arguments": [5.8]},
      {"method": "setMin", "arguments": [3]},
      {"method": "setMax", "arguments": [6]},
      {"method": "setInclusiveMin", "arguments": [false]},
      {"method": "setInclusiveMax", "arguments": [false]}
    ]
    """
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "description": "type-b-description",
      "type": "float",
      "nullable": false,
      "required": true,
      "default": 2.4,
      "example": 5.8,
      "allowed_values": [1, 2.4, 5.8],
      "minimum": 3,
      "inclusive_minimum": false,
      "maximum": 6,
      "inclusive_maximum": false
    }
    """

  Scenario: Simple collection normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\CollectionDoc"
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "type": "collection",
      "nullable": true,
      "required": false
    }
    """

  Scenario: Fully configured collection normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\CollectionDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["type-b"]},
      {"method": "setDescription", "arguments": ["type-b-description"]},
      {"method": "setDefault", "arguments": [["default"]]},
      {"method": "setExample", "arguments": [["example"]]},
      {"method": "setRequired", "arguments": [true]},
      {"method": "setNullable", "arguments": [false]},
      {"method": "addAllowedValue", "arguments": [["type-b-allowed-value-a"]]},
      {"method": "addAllowedValue", "arguments": [["type-b-allowed-value-b"]]},
      {"method": "setMinItem", "arguments": [2]},
      {"method": "setMaxItem", "arguments": [8]},
      {"method": "setAllowExtraSibling", "arguments": [true]},
      {"method": "setAllowMissingSibling", "arguments": [true]}

    ]
    """
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "description": "type-b-description",
      "type": "collection",
      "nullable": false,
      "required": true,
      "default": ["default"],
      "example": ["example"],
      "allowed_values": [["type-b-allowed-value-a"], ["type-b-allowed-value-b"]],
      "min_item": 2,
      "max_item": 8,
      "allow_extra": true,
      "allow_missing": true
    }
    """

  Scenario: Simple array normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\ArrayDoc"
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "type": "array",
      "nullable": true,
      "required": false
    }
    """

  Scenario: Fully configured array normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\ArrayDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["type-b"]},
      {"method": "setDescription", "arguments": ["type-b-description"]},
      {"method": "setDefault", "arguments": [["default"]]},
      {"method": "setExample", "arguments": [["example"]]},
      {"method": "setRequired", "arguments": [true]},
      {"method": "setNullable", "arguments": [false]},
      {"method": "addAllowedValue", "arguments": [["type-b-allowed-value-a"]]},
      {"method": "addAllowedValue", "arguments": [["type-b-allowed-value-b"]]},
      {"method": "setMinItem", "arguments": [2]},
      {"method": "setMaxItem", "arguments": [8]},
      {"method": "setAllowExtraSibling", "arguments": [true]},
      {"method": "setAllowMissingSibling", "arguments": [true]}

    ]
    """
    And last TypeDoc will have a scalar item validation
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "description": "type-b-description",
      "type": "array",
      "nullable": false,
      "required": true,
      "default": ["default"],
      "example": ["example"],
      "item_validation": {
        "type": "scalar",
        "nullable": true,
        "required": false
      },
      "allowed_values": [["type-b-allowed-value-a"], ["type-b-allowed-value-b"]],
      "min_item": 2,
      "max_item": 8,
      "allow_extra": true,
      "allow_missing": true
    }
    """

  Scenario: Simple object normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\ObjectDoc"
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "type": "object",
      "nullable": true,
      "required": false
    }
    """

  Scenario: Fully configured object normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\ObjectDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["type-b"]},
      {"method": "setDescription", "arguments": ["type-b-description"]},
      {"method": "setDefault", "arguments": [["default"]]},
      {"method": "setExample", "arguments": [["example"]]},
      {"method": "setRequired", "arguments": [true]},
      {"method": "setNullable", "arguments": [false]},
      {"method": "addAllowedValue", "arguments": [["type-b-allowed-value-a"]]},
      {"method": "addAllowedValue", "arguments": [["type-b-allowed-value-b"]]},
      {"method": "setMinItem", "arguments": [2]},
      {"method": "setMaxItem", "arguments": [8]},
      {"method": "setAllowExtraSibling", "arguments": [true]},
      {"method": "setAllowMissingSibling", "arguments": [true]}

    ]
    """
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "description": "type-b-description",
      "type": "object",
      "nullable": false,
      "required": true,
      "default": ["default"],
      "example": ["example"],
      "allowed_values": [["type-b-allowed-value-a"], ["type-b-allowed-value-b"]],
      "min_item": 2,
      "max_item": 8,
      "allow_extra": true,
      "allow_missing": true
    }
    """
