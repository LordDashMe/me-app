<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181016074705 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->createTable('users');
    
        $table->addColumn('ID', 'guid');
        $table->addColumn('FirstName', 'text');
        $table->addColumn('LastName', 'text');
        $table->addColumn('Email', 'text');
        $table->addColumn('Username', 'text');
        $table->addColumn('Password', 'text');
        $table->addColumn('Status', 'smallint', ['comment' => '1 = Active | 2 = Inactive']);
        $table->addColumn('Role', 'smallint', ['comment' => '1 = Admin | 2 = Editor | 3 = Member']);
        $table->addColumn('CreatedAt', 'datetime', ['default' => '2000-01-01 01:01:01']);
        $table->addColumn('DeletedAt', 'text', ['default' => '']);

        $table->setPrimaryKey(['ID']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('users');
    }
}
