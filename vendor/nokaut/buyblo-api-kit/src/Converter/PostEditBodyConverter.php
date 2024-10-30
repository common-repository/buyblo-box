<?php

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Entity\Group;
use Nokaut\BuybloApiKit\Entity\Product;
use Nokaut\BuybloApiKit\Entity\Post;
use Nokaut\BuybloApiKit\Entity\Post\Photo;

class PostEditBodyConverter
{
    /**
     * @param Post $post
     * @param bool $updateMode
     * @return \stdClass
     */
    public function convert(Post $post, $updateMode = false)
    {
        $body = new \stdClass();
        $postBody = array();

        $postBody['external_visibility'] = $post->getExternalVisibility();
        $postBody['external_change_allowed'] = $post->isExternalChangeAllowed();

        if ($post->getType()) {
            $postBody['type'] = $post->getType();
        }

        if ($post->getExternalId() && !$updateMode) {
            $postBody['external_id'] = $post->getExternalId();
        }

        if ($post->getExternalUrl()) {
            $postBody['external_url'] = $post->getExternalUrl();
        }

        if ($post->getRedirectUrl() || $updateMode) {
            $postBody['redirect_url'] = $post->getRedirectUrl();
        }

        $postBody['title'] = $post->getTitle();
        $postBody['content'] = $post->getContent();

        if (($post->getPhoto() && ($post->getPhoto()->getExternalUrl()) || $updateMode)) {
            $postBody['photo'] = $this->preparePhoto($post->getPhoto());
        }

        if ($post->getPostDate()) {
            $postBody['post_date'] = $post->getPostDate()->format('c');
        }

        if ($post->getGroups() || $updateMode) {
            $postBody['groups'] = $this->preparePostQueryGroups($post->getGroups());
        }

        $body->post = $postBody;

        return $body;
    }

    /**
     * @param Group[] $postGroups
     * @return array
     */
    private function preparePostQueryGroups(array $postGroups)
    {
        $groups = array();
        foreach ($postGroups as $group) {
            $tmpGroup = array();
            /** @var Product $product */
            foreach ($group->getProducts() as $product) {
                if ($product->isManual()) {
                    $tmpGroup[] = $product->getId();
                }
            }
            $groups[] = $tmpGroup;
        }

        return $groups;
    }

    /**
     * @param Photo $postPhoto
     * @return \stdClass
     */
    private function preparePhoto(Photo $postPhoto)
    {
        $photo = new \stdClass();
        $photo->external_url = $postPhoto->getExternalUrl() ? $postPhoto->getExternalUrl() : null;
        return $photo;
    }
}