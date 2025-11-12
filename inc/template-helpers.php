<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'pe_readable_date' ) ) {
    function pe_readable_date( $ymd ) {
        if ( ! $ymd ) return '';
        $ts = strtotime( $ymd );
        return date_i18n( get_option('date_format'), $ts );
    }
}
