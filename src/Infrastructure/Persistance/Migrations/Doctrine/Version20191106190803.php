<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191106190803 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE source_querier ADD data_type_id INT DEFAULT NULL, ADD source_app_id INT DEFAULT NULL, ADD method_name VARCHAR(32) NOT NULL');
        $this->addSql('ALTER TABLE source_querier ADD CONSTRAINT FK_B420CF8CA147DA62 FOREIGN KEY (data_type_id) REFERENCES data_type (id)');
        $this->addSql('ALTER TABLE source_querier ADD CONSTRAINT FK_B420CF8CCF7804CB FOREIGN KEY (source_app_id) REFERENCES source_app (id)');
        $this->addSql('CREATE INDEX IDX_B420CF8CA147DA62 ON source_querier (data_type_id)');
        $this->addSql('CREATE INDEX IDX_B420CF8CCF7804CB ON source_querier (source_app_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE source_querier DROP FOREIGN KEY FK_B420CF8CA147DA62');
        $this->addSql('ALTER TABLE source_querier DROP FOREIGN KEY FK_B420CF8CCF7804CB');
        $this->addSql('DROP INDEX IDX_B420CF8CA147DA62 ON source_querier');
        $this->addSql('DROP INDEX IDX_B420CF8CCF7804CB ON source_querier');
        $this->addSql('ALTER TABLE source_querier DROP data_type_id, DROP source_app_id, DROP method_name');
    }
}
