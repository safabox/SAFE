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

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Util\Debug;

class CATService {
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
    
    public function registerResult($examinee_code, $item_code, $result) {
        
        $this->entityManager->getConnection()->beginTransaction();
        try {
            $examinee = $this->getExamineeByCode($examinee_code);
            $item = $this->itemRepository->findOneByCode($item_code);            
            $item->addResult($examinee, $result);
            $this->itemRepository->save($item);       

            $itemBank = $item->getItemBank();
            $ability = $this->abilityRepository->findOneAbility($examinee->getCode(), $itemBank->getCode());
            if (ThetaEstimationMethodType::THETA_ML == $itemBank->getThetaEstimationMethod()) {
                $thetaEstimation = IrtEquations::estimateNewThetaWithStandarErrorML($ability->getTheta(), $item->getItemsResults(), $itemBank->getDiscretIncrement(), $itemBank->getItemRange());
            } else {
                $thetaEstimation = IrtEquations::estimateNewThetaWithStandarErrorNR($ability->getTheta(), $item->getItemsResults(), $itemBank->getDiscretIncrement(), $itemBank->getItemRange());
            }
            
            $ability->updateTheta($thetaEstimation->getTheta());

            $this->abilityRepository->save($ability);
            $this->entityManager->getConnection()->commit();
            return $thetaEstimation;
        } catch (Exception $e) {
            $this->entityManager->getConnection()->rollBack();
            throw $e;
        }
    }
    
    protected function getOrCreateAbility($examinee_code, $item_bank_code) {
        $ability = $this->abilityRepository->findOneAbility($examinee_code, $item_bank_code);
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
                       ->andWhere($query->expr()->not($query->expr()->exists($queryItemResult->getDQL()))) 
                       ->setParameter('item_bank_code', $item_bank_code)
                       ->setParameter('examinee_code', $examinee_code) 
                 ;
        
         return $query->getQuery()->getResult();
    }
}
