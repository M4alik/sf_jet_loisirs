<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221206233214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planning CHANGE date_debut date_debut DATETIME NOT NULL, CHANGE duree_crenau duree_crenau INT NOT NULL, CHANGE duree_journee duree_journee INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planning CHANGE date_debut date_debut DATE NOT NULL, CHANGE duree_crenau duree_crenau TIME NOT NULL, CHANGE duree_journee duree_journee TIME NOT NULL');
    }
}
