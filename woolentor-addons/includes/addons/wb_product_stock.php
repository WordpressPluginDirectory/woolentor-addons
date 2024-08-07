<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Woolentor_Wb_Product_Stock_Widget extends Widget_Base {

    public function get_name() {
        return 'wl-single-product-stock';
    }

    public function get_title() {
        return __( 'WL: Product Stock', 'woolentor' );
    }

    public function get_icon() {
        return 'eicon-product-stock';
    }

    public function get_categories() {
        return array( 'woolentor-addons' );
    }

    public function get_help_url() {
        return 'https://woolentor.com/documentation/';
    }

    public function get_style_depends(){
        return [
            'woolentor-widgets',
        ];
    }

    public function get_keywords(){
        return ['product','stock','product stock'];
    }

    protected function register_controls() {

        // Product Price Style
        $this->start_controls_section(
            'product_stock_style_section',
            array(
                'label' => __( 'Style', 'woolentor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'stock_text_color',
                [
                    'label' => __( 'Text Color', 'woolentor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} .stock' => 'color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'stock_text_typography',
                    'label' => __( 'Typography', 'woolentor' ),
                    'selector' => '.woocommerce {{WRAPPER}} .stock',
                ]
            );

            $this->add_responsive_control(
                'stock_margin',
                [
                    'label' => __( 'Margin', 'woolentor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .stock' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                ]
            );

        $this->end_controls_section();

    }


    protected function render( $instance = [] ) {

        $settings = $this->get_settings_for_display();
        $id       = $this->get_id();
        global $product;
        $product = wc_get_product();
        
        if( woolentor_is_preview_mode() ){
            echo \WooLentor_Default_Data::instance()->default( $this->get_name() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        } else{
            if ( empty( $product ) ) { return; }
            echo wc_get_stock_html( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
        
        // For Variable Product
        $poduct_type = $product ? $product->get_type() : '';
        if( "variable" == $poduct_type){
            ?>
                <div class="woolentor-variable-product-status" id="woolentor-stock-status-<?php echo esc_attr($id); ?>"></div>
                <script>
                    ;jQuery(document).ready(function($) {
                        'use strict';
                        let widgetUniqid = '<?php echo esc_js($id); ?>';
                        $( '.single_variation_wrap' ).on( 'show_variation', function ( event, variation ) {
                            $('#woolentor-stock-status-'+widgetUniqid).html(variation?.availability_html);
                        });

                        $('.variations').find('.reset_variations').on('click', function(e){
                            $('#woolentor-stock-status-'+widgetUniqid).html('');
                        });
                    });
                </script>
            <?php
        }
        

    }

}
