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
     * {@inheritdoc}
     */
    protected function getEditableConfigNames()
    {
        return [
            'maps.maps_form'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
       $config = $this->config('maps.maps_form');

        $form['maps_key'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Maps key'),
            '#default_value' => $config->get('maps_key'),
            '#description' => $this->t('Add google maps  <a href="https://console.developers.google.com" target="_blanc">free API key</a>'),
            '#size' => 60,
        );


        return parent::buildForm($form, $form_state);

    }


    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {

        parent::submitForm($form, $form_state);

        $config = $this->config('maps.maps_form');

        $config->set('maps_key', $form_state->getValue('maps_key'));
        $config->save();
    }


}