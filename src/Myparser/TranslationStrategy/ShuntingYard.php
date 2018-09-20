<?php

namespace Drupal\parser_sample\Myparser\TranslationStrategy;

use Drupal\parser_sample\Myparser\Token;
use InvalidArgumentException;
use SplQueue;
use SplStack;

/**
 * Implementation of Shunting-Yard algorithm.
 * Used to translate infix mathematical expressions
 * to RPN mathematical expressions.
 *
 * @see http://en.wikipedia.org/wiki/Shunting-yard_algorithm
 */
class ShuntingYard implements TranslationStrategyInterface
{
    /**
     * Operator stack
     *
     * @var \SplStack
     */
    private $operatorStack;

    /**
     * Output queue
     *
     * @var \SplQueue
     */
    private $outputQueue;

    /**
     * Translate array sequence of tokens from infix to
     * Reverse Polish notation (RPN) which representing mathematical expression.
     *
     * @param array $tokens Collection of Token instances
     * @return array Collection of Token instances
     * @throws InvalidArgumentException
     */
    public function translate(array $tokens)
    {
        $this->operatorStack = new SplStack();
        $this->outputQueue = new SplQueue();
        foreach ($tokens as $token) {
            switch ($token->getType()) {
                case Token::T_OPERAND:
                    $this->outputQueue->enqueue($token);
                    break;
                case Token::T_OPERATOR:
                    $o1 = $token;
                    while ($this->hasOperatorInStack()
                        && ($o2 = $this->operatorStack->top())
                        && $o1->hasLowerPriority($o2)) {
                        $this->outputQueue->enqueue($this->operatorStack->pop());
                    }
                    $this->operatorStack->push($o1);
                    break;
                case Token::T_LEFT_BRACKET:
                    $this->operatorStack->push($token);
                    break;
                case Token::T_RIGHT_BRACKET:
                    while ((!$this->operatorStack->isEmpty()) && (Token::T_LEFT_BRACKET != $this->operatorStack->top()->getType())) {
                        $this->outputQueue->enqueue($this->operatorStack->pop());
                    }
                    if ($this->operatorStack->isEmpty()) {
                        throw new InvalidArgumentException(sprintf('Mismatched parentheses: %s', implode(' ', $tokens)));
                    }
                    $this->operatorStack->pop();
                    break;
                default:
                    throw new InvalidArgumentException(sprintf('Invalid token detected: %s', $token));
                    break;
            }
        }
        while ($this->hasOperatorInStack()) {
            $this->outputQueue->enqueue($this->operatorStack->pop());
        }
        if (!$this->operatorStack->isEmpty()) {
            throw new InvalidArgumentException(sprintf('Mismatched parenthesis or misplaced number: %s', implode(' ', $tokens)));
        }
        return iterator_to_array($this->outputQueue);
    }

    /**
     * Determine if there is operator token in operator stack
     *
     * @return boolean
     */
    private function hasOperatorInStack()
    {
        $hasOperatorInStack = FALSE;
        if (!$this->operatorStack->isEmpty()) {
            $top = $this->operatorStack->top();
            if (Token::T_OPERATOR == $top->getType()) {
                $hasOperatorInStack = TRUE;
            }
        }
        return $hasOperatorInStack;
    }
}
