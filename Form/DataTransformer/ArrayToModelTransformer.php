<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\AdminBundle\Form\DataTransformer;

use Symfony\Component\Form\Exception\InvalidPropertyException;
use Symfony\Component\Form\Exception\PropertyAccessDeniedException;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Exception\TransformationFailedException;

use Sonata\AdminBundle\Model\ModelManagerInterface;

class ArrayToModelTransformer implements DataTransformerInterface
{
    protected $modelManager;

    protected $className;

    public function __construct(ModelManagerInterface $modelManager, $className)
    {
        $this->modelManager = $modelManager;
        $this->className    = $className;
    }

    /**
     * @param array $ids
     * @return $object
     */
    public function reverseTransform($array)
    {
        // when the object is created the form return an array
        // one the object is persisted, the edit $array is the user instance
        if ($array instanceof $this->className)
        {
            return $array;
        }

        $instance = new $this->className;

        if (!is_array($array)) {

            return $instance;
        }

        return $this->modelManager->modelReverseTransform($this->className, $array);
    }

    /**
     * @param Collection $value
     */
    public function transform($value)
    {
        return $value;
    }
}