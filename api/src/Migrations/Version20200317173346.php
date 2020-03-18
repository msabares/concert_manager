<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200317173346 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_91911B0D7E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__venue AS SELECT id, owner_id, name FROM venue');
        $this->addSql('DROP TABLE venue');
        $this->addSql('CREATE TABLE venue (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, concert_list_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_91911B0D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_91911B0DA7B4AA2D FOREIGN KEY (concert_list_id) REFERENCES concert (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO venue (id, owner_id, name) SELECT id, owner_id, name FROM __temp__venue');
        $this->addSql('DROP TABLE __temp__venue');
        $this->addSql('CREATE INDEX IDX_91911B0D7E3C61F9 ON venue (owner_id)');
        $this->addSql('CREATE INDEX IDX_91911B0DA7B4AA2D ON venue (concert_list_id)');
        $this->addSql('DROP INDEX IDX_D57C02D27E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__concert AS SELECT id, owner_id, headliner, date, attended, opening_acts FROM concert');
        $this->addSql('DROP TABLE concert');
        $this->addSql('CREATE TABLE concert (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, headliner VARCHAR(100) NOT NULL COLLATE BINARY, date DATE NOT NULL, attended BOOLEAN NOT NULL, opening_acts CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:array)
        , CONSTRAINT FK_D57C02D27E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO concert (id, owner_id, headliner, date, attended, opening_acts) SELECT id, owner_id, headliner, date, attended, opening_acts FROM __temp__concert');
        $this->addSql('DROP TABLE __temp__concert');
        $this->addSql('CREATE INDEX IDX_D57C02D27E3C61F9 ON concert (owner_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_D57C02D27E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__concert AS SELECT id, owner_id, headliner, date, attended, opening_acts FROM concert');
        $this->addSql('DROP TABLE concert');
        $this->addSql('CREATE TABLE concert (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, headliner VARCHAR(100) NOT NULL, date DATE NOT NULL, attended BOOLEAN NOT NULL, opening_acts CLOB DEFAULT NULL --(DC2Type:array)
        , venue VARCHAR(100) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO concert (id, owner_id, headliner, date, attended, opening_acts) SELECT id, owner_id, headliner, date, attended, opening_acts FROM __temp__concert');
        $this->addSql('DROP TABLE __temp__concert');
        $this->addSql('CREATE INDEX IDX_D57C02D27E3C61F9 ON concert (owner_id)');
        $this->addSql('DROP INDEX IDX_91911B0D7E3C61F9');
        $this->addSql('DROP INDEX IDX_91911B0DA7B4AA2D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__venue AS SELECT id, owner_id, name FROM venue');
        $this->addSql('DROP TABLE venue');
        $this->addSql('CREATE TABLE venue (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO venue (id, owner_id, name) SELECT id, owner_id, name FROM __temp__venue');
        $this->addSql('DROP TABLE __temp__venue');
        $this->addSql('CREATE INDEX IDX_91911B0D7E3C61F9 ON venue (owner_id)');
    }
}
