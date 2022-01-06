<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220106012201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE technologies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, price INT NOT NULL, lvl_max INT NOT NULL, description VARCHAR(255) DEFAULT NULL, damage INT DEFAULT NULL, gold_boost INT DEFAULT NULL, damage_per_level INT DEFAULT NULL, gold_boost_per_level INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technologies_owned (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, level INT NOT NULL, INDEX IDX_B92143A8C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_technologies_owned (user_id INT NOT NULL, technologies_owned_id INT NOT NULL, INDEX IDX_1565A553A76ED395 (user_id), INDEX IDX_1565A5532617C5C9 (technologies_owned_id), PRIMARY KEY(user_id, technologies_owned_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE technologies_owned ADD CONSTRAINT FK_B92143A8C54C8C93 FOREIGN KEY (type_id) REFERENCES technologies (id)');
        $this->addSql('ALTER TABLE user_technologies_owned ADD CONSTRAINT FK_1565A553A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_technologies_owned ADD CONSTRAINT FK_1565A5532617C5C9 FOREIGN KEY (technologies_owned_id) REFERENCES technologies_owned (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE technologies_owned DROP FOREIGN KEY FK_B92143A8C54C8C93');
        $this->addSql('ALTER TABLE user_technologies_owned DROP FOREIGN KEY FK_1565A5532617C5C9');
        $this->addSql('DROP TABLE technologies');
        $this->addSql('DROP TABLE technologies_owned');
        $this->addSql('DROP TABLE user_technologies_owned');
    }
}
