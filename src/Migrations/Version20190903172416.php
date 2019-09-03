<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190903172416 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE traction ADD quai_id INT NOT NULL');
        $this->addSql('ALTER TABLE traction ADD CONSTRAINT FK_C0C1AC30F7E062C5 FOREIGN KEY (quai_id) REFERENCES quai (id)');
        $this->addSql('CREATE INDEX IDX_C0C1AC30F7E062C5 ON traction (quai_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE traction DROP FOREIGN KEY FK_C0C1AC30F7E062C5');
        $this->addSql('DROP INDEX IDX_C0C1AC30F7E062C5 ON traction');
        $this->addSql('ALTER TABLE traction DROP quai_id');
    }
}
