<?php
namespace Safe\CatBundle\Service;

use Safe\CatBundle\Repository\ItemBankRepository;
use Safe\CatBundle\Repository\ItemRepository;
use Safe\CatBundle\Repository\ItemResultRepository;
use Safe\CatBundle\Repository\ExamineeRepository;
use Safe\CatBundle\Repository\AbilityRepository;
use Safe\CatBundle\Repository\PastAbilityRepository;

use Safe\CatBundle\Entity\IrtEquations;
use Safe\CatBundle\Entity\Ability;
use Safe\CatBundle\Entity\ItemBank;
use Safe\CatBundle\Entity\ItemResult;
use Safe\CatBundle\Entity\ThetaEstimation;
use Safe\CatBundle\Entity\ThetaEstimationMethodType;
use Safe\CatBundle\Entity\ExamineeTestStatus;

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Util\Debug;
use Symfony\Bridge\Monolog\Logger;

class CATService {
    private $itemBankRepository;
    private $itemRepository;
    private $itemResultRepository;
    private $examineeRepository;
    private $abilityRepository;
    private $pastAbilityRepository;
    private $entityManager;
    private $logger;
    
    public function __construct(EntityManager $entityManager, ItemBankRepository $itemBankRepository, ItemRepository $itemRepository, ItemResultRepository $itemResultRepository,
            ExamineeRepository $examineeRepository, AbilityRepository $abilityRepository, Logger $logger)
    {
        $this->entityManager = $entityManager;
        $this->itemBankRepository = $itemBankRepository;
        $this->itemRepository = $itemRepository;
        $this->itemResultRepository = $itemResultRepository;
        $this->examineeRepository = $examineeRepository;
        $this->abilityRepository = $abilityRepository;
        $this->logger = $logger;
    }
    
    public function findAllItemBanks($limit = null, $offset = null) {
        return $this->itemBankRepository->findBy(array(), null, $limit, $offset);
    }
    
    public function getItemBankByCode($code) {
        return $this->itemBankRepository->findOneByCode($code);
    }
    
    public function getItemByCode($code) {
        return $this->itemRepository->findOneByCode($code);
    }
    
    public function findAllExaminees($limit = null, $offset = null) {
        return $this->examineeRepository->findBy(array(), null, $limit, $offset);
    }
    
    public function getExamineeByCode($code) {
        return $this->examineeRepository->findOneByCode($code);
    }
    
    public function getNextItemFor($item_bank_code, $examinee_code) {
        $ability = $this->getOrCreateAbility($examinee_code, $item_bank_code);
        $items = $this->findAvailableItem($item_bank_code, $examinee_code);        
        $maxInformation = null;
        $nextItem = null;
        foreach ($items as $item) {
            $information = IrtEquations::informationI($ability->getTheta(), $item);
            if ($maxInformation == null || $maxInformation <= $information) {
                if (($maxInformation == $information && $nextItem->getB() < $item->getB())
                     || $maxInformation < $information) {
                    $nextItem = $item;
                    $maxInformation = $information;
                }
            }
            //echo "information: ".$information." id[".$item->getId()."] code[".$item->getCode()."] difficulty: ".$item->getB()."\n";            
        }   
        //echo "NEXT id[".$nextItem->getId()."] code[".$nextItem->getCode()."] difficulty: ".$nextItem->getB()."\n";
        return $nextItem;
    }
    
    public function getExamineeStatusFor($item_bank_code, $examinee_code) {
        $ability = $this->getOrCreateAbility($examinee_code, $item_bank_code);
        $itemBank = $this->getItemBankByCode($item_bank_code);
        $examineeTestStatus = new ExamineeTestStatus(ExamineeTestStatus::FAIL, $ability->getTheta(), $ability->getThetaError(), $itemBank->getDiscretIncrement());
        
        if ($ability->getTheta() >= $itemBank->getExpectedTheta()) {
            if ($ability->getUnsignedThetaError() <= $itemBank->getDiscretIncrement()){
                $examineeTestStatus->setStatus(ExamineeTestStatus::APPROVED);
            } else {
                $examineeTestStatus->setStatus(ExamineeTestStatus::APPROVED_WITH_ERROR);
            }
        }
        return $examineeTestStatus;
    }
    
    public function registerResult($examinee_code, $item_code, $result) {        
        $this->entityManager->getConnection()->beginTransaction();
        try {
            $examinee = $this->getExamineeByCode($examinee_code);
            $item = $this->itemRepository->findOneByCode($item_code);            
            $item->addResult($examinee, $result);
            $this->itemRepository->save($item);       
            $itemBank = $item->getItemBank();            
            $ability = $this->abilityRepository->findOneAbility($examinee->getCode(), $itemBank->getCode());    
            
            $itemResults = $this->getItemResults($itemBank->getCode(), $examinee_code);
            if (ThetaEstimationMethodType::THETA_MLE == $itemBank->getThetaEstimationMethod()) {
                $thetaEstimation = IrtEquations::estimateNewThetaWithStandarErrorML($ability->getTheta(), $itemResults, $itemBank->getDiscretIncrement(), $itemBank->getItemRange(), $this->logger);
            } else {
                $thetaEstimation = IrtEquations::estimateNewThetaWithStandarErrorNR($ability->getTheta(), $itemResults, $itemBank->getDiscretIncrement(), $itemBank->getItemRange(), $this->logger);
            }
            $this->logger->addDebug("###################################Original theta ".$ability->getTheta());
            $ability->updateTheta($thetaEstimation->getTheta());
            $ability->setThetaError($thetaEstimation->getStandarError());
            
            //$this->logger->addDebug("###################################Current theta ".$thetaEstimation->getTheta());
            //foreach ($ability->getPastAbilities() as $value) {
            //    $this->logger->addDebug("###################################Past theta ".$value->getTheta());
            //}

            $this->abilityRepository->save($ability);
            $this->entityManager->getConnection()->commit();
            return $thetaEstimation;
        } catch (Exception $e) {
            $this->entityManager->getConnection()->rollBack();
            throw $e;
        }
    }
    
    public function getAbility($examinee_code, $item_bank_code) {
        return $this->abilityRepository->findOneAbility($examinee_code, $item_bank_code);
    }
    
    public function getItemResults($item_bank_code, $examinee_code) {
        $queryItem = $this->itemRepository->createQueryBuilder('item')
                       ->join('item.itemBank', 'ib')                                       
                       ->where('ib.code = :item_bank_code')
                       ->andWhere('itemResult.item = item');
        
        $query = $this->itemResultRepository->createQueryBuilder('itemResult');
        $query->join('itemResult.examinee', 'e')                                                        
                ->where('e.code= :examinee_code')
                ->andWhere($query->expr()->exists($queryItem->getDQL()))
                ->setParameter('item_bank_code', $item_bank_code)
                ->setParameter('examinee_code', $examinee_code);

        return $query->getQuery()->getResult();
    }
    
    protected function getOrCreateAbility($examinee_code, $item_bank_code) {
        $ability = $this->getAbility($examinee_code, $item_bank_code);
        if ($ability == null) {
            return $this->createAbilityFor($examinee_code, $item_bank_code);
        }
        return $ability;
    }


    protected function createAbilityFor($examinee_code, $item_bank_code) {
        $examinee = $this->getExamineeByCode($examinee_code);
        if ($examinee == null) {
            throw new EntityNotFoundException("Examinee with code [".$examinee_code."] not found");
        }
        
        $itemBank = $this->getItemBankByCode($item_bank_code);
        if ($itemBank == null) {
            throw new EntityNotFoundException("ItemBank with code [".$item_bank_code."] not found");
        }
        
        $ability = new Ability($examinee, $itemBank, 0);
        return $this->abilityRepository->save($ability);
    }
    
    protected function findAvailableItem($item_bank_code, $examinee_code) {
        $queryItemResult = $this->itemResultRepository->createQueryBuilder('itemResult')
                                                       ->join('itemResult.examinee', 'e') 
                                                       ->where('e.code= :examinee_code')
                                                       ->andWhere('itemResult.item = item')
                                                       ;
        $query = $this->itemRepository->createQueryBuilder('item');
        
        $query = $query->join('item.itemBank', 'ib')                                       
                       ->where('ib.code = :item_bank_code')
                       ->andWhere('item.enabled = true')
                       ->andWhere($query->expr()->not($query->expr()->exists($queryItemResult->getDQL()))) 
                       ->setParameter('item_bank_code', $item_bank_code)
                       ->setParameter('examinee_code', $examinee_code) 
                 ;
        
         return $query->getQuery()->getResult();
    }
}
