<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221201234204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity ADD author_id INT NOT NULL, ADD status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AC74095AF675F31B ON activity (author_id)');
        $this->addSql('ALTER TABLE creneau ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE creneau ADD CONSTRAINT FK_F9668B5FF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F9668B5FF675F31B ON creneau (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AF675F31B');
        $this->addSql('DROP INDEX IDX_AC74095AF675F31B ON activity');
        $this->addSql('ALTER TABLE activity DROP author_id, DROP status');
        $this->addSql('ALTER TABLE creneau DROP FOREIGN KEY FK_F9668B5FF675F31B');
        $this->addSql('DROP INDEX IDX_F9668B5FF675F31B ON creneau');
        $this->addSql('ALTER TABLE creneau DROP author_id');
    }
}
