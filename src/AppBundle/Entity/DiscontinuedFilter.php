<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

/**
 * This is our Custom Doctrine Filter
 *
 * Class DiscontinuedFilter
 * @package AppBundle\Entity
 */
class DiscontinuedFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if($targetEntity->getReflectionClass()->name != 'AppBundle\Entity\FortuneCookie') {
            return '';
        }

        return sprintf('%s.discontinued = %s', $targetTableAlias, $this->getParameter('discontinued'));
    }

}