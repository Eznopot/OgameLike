<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220111111449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE batiment (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE batiment_owned (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, level INT NOT NULL, startupgrade DATETIME DEFAULT NULL, endupgrade DATETIME DEFAULT NULL, upgrading TINYINT(1) DEFAULT NULL, hp INT DEFAULT NULL, upgrading_type VARCHAR(255) DEFAULT NULL, INDEX IDX_8C5D3026C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE batiments (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, price INT NOT NULL, lvl_max INT NOT NULL, gold_per_hour INT NOT NULL, image VARCHAR(255) DEFAULT NULL, damage INT NOT NULL, level INT NOT NULL, hp INT NOT NULL, damage_per_lvl INT NOT NULL, gold_per_hour_per_lvl INT NOT NULL, hp_per_lvl INT NOT NULL, upgrade_time INT NOT NULL, unites_per_hour_per_lvl INT DEFAULT NULL, unites_per_hour INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ongoing_atk (id INT AUTO_INCREMENT NOT NULL, planets_id INT NOT NULL, player_id_id INT NOT NULL, start DATETIME NOT NULL, difficuly INT NOT NULL, end_time DATETIME NOT NULL, success_rate INT NOT NULL, units_atk INT DEFAULT NULL, id_ended TINYINT(1) NOT NULL, technologies_bonus INT DEFAULT NULL, unites_realy_atk INT DEFAULT NULL, INDEX IDX_1AC6CF2BDCBDC375 (planets_id), INDEX IDX_1AC6CF2BC036E511 (player_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planets (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, defense_lvl INT DEFAULT NULL, distance INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technologies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, price INT NOT NULL, lvl_max INT NOT NULL, description VARCHAR(255) DEFAULT NULL, damage INT DEFAULT NULL, gold_boost INT DEFAULT NULL, damage_per_level INT DEFAULT NULL, gold_boost_per_level INT DEFAULT NULL, upgrade_time INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technologies_owned (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, level INT NOT NULL, upgrading TINYINT(1) NOT NULL, startupgrade DATETIME DEFAULT NULL, endupgrade DATETIME DEFAULT NULL, INDEX IDX_B92143A8C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, planet_id INT NOT NULL, username VARCHAR(25) NOT NULL, password VARCHAR(255) NOT NULL, gold INT NOT NULL, elo INT NOT NULL, units INT NOT NULL, last_update DATETIME NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D649A25E9820 (planet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_batiment_owned (user_id INT NOT NULL, batiment_owned_id INT NOT NULL, INDEX IDX_E7D8EF7FA76ED395 (user_id), INDEX IDX_E7D8EF7F901DE454 (batiment_owned_id), PRIMARY KEY(user_id, batiment_owned_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_technologies_owned (user_id INT NOT NULL, technologies_owned_id INT NOT NULL, INDEX IDX_1565A553A76ED395 (user_id), INDEX IDX_1565A5532617C5C9 (technologies_owned_id), PRIMARY KEY(user_id, technologies_owned_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE batiment_owned ADD CONSTRAINT FK_8C5D3026C54C8C93 FOREIGN KEY (type_id) REFERENCES batiments (id)');
        $this->addSql('ALTER TABLE ongoing_atk ADD CONSTRAINT FK_1AC6CF2BDCBDC375 FOREIGN KEY (planets_id) REFERENCES planets (id)');
        $this->addSql('ALTER TABLE ongoing_atk ADD CONSTRAINT FK_1AC6CF2BC036E511 FOREIGN KEY (player_id_id) REFERENCES user (id)');
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
        $this->addSql('ALTER TABLE ongoing_atk DROP FOREIGN KEY FK_1AC6CF2BDCBDC375');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A25E9820');
        $this->addSql('ALTER TABLE technologies_owned DROP FOREIGN KEY FK_B92143A8C54C8C93');
        $this->addSql('ALTER TABLE user_technologies_owned DROP FOREIGN KEY FK_1565A5532617C5C9');
        $this->addSql('ALTER TABLE ongoing_atk DROP FOREIGN KEY FK_1AC6CF2BC036E511');
        $this->addSql('ALTER TABLE user_batiment_owned DROP FOREIGN KEY FK_E7D8EF7FA76ED395');
        $this->addSql('ALTER TABLE user_technologies_owned DROP FOREIGN KEY FK_1565A553A76ED395');
        $this->addSql('DROP TABLE batiment');
        $this->addSql('DROP TABLE batiment_owned');
        $this->addSql('DROP TABLE batiments');
        $this->addSql('DROP TABLE ongoing_atk');
        $this->addSql('DROP TABLE planets');
        $this->addSql('DROP TABLE technologies');
        $this->addSql('DROP TABLE technologies_owned');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_batiment_owned');
        $this->addSql('DROP TABLE user_technologies_owned');
    }
}
