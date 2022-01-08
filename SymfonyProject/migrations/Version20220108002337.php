<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220108002337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE batiment_owned ADD startupgrade DATETIME DEFAULT NULL, ADD endupgrade DATETIME DEFAULT NULL, ADD upgrading TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE planets DROP under_atk');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE batiment_owned DROP startupgrade, DROP endupgrade, DROP upgrading');
        $this->addSql('ALTER TABLE planets ADD under_atk TINYINT(1) NOT NULL');
    }
}
