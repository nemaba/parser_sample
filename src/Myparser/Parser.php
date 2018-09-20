<?php

namespace Drupal\parser_sample\Myparser;
/**
 * Evaluate mathematical expression.
 */
class Parser
{
    /**
     * Lexer which should tokenize the mathematical expression.
     *
     * @var Lexer
     */
    protected $lexer;

    /**
     * TranslationStrategy that should translate from infix
     * mathematical expression notation.
     *
     * @var TranslationStrategy\TranslationStrategyInterface
     */
    protected $translationStrategy;

    /**
     * Array of key => value options.
     *
     * @var array
     */
    private $options = array(
        'translationStrategy' => 'TranslationStrategy\ShuntingYard',
    );

    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->lexer = new Lexer();
        $this->options = array_merge($this->options, $options);
        $this->translationStrategy = new TranslationStrategy\ShuntingYard();
    }

    /**
     * Evaluate string representing mathematical expression.
     *
     * @param string $expression
     * @return float
     */
    public function evaluate($expression)
    {
        $lexer = $this->getLexer();
        $tokens = $lexer->tokenize($expression);
        $translationStrategy = new TranslationStrategy\ShuntingYard();
        return $this->evaluateRPN($translationStrategy->translate($tokens));
    }

    /**
     * Return lexer.
     *
     * @return Lexer
     */
    public function getLexer()
    {
        return $this->lexer;
    }

    /**
     * Evaluate array sequence of tokens in Reverse Polish notation (RPN)
     * representing mathematical expression.
     *
     * @param array $expressionTokens
     * @return float
     * @throws \InvalidArgumentException
     */
    private function evaluateRPN(array $expressionTokens)
    {
        $stack = new \SplStack();
        foreach ($expressionTokens as $token) {
            $tokenValue = $token->getValue();
            if (is_numeric($tokenValue)) {
                $stack->push((float)$tokenValue);
                continue;
            }
            switch ($tokenValue) {
                case '+':
                    $stack->push($stack->pop() + $stack->pop());
                    break;
                case '-':
                    $n = $stack->pop();
                    $stack->push($stack->pop() - $n);
                    break;
                case '*':
                    $stack->push($stack->pop() * $stack->pop());
                    break;
                case '/':
                    $n = $stack->pop();
                    $stack->push($stack->pop() / $n);
                    break;
                case '%':
                    $n = $stack->pop();
                    $stack->push($stack->pop() % $n);
                    break;
                default:
                    throw new \InvalidArgumentException(sprintf('Invalid operator detected: %s', $tokenValue));
                    break;
            }
        }
        return $stack->top();
    }
}
