<?php
namespace Woolentor\Modules\CartReserveTime\Admin;
use WooLentor\Traits\Singleton;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Fields {
    use Singleton;

    public function __construct(){
        add_filter( 'woolentor_admin_fields', [ $this, 'admin_fields' ], 99, 1 );
    }

    /**
     * Admin Field Register
     * @param mixed $fields
     * @return mixed
     */
    public function admin_fields( $fields ){
        
        if( woolentor_is_pro() && method_exists( '\WoolentorPro\Modules\CartReserveTime\Admin\Fields', 'sitting_fields') ){
            array_splice( $fields['woolentor_others_tabs']['modules'], 29, 0, \WoolentorPro\Modules\CartReserveTime\Admin\Fields::instance()->sitting_fields() );
        }else{
            array_splice( $fields['woolentor_others_tabs']['modules'], 15, 0, $this->sitting_fields() );
        }

        return $fields;
    }

    /**
     * Settings Fields Fields;
     */
    public function sitting_fields(){
        
        $fields = [
            [
                'name'   => 'cart_reserve_timer_settings',
                'label'  => esc_html__( 'Cart Reserved Timer', 'woolentor' ),
                'type'   => 'module',
                'default'=> 'off',
                'section'  => 'woolentor_cart_reserve_timer_settings',
                'option_id' => 'enable',
                'documentation' => esc_url('https://woolentor.com/doc/cart-reserved-timer-reduce-cart-abandonment-in-woocommerce/'),
                'require_settings'  => true,
                'setting_fields' => [
                    [
                        'name'    => 'enable',
                        'label'   => esc_html__( 'Enable / Disable', 'woolentor' ),
                        'desc'    => esc_html__( 'Enable / disable this module.', 'woolentor' ),
                        'type'    => 'checkbox',
                        'default' => 'off',
                        'class'   => 'woolentor-action-field-left'
                    ],
                    [
                        'name'    => 'reserve_time',
                        'label'   => esc_html__( 'Reserve Time (Minutes)', 'woolentor' ),
                        'desc'    => esc_html__( 'Set the cart reserve time in minutes.', 'woolentor' ),
                        'type'    => 'number',
                        'default' => '15',
                        'class'   => 'woolentor-action-field-left'
                    ],
                    [
                        'name'    => 'cart_message',
                        'label'   => esc_html__( 'Demand Message', 'woolentor' ),
                        'desc'    => esc_html__( 'Message to show high demand status.', 'woolentor' ),
                        'type'    => 'text',
                        'default' => esc_html__('An item of your cart is in high demand.', 'woolentor'),
                        'class'   => 'woolentor-action-field-left'
                    ],
            
                    [
                        'name'    => 'timer_message',
                        'label'   => esc_html__( 'Timer Message', 'woolentor' ),
                        'desc'    => esc_html__( 'Use {time} placeholder to display the countdown timer.', 'woolentor' ),
                        'type'    => 'text',
                        'default' => esc_html__('Your cart is saved for {time} minutes!', 'woolentor'),
                        'class'   => 'woolentor-action-field-left'
                    ],
            
                    [
                        'name'    => 'expire_action',
                        'label'   => esc_html__( 'Expiration Action', 'woolentor' ),
                        'desc'    => esc_html__( 'Select action to perform when timer expires. Note: Custom Redirect and Apply Coupon option avaialbe in pro version', 'woolentor' ),
                        'type'    => 'select',
                        'default' => 'hide',
                        'options' => [
                            'hide'  => esc_html__('Hide Timer', 'woolentor'),
                            'clear' => esc_html__('Clear Cart', 'woolentor'),
                        ],
                        'class'   => 'woolentor-action-field-left'
                    ],

                    [
                        'name'    => 'redirect_urlp',
                        'label'   => esc_html__( 'Redirect URL', 'woolentor' ),
                        'type'    => 'text',
                        'class'   => 'woolentor-action-field-left',
                        'is_pro'  => true
                    ],
        
                    [
                        'name'    => 'coupon_codep',
                        'label'   => esc_html__( 'Coupon Code', 'woolentor' ),
                        'type'    => 'text',
                        'class'   => 'woolentor-action-field-left',
                        'is_pro'  => true
                    ],
    
                    [
                        'name'    => 'notice_icon',
                        'label'   => esc_html__( 'Notice Icon', 'woolentor' ),
                        'desc'    => esc_html__( 'Choose an icon to display with the message.', 'woolentor' ),
                        'type'    => 'select',
                        'default' => 'fire',
                        'options' => [
                            'none'      => esc_html__('None', 'woolentor'),
                            'fire'      => esc_html__('🔥 Fire', 'woolentor'),
                            'hourglass' => esc_html__('⌛ Hourglass', 'woolentor'),
                            'bell'      => esc_html__('🔔 Bell', 'woolentor'),
                            'watch'     => esc_html__('⏱️ Watch', 'woolentor'),
                            'timer'     => esc_html__('⏳ Timer', 'woolentor'),
                            'rocket'    => esc_html__('🚀 Rocket', 'woolentor'),
                            'alert'     => esc_html__('🚨 Alert', 'woolentor'),
                            'spark'     => esc_html__('✨ Spark', 'woolentor'),
                        ],
                        'class'   => 'woolentor-action-field-left'
                    ],

                    [
                        'name'    => 'product_specific_settings',
                        'headding'=> esc_html__( 'Product Specific Settings', 'woolentor' ),
                        'type'    => 'title'
                    ],
        
                    [
                        'name'    => 'enable_per_productp',
                        'label'   => esc_html__( 'Enable Per Product Timer', 'woolentor' ),
                        'desc'    => esc_html__( 'Enable different timer settings for individual products.', 'woolentor' ),
                        'type'    => 'checkbox',
                        'default' => 'off',
                        'class'   => 'woolentor-action-field-left',
                        'is_pro'  => true
                    ],
        
                    [
                        'name'    => 'product_categoriesp',
                        'label'   => esc_html__( 'Product Categories', 'woolentor' ),
                        'desc'    => esc_html__( 'Apply timer to specific product categories.', 'woolentor' ),
                        'type'    => 'select',
                        'options' => ['select_option' => esc_html__('Product categories', 'woolentor')],
                        'class'   => 'woolentor-action-field-left',
                        'is_pro'  => true
                    ],
        
                    [
                        'name'    => 'style_settings',
                        'headding'=> esc_html__( 'Style Settings', 'woolentor' ),
                        'type'    => 'title'
                    ],
        
                    [
                        'name'    => 'notice_stylep',
                        'label'   => esc_html__( 'Notice Style', 'woolentor' ),
                        'type'    => 'select',
                        'options' => ['select_option' => esc_html__('Select Style', 'woolentor')],
                        'default' => '',
                        'class'   => 'woolentor-action-field-left',
                        'is_pro'  => true
                    ],
        
                    [
                        'name'    => 'background_colorp',
                        'label'   => esc_html__( 'Background Color', 'woolentor' ),
                        'type'    => 'color',
                        'default' => '#f7f6f7',
                        'class'   => 'woolentor-action-field-left',
                        'is_pro'  => true
                    ],
        
                    [
                        'name'    => 'text_colorp',
                        'label'   => esc_html__( 'Text Color', 'woolentor' ),
                        'type'    => 'color',
                        'default' => '#515151',
                        'class'   => 'woolentor-action-field-left',
                        'is_pro'  => true
                    ],
        
                    [
                        'name'    => 'timer_colorp',
                        'label'   => esc_html__( 'Timer Color', 'woolentor' ),
                        'type'    => 'color',
                        'default' => '#ff6b6b',
                        'class'   => 'woolentor-action-field-left',
                        'is_pro'  => true
                    ],

                    [
                        'name'    => 'content_alignp',
                        'type'    => 'select',
                        'label'   => esc_html__('Content Align', 'woolentor'),
                        'options' => ['select_option' => esc_html__('Alignment', 'woolentor')],
                        'default' => 'left',
                        'class'   => 'woolentor-action-field-left',
                        'is_pro'  => true
                    ],

                ]
            ]
        ];

        return $fields;

    }

}