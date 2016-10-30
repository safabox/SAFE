<?php
namespace Safe\CursoBundle\Service;

use Safe\CursoBundle\Repository\CursoRepository;

use Safe\CoreBundle\Exception\IllegalArgumentException;

class CursoService {
    protected $cursoRepository;

    public function __construct(CursoRepository $cursoRepository)
    {
        $this->cursoRepository = $cursoRepository;
    }
    
    public function findAll($limit = null, $offset = null) {
         return $this->cursoRepository->findBy(array(), null, $limit, $offset);
    }
    
    public function getById($id) {
        return $this->cursoRepository->find($id);
    }
    
    public function crearOActualizar($curso) {        
        return $this->cursoRepository->crearOActualizar($curso);
    }
    
    public function inscribirAlCurso($cursoId, $alumno) {
        $curso = $this->cursoRepository->find($cursoId);                
        if ($this->existeAlumnoEnCurso($curso, $alumno)) {
            throw new IllegalArgumentException("cursoBundle.curso.alumno.inscripto");
        }
        $curso->getAlumnos()->add($alumno);
        $this->cursoRepository->crearOActualizar($curso);
    }
    
    public function desinscribirDelCurso($cursoId, $alumno) {
        $curso = $this->cursoRepository->find($cursoId);        
        if (!$this->existeAlumnoEnCurso($curso, $alumno)) {
            throw new IllegalArgumentException("cursoBundle.curso.alumno.no_inscripto");
        }
        $curso->getAlumnos()->removeElement($alumno);
        $this->cursoRepository->crearOActualizar($curso);
    }


    public function existeAlumnoEnCurso($curso, $alumno) {
        $query = $this->cursoRepository->createQueryBuilder('curso');
        $query = $query->select('count(curso.id)')
                        ->join('curso.alumnos', 'a')
                        ->where('curso.id = :idCurso')
                        ->andWhere('a.id = :idAlumno') 
                        ->setParameter('idAlumno', $alumno->getId())
                        ->setParameter('idCurso', $curso->getId()) 
                        ->getQuery();
        
         return ($query->getSingleScalarResult() > 0);
    }
    
    public function cantidadCursos($instituto) {        
        $query = $this->cursoRepository->createQueryBuilder('curso2');
        $query->select($query->expr()->count('curso.id'));
        $query->from('SafeCursoBundle:Curso','curso')
                ->join('curso.instituto', 'i')
                ->where('i.id = :id')
                ->setParameter('id', $instituto->getId());
        $count = $query->getQuery()->getSingleScalarResult();
        return $count;
    }
}
