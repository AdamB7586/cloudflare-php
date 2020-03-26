<?php
/**
 * Created by PhpStorm.
 * User: paul.adams
 * Date: 2019-02-22
 * Time: 23:28
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class ZoneSettings implements API
{
    use BodyAccessorTrait;

    private $adapter;
    
    protected $availableMethods = [
        'OpportunisticOnion' => 'opportunistic_onion',
        'AutomaticHTTPSRewrites' => 'automatic_https_rewrites',
        'Minify' => 'minify',
        'RocketLoader' => 'rocket_loader',
        'AlwaysOnline' => 'always_online',
        'AlwaysUseHTTPS' => 'always_use_https',
        'EmailObfuscation' => 'email_obfuscation',
        'ServerSideExclude' => 'server_side_exclude',
        'HotlinkProtection' => 'hotlink_protection',
        'CacheLevel' => 'cache_level',
        'ChallengeTTL' => 'challenge_ttl',
        'BrowserCacheTTL' => 'browser_cache_ttl',
        'BrowserCheck' => 'browser_check',
        'IPGeolocation' => 'ip_geolocation',
        'Mirage' => 'mirage',
        'Polish' => 'polish',
        'WebP' => 'webp',
        'Brotli' => 'brotli',
        'MobileRedirect' => 'mobile_redirect',
        'ResponseBuffering' => 'response_buffering',
        'SSL' => 'ssl',
        'MinimumTLSVersion' => 'min_tls_version',
        'Ciphers' => 'ciphers',
        'TLS13' => 'tls_1_3',
        'TLSClientAuth' => 'tls_client_auth',
        'WAF' => 'waf',
        'HTTP2' => 'http2',
        'HTTP3' => 'http3',
        '0RTT' => '0rtt',
        'ImageResizing' => 'image_resizing',
        'IPv6' => 'ipv6',
        'PseudoIPv4' => 'pseudo_ipv4',
        'WebSocket' => 'websockets',
        'PrivacyPass' => 'privacy_pass',
        'OpportunisticEncryption' => 'opportunistic_encryption',
        'EmailObfuscation' => 'email_obfuscation',
        'EnableErrorPagesOn' => 'origin_error_page_pass_thru',
        'PrefetchPreload' => 'prefetch_preload',
        'TrueClientIP' => 'true_client_ip_header',
        'HTTP2EdgePrioritization' => 'h2_prioritization',
        'SecurityLevel' => 'security_level',
        'DevelopmentMode' => 'development_mode'
    ];

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function updateMinifySetting(string $zoneID, string $html, string $css, string $javascript)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/minify',
            [
                'value' => [
                    'html' => $html,
                    'css'  => $css,
                    'js'   => $javascript,
                ],
            ]
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return true;
        }

        return false;
    }
    
    public function updateMobileRedirectSetting(string $zoneID, string $status, string $mobileSubdomain, bool $strip)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/mobile_redirect',
            [
                'value' => [
                    'status'           => $status,
                    'mobile_subdomain' => $mobileSubdomain,
                    'strip_uri'        => $strip,
                ],
            ]
        );
        $body   = json_decode($return->getBody());

        if ($body->success) {
            return true;
        }

        return false;
    }
    
    public function __call($name, $arguments)
    {
        $method = str_replace(['get', 'update', 'Setting'], '', $name);
        if (substr($name, 0, 3) !== 'get' && substr($name, 0, 6) !== 'update' || !array_key_exists($method, $this->availableMethods)) {
            throw new EndpointException('No such method exists');
        }
        return call_user_func_array([$this, (substr($name, 0, 3) === 'get' ? 'get' : 'update') . 'Setting'], array_merge([$method], $arguments));
    }

    protected function getSetting(string $method, string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/' . $this->availableMethods[$method]
        );
        $body   = json_decode($return->getBody());
        if (isset($body->result)) {
            return isset($body->result->value) ? $body->result->value : $body->result;
        }

        return false;
    }

    protected function updateSetting(string $method, string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/' . $this->availableMethods[$method],
            [
                'value' => $value,
            ]
        );
        $body   = json_decode($return->getBody());

        if (isset($body->success)) {
            return $body->success;
        }

        return false;
    }
}
