<?php

namespace UserBundle\Model;

use Maghead\Schema\DeclareSchema;

class RoleSchema extends DeclareSchema
{
    public function schema() 
    {
        $this->column('label')
            ->varchar(32)
            ->label( _('Label') );

        $this->column('identity')
            ->varchar(12)
            ->required()
            ->unique()
            ->label( _('Identity') );

        $this->column('description')
            ->text()
            ->label( _('Description') )
            ;
    }
}



