<?php

/**
 * @file
 * Contains \Drupal\parser_sample\Plugin\Field\FieldWidget\MyRealParserDefaultWidget
 */

namespace Drupal\parser_sample\Plugin\Field\FieldWidget;

use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'my_realparser_default' widget.
 *
 * @FieldWidget(
 *   id = "my_realparser_default",
 *   label = @Translation("My Sample Parser"),
 *   field_types = {
 *     "myrealparser"
 *   }
 * )
 */
class MyRealParserDefaultWidget extends WidgetBase {
  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['my_parser'] = array(
      '#type' => 'textfield',
      '#title' => t('My First parser:'),
      '#default_value' => '',
      '#size' => 25,
      '#required' => $element['#required'],
    );
    return $element;
  }
}
