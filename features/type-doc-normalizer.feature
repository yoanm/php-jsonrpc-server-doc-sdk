Feature: TypeDocNormalizer

  Scenario: Simple type normalization
    Given I have a TypeDoc of class "Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc"
    When I normalize type
    Then I should have following normalized type:
    """
    {
      "nullable": true,
      "required": false
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
