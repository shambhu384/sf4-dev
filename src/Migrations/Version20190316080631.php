<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190316080631 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_meeting (tag_id INT NOT NULL, meeting_id INT NOT NULL, INDEX IDX_C724CC93BAD26311 (tag_id), INDEX IDX_C724CC9367433D9C (meeting_id), PRIMARY KEY(tag_id, meeting_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meeting (id INT AUTO_INCREMENT NOT NULL, organiser_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, datetime DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_F515E139A0631C12 (organiser_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_device (id INT AUTO_INCREMENT NOT NULL, userid_id INT NOT NULL, appid VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, model VARCHAR(255) DEFAULT NULL, platform VARCHAR(255) DEFAULT NULL, version VARCHAR(255) DEFAULT NULL, pushid VARCHAR(255) DEFAULT NULL, uuid VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6C7DADB358E0A285 (userid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, fullname VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tag_meeting ADD CONSTRAINT FK_C724CC93BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_meeting ADD CONSTRAINT FK_C724CC9367433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E139A0631C12 FOREIGN KEY (organiser_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE user_device ADD CONSTRAINT FK_6C7DADB358E0A285 FOREIGN KEY (userid_id) REFERENCES fos_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tag_meeting DROP FOREIGN KEY FK_C724CC93BAD26311');
        $this->addSql('ALTER TABLE tag_meeting DROP FOREIGN KEY FK_C724CC9367433D9C');
        $this->addSql('ALTER TABLE meeting DROP FOREIGN KEY FK_F515E139A0631C12');
        $this->addSql('ALTER TABLE user_device DROP FOREIGN KEY FK_6C7DADB358E0A285');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_meeting');
        $this->addSql('DROP TABLE meeting');
        $this->addSql('DROP TABLE user_device');
        $this->addSql('DROP TABLE fos_user');
    }
}
