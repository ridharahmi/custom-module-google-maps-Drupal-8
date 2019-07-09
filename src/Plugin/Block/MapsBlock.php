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
            'border' => $default_config->get('border'),
            'color_border' => $default_config->get('color_border'),
            'padding_maps' => $default_config->get('padding_maps'),
            'zoom_level' => $default_config->get('zoom_level'),
            'center_position' => $default_config->get('center_position'),
            'logo_marker' => $default_config->get('logo_marker'),
            'title_marker' => $default_config->get('logo_marker'),
            'description_marker' => $default_config->get('logo_marker'),
            'position_marker' => $default_config->get('logo_marker'),
            'border_radius' => $default_config->get('logo_marker'),
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
            '#border' => $config['border'],
            '#color_border' => $config['color_border'],
            '#padding_maps' => $config['padding_maps'],
            '#border_radius' => $config['border_radius'],
            '#attached' => array(
                'library' => array(
                    'maps/maps_style',
                ),
                'drupalSettings' => [
                    'zoom' => $config['zoom_level'],
                    'center' => $config['center_position'],
                    'logo_marker' => $config['logo_marker'],
                    'title_marker' => $config['title_marker'],
                    'description_marker' => $config['description_marker'],
                    'position_marker' => $config['position_marker'],
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
        ];
        $form['height'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Height'),
            '#description' => $this->t('Height of google your map '),
            '#default_value' => isset($config['height']) ? $config['height'] : '',
        ];
        $form['zoom_level'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Map Zoom Level'),
            '#default_value' => isset($config['zoom_level']) ? $config['zoom_level'] : '',
        ];

        $form['center_position'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Position'),
            '#placeholder' => "latitude,longitude",
            '#description' => $this->t('Use this link to get latitude and longitude <a target="_blank" href="https://www.latlong.net/">https://www.latlong.net/</a>'),
            '#default_value' => isset($config['center_position']) ? $config['center_position'] : '',
        ];
        $form['title_marker'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Title Marker'),
            '#description' => $this->t('This Is Label Marker'),
            '#default_value' => isset($config['title_marker']) ? $config['title_marker'] : '',
        ];
        $form['description_marker'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Description Marker'),
            '#description' => $this->t('This Is Description Marker'),
            '#default_value' => isset($config['description_marker']) ? $config['description_marker'] : '',
        ];
        $form['logo_marker'] = [
            '#type' => 'file',
            '#title' => $this->t('Logo Marker'),
            '#description' => $this->t('Logo Marker: Image png, jpg'),
            '#default_value' => isset($config['logo_marker']) ? $config['logo_marker'] : '',
        ];
        $form['position_marker'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Position Marker'),
            '#placeholder' => "latitude,longitude",
            '#description' => $this->t('Use this link to get latitude and longitude <a target="_blank" href="https://www.latlong.net/">https://www.latlong.net/</a>'),
            '#default_value' => isset($config['position_marker']) ? $config['position_marker'] : '',
        ];
        $form['border'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Border'),
            '#description' => $this->t('PX border Maps'),
            '#default_value' => isset($config['border']) ? $config['border'] : '',
            '#size' => 20
        ];

        $form['border_radius'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Border Radius'),
            '#description' => $this->t('PX Border Radius  Maps'),
            '#default_value' => isset($config['border_radius']) ? $config['border_radius'] : '',
            '#size' => 20
        ];
        $form['color_border'] = [
            '#type' => 'color',
            '#title' => $this->t('Color Border'),
            '#description' => $this->t('Color border maps'),
            '#default_value' => isset($config['color_border']) ? $config['color_border'] : '',

        ];
        $form['padding_maps'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Padding'),
            '#description' => $this->t('Padding Maps'),
            '#default_value' => isset($config['padding_maps']) ? $config['padding_maps'] : '',
            '#size' => 20
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
        $this->configuration['logo_marker'] = $values['logo_marker'];
        $this->configuration['title_marker'] = $values['title_marker'];
        $this->configuration['description_marker'] = $values['description_marker'];
        $this->configuration['position_marker'] = $values['position_marker'];
        $this->configuration['border_radius'] = $values['border_radius'];
        $this->configuration['border'] = $values['border'];
        $this->configuration['color_border'] = $values['color_border'];
        $this->configuration['padding_maps'] = $values['padding_maps'];
    }

}