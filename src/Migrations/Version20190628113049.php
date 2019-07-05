<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190628113049 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE remorque ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE remorque ADD CONSTRAINT FK_644A4CAC54C8C93 FOREIGN KEY (type_id) REFERENCES remorque_type (id)');
        $this->addSql('CREATE INDEX IDX_644A4CAC54C8C93 ON remorque (type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE remorque DROP FOREIGN KEY FK_644A4CAC54C8C93');
        $this->addSql('DROP INDEX IDX_644A4CAC54C8C93 ON remorque');
        $this->addSql('ALTER TABLE remorque DROP type_id');
    }
}
