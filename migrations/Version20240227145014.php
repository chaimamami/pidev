<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240227145014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE biological_data ADD user_id INT DEFAULT NULL, ADD health_professional_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE biological_data ADD CONSTRAINT FK_218BB85BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE biological_data ADD CONSTRAINT FK_218BB85BB7750F8C FOREIGN KEY (health_professional_id) REFERENCES health_professional (id)');
        $this->addSql('CREATE INDEX IDX_218BB85BA76ED395 ON biological_data (user_id)');
        $this->addSql('CREATE INDEX IDX_218BB85BB7750F8C ON biological_data (health_professional_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE biological_data DROP FOREIGN KEY FK_218BB85BA76ED395');
        $this->addSql('ALTER TABLE biological_data DROP FOREIGN KEY FK_218BB85BB7750F8C');
        $this->addSql('DROP INDEX IDX_218BB85BA76ED395 ON biological_data');
        $this->addSql('DROP INDEX IDX_218BB85BB7750F8C ON biological_data');
        $this->addSql('ALTER TABLE biological_data DROP user_id, DROP health_professional_id');
    }
}
