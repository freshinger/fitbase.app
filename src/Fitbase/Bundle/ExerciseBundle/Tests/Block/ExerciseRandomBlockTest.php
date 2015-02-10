<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 03/02/15
 * Time: 14:54
 */

namespace Fitbase\Bundle\ExerciseBundle\Tests\Block;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Fitbase\Bundle\ExerciseBundle\Block\ExerciseRandomBlockService;
use Fitbase\Bundle\ExerciseBundle\Entity\Exercise;
use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Model\Block;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ExerciseRandomBlockTest extends WebTestCase
{
    protected $name;
    protected $templating;
    protected $serviceUser;
    protected $objectManager;

    protected function container(array $options = array(), array $server = array())
    {
        static::bootKernel($options);
        return static::$kernel->getContainer();
    }


    public function setUp()
    {
        date_default_timezone_set('Europe/Berlin');

        $this->name = 'Exercise random block';

        $this->templating = $this->getMock('\Symfony\Bundle\FrameworkBundle\Templating\EngineInterface', array(
            'renderResponse', 'render', 'exists', 'supports'
        ));
        $this->templating->expects($this->any())
            ->method('renderResponse')
            ->will($this->returnValue(new Response()));
        $this->templating->expects($this->any())
            ->method('render')
            ->will($this->returnValue(true));
        $this->templating->expects($this->any())
            ->method('exists')
            ->will($this->returnValue(true));
        $this->templating->expects($this->any())
            ->method('supports')
            ->will($this->returnValue(true));
    }


    /**
     * Block should return response with code 200
     *
     */
    public function testBlockShouldReturnResponseWithCode200()
    {
        $blockContext = new BlockContext(new Block(), array(
            "category" => (new Category())
                ->addExercise((new Exercise())->setId(1))
                ->addExercise((new Exercise())->setId(2))
                ->addExercise((new Exercise())->setId(3)),
            'template' => 'FitbaseExerciseBundle:Block:exercise.html.twig',
        ));

        $block = new ExerciseRandomBlockService($this->name, $this->container()->get('templating'));


        $result = $block->execute($blockContext, new Response());

        $this->assertTrue($result instanceof Response);
        $this->assertEquals($result->getStatusCode(), 200);
    }
}