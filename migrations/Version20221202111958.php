<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221202111958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creneau DROP FOREIGN KEY FK_F9668B5F226B91CB');
        $this->addSql('DROP INDEX IDX_F9668B5F226B91CB ON creneau');
        $this->addSql('ALTER TABLE creneau DROP date_debut_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creneau ADD date_debut_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE creneau ADD CONSTRAINT FK_F9668B5F226B91CB FOREIGN KEY (date_debut_id) REFERENCES planning (id)');
        $this->addSql('CREATE INDEX IDX_F9668B5F226B91CB ON creneau (date_debut_id)');
    }
}
