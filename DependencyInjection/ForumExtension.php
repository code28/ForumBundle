<?php

namespace Bundle\ForumBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class ForumExtension extends Extension
{

    public function configLoad($config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, __DIR__ . '/../Resources/config');

        if (empty($config['db_driver'])) {
            throw new \Exception('You must choose the database driver to use (ORM or ODM).');
        }

        switch (strtolower($config['db_driver'])) {
            case 'orm':
                $loader->load('orm.xml');
                break;
            case 'odm':
                // TODO: Implement the ODM database driver
                throw new \Exception(sprintf('Sorry, the ODM database driver is not implemented yet.'));
                $loader->load('odm.xml');
                break;
            default:
                throw new \Exception('The "%s" database driver is not supported.', $config['db_driver']);
        }

        $loader->load('services.xml');
    }

    /**
     * Returns the namespace to be used for this extension (XML namespace).
     *
     * @return string The XML namespace
     */
    public function getNamespace()
    {
        return 'http://www.symfony-project.org/shemas/dic/symfony';
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     */
    public function getXsdValidationBasePath()
    {
        return null;
    }

    /**
     * Returns the recommended alias to use in XML.
     *
     * This alias is also the mandatory prefix to use when using YAML.
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return 'forum';
    }

}