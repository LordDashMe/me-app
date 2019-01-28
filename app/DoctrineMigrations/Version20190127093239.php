<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190127093239 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->createTable('expenses');

        $table->addColumn('id', 'guid');
        $table->addColumn('user_id', 'text');
        $table->addColumn('label', 'text');
        $table->addColumn('cost', 'integer');
        $table->addColumn('created_at', 'datetime', array('default' => '2000-01-01 01:01:01'));
        
        $table->setPrimaryKey(array('id'));
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('expenses');
    }
}
