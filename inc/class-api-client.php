<?php
if (!defined('ABSPATH')) exit;

class Xupport_API_Client
{
    private static $token_key = 'xupport_api_token';

    public static function get_token()
    {
        $cached = get_transient(self::$token_key);
        if ($cached) return $cached;

        $resp = wp_remote_post(XUPPORT_API_BASE . '/auth/login', [
            'headers' => [
                'Auth'         => XUPPORT_API_AUTH,
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ],
            'body'    => wp_json_encode([
                'username' => XUPPORT_API_USER,
                'password' => XUPPORT_API_PASS,
            ]),
            'timeout' => 12,
        ]);

        if (is_wp_error($resp)) return false;
        $code = wp_remote_retrieve_response_code($resp);
        $body = json_decode(wp_remote_retrieve_body($resp), true);
        if ($code !== 200 || empty($body['token'])) return false;

        $token = $body['token'];

        // TTL dal JWT exp (fallback 1h)
        $ttl = HOUR_IN_SECONDS;
        $parts = explode('.', $token);
        if (count($parts) === 3) {
            $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);
            if (!empty($payload['exp'])) {
                $ttl = max(300, (int)$payload['exp'] - time() - 300);
            }
        }
        set_transient(self::$token_key, $token, $ttl);
        return $token;
    }

    public static function get($path)
    {
        $token = self::get_token();
        if (!$token) return new WP_Error('xupport_no_token', 'Impossibile ottenere token');
        $resp = wp_remote_get(XUPPORT_API_BASE . $path, [
            'headers' => [
                'Auth'          => XUPPORT_API_AUTH,
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json',
            ],
            'timeout' => 12,
        ]);
        return $resp;
    }

    public static function post($path, $payload, $is_json = true)
    {
        $token = self::get_token();
        if (!$token) return new WP_Error('xupport_no_token', 'Impossibile ottenere token');
        $args = [
            'headers' => [
                'Auth'          => XUPPORT_API_AUTH,
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json',
            ],
            'timeout' => 20,
        ];
        if ($is_json) {
            $args['headers']['Content-Type'] = 'application/json';
            $args['body'] = wp_json_encode($payload);
        } else {
            $args['body'] = $payload; // per upload multipart/form-data
        }
        return wp_remote_post(XUPPORT_API_BASE . $path, $args);
    }
}
