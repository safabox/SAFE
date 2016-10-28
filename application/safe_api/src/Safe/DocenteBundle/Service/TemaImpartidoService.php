<?php
namespace Safe\DocenteBundle\Service;

use Safe\TemaBundle\Repository\TemaRepository;

use Safe\TemaBundle\Service\TemaService;

class TemaImpartidoService extends TemaService {

    public function __construct(TemaRepository $temaRepository)
    {
         parent::__construct($temaRepository);
    }

}
