<?php
/**
 * @file
 * Contains \Drupal\parser_sample\Plugin\Field\FieldFormatter\MyRealParserFormatter
 */

namespace Drupal\parser_sample\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\parser_sample\Myparser\Parser;

/**
 * Plugin implementation of the 'my_realparser' formatter.
 *
 * @property  valueGenerator
 * @FieldFormatter(
 *   id = "my_realparser",
 *   label = @Translation("My Sample Parser"),
 *   field_types = {
 *     "myrealparser"
 *   }
 * )
 */
class MyRealParserFormatter extends FormatterBase
{
    /**
     * {@inheritdoc}
     */
    public function viewElements(FieldItemListInterface $items, $langcode)
    {
        $element = [];
        foreach ($items as $delta => $item) {
            try {
                // if it's the php exception http://php.net/manual/en/class.invalidargumentexception.php
                $result = $this->parser($item->my_parser);
            } catch (\InvalidArgumentException $e) {
                //  token is not valid
                $result = 'Token is not valid! Try ex: 10 + 20 - 30 + 15 * 5';
            }

            $element[$delta] = array(
                '#prefix' => '<em>',
                '#markup' => $this->t('@myfirst', array(
                        '@myfirst' => $result,
                    )
                ),
                '#suffix' => '</em>',
            );
        }
        return $element;
    }

    public function parser($input)
    {
        $parser = new Parser();
        return $parser->evaluate($input);
    }
}
