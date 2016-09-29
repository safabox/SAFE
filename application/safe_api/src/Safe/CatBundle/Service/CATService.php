<?php
namespace Safe\CatBundle\Service;

use Safe\CatBundle\Repository\ItemBankRepository;

class CATService {
    private $itemBankRepository;

    public function __construct(ItemBankRepository $itemBankRepository)
    {
        $this->itemBankRepository = $itemBankRepository;
    }
    
    public function findAllItemBanks($limit = null, $offset = null) {
         return $this->itemBankRepository->findBy(array(), null, $limit, $offset);
    }
    
    public function getNextItemFor($examinee, $itemBank) {
        
    }
    
    public function saveResult($examinee, $itemResult) {
        
    }
}
