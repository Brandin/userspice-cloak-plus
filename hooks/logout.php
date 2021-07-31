<?php

global $user;

$cloakTo = Session::get('cloak_to');
$disableLogout = Session::get('CloakPlus_disable_logout_uncloak');
if ($disableLogout == null && $cloakTo != null) {
    $cloakFrom = Session::get('cloak_from');
    if ($cloakFrom != null) {
        Session::delete('cloak_to');
        Session::delete('cloak_from');
        Session::put(Config::get('session/session_name'), $cloakFrom);
        logger($cloakFrom, 'Cloaking', "Uncloaked from {$cloakTo}");
        $cloak_dest = Session::get('CloakPlus_dest');
        if ($cloak_dest != null) {
            Session::delete('cloak_dest');
            Redirect::to("{$us_url_root}{$cloak_dest}");
        } else {
            Redirect::to($us_url_root);
        }
        exit();
    } else {
        logger($user->data()->id, 'Cloaking', 'Uncloak Failed', ['ERROR' => 'no_cloak_from']);
    }
}
