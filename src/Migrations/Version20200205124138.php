<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200205124138 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE log');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE log (id INT AUTO_INCREMENT NOT NULL, employee_id INT DEFAULT NULL, zerrenda_id INT DEFAULT NULL, employeezerrenda_id INT DEFAULT NULL, user_id INT DEFAULT NULL, result_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created DATETIME DEFAULT NULL, updated DATETIME DEFAULT NULL, INDEX IDX_8F3F68C58C03F15C (employee_id), INDEX IDX_8F3F68C51620191C (employeezerrenda_id), INDEX IDX_8F3F68C57A7B643 (result_id), INDEX IDX_8F3F68C5EDBC59B0 (zerrenda_id), INDEX IDX_8F3F68C5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C51620191C FOREIGN KEY (employeezerrenda_id) REFERENCES employee_zerrenda (id)');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C57A7B643 FOREIGN KEY (result_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C58C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C5EDBC59B0 FOREIGN KEY (zerrenda_id) REFERENCES zerrenda (id)');
    }
}
