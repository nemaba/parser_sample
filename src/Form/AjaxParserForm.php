<?php

/**
 * @file
 * Contains Drupal\ajax_example\AjaxExampleForm
 */

namespace Drupal\parser_sample\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\parser_sample\Myparser\Parser;

class AjaxParserForm extends FormBase {

    public function getFormId() {
        return 'AjaxParserFormID';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['operation'] = array(
            '#type' => 'textfield',
            '#title' => 'Operation',
            '#description' => 'Please enter operation. e.g.: 10 + 20 - 30 + 15 * 5',
            '#ajax' => array(
                // Function to call when event on form element triggered.
                'callback' => 'Drupal\parser_sample\Form\AjaxParserForm::operationValidateCallback',
                // Effect when replacing content. Options: 'none' (default), 'slide', 'fade'.
                'effect' => 'fade',
                // Javascript event to trigger Ajax. Currently for: 'onchange'.
                'event' => 'change',
                'progress' => array(
                    // Graphic shown to indicate ajax. Options: 'throbber' (default), 'bar'.
                    'type' => 'throbber',
                    // Message to show along progress graphic. Default: 'Please wait...'.
                    'message' => NULL,
                ),
            ),
        );

        $form['button_operation'] = array(
            '#type' => 'button',
            '#value' => 'Calculate operation',
            '#ajax' => array(
                'callback' => 'Drupal\parser_sample\Form\AjaxParserForm::operationCalculateCallback',
                'event' => 'click',
                'progress' => array(
                    'type' => 'throbber',
                    'message' => 'Computing...',
                ),

            ),
        );
        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        drupal_set_message('Nothing Submitted.');
    }

    public function operationValidateCallback(array &$form, FormStateInterface $form_state)
    {
        $input = $form_state->getValue('operation');
        try {
            $parser = new Parser();
            $text =  $parser->evaluate($input);
            $text = var_export($text, true);
            $color = 'green';

        } catch (\InvalidArgumentException $e) {
            //  token is not valid
            $text = 'Invalid data! Please enter operation. e.g.: 10 + 20 - 30 + 15 * 5';
            $color = 'red';
        }

        // Instantiate an AjaxResponse Object to return.
        $ajax_response = new AjaxResponse();

        $ajax_response->addCommand(new InvokeCommand('#edit-operation', 'val' , array($input)) );

        // Add a command to execute on form, jQuery .html() replaces content between tags.
        // In this case, we replace the description with whether the username was found or not.
        $ajax_response->addCommand(new HtmlCommand('#edit-operation--description', $text));

        // Add a command, InvokeCommand, which allows for custom jQuery commands.
        // In this case, we alter the color of the description.
        $ajax_response->addCommand(new InvokeCommand('#edit-operation--description', 'css', array('color', $color)));

        // Return the AjaxResponse Object.
        return $ajax_response;
    }

    public function operationCalculateCallback(array &$form, FormStateInterface $form_state) {

        // Instantiate an AjaxResponse Object to return.
        $ajax_response = new AjaxResponse();

        return $ajax_response;
    }
}