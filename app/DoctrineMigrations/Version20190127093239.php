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

        $table->addColumn('ID', 'guid');
        $table->addColumn('UserID', 'text');
        $table->addColumn('Label', 'text');
        $table->addColumn('Cost', 'integer');
        $table->addColumn('CreatedAt', 'datetime', ['default' => '2000-01-01 01:01:01']);
        
        $table->setPrimaryKey(['ID']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('expenses');
    }
}
