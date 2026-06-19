<?php
/**
 * AJAX: contact form + newsletter subscribe
 *
 * @package Shopping
 * Extracted from functions.php for maintainability.
 */
if ( ! defined( "ABSPATH" ) ) { exit; }

/* ═══════════════════════════════════════
   CONTACT FORM HANDLER
═══════════════════════════════════════ */
add_action( 'wp_ajax_alluvia_contact', 'alluvia_handle_contact' );
add_action( 'wp_ajax_nopriv_alluvia_contact', 'alluvia_handle_contact' );
function alluvia_handle_contact() {
    check_ajax_referer( 'alluvia_contact_nonce', 'nonce' );

    $name    = sanitize_text_field( $_POST['name'] ?? '' );
    $email   = sanitize_email( $_POST['email'] ?? '' );
    $subject = sanitize_text_field( $_POST['subject'] ?? 'Contact Form Submission' );
    $message = sanitize_textarea_field( $_POST['message'] ?? '' );

    if ( ! $name || ! is_email( $email ) || ! $message ) {
        wp_send_json_error( array( 'message' => 'Please fill in all required fields.' ) );
    }

    $to      = get_option( 'admin_email' );
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        "Reply-To: {$name} <{$email}>",
    );

    $body = '<p><strong>From:</strong> ' . esc_html( $name ) . ' (' . esc_html( $email ) . ')</p>'
          . '<p><strong>Subject:</strong> ' . esc_html( $subject ) . '</p>'
          . '<p><strong>Message:</strong><br>' . nl2br( esc_html( $message ) ) . '</p>';

    $sent = wp_mail( $to, "Alluvia Contact: {$subject}", $body, $headers );

    if ( $sent ) {
        wp_send_json_success( array( 'message' => 'Message sent. We\'ll be in touch within 24 hours.' ) );
    } else {
        wp_send_json_error( array( 'message' => 'Failed to send. Please email us directly.' ) );
    }
}

/* ═══════════════════════════════════════
   NEWSLETTER / EMAIL SUBSCRIBE
═══════════════════════════════════════ */
add_action( 'wp_ajax_alluvia_subscribe', 'alluvia_handle_subscribe' );
add_action( 'wp_ajax_nopriv_alluvia_subscribe', 'alluvia_handle_subscribe' );
function alluvia_handle_subscribe() {
    check_ajax_referer( 'alluvia_sub_nonce', 'nonce' );
    $email = sanitize_email( $_POST['email'] ?? '' );
    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Invalid email address.' ) );
    }
    // Log to options (replace with Mailchimp/ActiveCampaign API call in production)
    $subs   = get_option( 'alluvia_subscribers', array() );
    $subs[] = array( 'email' => $email, 'date' => current_time( 'mysql' ) );
    update_option( 'alluvia_subscribers', array_unique( array_column( $subs, 'email' ) ) );
    wp_send_json_success( array( 'message' => 'Welcome! You\'re on the list.' ) );
}

