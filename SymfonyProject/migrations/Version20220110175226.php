<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220110175226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ongoing_atk_user');
        $this->addSql('ALTER TABLE ongoing_atk ADD player_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE ongoing_atk ADD CONSTRAINT FK_1AC6CF2BC036E511 FOREIGN KEY (player_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1AC6CF2BC036E511 ON ongoing_atk (player_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ongoing_atk_user (ongoing_atk_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_6D86563E6C3CC02F (ongoing_atk_id), INDEX IDX_6D86563EA76ED395 (user_id), PRIMARY KEY(ongoing_atk_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ongoing_atk_user ADD CONSTRAINT FK_6D86563E6C3CC02F FOREIGN KEY (ongoing_atk_id) REFERENCES ongoing_atk (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ongoing_atk_user ADD CONSTRAINT FK_6D86563EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ongoing_atk DROP FOREIGN KEY FK_1AC6CF2BC036E511');
        $this->addSql('DROP INDEX IDX_1AC6CF2BC036E511 ON ongoing_atk');
        $this->addSql('ALTER TABLE ongoing_atk DROP player_id_id');
    }
}
