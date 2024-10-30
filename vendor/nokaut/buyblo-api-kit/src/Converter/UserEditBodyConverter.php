<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 13.04.2017
 * Time: 10:22
 */

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Entity\User;

class UserEditBodyConverter
{
    public function convert(User $user, $updateMode = false, bool $setVisible = null)
    {
        $body = $userBody = array();

        if (!$updateMode) {
            $userBody['slug'] = $user->getSlug();
            $userBody['region'] = 'pl';
            $userBody['recommendation_code'] = $user->getRecommendationCode();
        }
        if ($setVisible !== null) {
            $userBody['external_visibility'] = $setVisible;
        }
        $userBody['title'] = $user->getTitle();
        $userBody['description'] = $user->getDescription();
        $userBody['url'] = $user->getUrl();
        $userBody['external_logo_url'] = $user->getExternalLogoUrl();
        $userBody['facebook_url'] = $user->getFacebookUrl();
        $userBody['instagram_url'] = $user->getInstagramUrl();
        $userBody['first_name'] = $user->getFirstName();
        $userBody['last_name'] = $user->getLastName();
        $userBody['website_platform'] = $user->getWebsitePlatform();

        $body['user'] = $userBody;

        return json_encode($body);
    }
}