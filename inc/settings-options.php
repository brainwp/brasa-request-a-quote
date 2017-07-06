<?php
/*
 *
 * WP Settings API Page
 *
*/
$options = new Brasa_Request_A_Quote_Options(
    'brasa-request-a-quote', // page Slug/ID
    __( 'Request A Quote', 'brasa-request-a-quote' ), // page title
    'manage_options' // permission
);
$options->set_tabs(
    array(
        array(
            'id' => 'brasa-request-a-quote_general',
            'title' => __( 'General', 'brasa-request-a-quote' ), // tab title
        ),
        array(
            'id' => 'brasa-request-a-quote_email',
            'title' => __( 'E-mail', 'brasa-request-a-quote' ), // tab title
        ),

    )
);

$options->set_fields(
    array(
    	'brasa-request-a-quote_general' => array(
    	'tab'   => 'brasa-request-a-quote_general', // Sessão da aba odin_general
    	'title' => '',
    	'fields' => array(
    		array(
    			'id' => 'all_site',
    			'label' => __( 'Activate Brasa Request A Quote on all products', 'brasa-request-a-quote' ),
    			'type' => 'checkbox',
    			'default' => '',
    			),
    		)
        ),
        'brasa-request-a-quote' => array(
        'tab'   => 'brasa-request-a-quote_email', // Sessão da aba odin_general
    	'title' => '',
    	'fields' => array(
    		array(
    			'id' => 'email_title',
    			'label' => __( 'E-mail Title', 'brasa-request-a-quote' ),
    			'type' => 'text',
    			'default' => '',
    			),
    		array(
    			'id' => 'email_template',
    			'label' => __( 'E-mail Message', 'brasa-request-a-quote' ),
    			'type' => 'editor',
    			'default' => '',
    			),
    		)
        ),
    )
);
