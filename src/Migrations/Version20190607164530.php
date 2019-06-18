<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190607164530 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quai ADD remorque_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quai ADD CONSTRAINT FK_E875314441A32AC4 FOREIGN KEY (remorque_id) REFERENCES remorque (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E875314441A32AC4 ON quai (remorque_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quai DROP FOREIGN KEY FK_E875314441A32AC4');
        $this->addSql('DROP INDEX UNIQ_E875314441A32AC4 ON quai');
        $this->addSql('ALTER TABLE quai DROP remorque_id');
    }
}
