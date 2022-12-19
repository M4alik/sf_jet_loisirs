<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221129230216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planning ADD nom_activite_id INT NOT NULL');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6556F23AE FOREIGN KEY (nom_activite_id) REFERENCES activity (id)');
        $this->addSql('CREATE INDEX IDX_D499BFF6556F23AE ON planning (nom_activite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6556F23AE');
        $this->addSql('DROP INDEX IDX_D499BFF6556F23AE ON planning');
        $this->addSql('ALTER TABLE planning DROP nom_activite_id');
    }
}
