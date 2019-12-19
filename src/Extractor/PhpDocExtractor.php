<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Extractor;

use Abryb\ParameterInfo\ParameterDescriptionExtractorInterface;
use Abryb\ParameterInfo\ParameterTypeExtractorInterface;
use Abryb\ParameterInfo\Util\PhpDocTypeHelper;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\DocBlockFactoryInterface;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 */
class PhpDocExtractor implements ParameterTypeExtractorInterface, ParameterDescriptionExtractorInterface
{
    /**
     * @var DocBlockFactory
     */
    private $docBlockFactory;

    /**
     * @var PhpDocTypeHelper
     */
    private $phpDocTypeHelper;

    public function __construct(DocBlockFactoryInterface $docBlockFactory = null)
    {
        $this->docBlockFactory  = $docBlockFactory ?? DocBlockFactory::createInstance();
        $this->phpDocTypeHelper = new PhpDocTypeHelper();
    }

    /**
     * {@inheritdoc}
     */
    public function getTypes(\ReflectionParameter $parameter): array
    {
        $tag = $this->getParamTag($parameter);

        if ($tag && $tag->getType()) {
            return $this->phpDocTypeHelper->getTypes($tag->getType());
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(\ReflectionParameter $parameter): ?string
    {
        $tag = $this->getParamTag($parameter);

        if ($tag && $tag->getDescription()) {
            return $tag->getDescription()->render();
        }

        return null;
    }

    private function getParamTag(\ReflectionParameter $parameter): ?Param
    {
        if (!$docBlock = $this->getDocBlock($parameter)) {
            return null;
        }

        /** @var Param[] $paramsTag */
        $paramsTag = $docBlock->getTagsByName('param');

        $tag = null;
        // 1. Find tag by name
        foreach ($paramsTag as $t) {
            if ($t->getVariableName() === $parameter->getName()) {
                $tag = $t;

                break;
            }
        }

        // 2. find tag by position
        if (null === $tag) {
            if (count($paramsTag) === $parameter->getDeclaringFunction()->getNumberOfParameters()) {
                $tag = $paramsTag[$parameter->getPosition()];
            }
        }

        return $tag;
    }

    private function getDocBlock(\ReflectionParameter $parameter): ?DocBlock
    {
        if (!$docComment = $parameter->getDeclaringFunction()->getDocComment()) {
            return null;
        }

        return $this->docBlockFactory->create($docComment);
    }
}
