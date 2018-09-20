<?php

namespace Drupal\parser_sample\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\parser_sample\Myparser\ParserGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @property ParserGenerator valueGenerator
 */
class ParserController extends ControllerBase
{
    /**
     * @var ParserGenerator
     */
    private $valueGenerator;

    public function __construct(ParserGenerator $valueGenerator)
    {
        $this->valueGenerator = $valueGenerator;
    }

    /**
     * @param ContainerInterface $container
     * @return ControllerBase|ParserController
     */
    public static function create(ContainerInterface $container)
    {
        $valueGenerator = $container->get('parser_sample.parser_generator');

        return new static($valueGenerator);
    }

    public function parser($input)
    {
        $result = $this->valueGenerator->getValue($input);

        return [
            '#title' => $result
        ];
    }
}
