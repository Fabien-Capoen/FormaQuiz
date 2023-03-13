<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230313142724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA92C54C8C93');
        $this->addSql('CREATE TABLE question_type (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE type');
        $this->addSql('ALTER TABLE question ADD question_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494ECB90598E FOREIGN KEY (question_type_id) REFERENCES question_type (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494ECB90598E ON question (question_type_id)');
        $this->addSql('DROP INDEX IDX_A412FA92C54C8C93 ON quiz');
        $this->addSql('ALTER TABLE quiz DROP type_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494ECB90598E');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE question_type');
        $this->addSql('ALTER TABLE quiz ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_A412FA92C54C8C93 ON quiz (type_id)');
        $this->addSql('DROP INDEX IDX_B6F7494ECB90598E ON question');
        $this->addSql('ALTER TABLE question DROP question_type_id');
    }
}
