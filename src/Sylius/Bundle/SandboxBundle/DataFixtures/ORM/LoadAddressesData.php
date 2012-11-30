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
 * Default addresssing fixtures to play with Sylius sandbox.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadAddressesData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $addressManager = $this->getAddressManager();

        for ($i = 1; $i <= 100; $i++) {
            $address = $addressManager->create();

            $address->setFirstname($this->faker->firstName);
            $address->setLastname($this->faker->lastName);
            $address->setCity($this->faker->city);
            $address->setStreet($this->faker->streetAddress);
            $address->setPostcode($this->faker->postcode);

            $addressManager->persist($address, false);

            $this->setReference('Address-'.$i, $address);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 7;
    }

    private function getAddressManager()
    {
        return $this->get('sylius_addressing.manager.address');
    }
}
