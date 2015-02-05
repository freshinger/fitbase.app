<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 04/02/15
 * Time: 10:19
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Test\Component\Chooser;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Fitbase\Bundle\WeeklytaskBundle\Component\Chooser\ChooserWeeklytask;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;

class ChooserWeeklytaskTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Check that only not existed
     * weeklytask will choosed
     *
     */
    public function testChooserShouldSelectNotUsedWeeklytask()
    {
        $category1 = (new Category())
            ->addWeeklytask((new Weeklytask())
                ->setId(1)
                ->setPriority(1))
            ->addWeeklytask((new Weeklytask())
                ->setId(2)
                ->setPriority(2))
            ->addWeeklytask((new Weeklytask())
                ->setId(3)
                ->setPriority(3));


        $weeklytask = (new ChooserWeeklytask())
            ->choose(array($category1), array(1, 2));


        $this->assertEquals($weeklytask->getId(), 3);
    }

    /**
     * Check that only not existed weeklytask
     * from second category will choosed
     */
    public function testChooserShouldSelectNotUsedWeeklytaskFromSecondCategory()
    {
        $category1 = (new Category())
            ->addWeeklytask((new Weeklytask())
                ->setId(1)
                ->setPriority(1))
            ->addWeeklytask((new Weeklytask())
                ->setId(2)
                ->setPriority(2))
            ->addWeeklytask((new Weeklytask())
                ->setId(3)
                ->setPriority(3));


        $category2 = (new Category())
            ->addWeeklytask((new Weeklytask())
                ->setId(4)
                ->setPriority(1))
            ->addWeeklytask((new Weeklytask())
                ->setId(5)
                ->setPriority(2))
            ->addWeeklytask((new Weeklytask())
                ->setId(6)
                ->setPriority(3));

        $weeklytask = (new ChooserWeeklytask())
            ->choose(array($category1, $category2), array(1, 2, 3, 4, 5));


        $this->assertEquals($weeklytask->getId(), 6);
    }

    /**
     * Check that only not existed weeklytask
     * from third category will be choosed
     *
     */
    public function testChooserShouldSelectNotUsedWeeklytaskFromThirdCategory()
    {
        $category1 = (new Category())
            ->addWeeklytask((new Weeklytask())
                ->setId(1)
                ->setPriority(1))
            ->addWeeklytask((new Weeklytask())
                ->setId(2)
                ->setPriority(2))
            ->addWeeklytask((new Weeklytask())
                ->setId(3)
                ->setPriority(3));

        $category2 = (new Category())
            ->addWeeklytask((new Weeklytask())
                ->setId(1)
                ->setPriority(1))
            ->addWeeklytask((new Weeklytask())
                ->setId(2)
                ->setPriority(2))
            ->addWeeklytask((new Weeklytask())
                ->setId(3)
                ->setPriority(3));

        $category3 = (new Category())
            ->addWeeklytask((new Weeklytask())
                ->setId(7)
                ->setPriority(1))
            ->addWeeklytask((new Weeklytask())
                ->setId(8)
                ->setPriority(2))
            ->addWeeklytask((new Weeklytask())
                ->setId(9)
                ->setPriority(3));

        $weeklytask = (new ChooserWeeklytask())
            ->choose(array($category1, $category2, $category3), array(1, 2, 3, 4, 5, 6));

        $this->assertEquals($weeklytask->getId(), 7);
    }
} 