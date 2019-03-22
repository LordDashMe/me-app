<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190322113231 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE users (ID INT AUTO_INCREMENT NOT NULL, UUID CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', FirstName LONGTEXT NOT NULL, LastName LONGTEXT NOT NULL, Email LONGTEXT NOT NULL, Username LONGTEXT NOT NULL, Password LONGTEXT NOT NULL, Status SMALLINT NOT NULL COMMENT \'1 = Active | 2 = Inactive\', Role SMALLINT NOT NULL COMMENT \'1 = Admin | 2 = Editor | 3 = Member\', CreatedAt VARCHAR(255) NOT NULL, DeletedAt VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E911D3633A (ID), UNIQUE INDEX UNIQ_1483A5E9E7EABD12 (UUID), PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expenses (ID CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', UserID LONGTEXT NOT NULL, `Label` LONGTEXT NOT NULL, Cost INT NOT NULL, Date VARCHAR(255) NOT NULL, CreatedAt VARCHAR(255) NOT NULL, DeletedAt VARCHAR(255) NOT NULL, PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE expenses');
    }
}
