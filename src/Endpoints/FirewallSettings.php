<?php

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;

class FirewallSettings implements API
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Get the Security Level feature for a zone.
     *
     * @param string $zoneID The ID of the zone
     * @return string|false
     */
    public function getSecurityLevelSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/security_level'
        );
        $body = json_decode($return->getBody());
        if (isset($body->result)) {
            return $body->result->value;
        }
        return false;
    }

    /**
     * Get the Challenge TTL feature for a zone.
     *
     * @param string $zoneID The ID of the zone
     * @return integer|false
     */
    public function getChallengeTTLSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/challenge_ttl'
        );
        $body = json_decode($return->getBody());
        if (isset($body->result)) {
            return $body->result->value;
        }
        return false;
    }

    /**
     * Get the Browser Integrity Check feature for a zone.
     *
     * @param string $zoneID The ID of the zone
     * @return string|false
     */
    public function getBrowserIntegrityCheckSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/browser_check'
        );
        $body = json_decode($return->getBody());
        if (isset($body->result)) {
            return $body->result->value;
        }
        return false;
    }
    
    /**
     * Gets the Privacy Pass feature for a zone.
     *
     * @param string $zoneID The ID of the zone
     * @return string|false
     */
    public function getPrivacyPassSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/privacy_pass'
        );
        $body = json_decode($return->getBody());
        if (isset($body->result)) {
            return $body->result->value;
        }
        return false;
    }
    
    /**
     * Gets the bot management settings
     *
     * @param string $zoneID The ID of the zone
     * @return array|false
     */
    public function getBotManagementSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/bot_management'
        );
        $body = json_decode($return->getBody());
        if (isset($body->result)) {
            return $body->result;
        }
        return false;
    }

    /**
     * Update the Security Level setting for the zone
     *
     * @param string $zoneID The ID of the zone
     * @param string $value The value of the zone setting
     * @return bool
     */
    public function updateSecurityLevelSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/security_level',
            [
                'value' => $value,
            ]
        );
        $body = json_decode($return->getBody());
        if (isset($body->success) && $body->success == true) {
            return true;
        }
        return false;
    }

    /**
     * Update the Challenge TTL setting for the zone
     *
     * @param string $zoneID The ID of the zone
     * @param int $value The value of the zone setting
     * @return bool
     */
    public function updateChallengeTTLSetting(string $zoneID, int $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/challenge_ttl',
            [
                'value' => $value,
            ]
        );
        $body = json_decode($return->getBody());
        if (isset($body->success) && $body->success == true) {
            return true;
        }
        return false;
    }

    /**
     * Update the Browser Integrity Check setting for the zone
     *
     * @param string $zoneID The ID of the zone
     * @param string $value The value of the zone setting
     * @return bool
     */
    public function updateBrowserIntegrityCheckSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/browser_check',
            [
                'value' => $value,
            ]
        );
        $body = json_decode($return->getBody());
        if (isset($body->success) && $body->success == true) {
            return true;
        }
        return false;
    }
    
    /**
     * Update the Privacy Pass setting for the zone
     *
     * @param string $zoneID The ID of the zone
     * @param string $value The value of the zone setting
     * @return bool
     */
    public function updatePrivacyPassSetting(string $zoneID, string $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/privacy_pass',
            [
                'value' => $value,
            ]
        );
        $body = json_decode($return->getBody());
        if (isset($body->success)) {
            return $body->success;
        }
        return false;
    }
    
    /**
     * Update the Bot management setting for the zone
     *
     * @param string $zoneID The ID of the zone
     * @param boolean $value Enable or disable the bot management
     * @return bool
     */
    public function updateBotManagementSetting(string $zoneID, bool $value)
    {
        $return = $this->adapter->put(
            'zones/' . $zoneID . '/bot_management',
            [
                'fight_mode' => $value,
            ]
        );
        $body = json_decode($return->getBody());
        if (isset($body->success)) {
            return $body->success;
        }
        return false;
    }
}
