<?php


namespace App\Service;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

class PasaiaVichDirectoryNamer implements DirectoryNamerInterface
{
    /**
     * Returns the name of a directory where files will be uploaded.
     *
     * Directory name is formed based on user ID and media type
     *
     * @param                 $object
     * @param PropertyMapping $mapping
     *
     * @return string
     */
    public function directoryName($object, PropertyMapping $mapping): string
    {
        /** @var \App\Entity\Employee $employee */
        $employee = $object->getEmployee();


        return $employee->getNan() . '/';
    }
}
