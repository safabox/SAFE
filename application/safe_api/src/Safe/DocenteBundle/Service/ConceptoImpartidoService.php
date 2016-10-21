<?php
namespace Safe\DocenteBundle\Service;

use Safe\TemaBundle\Repository\ConceptoRepository;

use Safe\TemaBundle\Service\ConceptoService;

class ConceptoImpartidoService extends ConceptoService {

    public function __construct(ConceptoRepository $conceptoRepository)
    {
         parent::__construct($conceptoRepository);
    }

}
