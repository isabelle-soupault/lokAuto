<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210720094910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, rentals_id INT NOT NULL, makes_id INT NOT NULL, fleets_id INT NOT NULL, seats_id INT NOT NULL, types_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, availability TINYINT(1) NOT NULL, registration VARCHAR(10) NOT NULL, INDEX IDX_773DE69DA564EA6A (rentals_id), INDEX IDX_773DE69DD06639A6 (makes_id), INDEX IDX_773DE69D235BF180 (fleets_id), INDEX IDX_773DE69DB103A3F8 (seats_id), INDEX IDX_773DE69D8EB23357 (types_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fleet (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mark (id INT AUTO_INCREMENT NOT NULL, makes VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rental (id INT AUTO_INCREMENT NOT NULL, start_date DATETIME NOT NULL, endtime DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seat (id INT AUTO_INCREMENT NOT NULL, numbers SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, types VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(52) NOT NULL, lastname VARCHAR(51) NOT NULL, phone VARCHAR(14) NOT NULL, birth_date DATE NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DA564EA6A FOREIGN KEY (rentals_id) REFERENCES rental (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DD06639A6 FOREIGN KEY (makes_id) REFERENCES mark (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D235BF180 FOREIGN KEY (fleets_id) REFERENCES fleet (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DB103A3F8 FOREIGN KEY (seats_id) REFERENCES seat (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D8EB23357 FOREIGN KEY (types_id) REFERENCES type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D235BF180');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DD06639A6');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DA564EA6A');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DB103A3F8');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D8EB23357');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE fleet');
        $this->addSql('DROP TABLE mark');
        $this->addSql('DROP TABLE rental');
        $this->addSql('DROP TABLE seat');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE `user`');
    }
}
