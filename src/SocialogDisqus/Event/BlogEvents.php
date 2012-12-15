<?php

namespace SocialogDisqus\Event;

use Socialog\EventManager\AbstractListenerAggregate;
use Zend\EventManager\Event;

/**
 * Hook into Theme events
 */
class BlogEvents extends AbstractListenerAggregate
{
    protected $globalHooks = array(
        'view' => array(
            'post.post@100'         => 'onRenderPost',
            'body.bottom@100'       => 'onRenderBodyBottom',
            'home-post.post@100'    => 'onHomeRenderPost',
        ),
    );

    /**
     * @param \Zend\EventManager\Event $e
     * @return String
     */
    public function onRenderPost(Event $e)
    {
        return $e->getTarget()->partial('socialog-disqus/post', $e->getParams());
    }

    /**
     * @param \Zend\EventManager\Event $e
     * @return String
     */
    public function onRenderBodyBottom(Event $e)
    {
        return $e->getTarget()->partial('socialog-disqus/home/bottom', $e->getParams());
    }

    /**
     * @param \Zend\EventManager\Event $e
     * @return String
     */
    public function onHomeRenderPost(Event $e)
    {
        return $e->getTarget()->partial('socialog-disqus/home/post', $e->getParams());
    }
}