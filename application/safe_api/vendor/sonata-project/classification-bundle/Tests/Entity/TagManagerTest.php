<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\ClassificationBundle\Tests\Entity;

use Sonata\ClassificationBundle\Entity\TagManager;
use Sonata\CoreBundle\Test\EntityManagerMockFactory;

/**
 * Class TagManagerTest.
 */
class TagManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPager()
    {
        $self = $this;
        $this
            ->getTagManager(function ($qb) use ($self) {
                $qb->expects($self->never())->method('andWhere');
                $qb->expects($self->once())->method('setParameters')->with(array());
            })
            ->getPager(array(), 1);
    }

    public function testGetPagerWithEnabledTags()
    {
        $self = $this;
        $this
            ->getTagManager(function ($qb) use ($self) {
                $qb->expects($self->once())->method('andWhere')->with($self->equalTo('t.enabled = :enabled'));
                $qb->expects($self->once())->method('setParameters')->with(array('enabled' => true));
            })
            ->getPager(array(
                'enabled' => true,
            ), 1);
    }

    public function testGetPagerWithDisabledTags()
    {
        $self = $this;
        $this
            ->getTagManager(function ($qb) use ($self) {
                $qb->expects($self->once())->method('andWhere')->with($self->equalTo('t.enabled = :enabled'));
                $qb->expects($self->once())->method('setParameters')->with(array('enabled' => false));
            })
            ->getPager(array(
                'enabled' => false,
            ), 1);
    }

    protected function getTagManager($qbCallback)
    {
        $em = EntityManagerMockFactory::create($this, $qbCallback, array());

        $registry = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $registry->expects($this->any())->method('getManagerForClass')->will($this->returnValue($em));

        return new TagManager('Sonata\PageBundle\Entity\BaseTag', $registry);
    }
}
