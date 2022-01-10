<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220110020545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE batiment_owned ADD hp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ongoing_atk CHANGE start start DATETIME NOT NULL, CHANGE end_time end_time DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE batiment_owned DROP hp');
        $this->addSql('ALTER TABLE ongoing_atk CHANGE start start INT NOT NULL, CHANGE end_time end_time INT NOT NULL');
    }
}
