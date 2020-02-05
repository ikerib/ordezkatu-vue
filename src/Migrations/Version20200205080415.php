<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200205080415 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE `call`');
        $this->addSql('ALTER TABLE calls ADD notes LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `call` (id INT AUTO_INCREMENT NOT NULL, employeezerrenda_id INT DEFAULT NULL, result_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_CC8E2F3E7A7B643 (result_id), INDEX IDX_CC8E2F3EA76ED395 (user_id), INDEX IDX_CC8E2F3E1620191C (employeezerrenda_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `call` ADD CONSTRAINT FK_CC8E2F3E1620191C FOREIGN KEY (employeezerrenda_id) REFERENCES employee_zerrenda (id)');
        $this->addSql('ALTER TABLE `call` ADD CONSTRAINT FK_CC8E2F3E7A7B643 FOREIGN KEY (result_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE `call` ADD CONSTRAINT FK_CC8E2F3EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE calls DROP notes');
    }
}
