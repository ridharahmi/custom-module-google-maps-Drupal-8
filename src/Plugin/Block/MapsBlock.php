<?php

namespace Drupal\maps\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;


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
            'border_radius' => $default_config->get('border_radius'),
            'zoom_level' => $default_config->get('zoom_level'),
            'center_position' => $default_config->get('center_position'),
            'animate_marker_position' => $default_config->get('animate_marker_position'),
            'enable_marker' => $default_config->get('enable_marker'),
            'size_logo' => $default_config->get('size_logo'),
            'title_marker' => $default_config->get('title_marker'),
            'description_marker' => $default_config->get('description_marker'),
            'position_marker' => $default_config->get('position_marker'),
            'animate_marker' => $default_config->get('animate_marker'),
        ];

    }

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $config = $this->getConfiguration();

        if (File::load($config['logo_marker'][0])) {
            $file = File::load($config['logo_marker'][0]);
            $image = '/drupal8613/sites/default/files/' . $file->getFileUri();
        } else {
            $image = drupal_get_path('module', 'maps') . '/assets/image/logo.png';
        }


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
                    'animate_marker_position' => $config['animate_marker_position'],
                    'enable_marker' => $config['enable_marker'],
                    'logo_marker' => $image,
                    'size_logo' => $config['size_logo'],
                    'title_marker' => $config['title_marker'],
                    'description_marker' => $config['description_marker'],
                    'position_marker' => $config['position_marker'],
                    'animate_marker' => $config['animate_marker'],
                    'maps_key' => $config['maps_key'],
                ]
            ),
        );


    }


    /**
     * {@inheritdoc}
     */
    public
    function blockForm($form, FormStateInterface $form_state)
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
        $form['animate_marker_position'] = array(
            '#type' => 'select',
            '#title' => $this->t('Animate Marker Position'),
            '#description' => $this->t('This Is Animate Marker Position: Bounce|Drop'),
            '#options' => array(
                1 => $this->t('None'),
                2 => $this->t('Bounce'),
                3 => $this->t('Drop'),
            ),
            '#default_value' => isset($config['animate_marker_position']) ? $config['animate_marker_position'] : '',
        );
        $form['enable_marker'] = array(
            '#type' => 'checkbox',
            '#title' => $this->t('Enable Marker Maps'),
            '#description' => $this->t('Enable Marker Maps: Position Marker|Logo Marker'),
            '#default_value' => isset($config['enable_marker']) ? $config['enable_marker'] : '',
        );
        $form['logo_marker'] = array(
            '#type' => 'managed_file',
            '#upload_location' => 'public://images/',
            '#title' => $this->t('Logo Marker'),
            '#multiple' => FALSE,
            '#description' => t("Logo Marker: Image png, jpg"),
            '#default_value' => isset($config['logo_marker']) ? $config['logo_marker'] : '',
            '#upload_validators' => array(
                'file_validate_extensions' => array('gif png jpg jpeg'),
                'file_validate_size' => array(25600000),
            ),
            '#states' => array(
                'visible' => array(
                    ':input[name="image_type"]' => array('value' => t('Upload New Image(s)')),
                )
            )
        );
        $form['size_logo'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Size Logo Marker'),
            '#description' => $this->t('This Is Size Logo Marker Exp: 50'),
            '#default_value' => isset($config['size_logo']) ? $config['size_logo'] : '',
            '#size' => 20
        ];
        $form['position_marker'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Position Marker'),
            '#placeholder' => "latitude,longitude",
            '#description' => $this->t('Use this link to get latitude and longitude <a target="_blank" href="https://www.latlong.net/">https://www.latlong.net/</a>'),
            '#default_value' => isset($config['position_marker']) ? $config['position_marker'] : '',
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


        $form['animate_marker'] = array(
            '#type' => 'select',
            '#title' => $this->t('Animate Marker'),
            '#description' => $this->t('This Is Animate Marker: Bounce|Drop'),
            '#options' => array(
                1 => $this->t('None'),
                2 => $this->t('Bounce'),
                3 => $this->t('Drop'),
            ),
            '#default_value' => isset($config['animate_marker']) ? $config['animate_marker'] : '',
        );
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


    public
    function blockSubmit($form, FormStateInterface $form_state)
    {
        parent::blockSubmit($form, $form_state);
        $values = $form_state->getValues();
        $this->configuration['width'] = $values['width'];
        $this->configuration['height'] = $values['height'];
        $this->configuration['zoom_level'] = $values['zoom_level'];
        $this->configuration['center_position'] = $values['center_position'];
        $this->configuration['animate_marker_position'] = $values['animate_marker_position'];
        $this->configuration['enable_marker'] = $values['enable_marker'];
        $this->configuration['logo_marker'] = $values['logo_marker'];
        $this->configuration['size_logo'] = $values['size_logo'];
        $this->configuration['title_marker'] = $values['title_marker'];
        $this->configuration['description_marker'] = $values['description_marker'];
        $this->configuration['position_marker'] = $values['position_marker'];
        $this->configuration['animate_marker'] = $values['animate_marker'];
        $this->configuration['border_radius'] = $values['border_radius'];
        $this->configuration['border'] = $values['border'];
        $this->configuration['color_border'] = $values['color_border'];
        $this->configuration['padding_maps'] = $values['padding_maps'];
        //dsm($values['enable_marker']);


    }


}