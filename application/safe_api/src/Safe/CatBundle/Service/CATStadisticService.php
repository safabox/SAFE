<?php
namespace Safe\CatBundle\Service;

use Safe\CatBundle\Repository\ItemBankRepository;
use Safe\CatBundle\Repository\ItemRepository;
use Safe\CatBundle\Repository\ItemResultRepository;
use Safe\CatBundle\Repository\ExamineeRepository;
use Safe\CatBundle\Repository\AbilityRepository;


use Safe\CatBundle\Entity\IrtEquations;
use Safe\CatBundle\Entity\Ability;
use Safe\CatBundle\Entity\ItemBank;
use Safe\CatBundle\Entity\ItemResult;
use Safe\CatBundle\Entity\ThetaEstimation;
use Safe\CatBundle\Entity\ThetaEstimationMethodType;

use Safe\CatBundle\Entity\Stadistic\ExamineeItemBankStadistic;
use Safe\CatBundle\Entity\Stadistic\ExamineeStadistic;

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Util\Debug;

class CATStadisticService {
    private $itemBankRepository;
    private $itemRepository;
    private $itemResultRepository;
    private $examineeRepository;
    private $abilityRepository;
    private $entityManager;
    
    public function __construct(EntityManager $entityManager, ItemBankRepository $itemBankRepository, ItemRepository $itemRepository, ItemResultRepository $itemResultRepository,
            ExamineeRepository $examineeRepository, AbilityRepository $abilityRepository)
    {
        $this->entityManager = $entityManager;
        $this->itemBankRepository = $itemBankRepository;
        $this->itemRepository = $itemRepository;
        $this->itemResultRepository = $itemResultRepository;
        $this->examineeRepository = $examineeRepository;
        $this->abilityRepository = $abilityRepository;
        
    }
    
    public function findExamineesStadistics($examinee_code) {
        $examinee = $this->examineeRepository->findOneByCode($examinee_code);
        return $this->findExamineesStadisticsByExaminee($examinee);
    }
    
    public function findAllExamineesStadistics($limit = null, $offset = null){
        $examineeList = $this->examineeRepository->findAll(array(), null, $limit, $offset);
        $examineesStadisticList = array();
        foreach ($examineeList as $examinee) {
            $examineeStadistic = $this->findExamineesStadisticsByExaminee($examinee);
            $examineesStadisticList[] = $examineeStadistic;
        }
        
        return $examineesStadisticList;       
    }
    
    protected function findExamineesStadisticsByExaminee($examinee){
        $examineeStadistic = new ExamineeStadistic($examinee->getCode());
            
        $itemBankist = $this->itemBankRepository->findAll(array());
        foreach ($itemBankist as $itemBank) {
            $itemsCount = $this->countItemByExaminee($examinee, $itemBank);                
            $examineeItemBankStadistic = new ExamineeItemBankStadistic($itemBank->getCode(), $itemsCount['itemNumbers'], $itemsCount['itemsResolved'], $itemsCount['itemsResolvedOk']);
            $ability = $this->abilityRepository->findOneAbility($examinee->getCode(), $itemBank->getCode());
            if ($ability != null) {
                $examineeItemBankStadistic->setCurrentTheta($ability->getTheta());
                $examineeItemBankStadistic->setPastAbilities($ability->getPastAbilities());
            }
            $examineeStadistic->addItemBankStadistic($examineeItemBankStadistic);
        } 
        return $examineeStadistic;
    }




    protected function countItemByExaminee($examinee, $itemBank) {
        $query = $this->entityManager->createQuery('select '
                . ' count(i1) as itemNumbers, '
                . '(select count(i2)'
                    . ' from SafeCatBundle:Item i2 '
                    . ' where i2.itemBank = :itemBank'
                    . ' and exists (select ir2 from SafeCatBundle:ItemResult ir2 where ir2.item = i2 and ir2.examinee = :examinee)'    
                . ' ) as itemsResolved, '
                . '(select count(i3)'
                    . ' from SafeCatBundle:Item i3 '
                    . ' where i3.itemBank = :itemBank'
                    . ' and exists (select ir3 from SafeCatBundle:ItemResult ir3 where ir3.item = i3 and ir3.examinee = :examinee and ir3.result = 1)'    
                . ' ) as itemsResolvedOk '                
                . ' from SafeCatBundle:Item i1 '
                . ' where i1.itemBank = :itemBank'                
                );
 
         $query->setParameter('itemBank', $itemBank);
         $query->setParameter('examinee', $examinee);
         return $query->getSingleResult();
    }


}
