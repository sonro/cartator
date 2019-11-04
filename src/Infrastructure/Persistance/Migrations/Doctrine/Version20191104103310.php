<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191104103310 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE db_host (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, address VARCHAR(190) NOT NULL, port INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE db_user ADD db_host_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE db_user ADD CONSTRAINT FK_B13D489647C18ACF FOREIGN KEY (db_host_id) REFERENCES db_host (id)');
        $this->addSql('CREATE INDEX IDX_B13D489647C18ACF ON db_user (db_host_id)');
        $this->addSql('ALTER TABLE source_db ADD db_host_id INT DEFAULT NULL, DROP db_host, DROP db_port');
        $this->addSql('ALTER TABLE source_db ADD CONSTRAINT FK_C9F1C71947C18ACF FOREIGN KEY (db_host_id) REFERENCES db_host (id)');
        $this->addSql('CREATE INDEX IDX_C9F1C71947C18ACF ON source_db (db_host_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE db_user DROP FOREIGN KEY FK_B13D489647C18ACF');
        $this->addSql('ALTER TABLE source_db DROP FOREIGN KEY FK_C9F1C71947C18ACF');
        $this->addSql('DROP TABLE db_host');
        $this->addSql('DROP INDEX IDX_B13D489647C18ACF ON db_user');
        $this->addSql('ALTER TABLE db_user DROP db_host_id');
        $this->addSql('DROP INDEX IDX_C9F1C71947C18ACF ON source_db');
        $this->addSql('ALTER TABLE source_db ADD db_host VARCHAR(190) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD db_port INT NOT NULL, DROP db_host_id');
    }
}
