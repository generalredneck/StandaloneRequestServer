<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180209043757 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE settings (id VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE requests (id INTEGER NOT NULL, artist CLOB NOT NULL, title CLOB NOT NULL, singer CLOB NOT NULL, request_time DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE songs (id INTEGER NOT NULL, artist CLOB NOT NULL, title CLOB NOT NULL, combined CLOB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BAECB19B47121894 ON songs (combined)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE settings');
        $this->addSql('DROP TABLE requests');
        $this->addSql('DROP TABLE songs');
    }
}
