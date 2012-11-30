<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * Default assortment categories to play with Sylius sandbox.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadProductCategoriesData extends DataFixture
{
    /**
     * Category manager.
     *
     * @var CategoryManagerInterface
     */
    private $manager;

    /**
     * Category manipulator.
     *
     * @var CategoryManipulatorInterface
     */
    private $manipulator;

    /**
     * Assortment products catalog.
     *
     * @var CatalogInterface
     */
    private $catalog;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $this->container->get('sylius_categorizer.manager.category');
        $this->manipulator = $this->container->get('sylius_categorizer.manipulator.category');
        $this->catalog = $this->container->get('sylius_categorizer.registry')->getCatalog('assortment');

        $this->createCategory('T-Shirts');
        $this->createCategory('Stickers');
        $this->createCategory('Mugs');
        $this->createCategory('Books');
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 5;
    }

    /**
     * Create and save category.
     *
     * @param string $name
     */
    private function createCategory($name)
    {
        $category = $this->manager->createCategory($this->catalog);
        $category->setName($name);

        $this->manipulator->create($category);
        $this->setReference('Category.'.$name, $category);
    }
}
