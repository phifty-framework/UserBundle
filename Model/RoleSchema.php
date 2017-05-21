<?php
namespace UserBundle\Model;
use LazyRecord\Schema\SchemaDeclare;

class RoleSchema extends SchemaDeclare
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



