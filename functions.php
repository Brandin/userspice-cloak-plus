<?php

if (!function_exists('CloakPlus_Cloak')) {
    function CloakPlus_Cloak($cloakTo, $opts = [])
    {
        global $user, $master_account, $us_url_root;

        $return = [];
        $return['state'] = false;

        if (!$user->isLoggedIn()) {
            $return['error'] = 'not_logged_in';

            return $return;
        }

        $cloakTo = (int) $cloakTo;
        if ($cloakTo === null || !userIdExists($cloakTo)) {
            $return['error'] = 'cloakee_invalid';

            return $return;
        }

        if ($user->data()->id == $cloakTo) {
            $return['error'] = 'cloakee_is_self';

            return $return;
        }

        if (!in_array('skip_master_check', $opts)) {
            if (!in_array($user->data()->id, $master_account)) {
                $return['error'] = 'cloaker_not_in_master_array';

                return $return;
            }
        }

        if (!in_array('allow_master_cloaking', $opts)) {
            if (in_array($cloakTo, $master_account)) {
                $return['error'] = 'cloakee_in_master_array';

                return $return;
            }
        }

        $data = [
          'cloak_from' => $user->data()->id,
          'cloak_to' => $cloakTo,
        ];

        if (!in_array('do_not_store_original_dest', $opts)) {
            $request_uri = $_SERVER['REQUEST_URI'];
            $request_uri = explode($us_url_root, $request_uri);
            if (($request_uri[1] ?? null) != null) {
                $data['CloakPlus_dest'] = $request_uri[1];
            }
        }

        if (in_array('disable_logout_uncloak', $opts)) {
            $data['CloakPlus_disable_logout_uncloak'] = true;
        }

        foreach ($data as $key => $value) {
            Session::put($key, $value);
        }
        logger($user->data()->id, __FUNCTION__, "Cloaked into {$cloakTo}");
        $return['state'] = true;

        if (in_array('no_redirect_on_success', $opts)) {
            return $return;
        }

        Redirect::to($us_url_root);
    }
}
