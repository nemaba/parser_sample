<?php

/**
 * @file
 * Contains \Drupal\parser_sample\Plugin\Field\FieldType\MyRealParser.
 */

namespace Drupal\parser_sample\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;

/**
 * Plugin implementation of the 'myrealparser' field type.
 *
 * @FieldType(
 *   id = "myrealparser",
 *   label = @Translation("My Sample Parser"),
 *   description = @Translation("This field stores a My Sample Parser."),
 *   category = @Translation("General"),
 *   default_widget = "my_realparser_default",
 *   default_formatter = "my_realparser"
 * )
 */

class MyRealParser extends FieldItemBase {
  /**
   * {@inheritdoc}
   */
  public static function schema(\Drupal\Core\Field\FieldStorageDefinitionInterface $field_definition) {
    return array(
      'columns' => array(
        'my_parser' => array(
          'description' => 'My parser.',
          'type' => 'varchar',
          'length' => '255',
          'not null' => TRUE,
          'default' => '',
        ),
      ),
      'indexes' => array(
        'my_parser' => array('my_parser'),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['my_parser'] = \Drupal\Core\TypedData\DataDefinition::create('string')
      ->setLabel(t('My Parser'));

    return $properties;
  }

}
