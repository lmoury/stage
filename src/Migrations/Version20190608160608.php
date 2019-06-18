<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190608160608 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quai ADD operation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quai ADD CONSTRAINT FK_E875314444AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E875314444AC3583 ON quai (operation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quai DROP FOREIGN KEY FK_E875314444AC3583');
        $this->addSql('DROP INDEX UNIQ_E875314444AC3583 ON quai');
        $this->addSql('ALTER TABLE quai DROP operation_id');
    }
}
