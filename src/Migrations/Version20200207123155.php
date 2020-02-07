<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200207123155 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE job_zerrenda');
        $this->addSql('ALTER TABLE employee_zerrenda_type ADD last_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employee_zerrenda_type ADD CONSTRAINT FK_65339F50D1FD94E6 FOREIGN KEY (last_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_65339F50D1FD94E6 ON employee_zerrenda_type (last_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE job_zerrenda (job_id INT NOT NULL, zerrenda_id INT NOT NULL, INDEX IDX_5616951BBE04EA9 (job_id), INDEX IDX_5616951BEDBC59B0 (zerrenda_id), PRIMARY KEY(job_id, zerrenda_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE job_zerrenda ADD CONSTRAINT FK_5616951BBE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_zerrenda ADD CONSTRAINT FK_5616951BEDBC59B0 FOREIGN KEY (zerrenda_id) REFERENCES zerrenda (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employee_zerrenda_type DROP FOREIGN KEY FK_65339F50D1FD94E6');
        $this->addSql('DROP INDEX IDX_65339F50D1FD94E6 ON employee_zerrenda_type');
        $this->addSql('ALTER TABLE employee_zerrenda_type DROP last_id');
    }
}
