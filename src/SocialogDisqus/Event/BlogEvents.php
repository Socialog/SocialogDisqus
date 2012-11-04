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
        'theme' => array(
            'post.post@100' => 'onRenderPost',
            'body.bottom@100' => 'onRenderBodyBottom',
            'home-post.post@100' => 'onHomeRenderPost',
        ),
    );

    /**
     * @param \Zend\EventManager\Event $e
     * @return String
     */
    public function onRenderPost(Event $e)
    {
        $e->stopPropagation(true);
        $sm = $this->getServiceLocator();
        $viewRenderer = $sm->get('ViewRenderer');
        return $viewRenderer->partial('socialog-disqus/post');
    }

    /**
     * @param \Zend\EventManager\Event $e
     * @return String
     */
    public function onRenderBodyBottom(Event $e)
    {
        $sm = $this->getServiceLocator();
        $viewRenderer = $sm->get('ViewRenderer');
        return $viewRenderer->partial('socialog-disqus/home/bottom');
    }

    /**
     * @param \Zend\EventManager\Event $e
     * @return String
     */
    public function onHomeRenderPost(Event $e)
    {
        $sm = $this->getServiceLocator();
        $viewRenderer = $sm->get('ViewRenderer');
        return $viewRenderer->partial('socialog-disqus/home/post', $e->getParams());
    }

}