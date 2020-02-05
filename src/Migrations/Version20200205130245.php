<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200205130245 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE calls ADD employees_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calls ADD CONSTRAINT FK_DAA35C8F8520A30B FOREIGN KEY (employees_id) REFERENCES calls (id)');
        $this->addSql('CREATE INDEX IDX_DAA35C8F8520A30B ON calls (employees_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE calls DROP FOREIGN KEY FK_DAA35C8F8520A30B');
        $this->addSql('DROP INDEX IDX_DAA35C8F8520A30B ON calls');
        $this->addSql('ALTER TABLE calls DROP employees_id');
    }
}
