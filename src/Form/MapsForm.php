<?php

namespace Drupal\maps\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class MapsForm extends ConfigFormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'maps_form';
    }

    /**
     * Gets the configuration names that will be editable.
     *
     * @return array
     *   An array of configuration object names that are editable if called in
     *   conjunction with the trait's config() method.
     */
    protected function getEditableConfigNames()
    {
        return [
            'maps.settings',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form = parent::buildForm($form, $form_state);
        $config = $this->config('maps.settings');

        $form['maps_key'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('api key for google map'),
            '#required' => TRUE,
            '#default_value' => $config->get('maps_key'),
            '#description' => $this->t('Go to <a target="_blank" href="https://console.developers.google.com">https://console.developers.google.com</a> to get a free API key'),
        );

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        $maps_key = $form_state->getValue('maps_key');

        if (empty($maps_key)) {
            $form_state->setErrorByName('maps_key', $this->t('this field is required '));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $config = $this->config('maps.settings');
        $config->set('maps_key', $form_state->getValue('maps_key'));
        $config->save();
        parent::submitForm($form, $form_state);
    }


}