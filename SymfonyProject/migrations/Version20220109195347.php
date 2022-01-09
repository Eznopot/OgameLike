<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220109195347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE batiment (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE batiment_owned (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, level INT NOT NULL, startupgrade DATETIME DEFAULT NULL, endupgrade DATETIME DEFAULT NULL, upgrading TINYINT(1) DEFAULT NULL, INDEX IDX_8C5D3026C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE batiments (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, price INT NOT NULL, lvl_max INT NOT NULL, gold_per_hour INT NOT NULL, image LONGBLOB NOT NULL, damage INT NOT NULL, level INT NOT NULL, hp INT NOT NULL, damage_per_lvl INT NOT NULL, gold_per_hour_per_lvl INT NOT NULL, hp_per_lvl INT NOT NULL, upgrade_time INT NOT NULL, unites_per_hour_per_lvl INT DEFAULT NULL, unites_per_hour INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE map (id INT AUTO_INCREMENT NOT NULL, size_x INT NOT NULL, size_y INT NOT NULL, name VARCHAR(25) NOT NULL, level INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ongoing_atk (id INT AUTO_INCREMENT NOT NULL, planet_id_id INT NOT NULL, start INT NOT NULL, difficuly INT NOT NULL, end_time INT NOT NULL, success_rate INT NOT NULL, UNIQUE INDEX UNIQ_1AC6CF2B6B47FF93 (planet_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ongoing_atk_user (ongoing_atk_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_6D86563E6C3CC02F (ongoing_atk_id), INDEX IDX_6D86563EA76ED395 (user_id), PRIMARY KEY(ongoing_atk_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planets (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, defense_lvl INT DEFAULT NULL, distance INT DEFAULT NULL, image LONGBLOB DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technologies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, price INT NOT NULL, lvl_max INT NOT NULL, description VARCHAR(255) DEFAULT NULL, damage INT DEFAULT NULL, gold_boost INT DEFAULT NULL, damage_per_level INT DEFAULT NULL, gold_boost_per_level INT DEFAULT NULL, upgrade_time INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technologies_owned (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, level INT NOT NULL, startupgrade DATETIME NOT NULL, endupgrade DATETIME NOT NULL, upgrading TINYINT(1) NOT NULL, INDEX IDX_B92143A8C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, planet_id INT NOT NULL, username VARCHAR(25) NOT NULL, password VARCHAR(255) NOT NULL, gold INT NOT NULL, elo INT NOT NULL, image LONGBLOB DEFAULT NULL, units INT NOT NULL, last_update DATETIME NOT NULL, INDEX IDX_8D93D649A25E9820 (planet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_batiment_owned (user_id INT NOT NULL, batiment_owned_id INT NOT NULL, INDEX IDX_E7D8EF7FA76ED395 (user_id), INDEX IDX_E7D8EF7F901DE454 (batiment_owned_id), PRIMARY KEY(user_id, batiment_owned_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_technologies_owned (user_id INT NOT NULL, technologies_owned_id INT NOT NULL, INDEX IDX_1565A553A76ED395 (user_id), INDEX IDX_1565A5532617C5C9 (technologies_owned_id), PRIMARY KEY(user_id, technologies_owned_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE batiment_owned ADD CONSTRAINT FK_8C5D3026C54C8C93 FOREIGN KEY (type_id) REFERENCES batiments (id)');
        $this->addSql('ALTER TABLE ongoing_atk ADD CONSTRAINT FK_1AC6CF2B6B47FF93 FOREIGN KEY (planet_id_id) REFERENCES planets (id)');
        $this->addSql('ALTER TABLE ongoing_atk_user ADD CONSTRAINT FK_6D86563E6C3CC02F FOREIGN KEY (ongoing_atk_id) REFERENCES ongoing_atk (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ongoing_atk_user ADD CONSTRAINT FK_6D86563EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE technologies_owned ADD CONSTRAINT FK_B92143A8C54C8C93 FOREIGN KEY (type_id) REFERENCES technologies (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A25E9820 FOREIGN KEY (planet_id) REFERENCES planets (id)');
        $this->addSql('ALTER TABLE user_batiment_owned ADD CONSTRAINT FK_E7D8EF7FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_batiment_owned ADD CONSTRAINT FK_E7D8EF7F901DE454 FOREIGN KEY (batiment_owned_id) REFERENCES batiment_owned (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_technologies_owned ADD CONSTRAINT FK_1565A553A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_technologies_owned ADD CONSTRAINT FK_1565A5532617C5C9 FOREIGN KEY (technologies_owned_id) REFERENCES technologies_owned (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_batiment_owned DROP FOREIGN KEY FK_E7D8EF7F901DE454');
        $this->addSql('ALTER TABLE batiment_owned DROP FOREIGN KEY FK_8C5D3026C54C8C93');
        $this->addSql('ALTER TABLE ongoing_atk_user DROP FOREIGN KEY FK_6D86563E6C3CC02F');
        $this->addSql('ALTER TABLE ongoing_atk DROP FOREIGN KEY FK_1AC6CF2B6B47FF93');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A25E9820');
        $this->addSql('ALTER TABLE technologies_owned DROP FOREIGN KEY FK_B92143A8C54C8C93');
        $this->addSql('ALTER TABLE user_technologies_owned DROP FOREIGN KEY FK_1565A5532617C5C9');
        $this->addSql('ALTER TABLE ongoing_atk_user DROP FOREIGN KEY FK_6D86563EA76ED395');
        $this->addSql('ALTER TABLE user_batiment_owned DROP FOREIGN KEY FK_E7D8EF7FA76ED395');
        $this->addSql('ALTER TABLE user_technologies_owned DROP FOREIGN KEY FK_1565A553A76ED395');
        $this->addSql('DROP TABLE batiment');
        $this->addSql('DROP TABLE batiment_owned');
        $this->addSql('DROP TABLE batiments');
        $this->addSql('DROP TABLE map');
        $this->addSql('DROP TABLE ongoing_atk');
        $this->addSql('DROP TABLE ongoing_atk_user');
        $this->addSql('DROP TABLE planets');
        $this->addSql('DROP TABLE technologies');
        $this->addSql('DROP TABLE technologies_owned');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_batiment_owned');
        $this->addSql('DROP TABLE user_technologies_owned');
    }
}
