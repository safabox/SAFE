<?php

namespace Safe\CatBundle\Tests\Service;

use Liip\FunctionalTestBundle\Test\WebTestCase;

use Doctrine\Common\Util\Debug;

abstract class SafeCATServiceTest extends WebTestCase {
    protected $em;
    
    public function setUp(){
        self::bootKernel();
        //loadFixtures
        $fixtures = array(
                          'Safe\CoreBundle\DataFixtures\ORM\CoreData',
                          'Safe\InstitutoBundle\DataFixtures\ORM\InstitutoData', 
                          'Safe\AdminBundle\DataFixtures\ORM\AdminData',
                          'Safe\DocenteBundle\DataFixtures\ORM\DocenteData',
                          'Safe\AlumnoBundle\DataFixtures\ORM\AlumnoData',
                          'Safe\CursoBundle\DataFixtures\ORM\CursoData',
                          'Safe\CatBundle\DataFixtures\ORM\CATData',
                          
            );
        $this->loadFixtures($fixtures);
        
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
    }
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
        $this->em = null; // avoid memory leaks
    }
    
    protected function getExaminee($code) {
        return $this->em
            ->getRepository('SafeCatBundle:Examinee')
            ->findOneByCode($code)
        ;
    }
    
    protected function getItemBank($code) {
        return $this->em
            ->getRepository('SafeCatBundle:ItemBank')
            ->findOneByCode($code)
        ;
    }
    
    protected function getItem($code) {
        return $this->getContainer()
            ->get('safe_cat.repository.item')
            ->findOneByCode($code)
        ;
    }
    
    protected function getAbility($examinee_code, $itemBank_code) {
        return $this->getContainer()
                ->get('safe_cat.repository.ability')
                ->findOneAbility($examinee_code, $itemBank_code);
        
    }
    
    
}
