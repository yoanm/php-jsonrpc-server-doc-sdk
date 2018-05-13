<?php
namespace Yoanm\JsonRpcServerDoc\Model;

/**
 * Class JsonRpcParamDoc
 */
class JsonRpcParamDocBackup
{
    const TYPE_SCALAR = 'scalar';
    const TYPE_STRING = 'string';
    const TYPE_BOOL = 'bool';
    const TYPE_FLOAT = 'float';
    const TYPE_INT = 'int';
    const TYPE_ARRAY = 'array';
    const TYPE_OBJECT = 'object';

    public static $allowedTypeList = [
        self::TYPE_SCALAR,
        self::TYPE_STRING,
        self::TYPE_BOOL,
        self::TYPE_FLOAT,
        self::TYPE_INT,
        self::TYPE_ARRAY,
        self::TYPE_OBJECT,
    ];

    /** @var null|string|integer */
    private $name = null;
    /** @var null|string */
    private $type;

    /** @var bool */
    private $required = false;
    /** @var null|bool */
    private $nullable = null;

    /** @var null|bool */
    private $blankAllowed = null;
    /** @var null|string */
    private $format = null;


    /** @var JsonRpcParamDoc[] */
    private $validItemList = [];
    /** @var bool */
    private $allOfValidItemList = false;

    /** @var JsonRpcParamDoc[] */
    private $siblingList = [];
    /** @var bool */
    private $allowExtraSibling = true;
    /** @var bool */
    private $allowMissingSibling = true;



    /** @var null|mixed */
    private $expectedValue;

    /**
     * @param bool|false $isRoot
     */
    public function __construct(bool $isRoot = false)
    {
        $this->isRoot = $isRoot;
    }

    /**
     * @param string|null $type
     *
     * @return JsonRpcParamDoc
     */
    public function setType($type) : JsonRpcParamDoc
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param null|string|integer $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param bool $required
     *
     * @return JsonRpcParamDoc
     */
    public function setRequired(bool $required) : JsonRpcParamDoc
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @param bool $nullable
     *
     * @return JsonRpcParamDoc
     */
    public function setNullable(bool $nullable) : JsonRpcParamDoc
    {
        $this->nullable = $nullable;

        return $this;
    }

    /**
     * @param bool $blankAllowed
     *
     * @return JsonRpcParamDoc
     */
    public function setBlankAllowed(bool $blankAllowed) : JsonRpcParamDoc
    {
        $this->blankAllowed = $blankAllowed;

        return $this;
    }

    /**
     * @param boolean $allOfValidItemList
     */
    public function setAllOfValidItemList(bool $allOfValidItemList)
    {
        $this->allOfValidItemList = $allOfValidItemList;
    }

    /**
     * @param mixed|null $expectedValue
     */
    public function setExpectedValue($expectedValue)
    {
        $this->expectedValue = $expectedValue;
    }

    /**
     * @param null $min
     */
    public function setMin($min)
    {
        $this->min = $min;
    }

    /**
     * @param null $max
     */
    public function setMax($max)
    {
        $this->max = $max;
    }

    /**
     * @param boolean $inclusiveMax
     */
    public function setInclusiveMax($inclusiveMax)
    {
        $this->inclusiveMax = $inclusiveMax;
    }

    /**
     * @param boolean $inclusiveMin
     */
    public function setInclusiveMin($inclusiveMin)
    {
        $this->inclusiveMin = $inclusiveMin;
    }

    /**
     * @param null $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @param boolean $allowExtraSibling
     */
    public function setAllowExtraSibling(bool $allowExtraSibling)
    {
        $this->allowExtraSibling = $allowExtraSibling;
    }

    /**
     * @param boolean $allowMissingSibling
     */
    public function setAllowMissingSibling(bool $allowMissingSibling)
    {
        $this->allowMissingSibling = $allowMissingSibling;
    }

    /**
     * @param JsonRpcParamDoc $doc
     */
    public function addSibling(JsonRpcParamDoc $doc)
    {
        $this->siblingList[] = $doc;
    }

    /**
     * @param JsonRpcParamDoc $validItem
     */
    public function addValidItem(JsonRpcParamDoc $validItem)
    {
        $this->validItemList[] = $validItem;
    }

    /**
     * @param mixed|null $default
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }

    /**
     * @param mixed|null $example
     */
    public function setExample($example)
    {
        $this->example = $example;
    }

    /**
     * @return bool
     */
    public function isRoot()
    {
        return $this->isRoot;
    }

    /**
     * @return null|string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int|null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return boolean
     */
    public function isRequired() : bool
    {
        return $this->required;
    }

    /**
     * @return bool|null
     */
    public function isNullable()
    {
        return $this->nullable;
    }

    /**
     * @return bool|null
     */
    public function isBlankAllowed()
    {
        return $this->blankAllowed;
    }

    /**
     * @return null
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @return null
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @return boolean
     */
    public function isInclusiveMin()
    {
        return $this->inclusiveMin;
    }

    /**
     * @return boolean
     */
    public function isInclusiveMax()
    {
        return $this->inclusiveMax;
    }

    /**
     * @return null
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return JsonRpcParamDoc[]
     */
    public function getSiblingList()
    {
        return $this->siblingList;
    }

    /**
     * @return mixed|null
     */
    public function getExpectedValue()
    {
        return $this->expectedValue;
    }

    /**
     * @return boolean
     */
    public function isAllowExtraSibling()
    {
        return $this->allowExtraSibling;
    }

    /**
     * @return boolean
     */
    public function isAllowMissingSibling()
    {
        return $this->allowMissingSibling;
    }

    /**
     * @return boolean
     */
    public function isAllOfValidItemList()
    {
        return $this->allOfValidItemList;
    }

    /**
     * @return JsonRpcParamDoc[]
     */
    public function getValidItemList()
    {
        return $this->validItemList;
    }

    /**
     * @return mixed|null
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @return mixed|null
     */
    public function getExample()
    {
        return $this->example;
    }
}
