<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200211124438 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE calls DROP FOREIGN KEY FK_DAA35C8F1620191C');
        $this->addSql('ALTER TABLE calls DROP FOREIGN KEY FK_DAA35C8F7A7B643');
        $this->addSql('DROP INDEX IDX_DAA35C8F1620191C ON calls');
        $this->addSql('DROP INDEX IDX_DAA35C8F7A7B643 ON calls');
        $this->addSql('ALTER TABLE calls ADD jobdetail_id INT DEFAULT NULL, DROP employeezerrenda_id, DROP result_id');
        $this->addSql('ALTER TABLE calls ADD CONSTRAINT FK_DAA35C8F9157E3A0 FOREIGN KEY (jobdetail_id) REFERENCES job_detail (id)');
        $this->addSql('CREATE INDEX IDX_DAA35C8F9157E3A0 ON calls (jobdetail_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE calls DROP FOREIGN KEY FK_DAA35C8F9157E3A0');
        $this->addSql('DROP INDEX IDX_DAA35C8F9157E3A0 ON calls');
        $this->addSql('ALTER TABLE calls ADD result_id INT DEFAULT NULL, CHANGE jobdetail_id employeezerrenda_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calls ADD CONSTRAINT FK_DAA35C8F1620191C FOREIGN KEY (employeezerrenda_id) REFERENCES employee_zerrenda (id)');
        $this->addSql('ALTER TABLE calls ADD CONSTRAINT FK_DAA35C8F7A7B643 FOREIGN KEY (result_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_DAA35C8F1620191C ON calls (employeezerrenda_id)');
        $this->addSql('CREATE INDEX IDX_DAA35C8F7A7B643 ON calls (result_id)');
    }
}
