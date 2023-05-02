<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502084013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question CHANGE reponse1 reponse1 VARCHAR(255) DEFAULT NULL, CHANGE reponse2 reponse2 VARCHAR(255) DEFAULT NULL, CHANGE reponse4 reponse4 VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE quiz CHANGE note_max note_max DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question CHANGE reponse1 reponse1 VARCHAR(255) NOT NULL, CHANGE reponse2 reponse2 VARCHAR(255) NOT NULL, CHANGE reponse4 reponse4 VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE quiz CHANGE note_max note_max VARCHAR(255) NOT NULL');
    }
}
