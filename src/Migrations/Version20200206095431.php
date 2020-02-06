<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200206095431 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE calls CHANGE created created DATETIME DEFAULT NULL, CHANGE updated updated DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE sailkapen_taldea ADD created DATETIME DEFAULT NULL, ADD updated DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE arrazoia ADD created DATETIME DEFAULT NULL, ADD updated DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE titulazioa ADD created DATETIME DEFAULT NULL, ADD updated DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE hizkuntza ADD created DATETIME DEFAULT NULL, ADD updated DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE job_type ADD created DATETIME DEFAULT NULL, ADD updated DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE employee_zerrenda ADD created DATETIME DEFAULT NULL, ADD updated DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE arrazoia DROP created, DROP updated');
        $this->addSql('ALTER TABLE calls CHANGE created created DATETIME NOT NULL, CHANGE updated updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE employee_zerrenda DROP created, DROP updated');
        $this->addSql('ALTER TABLE hizkuntza DROP created, DROP updated');
        $this->addSql('ALTER TABLE job_type DROP created, DROP updated');
        $this->addSql('ALTER TABLE sailkapen_taldea DROP created, DROP updated');
        $this->addSql('ALTER TABLE titulazioa DROP created, DROP updated');
    }
}
