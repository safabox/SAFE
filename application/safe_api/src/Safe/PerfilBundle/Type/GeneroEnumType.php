<?php
namespace Safe\PerfilBundle\Type;

use Safe\CoreBundle\Type\EnumType;

class GeneroEnumType extends EnumType {
    protected $name = 'tipo';
    protected $values = array('visible', 'invisible');
}
