<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230314100805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse CHANGE choixrep1 choixrep1 TINYINT(1) DEFAULT NULL, CHANGE choixrep2 choixrep2 TINYINT(1) DEFAULT NULL, CHANGE choixrep3 choixrep3 TINYINT(1) DEFAULT NULL, CHANGE choixrep4 choixrep4 TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse CHANGE choixrep1 choixrep1 TINYINT(1) NOT NULL, CHANGE choixrep2 choixrep2 TINYINT(1) NOT NULL, CHANGE choixrep3 choixrep3 TINYINT(1) NOT NULL, CHANGE choixrep4 choixrep4 TINYINT(1) NOT NULL');
    }
}
