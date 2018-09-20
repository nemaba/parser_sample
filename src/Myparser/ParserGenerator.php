<?php

namespace Drupal\parser_sample\Myparser;

use Drupal\Core\KeyValueStore\KeyValueFactoryInterface;

class ParserGenerator
{
    private $keyValueFactory;
    private $useCache;

    public function __construct(KeyValueFactoryInterface $keyValueFactory, $useCache)
    {
        $this->keyValueFactory = $keyValueFactory;
        $this->useCache = $useCache;
    }

    public function getValue($input)
    {
        $store = $this->keyValueFactory->get('lexer');
        $key = 'parser_sample_'.$input;

        if ($this->useCache && $store->has($key)) {
            return $store->get($key);
        }

        $parser = new parser();
        $result= $parser->evaluate($input);

        $string = '==>'.$result;

        if ($this->useCache) {
            $store->set($key, $string);
        }

        return $string;
    }
}
