<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191029103412 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE shop (id INT AUTO_INCREMENT NOT NULL, installation_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(190) NOT NULL, shortname VARCHAR(64) NOT NULL, installation_shop_id INT NOT NULL, url VARCHAR(190) NOT NULL, active TINYINT(1) NOT NULL, metatitle VARCHAR(190) NOT NULL, metadescription LONGTEXT NOT NULL, INDEX IDX_AC6A4CA2167B88B4 (installation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE application (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(190) NOT NULL, website VARCHAR(190) NOT NULL, downloads_url VARCHAR(190) NOT NULL, auto_download TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE software (id INT AUTO_INCREMENT NOT NULL, application_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, version VARCHAR(32) NOT NULL, download_url VARCHAR(190) NOT NULL, INDEX IDX_77D068CF3E030ACD (application_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA2167B88B4 FOREIGN KEY (installation_id) REFERENCES installation (id)');
        $this->addSql('ALTER TABLE software ADD CONSTRAINT FK_77D068CF3E030ACD FOREIGN KEY (application_id) REFERENCES application (id)');
        $this->addSql('ALTER TABLE installation ADD software_id INT DEFAULT NULL, ADD url_base VARCHAR(255) NOT NULL, ADD url_admin VARCHAR(255) NOT NULL, ADD multistore TINYINT(1) NOT NULL, ADD registered TINYINT(1) NOT NULL, ADD active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE installation ADD CONSTRAINT FK_1CBA6AB1D7452741 FOREIGN KEY (software_id) REFERENCES software (id)');
        $this->addSql('CREATE INDEX IDX_1CBA6AB1D7452741 ON installation (software_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE software DROP FOREIGN KEY FK_77D068CF3E030ACD');
        $this->addSql('ALTER TABLE installation DROP FOREIGN KEY FK_1CBA6AB1D7452741');
        $this->addSql('DROP TABLE shop');
        $this->addSql('DROP TABLE application');
        $this->addSql('DROP TABLE software');
        $this->addSql('DROP INDEX IDX_1CBA6AB1D7452741 ON installation');
        $this->addSql('ALTER TABLE installation DROP software_id, DROP url_base, DROP url_admin, DROP multistore, DROP registered, DROP active');
    }
}
