<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180725143423 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_D34A04ADA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, user_id, release_on, title, description, area, category, price, photo, authorized FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, release_on DATETIME NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, area VARCHAR(255) NOT NULL COLLATE BINARY, category VARCHAR(255) NOT NULL COLLATE BINARY, price INTEGER NOT NULL, photo VARCHAR(255) DEFAULT NULL COLLATE BINARY, authorized BOOLEAN DEFAULT NULL, CONSTRAINT FK_D34A04ADA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product (id, user_id, release_on, title, description, area, category, price, photo, authorized) SELECT id, user_id, release_on, title, description, area, category, price, photo, authorized FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE INDEX IDX_D34A04ADA76ED395 ON product (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_D34A04ADA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, user_id, release_on, title, description, area, category, price, photo, authorized FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, release_on DATETIME NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, area VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, price INTEGER NOT NULL, photo VARCHAR(255) DEFAULT NULL, authorized BOOLEAN DEFAULT NULL)');
        $this->addSql('INSERT INTO product (id, user_id, release_on, title, description, area, category, price, photo, authorized) SELECT id, user_id, release_on, title, description, area, category, price, photo, authorized FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE INDEX IDX_D34A04ADA76ED395 ON product (user_id)');
    }
}
