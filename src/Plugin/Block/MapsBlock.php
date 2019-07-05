<?php

namespace Drupal\maps\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "maps_block",
 *   admin_label = @Translation("Custom Google Maps block"),
 *   category = @Translation("Google Maps"),
 * )
 */
class MapsBlock extends BlockBase implements BlockPluginInterface
{

    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration()
    {
        $default_config = \Drupal::config('maps.settings');
        return [
            'width' => $default_config->get('width'),
            'height' => $default_config->get('height'),
            'zoom_level' => $default_config->get('zoom_level'),
            'center_position' => $default_config->get('center_position'),
            'markers' => $default_config->get('markers'),
            'maps_key' => $default_config->get('maps_key'),
        ];

    }

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $config = $this->getConfiguration();

        return array(
            '#theme' => 'maps',
            '#width' => $config['width'],
            '#height' => $config['height'],
            '#attached' => array(

                'drupalSettings' => [
                    'zoom' => $config['zoom_level'],
                    'center' => $config['center_position'],
                    'markers' => $config['markers'],
                    'maps_key' => $config['maps_key'],
                ]
            ),
        );
    }


    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state)
    {
        $form = parent::blockForm($form, $form_state);
        $config = $this->getConfiguration();
        $form['width'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Width'),
            '#description' => $this->t('Width of your map '),
            '#default_value' => isset($config['width']) ? $config['width'] : '',
            '#size' => 8
        ];
        $form['height'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Height'),
            '#description' => $this->t('Height of google your map '),
            '#default_value' => isset($config['height']) ? $config['height'] : '',
            '#size' => 8
        ];
        $form['zoom_level'] = [
            '#type' => 'number',
            '#title' => $this->t('Map Zoom Level'),
            '#default_value' => isset($config['zoom_level']) ? $config['zoom_level'] : '',
            '#size' => 8
        ];

        $form['center_position'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Center Position'),
            '#placeholder' => "latitude,longitude",
            '#description' => $this->t('Use this link to get latitude and longitude <a target="_blank" href="https://www.latlong.net/">https://www.latlong.net/</a>'),
            '#default_value' => isset($config['center_position']) ? $config['center_position'] : '',
        ];


        $form['markers'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Markers'),
            '#placeholder' => "latitude,longitude|latitude,longitude",
            '#description' => $this->t('Use | to separate markers. <br> Use this link to get latitude and longitude <a target="_blank" href="https://www.latlong.net/">https://www.latlong.net/</a>'),
            '#default_value' => isset($config['markers']) ? $config['markers'] : '',
        ];
        $form['border'] = [
            '#type' => 'number',
            '#title' => $this->t('Border'),
            '#description' => $this->t('PX border Maps'),
            '#default_value' => isset($config['border']) ? $config['border'] : '',
        ];
        $form['color_border'] = [
            '#type' => 'color',
            '#title' => $this->t('Color Border'),
            '#description' => $this->t('Color border maps'),
            '#default_value' => isset($config['color_border']) ? $config['color_border'] : '',
        ];
        $form['padding_maps'] = [
            '#type' => 'number',
            '#title' => $this->t('Padding'),
            '#description' => $this->t('Padding Maps'),
            '#default_value' => isset($config['padding_maps']) ? $config['padding_maps'] : '',
        ];


        return $form;
    }


    public function blockSubmit($form, FormStateInterface $form_state)
    {
        parent::blockSubmit($form, $form_state);
        $values = $form_state->getValues();
        $this->configuration['width'] = $values['width'];
        $this->configuration['height'] = $values['height'];
        $this->configuration['zoom_level'] = $values['zoom_level'];
        $this->configuration['center_position'] = $values['center_position'];
        $this->configuration['markers'] = $values['markers'];
        $this->configuration['border'] = $values['border'];
        $this->configuration['color_border'] = $values['color_border'];
        $this->configuration['padding_maps'] = $values['padding_maps'];
    }

}