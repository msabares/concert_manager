<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200307092355 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE user ADD COLUMN venue_list CLOB DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_D57C02D27E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__concert AS SELECT id, owner_id, headliner, date, attended, venue, opening_acts FROM concert');
        $this->addSql('DROP TABLE concert');
        $this->addSql('CREATE TABLE concert (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, headliner VARCHAR(100) NOT NULL COLLATE BINARY, date DATE NOT NULL, attended BOOLEAN NOT NULL, venue VARCHAR(100) NOT NULL COLLATE BINARY, opening_acts CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:array)
        , CONSTRAINT FK_D57C02D27E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO concert (id, owner_id, headliner, date, attended, venue, opening_acts) SELECT id, owner_id, headliner, date, attended, venue, opening_acts FROM __temp__concert');
        $this->addSql('DROP TABLE __temp__concert');
        $this->addSql('CREATE INDEX IDX_D57C02D27E3C61F9 ON concert (owner_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_D57C02D27E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__concert AS SELECT id, owner_id, headliner, date, attended, venue, opening_acts FROM concert');
        $this->addSql('DROP TABLE concert');
        $this->addSql('CREATE TABLE concert (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, headliner VARCHAR(100) NOT NULL, date DATE NOT NULL, attended BOOLEAN NOT NULL, venue VARCHAR(100) NOT NULL, opening_acts CLOB DEFAULT NULL --(DC2Type:array)
        )');
        $this->addSql('INSERT INTO concert (id, owner_id, headliner, date, attended, venue, opening_acts) SELECT id, owner_id, headliner, date, attended, venue, opening_acts FROM __temp__concert');
        $this->addSql('DROP TABLE __temp__concert');
        $this->addSql('CREATE INDEX IDX_D57C02D27E3C61F9 ON concert (owner_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password, name, fav_color FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, fav_color VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO user (id, email, roles, password, name, fav_color) SELECT id, email, roles, password, name, fav_color FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
