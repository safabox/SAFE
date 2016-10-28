<?php
namespace Safe\AlumnoBundle\Service;

use Safe\CursoBundle\Repository\CursoRepository;
use Safe\AlumnoBundle\Entity\CursoAsignado;
use Doctrine\ORM\EntityManager;
class CursoAsignadoService {
    private $cursoRepository;
    private $entityManager;
    
    public function __construct(EntityManager $entityManager, CursoRepository $cursoRepository)
    {
        $this->entityManager = $entityManager;
        $this->cursoRepository = $cursoRepository;
    }
    
    public function findAll($alumnoId, $limit = null, $offset = 0) {
        $query = $this->cursoRepository->createQueryBuilder('curso')
                                       ->join('curso.alumnos', 'a')
                                       ->where('a.id = :id')
                                       ->andWhere('curso.habilitado = true')
                                       ->setParameter('id', $alumnoId)
                                       ->getQuery();
        if ($limit != null) {
            $offset = ($offset == null) ? 0 : $offset;
            $query->setMaxResults($limit)
                  ->setFirstResult($limit * $offset);
        }        
        $cursos = $query->getResult();
        $cursosAsignados = array();
        foreach ($cursos as $curso) {
            $count = $this->countTemasFinalizados($alumnoId, $curso->getId());            
            $cursosAsignados[] = new CursoAsignado($curso, $count['cantTemas'], $count['cantResueltos']);    
        }
        
         return $cursosAsignados;
    }
    
    public function getById($id) {
        return $this->cursoRepository->find($id);
    }
    
    private function countTemasFinalizados($alumnoId, $cursoId) {
        $query = $this->entityManager->createQuery(
                'select count(t1) as cantTemas,
                (select count(t2)
                    from SafeTemaBundle:Tema t2
                    join t2.curso curso2		
                    where curso2.id = :cursoId		
                    and exists (
                                select estado 
                                from SafeTemaBundle:AlumnoEstadoTema estado
                                left join estado.alumno alumno
                                where estado.tema = t2 and alumno.id = :alumnoId
                                )
                ) as cantResueltos
                from SafeTemaBundle:Tema t1
                join t1.curso curso
                where curso.id = :cursoId'
                );
 
         $query->setParameter('alumnoId', $alumnoId);
         $query->setParameter('cursoId', $cursoId);
         return $query->getSingleResult();
    }
    

}
