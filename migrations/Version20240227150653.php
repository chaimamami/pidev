<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240227150653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medication ADD biological_data_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE medication ADD CONSTRAINT FK_5AEE5B7050DE7A58 FOREIGN KEY (biological_data_id) REFERENCES biological_data (id)');
        $this->addSql('CREATE INDEX IDX_5AEE5B7050DE7A58 ON medication (biological_data_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medication DROP FOREIGN KEY FK_5AEE5B7050DE7A58');
        $this->addSql('DROP INDEX IDX_5AEE5B7050DE7A58 ON medication');
        $this->addSql('ALTER TABLE medication DROP biological_data_id');
    }
}
