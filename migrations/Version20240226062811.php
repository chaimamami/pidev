<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240226062811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alert (id INT AUTO_INCREMENT NOT NULL, timestamp DATETIME NOT NULL, alert_type VARCHAR(255) NOT NULL, severity VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, handled VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, patient_user_id_id INT DEFAULT NULL, professional_user_id_id INT DEFAULT NULL, date_time DATETIME NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_FE38F8442B46C3E0 (patient_user_id_id), INDEX IDX_FE38F844AAEB1DB6 (professional_user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE biological_data (id INT AUTO_INCREMENT NOT NULL, timestamp DATETIME NOT NULL, measurement_type VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bracelet (id INT AUTO_INCREMENT NOT NULL, biological_data_id INT DEFAULT NULL, alert_id INT DEFAULT NULL, identification_code VARCHAR(255) NOT NULL, temperature VARCHAR(255) NOT NULL, blood_pressure VARCHAR(255) NOT NULL, heart_rate VARCHAR(255) NOT NULL, movement VARCHAR(255) NOT NULL, gps VARCHAR(255) NOT NULL, INDEX IDX_93F6777D50DE7A58 (biological_data_id), INDEX IDX_93F6777D93035F72 (alert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE health_professional (id INT AUTO_INCREMENT NOT NULL, hospital_id_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, specialty VARCHAR(255) NOT NULL, dashboard_type VARCHAR(255) NOT NULL, INDEX IDX_40A5C327E1E0EFB (hospital_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hospital (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professional_access (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, patient_user_id_id INT DEFAULT NULL, access_level VARCHAR(255) NOT NULL, INDEX IDX_46D759889D86650F (user_id_id), INDEX IDX_46D759882B46C3E0 (patient_user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, bracelet_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, INDEX IDX_8D93D649EC886B8 (bracelet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8442B46C3E0 FOREIGN KEY (patient_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844AAEB1DB6 FOREIGN KEY (professional_user_id_id) REFERENCES health_professional (id)');
        $this->addSql('ALTER TABLE bracelet ADD CONSTRAINT FK_93F6777D50DE7A58 FOREIGN KEY (biological_data_id) REFERENCES biological_data (id)');
        $this->addSql('ALTER TABLE bracelet ADD CONSTRAINT FK_93F6777D93035F72 FOREIGN KEY (alert_id) REFERENCES alert (id)');
        $this->addSql('ALTER TABLE health_professional ADD CONSTRAINT FK_40A5C327E1E0EFB FOREIGN KEY (hospital_id_id) REFERENCES hospital (id)');
        $this->addSql('ALTER TABLE professional_access ADD CONSTRAINT FK_46D759889D86650F FOREIGN KEY (user_id_id) REFERENCES health_professional (id)');
        $this->addSql('ALTER TABLE professional_access ADD CONSTRAINT FK_46D759882B46C3E0 FOREIGN KEY (patient_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649EC886B8 FOREIGN KEY (bracelet_id) REFERENCES bracelet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F8442B46C3E0');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844AAEB1DB6');
        $this->addSql('ALTER TABLE bracelet DROP FOREIGN KEY FK_93F6777D50DE7A58');
        $this->addSql('ALTER TABLE bracelet DROP FOREIGN KEY FK_93F6777D93035F72');
        $this->addSql('ALTER TABLE health_professional DROP FOREIGN KEY FK_40A5C327E1E0EFB');
        $this->addSql('ALTER TABLE professional_access DROP FOREIGN KEY FK_46D759889D86650F');
        $this->addSql('ALTER TABLE professional_access DROP FOREIGN KEY FK_46D759882B46C3E0');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649EC886B8');
        $this->addSql('DROP TABLE alert');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE biological_data');
        $this->addSql('DROP TABLE bracelet');
        $this->addSql('DROP TABLE health_professional');
        $this->addSql('DROP TABLE hospital');
        $this->addSql('DROP TABLE professional_access');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
