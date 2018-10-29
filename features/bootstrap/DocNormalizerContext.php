<?php
namespace Tests\Functional\BehatContext;

use Behat\Gherkin\Node\PyStringNode;
use PHPUnit\Framework\Assert;
use Yoanm\JsonRpcServerDoc\Domain\Model\ErrorDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\HttpServerDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\MethodDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\ServerDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\TagDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\ArrayDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\ObjectDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\ScalarDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\StringDoc;
use Yoanm\JsonRpcServerDoc\Domain\Model\Type\TypeDoc;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\ErrorDocNormalizer;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\HttpServerDocNormalizer;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\MethodDocNormalizer;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\ServerDocNormalizer;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TagDocNormalizer;
use Yoanm\JsonRpcServerDoc\Infra\Normalizer\TypeDocNormalizer;

class DocNormalizerContext extends AbstractContext
{
    /** @var HttpServerDoc|ServerDoc|null */
    private $serverDoc = null;
    /** @var ErrorDoc|null */
    private $lastErrorDoc = null;
    /** @var MethodDoc|null */
    private $lastMethodDoc = null;
    /** @var TagDoc|null */
    private $lastTagDoc = null;
    /** @var null|array */
    private $lastNormalizedOutput = null;
    /** @var TypeDoc|null */
    private $lastTypeDoc = null;

    /**
     * @Given I have an HttpServerDoc
     * @Given I have an HttpServerDoc with following calls:
     */
    public function givenIHaveAHttpServerDoc(PyStringNode $callList = null)
    {
        $this->serverDoc = new HttpServerDoc();
        $this->callMethods(
            $this->serverDoc,
            (null !== $callList) ? $this->jsonDecode($callList->getRaw()) : []
        );
    }

    /**
     * @Given I have a ServerDoc
     * @Given I have a ServerDoc with following calls:
     */
    public function givenIHaveAServerDoc(PyStringNode $callList = null)
    {
        $this->serverDoc = new ServerDoc();
        $this->callMethods(
            $this->serverDoc,
            (null !== $callList) ? $this->jsonDecode($callList->getRaw()) : []
        );
    }

    /**
     * @Given I have a MethodDoc with name :name
     * @Given I have a MethodDoc with name :name and following calls:
     * @Given I have a MethodDoc with name :name and identified by :identifier
     * @Given I have a MethodDoc with name :name, identified by :identifier and with following calls:
     */
    public function givenIHaveAMethodWithName($name, $identifier = null, PyStringNode $callList = null)
    {
        $this->lastMethodDoc = new MethodDoc($name, $identifier);
        $this->callMethods(
            $this->lastMethodDoc,
            (null !== $callList) ? $this->jsonDecode($callList->getRaw()) : []
        );
    }

    /**
     * @Given I have an ErrorDoc named :title with code :code
     * @Given I have an ErrorDoc named :title with code :code and message :message
     * @Given I have an ErrorDoc named :title with code :code and following calls:
     * @Given I have an ErrorDoc named :title with code :code, message :message and following calls:
     */
    public function givenIHaveAErrorNamed($title, $code, $message = null, PyStringNode $callList = null)
    {
        $this->lastErrorDoc = new ErrorDoc($title, $code, $message);
        $this->callMethods(
            $this->lastErrorDoc,
            (null !== $callList) ? $this->jsonDecode($callList->getRaw()) : []
        );
    }

    /**
     * @Given I have a TagDoc named :name
     * @Given I have a TagDoc named :name with following description:
     */
    public function givenIHaveATagNamed($name, PyStringNode $description = null)
    {
        $this->lastTagDoc = new TagDoc($name);

        if (null !== $description) {
            $this->lastTagDoc->setDescription($description->getRaw());
        }
    }

    /**
     * @Given I append last method doc to server doc
     */
    public function iAppendLastMethodDocToServerDoc()
    {
        $this->serverDoc->addMethod($this->lastMethodDoc);
        $this->lastMethodDoc = null;
    }

    /**
     * @Given I append last tag doc to server doc
     */
    public function iAppendLastTagDocToServerDoc()
    {
        $this->serverDoc->addTag($this->lastTagDoc);
        $this->lastTagDoc = null;
    }

    /**
     * @Given I append last error doc to server errors
     */
    public function iAppendLastErrorDocToServerErrors()
    {
        $this->serverDoc->addServerError($this->lastErrorDoc);
        $this->lastErrorDoc = null;
    }

    /**
     * @Given I append last error doc to global server errors
     */
    public function iAppendLastErrorDocToGlobalServerErrors()
    {
        $this->serverDoc->addGlobalError($this->lastErrorDoc);
        $this->lastErrorDoc = null;
    }

    /**
     * @Given I have a TypeDoc of class :class
     * @Given I have a TypeDoc of class :class with following calls:
     */
    public function givenIHaveATypeDocOfClass($class, PyStringNode $callList = null)
    {

        $this->lastTypeDoc = new $class();

        $this->callMethods(
            $this->lastTypeDoc,
            (null !== $callList) ? $this->jsonDecode($callList->getRaw()) : []
        );
    }

    /**
     * @Given last TypeDoc will have a scalar item validation
     */
    public function givenLastTypeDocWillHaveAnItemValidationOf()
    {
        $this->lastTypeDoc->setItemValidation(new ScalarDoc());
    }

    /**
     * @Given last MethodDoc will have a string and array params doc
     */
    public function givenLastMethodDocWillHaveAStringAndArrayParamsDoc()
    {
        $this->lastMethodDoc->setParamsDoc(
            (new ObjectDoc())
                ->addSibling(
                    (new StringDoc())
                        ->setName('string-val')
                )
                ->addSibling(
                    (new ArrayDoc())
                        ->setName('array-val')
                )
        );
    }

    /**
     * @Given last MethodDoc will have a string and array result doc
     */
    public function givenLastMethodDocWillHaveAStringAndArrayResultDoc()
    {
        $this->lastMethodDoc->setResultDoc(
            (new ObjectDoc())
                ->setRequired()
                ->addSibling(
                    (new StringDoc())
                        ->setName('string-val')
                )
                ->addSibling(
                    (new ArrayDoc())
                        ->setName('array-val')
                )
        );
    }

    /**
     * @Given last MethodDoc will have a custom errors doc
     */
    public function givenLastMethodDocWillHaveACustomErrorDoc()
    {
        $this->lastMethodDoc->addCustomError((new ErrorDoc('error-a', 123, 'message-error-a', null, 'Error-a-id')));
        $this->lastMethodDoc->addCustomError((new ErrorDoc('error-b', 321, 'message-error-b', null, 'Error-b-id')));
    }

    /**
     * @When I normalize method
     */
    public function whenINormalizeMethod()
    {
        $this->lastNormalizedOutput = $this->createMethodDocNormalizer()->normalize($this->lastMethodDoc);
    }

    /**
     * @When I normalize tag
     */
    public function whenINormalizeTag()
    {
        $this->lastNormalizedOutput = $this->createTagDocNormalizer()->normalize($this->lastTagDoc);
    }

    /**
     * @When I normalize type
     */
    public function whenINormalizeType()
    {
        $this->lastNormalizedOutput = $this->createTypeDocNormalizer()->normalize($this->lastTypeDoc);
    }

    /**
     * @When I normalize error
     */
    public function whenINormalizeError()
    {
        $this->lastNormalizedOutput = $this->createErrorDocNormalizer()->normalize($this->lastErrorDoc);
    }

    /**
     * @When I normalize server
     */
    public function whenINormalizeServer()
    {
        $this->lastNormalizedOutput = $this->createServerDocNormalizer()->normalize($this->serverDoc);
    }

    /**
     * @When I normalize http server
     */
    public function whenINormalizeHttServer()
    {
        $this->lastNormalizedOutput = (
            new HttpServerDocNormalizer(
                $this->createServerDocNormalizer()
            )
        )
            ->normalize($this->serverDoc);
    }

    /**
     * @Then I should have following normalized method:
     * @Then I should have following normalized tag:
     * @Then I should have following normalized type:
     * @Then I should have following normalized error:
     * @Then I should have following normalized server:
     * @Then I should have following normalized http server:
     */
    public function thenIShouldHaveFollowingNormalizedDoc(PyStringNode $data)
    {
        Assert::assertSame(
            $this->jsonDecode($data->getRaw()),
            $this->lastNormalizedOutput
        );
    }

    /**
     * @return TypeDocNormalizer
     */
    private function createTypeDocNormalizer(): TypeDocNormalizer
    {
        return new TypeDocNormalizer();
    }

    /**
     * @return TagDocNormalizer
     */
    private function createTagDocNormalizer(): TagDocNormalizer
    {
        return new TagDocNormalizer();
    }

    /**
     * @return MethodDocNormalizer
     */
    private function createMethodDocNormalizer(TypeDocNormalizer $typeDocNormalizer = null): MethodDocNormalizer
    {
        $typeDocNormalizer = $typeDocNormalizer ?? $this->createTypeDocNormalizer();

        return new MethodDocNormalizer(
            $typeDocNormalizer,
            $this->createErrorDocNormalizer($typeDocNormalizer)
        );
    }

    /**
     * @param $typeDocNormalizer
     *
     * @return ErrorDocNormalizer
     */
    private function createErrorDocNormalizer(TypeDocNormalizer $typeDocNormalizer = null): ErrorDocNormalizer
    {
        $typeDocNormalizer = $typeDocNormalizer ?? $this->createTypeDocNormalizer();

        return new ErrorDocNormalizer(
            $typeDocNormalizer
        );
    }

    /**
     * @param $methodDocNormalizer
     * @param $tagDocNormalizer
     * @param $errorDocNormalizer
     *
     * @return ServerDocNormalizer
     */
    private function createServerDocNormalizer(): ServerDocNormalizer
    {
        $typeDocNormalizer = $this->createTypeDocNormalizer();
        $tagDocNormalizer = $this->createTagDocNormalizer();
        $methodDocNormalizer = $this->createMethodDocNormalizer($typeDocNormalizer);
        $errorDocNormalizer = $this->createErrorDocNormalizer($typeDocNormalizer);

        return new ServerDocNormalizer(
            $methodDocNormalizer,
            $tagDocNormalizer,
            $errorDocNormalizer
        );
    }
}
