<?php

namespace SocialogDisqus;

use Zend\Mvc\MvcEvent;

class Module
{
    /**
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $sm = $app->getServiceManager();
        /* @var $sharedEventManager \Zend\EventManager\SharedEventManager */
        $sharedEventManager = $sm->get('SharedEventManager');

        $sharedEventManager->attach('theme', 'post.post', function($e) use ($sm) {
            $e->stopPropagation(true);
            $viewRenderer = $sm->get('ViewRenderer');
            return $viewRenderer->partial('socialog-disqus/post');
        }, 100);
        
        // Append frontpage information
        $sharedEventManager->attach('theme', 'body.bottom', function($e) use ($sm) {
            return $sm->get('ViewRenderer')->partial('socialog-disqus/home/bottom');
        }, 100);

        $sharedEventManager->attach('theme', 'home-post.post', function($e) use ($sm) {
            $viewRenderer = $sm->get('ViewRenderer');
            return $viewRenderer->partial('socialog-disqus/home/post', $e->getParams());
        }, 100);
    }
    
    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__	=> __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * 
     * @return array
     */
	public function getServiceConfig()
	{
		return include __DIR__ . '/config/service.config.php';
	}
}
