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
    
        $table->addColumn('id', 'integer', array('length' => 11, 'autoincrement' => true));
        $table->addColumn('user_name', 'text');
        $table->addColumn('password', 'text');
        $table->addColumn('first_name', 'string', array('length' => 32));
        $table->addColumn('last_name', 'string', array('length' => 32));
        $table->addColumn('created_at', 'datetime', array('default' => '2000-01-01 01:01:01'));

        $table->setPrimaryKey(array('id'));
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('users');
    }
}
