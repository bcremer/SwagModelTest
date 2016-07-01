<?php

namespace SwagModelTest;

use Doctrine\ORM\Tools\SchemaTool;
use Shopware\Components\Plugin;
use SwagModelTest\Models\BlogEntry;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class SwagModelTest extends Plugin
{
   public static function getSubscribedEvents()
   {
       return [
           'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'onPostDispatch'
       ];
   }

    /***
     * @param \Enlight_Event_EventArgs $args
     */
    public function onPostDispatch(\Enlight_Event_EventArgs $args)
    {
        $em = $this->container->get('models');
        $repository = $em->getRepository(BlogEntry::class);

        /** @var BlogEntry $blogEntry */
        $blogEntry = $repository->findOneBy(['name' => 'My First entry']);

        if (!$blogEntry) {
            $blogEntry = new BlogEntry('My First entry');
            $em->persist($blogEntry);
        } else {
            $blogEntry->increaseViews();
        }

        $em->flush($blogEntry);
    }

    /**
     * @inheritdoc
     */
    public function install(InstallContext $context)
    {
        $this->createSchema();
        parent::install($context);
    }

    /**
     * @inheritdoc
     */
    public function uninstall(UninstallContext $context)
    {
        $this->removeSchema();
        parent::uninstall($context);
    }

    /**
     * creates database tables on base of doctrine models
     */
    private function createSchema()
    {
        $tool = new SchemaTool($this->container->get('models'));

        $classes = [
            $this->container->get('models')->getClassMetadata(BlogEntry::class)
        ];

        $tool->createSchema($classes);
    }

    private function removeSchema()
    {
        $tool = new SchemaTool($this->container->get('models'));

        $classes = [
            $this->container->get('models')->getClassMetadata(BlogEntry::class)
        ];

        $tool->dropSchema($classes);
    }
}
