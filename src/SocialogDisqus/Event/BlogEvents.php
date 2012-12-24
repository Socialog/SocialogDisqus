<?php

namespace SocialogDisqus\Event;

use Socialog\EventManager\AbstractListenerAggregate;
use Socialog\Model\ArticleInterface;
use Zend\EventManager\Event;

/**
 * Hook into Theme events
 */
class BlogEvents extends AbstractListenerAggregate
{
    protected $globalHooks = array(
        'view' => array(
            'post.post@100'         => 'onRenderPost',
            'page.post@100'         => 'onRenderPost',
            'body.bottom@100'       => 'onRenderBodyBottom',
            'home-post.post@100'    => 'onHomeRenderPost',
        ),
    );

    /**
     * @param Event $e
     * @return string
     */
    public function onRenderPost(Event $e)
    {
        $article = $e->getParam('article');
        
        if ($article instanceof ArticleInterface && false == $article->getAllowComments()) {
            return;
        }
        
        return $e->getTarget()->partial('socialog-disqus/post', $e->getParams());
    }

    /**
     * @param Event $e
     * @return String
     */
    public function onRenderBodyBottom(Event $e)
    {
        $article = $e->getParam('article');
        
        if ($article instanceof ArticleInterface && false == $article->getAllowComments()) {
            return;
        }

        return $e->getTarget()->partial('socialog-disqus/home/bottom', $e->getParams());
    }

    /**
     * @param Event $e
     * @return String
     */
    public function onHomeRenderPost(Event $e)
    {
        $article = $e->getParam('article');
        
        if ($article instanceof ArticleInterface && false == $article->getAllowComments()) {
            return;
        }
        
        return $e->getTarget()->partial('socialog-disqus/home/post', $e->getParams());
    }
}