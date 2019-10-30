<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191030162721 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE accessor_data_type (accessor_id INT NOT NULL, data_type_id INT NOT NULL, INDEX IDX_DAF2B4542E8A75A9 (accessor_id), INDEX IDX_DAF2B454A147DA62 (data_type_id), PRIMARY KEY(accessor_id, data_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accessor_source_query (accessor_id INT NOT NULL, source_query_id INT NOT NULL, INDEX IDX_C21C0FBC2E8A75A9 (accessor_id), INDEX IDX_C21C0FBCACB4594B (source_query_id), PRIMARY KEY(accessor_id, source_query_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_type (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(64) NOT NULL, class_name VARCHAR(190) NOT NULL, UNIQUE INDEX UNIQ_37919CCBEA5E4949 (class_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE source_query (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, interface_name VARCHAR(190) NOT NULL, class_name VARCHAR(190) NOT NULL, UNIQUE INDEX UNIQ_BDB56ED4EA5E4949 (class_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accessor_data_type ADD CONSTRAINT FK_DAF2B4542E8A75A9 FOREIGN KEY (accessor_id) REFERENCES accessor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE accessor_data_type ADD CONSTRAINT FK_DAF2B454A147DA62 FOREIGN KEY (data_type_id) REFERENCES data_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE accessor_source_query ADD CONSTRAINT FK_C21C0FBC2E8A75A9 FOREIGN KEY (accessor_id) REFERENCES accessor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE accessor_source_query ADD CONSTRAINT FK_C21C0FBCACB4594B FOREIGN KEY (source_query_id) REFERENCES source_query (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE installation ADD accessor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE installation ADD CONSTRAINT FK_1CBA6AB12E8A75A9 FOREIGN KEY (accessor_id) REFERENCES accessor (id)');
        $this->addSql('CREATE INDEX IDX_1CBA6AB12E8A75A9 ON installation (accessor_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_989A758E5E237E06 ON source_app (name)');
        $this->addSql('DROP INDEX UNIQ_6FDC12FEEA5E4949 ON accessor');
        $this->addSql('ALTER TABLE accessor DROP class_name, DROP supported_data_types, CHANGE method method_name VARCHAR(32) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE accessor_data_type DROP FOREIGN KEY FK_DAF2B454A147DA62');
        $this->addSql('ALTER TABLE accessor_source_query DROP FOREIGN KEY FK_C21C0FBCACB4594B');
        $this->addSql('DROP TABLE accessor_data_type');
        $this->addSql('DROP TABLE accessor_source_query');
        $this->addSql('DROP TABLE data_type');
        $this->addSql('DROP TABLE source_query');
        $this->addSql('ALTER TABLE accessor ADD class_name VARCHAR(190) NOT NULL COLLATE utf8mb4_unicode_ci, ADD supported_data_types LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', CHANGE method_name method VARCHAR(32) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6FDC12FEEA5E4949 ON accessor (class_name)');
        $this->addSql('ALTER TABLE installation DROP FOREIGN KEY FK_1CBA6AB12E8A75A9');
        $this->addSql('DROP INDEX IDX_1CBA6AB12E8A75A9 ON installation');
        $this->addSql('ALTER TABLE installation DROP accessor_id');
        $this->addSql('DROP INDEX UNIQ_989A758E5E237E06 ON source_app');
    }
}
