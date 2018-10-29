Feature: TypeDocNormalizer

  Scenario: Fully configured type normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["my-type-name"]},
      {"method": "setDescription", "arguments": ["my-type-description"]},
      {"method": "setDefault", "arguments": ["my-type-default"]},
      {"method": "setExample", "arguments": ["my-type-example"]},
      {"method": "setRequired", "arguments": [true]},
      {"method": "setNullable", "arguments": [false]},
      {"method": "addAllowedValue", "arguments": ["my-type-allowed-value-a"]},
      {"method": "addAllowedValue", "arguments": ["my-type-allowed-value-b"]}
    ]
    """
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "description": "my-type-description",
      "type": "string",
      "nullable": false,
      "required": true,
      "default": "my-type-default",
      "example": "my-type-example",
      "allowedValues": ["my-type-allowed-value-a", "my-type-allowed-value-b"]
    }
    """

  Scenario: Fully configured scalar normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\ScalarDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["my-type-name"]},
      {"method": "setDescription", "arguments": ["my-type-description"]},
      {"method": "setDefault", "arguments": ["my-type-default"]},
      {"method": "setExample", "arguments": ["my-type-example"]},
      {"method": "setRequired", "arguments": [true]},
      {"method": "setNullable", "arguments": [false]},
      {"method": "addAllowedValue", "arguments": ["my-type-allowed-value-a"]},
      {"method": "addAllowedValue", "arguments": ["my-type-allowed-value-b"]}
    ]
    """
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "description": "my-type-description",
      "type": "scalar",
      "nullable": false,
      "required": true,
      "default": "my-type-default",
      "example": "my-type-example",
      "allowedValues": ["my-type-allowed-value-a", "my-type-allowed-value-b"]
    }
    """

  Scenario: Fully configured boolean normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\BooleanDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["my-type-name"]},
      {"method": "setDescription", "arguments": ["my-type-description"]},
      {"method": "setDefault", "arguments": [true]},
      {"method": "setExample", "arguments": [true]},
      {"method": "setRequired", "arguments": [true]},
      {"method": "setNullable", "arguments": [false]},
      {"method": "addAllowedValue", "arguments": [true]}
    ]
    """
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "description": "my-type-description",
      "type": "boolean",
      "nullable": false,
      "required": true,
      "default": true,
      "example": true,
      "allowedValues": [true]
    }
    """

  Scenario: Fully configured string normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\StringDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["my-type-name"]},
      {"method": "setDescription", "arguments": ["my-type-description"]},
      {"method": "setDefault", "arguments": ["my-type-default"]},
      {"method": "setExample", "arguments": ["my-type-example"]},
      {"method": "setRequired", "arguments": [true]},
      {"method": "setNullable", "arguments": [false]},
      {"method": "addAllowedValue", "arguments": ["my-type-allowed-value-a"]},
      {"method": "addAllowedValue", "arguments": ["my-type-allowed-value-b"]},
      {"method": "setFormat", "arguments": ["my-type-format"]},
      {"method": "setMinLength", "arguments": [2]},
      {"method": "setMaxLength", "arguments": [5]}
    ]
    """
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "description": "my-type-description",
      "type": "string",
      "nullable": false,
      "required": true,
      "default": "my-type-default",
      "example": "my-type-example",
      "format": "my-type-format",
      "allowedValues": ["my-type-allowed-value-a", "my-type-allowed-value-b"],
      "minLength": 2,
      "maxLength": 5
    }
    """

  Scenario: Fully configured number normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\NumberDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["my-type-name"]},
      {"method": "setDescription", "arguments": ["my-type-description"]},
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
      "description": "my-type-description",
      "type": "number",
      "nullable": false,
      "required": true,
      "default": 2,
      "example": 5,
      "allowedValues": [1, 2, 3, 4, 5],
      "minimum": 3,
      "inclusiveMinimum": false,
      "maximum": 6,
      "inclusiveMaximum": false
    }
    """

  Scenario: Fully configured integer normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\IntegerDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["my-type-name"]},
      {"method": "setDescription", "arguments": ["my-type-description"]},
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
      "description": "my-type-description",
      "type": "integer",
      "nullable": false,
      "required": true,
      "default": 2,
      "example": 5,
      "allowedValues": [1, 2, 3, 4, 5],
      "minimum": 3,
      "inclusiveMinimum": false,
      "maximum": 6,
      "inclusiveMaximum": false
    }
    """

  Scenario: Fully configured float normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\FloatDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["my-type-name"]},
      {"method": "setDescription", "arguments": ["my-type-description"]},
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
      "description": "my-type-description",
      "type": "float",
      "nullable": false,
      "required": true,
      "default": 2.4,
      "example": 5.8,
      "allowedValues": [1, 2.4, 5.8],
      "minimum": 3,
      "inclusiveMinimum": false,
      "maximum": 6,
      "inclusiveMaximum": false
    }
    """

  Scenario: Fully configured collection normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\CollectionDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["my-type-name"]},
      {"method": "setDescription", "arguments": ["my-type-description"]},
      {"method": "setDefault", "arguments": [["default"]]},
      {"method": "setExample", "arguments": [["example"]]},
      {"method": "setRequired", "arguments": [true]},
      {"method": "setNullable", "arguments": [false]},
      {"method": "addAllowedValue", "arguments": [["my-type-allowed-value-a"]]},
      {"method": "addAllowedValue", "arguments": [["my-type-allowed-value-b"]]},
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
      "description": "my-type-description",
      "type": "collection",
      "nullable": false,
      "required": true,
      "default": ["default"],
      "example": ["example"],
      "allowedValues": [["my-type-allowed-value-a"], ["my-type-allowed-value-b"]],
      "minItem": 2,
      "maxItem": 8,
      "allowExtra": true,
      "allowMissing": true
    }
    """

  Scenario: Fully configured array normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\ArrayDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["my-type-name"]},
      {"method": "setDescription", "arguments": ["my-type-description"]},
      {"method": "setDefault", "arguments": [["default"]]},
      {"method": "setExample", "arguments": [["example"]]},
      {"method": "setRequired", "arguments": [true]},
      {"method": "setNullable", "arguments": [false]},
      {"method": "addAllowedValue", "arguments": [["my-type-allowed-value-a"]]},
      {"method": "addAllowedValue", "arguments": [["my-type-allowed-value-b"]]},
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
      "description": "my-type-description",
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
      "allowedValues": [["my-type-allowed-value-a"], ["my-type-allowed-value-b"]],
      "minItem": 2,
      "maxItem": 8,
      "allowExtra": true,
      "allowMissing": true
    }
    """

  Scenario: Fully configured object normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\ObjectDoc" with following calls:
    """
    [
      {"method": "setName", "arguments": ["my-type-name"]},
      {"method": "setDescription", "arguments": ["my-type-description"]},
      {"method": "setDefault", "arguments": [["default"]]},
      {"method": "setExample", "arguments": [["example"]]},
      {"method": "setRequired", "arguments": [true]},
      {"method": "setNullable", "arguments": [false]},
      {"method": "addAllowedValue", "arguments": [{"key": "my-type-allowed-value-a"}]},
      {"method": "addAllowedValue", "arguments": [{"key": "my-type-allowed-value-b"}]},
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
      "description": "my-type-description",
      "type": "object",
      "nullable": false,
      "required": true,
      "default": ["default"],
      "example": ["example"],
      "allowedValues": [{"key": "my-type-allowed-value-a"}, {"key": "my-type-allowed-value-b"}],
      "minItem": 2,
      "maxItem": 8,
      "allowExtra": true,
      "allowMissing": true
    }
    """
