<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190730090107 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        if ($this->connection->getDatabasePlatform()->getName() !== 'mysql') {
            echo 'Migration can only be executed safely on \'mysql\'.';
            return;
        }

        $this->addSql('CREATE TABLE users (ID VARCHAR(255) NOT NULL, FirstName LONGTEXT NOT NULL, LastName LONGTEXT NOT NULL, Email LONGTEXT NOT NULL, UserName LONGTEXT NOT NULL, Password LONGTEXT NOT NULL, Status SMALLINT NOT NULL COMMENT \'1 = Active | 2 = Inactive\', CreatedAt VARCHAR(255) NOT NULL, DeletedAt VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E911D3633A (ID), PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expenses (ID VARCHAR(255) NOT NULL, UserID LONGTEXT NOT NULL, Type SMALLINT NOT NULL COMMENT \'1 = Communication | 2 = Transportation | 3 = Representation | 4 = Sundries\', `Label` LONGTEXT NOT NULL, Cost DOUBLE PRECISION NOT NULL, Date VARCHAR(255) NOT NULL, CreatedAt VARCHAR(255) NOT NULL, DeletedAt VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2496F35B11D3633A (ID), PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        if ($this->connection->getDatabasePlatform()->getName() !== 'mysql') {
            echo 'Migration can only be executed safely on \'mysql\'.';
            return;
        }

        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE expenses');
    }
}
