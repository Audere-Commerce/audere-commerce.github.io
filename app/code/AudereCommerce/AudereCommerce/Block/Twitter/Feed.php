<?php

namespace AudereCommerce\AudereCommerce\Block\Twitter;

use Magento\Framework\View\Element\Template;
use Abraham\TwitterOAuth\TwitterOAuth;

class Feed extends Template
{
    public function __construct(
        Template\Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }

    public function getTwitterPosts($count)
    {
        $apiPublicKey = $this->getWebsiteValue('social/twitter_auth/api_key_public');
        $apiSecretKey = $this->getWebsiteValue('social/twitter_auth/api_key_secret');
        $accessTokenPublic = $this->getWebsiteValue('social/twitter_auth/access_token_public');
        $accessTokenSecret = $this->getWebsiteValue('social/twitter_auth/access_token_secret');
        $userId = $this->getWebsiteValue('social/twitter_auth/user_id');

        if (!$apiPublicKey || !$apiSecretKey || !$accessTokenPublic || !$accessTokenSecret || !$userId) {
            return [];
        }

        $connection = new TwitterOAuth($apiPublicKey, $apiSecretKey, $accessTokenPublic, $accessTokenSecret);

        $connection->get('statuses/user_timeline', ['user_id' => $userId, 'count' => $count]);

        return $connection->getLastBody();
    }

    public function getWebsiteValue($path)
    {
        return $this->_scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getTimeAgo($dateTime, $full = false)
    {
        $now = new \DateTime;
        $ago = new \DateTime($dateTime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
